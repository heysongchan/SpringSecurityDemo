package com.example.securityDemo.mysql;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.AuthorityUtils;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;

@Service
public class MyUserDetailsService implements UserDetailsService {
	@Autowired
	private UsersService s;

	@Override
	public UserDetails loadUserByUsername(String username) throws UsernameNotFoundException {
		List<User> us = s.selectByUsername(username);
		User u = us.get(0);
		List<GrantedAuthority> ss = AuthorityUtils.commaSeparatedStringToAuthorityList(u.getRoles());
		u.setAuthorities(ss);
		return u;
	}

}
