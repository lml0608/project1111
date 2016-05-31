<?php

	//用户注册

	//引入公共文件
	include_once 'public.php';

	//接收用户提交的信息
	if(isset($_POST['submit'])){
		//当前脚本是被register.html提交请求到

		//获取用户信息
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$confirm  = isset($_POST['pass_confirm']) ? $_POST['pass_confirm'] : '';

		//判断数据的合法性
		if(empty($username) || empty($password)){
			//用户名或者密码为空，需要跳转，跳转到注册界面
			//调用公共函数
			redirect('register.html',3,'用户名和密码都不能为空！');
		}

		//判断两次密码输入
		//全等，要区分密码字母大小写
		if($password !== $confirm){
			//两次输入不一致
			redirect('register.html',3,'两次输入密码不一致，密码是区分大小写的！');
		}

		//判断数据有效性
		//调用连接数据库函数
		//connect();

		//判断当前用户名是否在数据库存在
		if(checkUsername($username)){
			//表示当前用户已经存在
			redirect('register.html',3,'当前用户名已经存在，请重新注册！');
		}

		//将用户信息写入到数据库
		if(insertUserAndPass($username,$password)){
			//插入成功，跳转到登录界面
			$info = "注册成功，正在跳转到登录界面！如果不能跳转请点击<a href='login.html'>这里</a>";
			redirect('login.html',2,$info);
		}else{
			//插入失败
			redirect('register.html',3,'注册失败！');
		}
	}else{
		//回到注册界面
		redirect('register.html',3,'您还没有注册！');
	}