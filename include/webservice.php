<?php 
	include_once "ez_sql_core.php";
	include_once "ez_sql_mysql.php";
	include_once "include/config.php";
	$db = new ezSQL_mysql(DB_USER,DB_PASSWORD,'siwei',DB_HOST);	

	$action = isset($_POST["action"]) ? $_POST["action"] : "";

	if($flag == "regist"){
		//添加新用户
		$sql="insert into userinfo(id,userpwd,userNickname,userHeadImage,userState,lastActiveTime) value(null,'$regPwd','$regname','$regheadimg','offline',now())";
		$db->query($sql);
		$var = $db->get_var("select max(id) from userinfo");
		echo $var;
		die();
	}
 ?>

 