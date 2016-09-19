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

$date = '';
$start_time = 0;
$end_time = 0;
$room = '';

if(isset($_POST['date']) && $_POST['date']
    &&isset($_POST['start_time']) && $_POST['start_time']
	&&isset($_POST['end_time']) && $_POST['end_time']
	&&isset($_POST['room']) && $_POST['room']) {
		
	$date = check_textInput($_POST['date']);
	$start_time = check_textInput($_POST['start_time']);
	$end_time = check_textInput($_POST['end_time']);
	$room = check_textInput($_POST['room']);
//	2是空闲
    $sql1 = "SELECT * FROM time WHERE date = '{$date}'";
    $res1 = $con->get_result($sql1);
    $res2 =  json_encode($con->deal_result($res1));
    $res3 = json_decode($res2,true);
    
    $cids = array();
    for($x = 0;$x < count($res3);$x++ ){
    	$index = $start_time;
//  	echo $index;
    	while($index <= $end_time){
    		$time = 'time_'.$index;
    		if($res3[$x][$time] == 2){
    			$item = $res3[$x]['cid'];
	    		array_push($cids,$item);
//	    		echo $item.'<br>';
	    		break;
	    	}
	    	$index++;
    	}
    }
	
	$re = implode(',', $cids);
	$sql2 = "SELECT cname FROM classroom WHERE area = '{$room}' 
		AND cid in ({$re})";
	$res = $con->get_result($sql2);
	$result = json_encode($con->deal_result($res));	
	echo $result;
	

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
?>