<?php
/*
 * 查找教室名字
 * 
 */	
 
session_start();
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/openMysql.class.php';
$response = array("statue" => '');
$con = new openMysql();

$area = '';

if(isset($_POST['area']) && $_POST['area']) {
	$area = $_POST['area'];
	
	$sql = "SELECT cname,cid FROM classroom WHERE area = '{$area}'";
	$res1 = $con->get_result($sql);
    $res2 =  json_encode($con->deal_result($res1));
    echo $res2;
}
?>