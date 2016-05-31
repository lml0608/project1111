<?php

	//系统首页
	//加载公共文件
	include_once 'public.php';

	//判断用户是否登录
	//得到当前访问的用户的ID
	$id = isset($_GET['id']) ? $_GET['id'] : '';

	//判断数据的合法性
	if(empty($id)){
		//表示用户是直接请求的index.php界面
		redirect('login.html',3,'请先登录！');
	}

	//连接数据库
	//connect();

	//验证数据有效性
	if($user = checkStatus($id)){
		//登录成功
		//获取页码
		$page = isset($_GET['page']) ? $_GET['page'] : 1;

		//设置每页显示的数量
		$length = 5;

		//获取当前满足条件的记录数有多少
		$counts = getCounts();
		//计算前一页和后一页
		$prev = ($page <= 1) ? 1 : ($page - 1);				//前一页
		//求出总页数
		$pages = ceil($counts/$length);
		
		//下一页
		$next = ($page >= $pages) ? $pages : ($page + 1);

		

		//取出学生信息
		$students = getStudents($page,$length);
	}else{
		//验证失败，用户没有登录
		redirect('login.html',3,'您还没有登录或者登录已经失效！请重新登录！');
	}
?>
<div id="all" style="width:100%;height:100%;float:left">
	<div id="head" style="width:100%;height:50px;float:left">
		<div id="userinfo" style="width:50%;float:left;text-align:right">
			欢迎<?php echo $user['u_username'];?>登录系统
		</div>
		<div id="sys" style="width:50%;float:left;text-align:right">
			<a href="logout.php?id=<?php echo $user['u_id'];?>" onclick="return confirm('确定要退出系统？')">退出系统</a>
		</div>
	</div>
	<div id="menu" style="width:20%;height:100%;float:left">
		<a href="edit.php?id=<?php echo $user['u_id'];?>">修改密码</a>
	</div>
	<div id="content" style="width:80%;height:100%;float:left">
		<table>
			<tr>
				<th>序号</th>
				<th>学号</th>
				<th>姓名</th>
				<th>性别</th>
				<th>年龄</th>
				<th>班级名称</th>
				<th>教室</th>
			</tr>

			<?php 
				//定义一个序号
				$i = 1;		
				foreach($students as $student):
			?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $student['s_number'];?></td>
				<td><?php echo $student['s_name'];?></td>
				<td><?php echo $student['s_gender'] ? '男' : '女';?></td>
				<td><?php echo $student['s_age'];?></td>
				<td><?php echo $student['c_name'];?></td>
				<td><?php echo $student['c_room'];?></td>
			</tr>
			<?php endforeach;?>

			<tr>
				<td colspan="7">
					<a href="index.php?id=<?php echo $user['u_id'];?>&page=1">首页</a>
					<a href="index.php?id=<?php echo $user['u_id'];?>&page=<?php echo $prev;?>">上一页</a>
					<a href="index.php?id=<?php echo $user['u_id'];?>&page=<?php echo $next;?>">下一页</a>
					<a href="index.php?id=<?php echo $user['u_id'];?>&page=<?php echo $pages;?>">末页</a>
				</td>
			</tr>
		</table>
	</div>
</div>