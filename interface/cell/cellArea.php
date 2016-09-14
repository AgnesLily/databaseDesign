<?php
/*
 * 得到所选校区的教室名称
 * 
 */	
	
session_start();
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/openMysql.class.php';
$response = array("statue" => '');
$con = new openMysql();
//$account = '';
$option = '';

if(isset($_POST['option']) && $_POST['option']) {
	$option = check_textInput($_POST['option']);
	
	$sql = "SELECT cname,cid FROM classroom WHERE area='{$option}'";
	$res = $con->get_result($sql);
	echo json_encode($con->deal_result($res));
	
	/*
	if($row = mysqli_fetch_assoc($res)){
		$response['statue'] = 1;
//		echo $row;
//		setSession($row['sid'],$account,$password);
		$con->for_close();
		echo json_encode($row);
		exit ;
	}else{
		$response['statue'] = -1;//数据库中数据查找失败	
		$con->for_close();
		echo json_encode($response);
		exit;
	}
	*/
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