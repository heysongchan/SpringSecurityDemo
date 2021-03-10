package com.example.securityDemo;

import java.io.IOException;
import java.util.Collection;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.config.annotation.authentication.builders.AuthenticationManagerBuilder;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.AuthenticationException;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.web.authentication.AuthenticationFailureHandler;
import org.springframework.security.web.authentication.AuthenticationSuccessHandler;

import com.example.securityDemo.mysql.MyUserDetailsService;

@EnableWebSecurity
public class config extends WebSecurityConfigurerAdapter
		implements AuthenticationSuccessHandler, AuthenticationFailureHandler {
	private Logger log;
	@Autowired
	private MyUserDetailsService userDetailsService;

	public config() {
		log = LoggerFactory.getLogger(this.getClass());
	}

	@Override
	protected void configure(HttpSecurity http) throws Exception {
		http.authorizeRequests() //
				.antMatchers("/admin/**").hasAuthority("a")//
				.antMatchers("/user/**").hasAuthority("ROLE_USER")//
//				.antMatchers("/admin/**").hasRole("ADMIN")//
//				.antMatchers("/user/**").hasRole("USER")//
				.antMatchers("/**").permitAll()//
				.anyRequest().authenticated()//
				.and()//
				.formLogin()//
				.loginPage("/login.html")//
				.permitAll()//
				.loginProcessingUrl("/aa")// 这里设置from中的action的值 这个url和html中form的action要一致
//				.successHandler(this)//
//				.failureHandler(this)//
				.and()//
				.rememberMe().userDetailsService(userDetailsService)//
				.and()//
				.csrf().disable()//
				.logout().logoutUrl("/logout");

	}

	@Override
	protected void configure(AuthenticationManagerBuilder auth) throws Exception {
		super.configure(auth);
	}

	@Override
	public void onAuthenticationFailure(HttpServletRequest request, HttpServletResponse response,
			AuthenticationException exception) throws IOException, ServletException {
		log.info("failure");
	}

	@Override
	public void onAuthenticationSuccess(HttpServletRequest request, HttpServletResponse response,
			Authentication authentication) throws IOException, ServletException {
		Collection<? extends GrantedAuthority> authorities = authentication.getAuthorities();
		for (GrantedAuthority g : authorities) {
			String authority = g.getAuthority();
			log.info(authority);
		}
		log.info("success");
	}
}
