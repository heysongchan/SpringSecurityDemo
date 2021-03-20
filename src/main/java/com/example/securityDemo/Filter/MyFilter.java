package com.example.securityDemo.Filter;

import java.io.IOException;

import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.web.filter.OncePerRequestFilter;

public class MyFilter extends OncePerRequestFilter {
	private Logger log;

	public MyFilter() {
		log = LoggerFactory.getLogger(this.getClass());
	}

	@Override
	protected void doFilterInternal(HttpServletRequest request, HttpServletResponse response, FilterChain filterChain)
			throws ServletException, IOException {
		log.info("MyFilter  " + request.getRequestURI());
		filterChain.doFilter(request, response);

	}
}
