package com.example.securityDemo.mysql;

import java.util.List;

import org.apache.ibatis.annotations.Mapper;
import org.apache.ibatis.annotations.Param;

@Mapper
public interface UsersMapper {
	List<User> selectAll();

	List<User> selectByUsername(@Param("username11") String username);
}
