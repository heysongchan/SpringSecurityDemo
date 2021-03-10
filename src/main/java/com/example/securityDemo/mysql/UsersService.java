package com.example.securityDemo.mysql;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class UsersService {
	@Autowired
	private UsersMapper mapper;

	public List<User> selectAll() {
		List<User> all = mapper.selectAll();
		return all;
	}

	public List<User> selectByUsername(String username) {
		List<User> all = mapper.selectByUsername(username);
		return all;
	}
}
