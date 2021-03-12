package com.example.securityDemo;

import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import io.swagger.annotations.Api;

@Api(tags = "管理员接口")
@RestController
@RequestMapping("/admin")
public class admincontroller {
	// @ApiOperation(value = "value!!!!", notes = "notesssss!!", produces =
	// "application/json", tags = "admin!!")
	@GetMapping("/dodo")
	String dodo() {
		return "admin admin";
	}
}
