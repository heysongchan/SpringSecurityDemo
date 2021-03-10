package com.example.securityDemo;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.example.securityDemo.mysql.User;
import com.example.securityDemo.mysql.UsersService;

@RestController
@RequestMapping("/api")
public class apicontroller {
	@Autowired
	private UsersService s;

	@GetMapping("/dodo")
	String dodo() {
		List<User> all = s.selectByUsername("user");
		System.out.println(all);
		return "api api";
	}
}
