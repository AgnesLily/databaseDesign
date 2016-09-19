<?php
/*
 * 用户登录接口
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
    && isset($_POST['password']) && $_POST['password']) {
	$account = check_textInput($_POST['account']);
	$password = check_textInput($_POST['password']);
	$password = md5($password);
	
	$sql = "SELECT * FROM student WHERE sno='{$account}' AND password='{$password}'";
	$res = $con->get_result($sql);
	if($row = mysqli_fetch_assoc($res)){
		$response['statue'] = 1;
		setSession($row['sid'],$account,$password);
		$con->for_close();
		echo json_encode($response);
		exit ;
	}else{
		$response['statue'] = -1;//数据库中数据查找失败	
		$con->for_close();
		echo json_encode($response);
		exit;
	}
}else{
	$response['statue'] = -2;//变量设置有问题	
	$con->for_close();
	echo json_encode($response);
	exit;
}


//检查数据
function check_textInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//将用户信息设置session
function setSession($id,$sno,$password) {
	$_SESSION['id'] = $id;
	$_SESSION['sno'] = $sno;
	$_SESSION['password'] = $password;
	setcookie("account",$sno, time()+3600);
	setcookie("password",$password,time()+3600);
}
?>