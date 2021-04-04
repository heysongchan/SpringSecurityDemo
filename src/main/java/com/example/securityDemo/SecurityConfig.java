package com.example.securityDemo;

import java.io.IOException;
import java.util.Collection;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.security.config.annotation.authentication.builders.AuthenticationManagerBuilder;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.builders.WebSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.AuthenticationException;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.authentication.AuthenticationFailureHandler;
import org.springframework.security.web.authentication.AuthenticationSuccessHandler;
import org.springframework.security.web.authentication.UsernamePasswordAuthenticationFilter;
import org.springframework.security.web.session.HttpSessionEventPublisher;

import com.example.securityDemo.Filter.MyFilter;
import com.example.securityDemo.mysql.MyUserDetailsService;

@EnableWebSecurity
public class SecurityConfig extends WebSecurityConfigurerAdapter
		implements AuthenticationSuccessHandler, AuthenticationFailureHandler {
	private Logger log;
	@Autowired
	private MyUserDetailsService userDetailsService;

	public SecurityConfig() {
		log = LoggerFactory.getLogger(this.getClass());
	}

	@Override
	public void configure(WebSecurity web) throws Exception {
		web.ignoring()//
				.antMatchers("/doc.html");
		super.configure(web);
	}

//	@Autowired
//	private MyLoginUrlAuthenticationEntryPoint ep;

	@Override
	protected void configure(HttpSecurity http) throws Exception {
		// http.exceptionHandling().authenticationEntryPoint(ep);
		http.addFilterBefore(new MyFilter(), UsernamePasswordAuthenticationFilter.class);
		http.authorizeRequests() //
				.antMatchers("/aa/**").hasAuthority("a")//
				.antMatchers("/admin/**").hasAuthority("a")//
				.antMatchers("/**").permitAll()//
//				.antMatchers("/user/**").hasAuthority("ROLE_USER")//
////				.antMatchers("/admin/**").hasRole("ADMIN")//
////				.antMatchers("/user/**").hasRole("USER")//
//				.antMatchers("/**").permitAll()//
				.anyRequest().authenticated()//
				.and()//
				.formLogin()//
				.loginProcessingUrl("/login")// 这里设置from中的action的值 这个url和html中form的action要一致
				// .failureUrl("http://localhost:8080/gateway/login.html")//
				.loginPage("http://localhost:8080/gateway/login.html")//
//				.successForwardUrl("http://localhost:8080/gateway/admin/getUser")//
//				.failureForwardUrl("http://localhost:8080/gateway/login.html")//

				.permitAll()//

				.successHandler(this)//
//				.failureHandler(this)//
				.and()//
				.sessionManagement().sessionFixation().migrateSession()//
				.maximumSessions(1).maxSessionsPreventsLogin(false).and()//
				.and()//
				.rememberMe().userDetailsService(userDetailsService)//
				.and()//
				.csrf().disable()//
				.logout()//
				// .logoutSuccessUrl("http://localhost:8080/gateway/login.html")//
				.logoutUrl("/logout");

	}

	@Autowired
	private MyAuthProvider authenticationProvider;

	@Override
	protected void configure(AuthenticationManagerBuilder auth) throws Exception {
		auth.authenticationProvider(authenticationProvider);
		super.configure(auth);
	}

	@Override
	public void onAuthenticationFailure(HttpServletRequest request, HttpServletResponse response,
			AuthenticationException exception) throws IOException, ServletException {
		log.info("failure    " + request.getRequestURI());
		response.sendRedirect("http://localhost:8080/gateway/login.html");
	}

	@Override
	public void onAuthenticationSuccess(HttpServletRequest request, HttpServletResponse response,
			Authentication authentication) throws IOException, ServletException {
		Collection<? extends GrantedAuthority> authorities = authentication.getAuthorities();
		for (GrantedAuthority g : authorities) {
			String authority = g.getAuthority();
			log.info("authority  " + authority);
		}
		log.info("success  " + request.getRequestURI());
		response.sendRedirect("http://localhost:8080/gateway/index.html");
//		ServletOutputStream out = response.getOutputStream();
//		Object un = authentication.getPrincipal();
//		com.example.securityDemo.mysql.User u = (com.example.securityDemo.mysql.User) un;
//		ByteArrayInputStream in = new ByteArrayInputStream(u.getUsername().getBytes("utf-8"));
//		FileCopyUtils.copy(in, out);
	}

	@Bean
	public HttpSessionEventPublisher httpSessionEventPublisher() {
		return new HttpSessionEventPublisher();
	}

	@Bean
	PasswordEncoder passwordEncoder() {
		return new BCryptPasswordEncoder();
	}

	@Bean("aa")
	public String aa() {
		return "aaaaaa";
	}

	@Bean("bb")
	public String bb() {
		return "bbbbbbbb";
	}

//	@Scope(proxyMode = ScopedProxyMode.TARGET_CLASS, value = "session")
//	@Bean
//	public User u() {
//		User uu = new User();
//		uu.setUsername("aaaaaaaaaaaaaa");
//		return uu;
//	}	
}
