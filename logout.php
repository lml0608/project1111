<?php

	//退出系统
	//加载公共文件
	include_once 'public.php';

	//接收用户信息
	$id = isset($_GET['id']) ?  $_GET['id'] : '';

	//判断用户
	if(empty($id)){
		//没有要退出的用户
		redirect('login.html',3,'请先登录系统！');
	}

	//连接数据库
	//connect();

	//用户退出，修改登录状态
	if(updateStatus($id,0)){
		//退出成功
		redirect('login.html',2,'退出成功，欢迎下次光临！');
	}else{
		//退出失败
		redirect('index.php?id='. $id,3,'退出失败！');
	}

