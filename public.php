<?php

	//用于存放公告代码
	//字符集处理
	header('Content-type:text/html;charset=utf-8');

	/*
	 * 公共跳转函数
	 * @param1 string $url，需要跳转到哪个界面，默认为登录界面
	 * @param2 int $time，跳转等待时间，默认为3秒
	 * @param3 string $info，跳转提示信息，默认为失败
	 */
	 function redirect($url = 'login.html',$time = 3,$info = '失败'){
		//通过刷新界面实现
		header("Refresh:{$time};url={$url}");

		//给出提示信息
		echo $info;

		//终止脚本执行
		exit;
	 }

	 /*
	  * 连接数据库
	  */
	 function connect(){
		//连接认证
		$link = mysql_connect('localhost','root','root');

		//验证
		if(!$link){
			//连接失败
			echo '当前连接失败，失败的原因如下：<br/>';
			echo '失败的错误编号：' . mysql_errno(),'<br/>';
			echo '失败的错误描述：' . mysql_error(),'<br/>';
			exit;
		}

		//设置字符集和选择数据库
		mysql_query('set names utf8');
		mysql_query('use project');
	 }

	 //理解连接
	 connect();


	 /*
	  * 判断用户名是否已经存在
	  * @param1 string $name，要判断的用户名
	  * @return boolean，成功返回TRUE，失败返回false
	  */
	 function checkUsername($name){
		//组织SQL
		$sql = "select * from pro_user where u_username = '{$name}'";

		//执行
		$res = mysql_query($sql);

		//转化成布尔类型，如果结果集中有记录，如果有记录就返回TRUE，失败返回false
		return mysql_num_rows($res) ? TRUE : FALSE;
	 }


	 /*
	  * 将用户注册信息写到数据库
	  * @param1 string $username，用户名
	  * @param2 string $password，密码
	  *
	  * @return Boolean，成功返回TRUE，失败返回false
	  */
	 function insertUserAndPass($username,$password){
		//加密
		$password = md5($password);

		//组织SQL
		$sql = "insert into pro_user values(null,'{$username}','{$password}',default)";

		//执行
		$res = mysql_query($sql);

		//判断执行结果
		return $res ? TRUE : FALSE;
	 }

	 /*
	  * 登录验证
	  * @param1 string $username，用户名
	  * @param2 string $password，用户密码
	  * @return mixed，如果成功返回当前用户的用户信息，如果失败返回false
	  */
	 function checkLogin($username,$password){
		//加密
		$password = md5($password);

		//转义
		$username = addslashes($username);

		//组织SQL
		$sql = "select * from pro_user where u_username='{$username}' and u_password='{$password}'";

		//执行
		$res = mysql_query($sql);

		//判断结果
		return mysql_fetch_assoc($res);
	 }

	 /*
	  * 更改用户登录状态
	  * @param1 int $id，当前登录成功的用户的id
	  * @param2 int $status，当前需要修改成哪个状态，默认为1，表示是登录成功
	  * @return Boolean
	 */
	 function updateStatus($id,$status){
		//组织SQL
		$sql = "update pro_user set u_status = '{$status}' where u_id='{$id}'";

		//执行
		$res = mysql_query($sql);

		//判断
		if($res && mysql_affected_rows()){
			//更新成功
			return TRUE;
		}else{
			//没有更新或者更新失败
			return FALSE;
		}
	 }

	/*
	 * 判断用户是否登录成功
	 * @param1 int $id，当前用户的id
	 * @return mixed，成功返回数组（用户信息），失败返回false
	 */
	function checkStatus($id){
		//组织SQL
		$sql = "select * from pro_user where u_id='{$id}' and u_status=1";

		//执行
		$res = mysql_query($sql);

		//判断
		return mysql_fetch_assoc($res);
	}

	/*
	 * 获取学生信息
	 * @param1 int $page，当前要获取的第几页，默认获取第一页的数据
	 * @param2 int $length，每页显示的数据量
	 * @return  array $students，二维数组
	*/
	function getStudents($page = 1,$length = 5){
		//计算limit的起始位置
		$offset = ($page - 1) * $length;

		//获取学生和对应的班级信息
		$sql = "select * from pro_student ps left join pro_class pc on ps.c_id = pc.c_id limit {$offset},{$length}";

		//执行
		$res = mysql_query($sql);

		//遍历结果集
		$students = array();
		while($student = mysql_fetch_assoc($res)){
			$students[] = $student;
		}

		//返回数据
		return $students;
	}

	/*
	 * 获取学生的总记录数
	 * @return int，总记录数
	 */
	function getCounts(){
		//组织SQL
		$sql = "select count(*) as s_count from pro_student ps left join pro_class pc on ps.c_id = pc.c_id";

		//执行
		$res = mysql_query($sql);

		//返回数据
		return mysql_fetch_assoc($res)['s_count'];
	}

	/*
	 * 通过用户id获取用户信息
	 * @param1 int $id，用户的id
	 * @return mixed，用户的信息，失败返回false
	 */
	function getUserById($id){
		//组织SQL
		$sql = "select * from pro_user where u_id = '{$id}'";

		//执行
		$res = mysql_query($sql);

		//返回值
		return mysql_fetch_assoc($res);
	}

	/*
	 * 通过用户id和原始密码来验证信息
	 * @param1 int $id，用户id
	 * @param2 string $password，原始密码
	 * @return Boolean，成功返回TRUE，失败返回false
	 */
	function checkByIdAndPass($id,$password){
		//密码加密
		$password = md5($password);

		//组织SQL
		$sql = "select * from pro_user where u_id='{$id}' and u_password ='{$password}'";

		$res = mysql_query($sql);

		return mysql_num_rows($res) ? TRUE : FALSE;
	}


	/*
	 * 通过用户id更新用户密码
	 * @param1 int $id，用户id
	 * @param2 string $password，新密码
	 * @return Boolean，成功返回TRUE，失败返回FALSE
	*/
	function updatePassById($id,$password){
		//加密
		$password = md5($password);

		//组织SQL
		$sql = "update pro_user set u_password = '{$password}',u_status =0 where u_id = '{$id}'";
		$res = mysql_query($sql);

		if($res && mysql_affected_rows()) return TRUE;
		else return FALSE;
	}