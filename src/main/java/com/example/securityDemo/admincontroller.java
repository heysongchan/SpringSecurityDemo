package com.example.securityDemo;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.alibaba.fastjson.JSONObject;
import com.example.securityDemo.mysql.User;

import io.swagger.annotations.Api;

@Api(tags = "管理员接口")
@RestController
@RequestMapping("/admin")
public class admincontroller {
	private Logger log;

	public admincontroller() {
		log = LoggerFactory.getLogger(this.getClass());
	}

	// @ApiOperation(value = "value!!!!", notes = "notesssss!!", produces =
	// "application/json", tags = "admin!!")
	@GetMapping("/dodo")
	public String dodo(HttpServletRequest req) {

		HttpSession session = req.getSession();
		if (session != null) {
			String id = session.getId();
			log.info("session id :" + id);
		} else
			log.info("no session");
		return "admin admin";
	}

	@GetMapping("/getUser")
	public String getUser(HttpServletRequest req) {
		Object principal = SecurityContextHolder.getContext().getAuthentication().getPrincipal();
		User u = (User) principal;
		String str = JSONObject.toJSONString(u);
		return str;
	}
}
