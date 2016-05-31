<?php

	//更新用户密码
	//加载公共文件
	include_once 'public.php';

	//接收用户数据
	if(isset($_POST['submit'])){
		//用户提交数据
		//接收数据
		$id			 = isset($_POST['id']) ? $_POST['id'] : '';
		$old		 = isset($_POST['old']) ? $_POST['old'] : '';
		$new		 = isset($_POST['new']) ? $_POST['new'] : '';
		$new_confirm = isset($_POST['new_confirm']) ? $_POST['new_confirm'] : '';

		//数据合法性验证
		if(empty($id)||empty($old)||empty($new)){
			//都不能为空
			redirect('edit.php?id='.$id,3,'原始密码和新密码都必填！');
		}

		//判断两次输入
		if($new !== $new_confirm){
			redirect('edit.php?id='.$id,3,'两次输入新密码不一致！');
		}

		//验证用户原始密码是否正确
		if(checkByIdAndPass($id,$old)){
			//更新用户密码
			if(updatePassById($id,$new)){
				//更新成功
				redirect('login.html',2,'更新成功！请重新登录！');
			}else{
				//更新失败
				redirect('edit.php?id='.$id,3,'更新失败！');
			}
		}else{
			//原始密码错误
			redirect('edit.php?id='.$id,3,'原始密码不对！');
		}

	}else{
		//没有提交
		redirect('login.html',3,'没有要更新的数据！');
	}