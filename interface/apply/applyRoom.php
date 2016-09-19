<?php
/*
 * 提交教室申请
 * 
 */	
 
 session_start();
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/openMysql.class.php';
$response = array("statue" => '');
$con = new openMysql();


$date = '';
$start_time = 0;
$end_time = 0;
$room = '103';
$area = '5';
$comment = '';
$number = '';

if(isset($_SESSION['id']) && isset($_SESSION['password'])){
	if(isset($_POST['date']) && $_POST['date']
	    &&isset($_POST['start_time']) && $_POST['start_time']
		&&isset($_POST['end_time']) && $_POST['end_time']
		&&isset($_POST['room']) && $_POST['room']
		&&isset($_POST['area']) && $_POST['area']
		&&isset($_POST['comment']) && $_POST['comment']
		&&isset($_POST['number']) && $_POST['number']) {
		
		$sid = $_SESSION['id'];
		$date = check_textInput($_POST['date']);
		$start_time = check_textInput($_POST['start_time']);
		$end_time = check_textInput($_POST['end_time']);
		$room = check_textInput($_POST['room']);
		$area = check_textInput($_POST['area']);
		$comment = check_textInput($_POST['comment']);
		$number = check_textInput($_POST['number']);
		
		//先找到教室ID
		$sql1 = "SELECT cid FROM classroom WHERE area = '{$area}' AND cname = '{$room}'";
		$res = $con->get_result($sql1);
		$res1 =  $con->deal_result($res);
        $cid = $res1['cid'];
		
		
	    $sql2 = "INSERT INTO apply(sid,cid,date,time_start,time_end,tel,comment) VALUES 
				('{$sid}','{$cid}','{$date}','{$start_time}','{$end_time}','{$number}','{$comment}')";
	    
		$res2 = $con->excute_dml($sql2);
		if($res2 == 1){
			$response['statue'] = 1;//插入成功
			$con->for_close();
			echo json_encode($response);
			exit ;
		}else{
			$response['statue'] = -3;//数据库插入失败
			$con->for_close();
			echo json_encode($response);
			exit ;
		}	
	}else{
		$response['statue'] = -2;//变量设置有问题	
		$con->for_close();
		echo json_encode($response);
		exit;
	}
}else{
	$response['statue'] = -1;//session过期
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
?>