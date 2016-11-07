<?php 
	include_once "ez_sql_core.php";
	include_once "ez_sql_mysql.php";
	$db = new ezSQL_mysql('root','123','webchat','localhost');
	session_start();
	$flag=isset($_POST["flag"])?$_POST["flag"]:"";
	//index页面请求
	$msg=isset($_POST["msg"])?$_POST["msg"]:"";
	$reciverid=isset($_POST["reciverid"])?$_POST["reciverid"]:"";
	$senderid=isset($_POST["senderid"])?$_POST["senderid"]:"";
	$currentUser=isset($_SESSION["userid"])?$_SESSION["userid"]:"";
	$readWho=isset($_POST["readWho"])?$_POST["readWho"]:"";
	//注册页面请求
	$regname=isset($_POST["regname"])?$_POST["regname"]:"";
	$regPwd=isset($_POST["regPwd"])?$_POST["regPwd"]:"";
	$regheadimg=isset($_POST["regheadimg"])?$_POST["regheadimg"]:"";

	if($flag=="regist"){
		//添加新用户
		$sql="insert into userinfo(id,userpwd,userNickname,userHeadImage,userState,lastActiveTime) value(null,'$regPwd','$regname','$regheadimg','offline',now())";
		$db->query($sql);
		$var = $db->get_var("select max(id) from userinfo");
		echo $var;
		die();
	}

	if($flag=="sendmsg"){
		//将发送的消息插入数据库messageinfo表
		$sql="insert into messageinfo(id,msgContent,msgSender,msgReceiver,msgSendTime,msgState) value(null,'$msg',$senderid,$reciverid,now(),'unread')";
		$db->query($sql);
		die();
	}
	
	if($flag=="getUnreadMsg"){
		//更新最后活跃时间，用于检测用户是否正常下线
		$db->query("update userinfo set lastActiveTime=now() where id=$currentUser");
		//查找未读消息
		$sql="select userNickname,userHeadImage,messageinfo.id,msgSender,msgReceiver,msgContent,msgSendtime from messageinfo,userinfo ";
		$sql.="where msgReceiver=$currentUser and msgState='unread' and messageinfo.msgsender=userinfo.id";
		$result = $db->get_results($sql);
		if(!$result){
			die();
		}else{
			echo json_encode($result);
			die();
		}
	}

	if($flag=="lastActiveTime"){
		$res = $db->get_results("select id,userState,lastActiveTime from userinfo where userinfo.id in (select friendid from friendsinfo where userid=$currentUser)");
		if($res){
			echo json_encode($res);
		}
		die();
	}

	if($flag=="haveRead"){
		$db->query("update messageinfo set msgState='haveread' where id=$readWho");
		die();
	}

	if($flag=="exit"){
		//退出时将当前用户状态设为离线
		$db->query("update userinfo set userState='offline' where id=$currentUser");
		unset($_SESSION["userid"]);
		sleep(1);
		die();
	}

	// //函数
	// function showtime($datetime){
	// 	return substr($datetime,0,19);
	// }
 ?>

 