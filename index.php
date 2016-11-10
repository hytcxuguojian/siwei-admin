<?php
	include_once "include/ez_sql_core.php";
	include_once "include/ez_sql_mysql.php";
	include_once "include/config.php";
	$db = new ezSQL_mysql(DB_USER,DB_PASSWORD,'siwei',DB_HOST);
	$action = isset($_POST["action"]) ? $_POST["action"] : "";

	if($action == "order"){
		$mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : "";
		$name = isset($_POST["name"]) ? $_POST["name"] : "";
		$city_id = isset($_POST["city_id"]) ? $_POST["city_id"] : 0;
		$house_area = isset($_POST["house_area"]) ? $_POST["house_area"] : 0;
		$room = isset($_POST["room"]) ? $_POST["room"] : 0;
		$holl = isset($_POST["holl"]) ? $_POST["holl"] : 0;
		$kitchen = isset($_POST["kitchen"]) ? $_POST["kitchen"] : 0;
		$toilet = isset($_POST["toilet"]) ? $_POST["toilet"] : 0;
		$balcony = isset($_POST["balcony"]) ? $_POST["balcony"] : 0;
		$ip_address = isset($_POST["ip_address"]) ? $_POST["ip_address"] : '0.0.0.0';
		$ip_city = isset($_POST["ip_city"]) ? $_POST["ip_city"] : '未知';
		//添加新用户
		$sql="insert into book_users(mobile,`name`,city_id,house_area,room,holl,kitchen,toilet,balcony,ip_address,ip_city,created_at,updated_at) 
		VALUES('$mobile','$name',$city_id,$house_area,$room,$holl,$kitchen,$toilet,$balcony,'$ip_address','$ip_city',NOW(),NOW())";
		$res = $db->query($sql);
		if($res){
			$result = [
				'status' => 200,
				'msg' => '您已成功提交信息，我们会尽快联系您'
			];
		}else{
			$result = [
				'status' => 0,
				'msg' => '服务器网络异常，提交失败，稍后请重试'
			];
		}		
		echo json_encode($result);
		die();
	}
	$res = $db->get_results("select * from book_users");
 ?>
<!DOCTYPE html>
 <html>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <head>
 	<title></title>
 </head>
 <body>
 	<ul>
 		<?php 
 			echo '--------------------------------数据--------------------------------------';
 			echo '<br>';
 			$html = '';
 			foreach ($res as $key => $value) {
 				$html .='<li>姓名：'.$value->name.'，手机号：'.$value->mobile.'，IP地址：'.$value->ip_address.'，IP所在地：'.$value->ip_city.'</li>';
 			}
 			echo $html;
 		 ?>
 	</ul>
 </body>
 </html>