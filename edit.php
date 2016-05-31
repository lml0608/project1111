<?php

	//编辑用户密码
	//加载公共文件
	include_once 'public.php';

	//接收用户信息
	$id = isset($_GET['id']) ?  $_GET['id'] : '';

	//判断用户
	if(empty($id)){
		//没有要编辑的用户
		redirect('index.php',3,'没有要修改的用户！');
	}

	//获取用户信息
	if($user = getUserById($id)){
		//获取到了用户的信息
	}else{
		//没有得到用户信息
		redirect('login.html',3,'当前用户不存在！');
	}
?>
<div style="width:400px;height:200px;margin:100px auto;text-align:center">
	<form action="update.php" method="POST">
		<p>用户名：<input type="text" value="<?php echo $user['u_username'];?>" disabled="disabled"/></p>
		<p>原始密码：<input type="password" name="old"/></p>
		<p>新密码：<input type="password" name="new" /></p>
		<p>确认新密码：<input type="password" name="new_confirm" /></p>
		<input type="hidden" name="id" value="<?php echo $id;?>"/>
		<input type="submit" name="submit" value="提交"/>
	</form>
</div>
