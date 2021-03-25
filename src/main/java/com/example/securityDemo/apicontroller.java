package com.example.securityDemo;

import java.util.List;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import com.example.securityDemo.mysql.User;
import com.example.securityDemo.mysql.UsersService;

import io.swagger.annotations.Api;

@Api(tags = "开放接口")
@RestController
@RequestMapping("/api")
public class apicontroller {
	private Logger log;

	public apicontroller() {
		log = LoggerFactory.getLogger(this.getClass());
	}

	@Autowired
	private UsersService s;

	@GetMapping("/dodo")
	String dodo(HttpServletRequest req) {
		HttpSession session = req.getSession();
		if (session != null) {
			String id = session.getId();
			log.info("session id :" + id);
		} else
			log.info("no session");
		List<User> all = s.selectByUsername("user");

		return "api api";
	}

	@GetMapping("/aa")
	public String aa() {
		JSONArray array = new JSONArray();
		JSONObject obj = new JSONObject();
		array.add(obj);
		obj.put("id", "id");
		obj.put("name", "name");
		return array.toJSONString();
	}

	@GetMapping("/bb")
	public String bb(@RequestParam("a") String a) {
		log.info(a);
		JSONArray array = new JSONArray();
		JSONObject obj = new JSONObject();
		obj.put("id", "id1");
		obj.put("name", "name1");
		array.add(obj);
		obj = new JSONObject();
		obj.put("id", "id2");
		obj.put("name", "name2");
		array.add(obj);
		return array.toJSONString();
	}
}
