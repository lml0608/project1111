<?php

	//用户登录
	//引入公共文件
	include_once 'public.php';

	//接收用户数据
	if(isset($_POST['submit'])){
		//有提交数据
		//接收数据
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		//数据合法性判断
		if(empty($username) || empty($password)){
			//用户信息不全
			redirect('login.html',3,'用户名和密码都不能为空！');
		}

		//判断通过，做登录验证
		//连接数据库
		//connect();

		//调用函数
		if($user = checkLogin($username,$password)){
			//登录成功
			//修改用户的登录状态
			//如果要判断，发现错误的话应该是将错误写入到日志文件
			updateStatus($user['u_id'],1);

			//进入到系统首页
			//将当前登录用户的ID传给index.php界面，后续处理
			redirect('index.php?id=' . $user['u_id'],2,'登录成功！');
		}else{
			//登录失败
			redirect('login.html',3,'用户名或者密码错误！');
		}

	}else{
		//回到登陆界面
		redirect('login.html',2,'请先登录！');
	}