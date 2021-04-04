package com.example.securityDemo;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.security.core.userdetails.User;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.provisioning.InMemoryUserDetailsManager;

@SpringBootApplication
public class SecurityDemoApplication {

	public static void main(String[] args) {
//		BCryptPasswordEncoder e = new BCryptPasswordEncoder();
//		String encode = e.encode("123456");
//		System.out.println(encode);
		SpringApplication.run(SecurityDemoApplication.class, args);
	}

	// @Bean
	public UserDetailsService aa() {
		InMemoryUserDetailsManager m = new InMemoryUserDetailsManager();
		m.createUser(User.withUsername("user").password("$2a$10$./4Nr.v3QW7nczI6kLhr7egq577aEi7DTWteBcXul5TddQGAVyUGO")
				.roles("USER").build());
		m.createUser(User.withUsername("admin").password("$2a$10$./4Nr.v3QW7nczI6kLhr7egq577aEi7DTWteBcXul5TddQGAVyUGO")
				.roles("ADMIN").build());
		return m;
	}

}
