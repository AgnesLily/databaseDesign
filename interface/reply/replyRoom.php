<?php
/*
 * 提交反馈信息
 * 
 */	
 
session_start();
header("Content-Type: text/html; charset=UTF-8");
include_once '../mysqli/openMysql.class.php';
$response = array("statue" => '');
$con = new openMysql();
$des = '';
$comment = '';

//if(isset($_SESSION['id']) && isset($_SESSION['password'])){
//	if(isset($_POST['des']) && $_POST['des']
//  	&&isset($_POST['comment']) && $_POST['comment']
//		&&isset($_POST['cid']) && $_POST['cid']) {
		
		$sid = $_SESSION['id'];
		$des = check_textInput($_POST['des']);
		$comment = check_textInput($_POST['comment']);
		$cid = $_POST['cid'];
		$pic['file'] = $_FILES['pic'];
		var_dump($pic);
		
		//将图片存到某个文件夹，然后返回路径
		//自定义文件名称  
        $array = $pic["file"]["name"];  
        $array = explode(".",$array);  
        $newfilename= time().$array[1];//自定义文件名（测试的时候中文名会操作失败）  
        $path = "../../assets/upload/".$_SESSION["id"];
        
        $path2 = "http://localhost/databaseDesign/assets/upload/".$_SESSION["id"]."/".$newfilename;
          
        if (!is_dir($path))//当路径不存在  
        {  
            mkdir($path);//创建路径  
        }  
        $url=$path."/";//记录路径  
        move_uploaded_file($pic["file"]["tmp_name"],$url.$newfilename);  
        
        $sql = "INSERT INTO reply(sid,cid,des,comment,pic) 
        		VALUES('{$sid}','{$cid}','{$des}','{$comment}','{$path2}')";
        $res = $con->excute_dml($sql);
        
        if($res == 1){
        	$response['statue'] = 1;//插入成功
			$con->for_close();
			echo json_encode($response);
			exit;
        }		
        
        //}		

//	}else{
//		$response['statue'] = -2;//变量设置有问题	
//		$con->for_close();
//		echo json_encode($response);
//		exit;
//	}
//}else {
//	$response['statue'] = -1;//session过期	
//	$con->for_close();
//	echo json_encode($response);
//	exit;
//}


//检查数据
function check_textInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>