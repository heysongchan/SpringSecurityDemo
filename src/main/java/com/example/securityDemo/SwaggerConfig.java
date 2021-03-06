package com.example.securityDemo;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import com.github.xiaoymin.swaggerbootstrapui.annotations.EnableSwaggerBootstrapUI;

import springfox.documentation.builders.ApiInfoBuilder;
import springfox.documentation.builders.PathSelectors;
import springfox.documentation.builders.RequestHandlerSelectors;
import springfox.documentation.service.ApiInfo;
import springfox.documentation.service.Contact;
import springfox.documentation.spi.DocumentationType;
import springfox.documentation.spring.web.plugins.Docket;
import springfox.documentation.swagger2.annotations.EnableSwagger2;

@EnableSwaggerBootstrapUI
@Configuration
@EnableSwagger2
public class SwaggerConfig {
	public static final String SWAGGER_SCAN_BASE_PACKAGE = "com.example";
	public static final String VERSION = "1.0.0";

	@Bean
	public Docket createRestApi() {
		Docket d = new Docket(DocumentationType.SWAGGER_2)//
				.apiInfo(apiinfo())//
				.select()//
				.apis(RequestHandlerSelectors.basePackage(SWAGGER_SCAN_BASE_PACKAGE))//
				.paths(PathSelectors.any())//
				.build();
		return d;
	}

	private ApiInfo apiinfo() {
		ApiInfoBuilder ab = new ApiInfoBuilder()//
				.title("AUTOCDM平台接口文档示例")//
				.description("详情")//
				.version(VERSION)//
				.termsOfServiceUrl("http://localhost:8080/user/user/111111")//
				.contact(new Contact("chenhs", "http://localhost:8080/user/user/2222", "email"))//
		;
		ApiInfo info = ab.build();
		return info;
	}
}
