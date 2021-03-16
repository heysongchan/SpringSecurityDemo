package com.example.securityDemo;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Qualifier;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
import org.springframework.security.core.AuthenticationException;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;

@Component
public class MyAuthProvider extends DaoAuthenticationProvider {
	@Qualifier("bb")
	@Autowired
	private String a;

	public MyAuthProvider(UserDetailsService uds, PasswordEncoder pde) {
		this.setUserDetailsService(uds);
		this.setPasswordEncoder(pde);
	}

	@Override
	protected void additionalAuthenticationChecks(UserDetails userDetails,
			UsernamePasswordAuthenticationToken authentication) throws AuthenticationException {
		System.out.println(a);
		super.additionalAuthenticationChecks(userDetails, authentication);
	}

}
