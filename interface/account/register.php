<?php
/*
 * 用户注册接口
 * 
 * */
session_start();
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/openMysql.class.php';
$response = array("statue" => '');
$con = new openMysql();

$account = '';
$password = '';

if(isset($_POST['account']) && $_POST['account']
   && isset($_POST['password']) && $_POST['password']){
   		$account = test_input($_POST['account']);
		$password = md5(test_input($_POST['password']));

		$sql01  = "SELECT sid FROM student WHERE sno='{$account}'";
		$res = $con->excute_dql($sql01);
		if($res == 1){
			$response['statue'] = -1;//已存在该账户
			$con->for_close();
			echo json_encode($response);
			exit ;
		}else{
			$sql = "INSERT INTO student(sno,password) VALUES ('{$account}','{$password}')";
			$res = $con->excute_dml($sql);
			if($res == 1) {
				$response['statue'] = 1;//插入成功
				$con->for_close();
				echo json_encode($response);
				exit ;
			}else {
				$response['statue'] = -2;//插入失败
				$con->for_close();
				echo json_encode($response);
				exit ;
			}
		}
}else{
	$response['statue'] = -3;//接口有问题
	$con->for_close();
	echo json_encode($response);
	exit ;
}

function test_input($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>