package com.example.securityDemo;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/user")
public class usercontroller {
	// @ApiOperation(value = "value!!!!", notes = "notesssss!!", produces =
	// "application/json", tags = "user!!")
	@GetMapping("/dodo")
	String dodo() {
		return "user user";
	}
}
