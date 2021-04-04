package com.example.securityDemo.Filter;

import java.io.IOException;

import javax.servlet.Filter;
import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.ServletRequest;
import javax.servlet.ServletResponse;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Component;

@Component
public class MyFilter2 implements Filter {
	private Logger log;

	public MyFilter2() {
		log = LoggerFactory.getLogger(this.getClass());
	}
//
//	@Override
//	protected void doFilterInternal(HttpServletRequest request, HttpServletResponse response, FilterChain filterChain)
//			throws ServletException, IOException {
//		log.info("MyFilter2  " + request.getRequestURL());
//		filterChain.doFilter(request, response);
//
//	}

	@Override
	public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain)
			throws IOException, ServletException {
		log.info("MyFilter2  " + request.getRemoteAddr());
		chain.doFilter(request, response);

	}
}
