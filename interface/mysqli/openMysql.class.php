<?php
/**
 * 
 *连接数据库的类
 * 
 * */
class openMysql{
	private $mysqli;
	private $host = "localhost";
	private $root = "root";
	private $password = "";
	private $db = "databasedesign";
	
	function __construct() {
		$this -> mysqli = new mysqli($this -> host, $this -> root, $this -> password, $this -> db);
		if (!$this -> mysqli) {
			die("connect error！" . $this -> mysqli -> connect_error);
		}
		$this -> mysqli -> query("set names 'utf8'");
		$this -> mysqli -> query("set charset set 'utf8'");
	}
	
	//stmt_init()类
	public function stmt($sql){
		$stmt = $this -> mysqli -> prepare($sql);
		return $stmt;
	}
	
	// 只是查询操作
	public function excute_dql($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		if ($row = mysqli_fetch_row($res)) {
			return 1;
		} else {
			return -1;
		}
	}
	//查询   数目
	public function excute_num($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		return $res;
	}
	//为了 获取多个结果
	public function get_result($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		if ($res) {
			return $res;
		} else {
			return -1;
		}
	}
	/*
	 * 处理 多条数据的*/
	public function deal_result($result){
		$res = array();
		$num = mysqli_num_rows($result);
		if($num == 0){
			$res['statue'] = -3;
		}elseif($num == 1){
			$res = mysqli_fetch_assoc($result);
		}elseif($num > 1){
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($res, $row);
			}
		}
		return $res;
	}
	//增删改操作
	public function excute_dml($sql) {
		$res = $this -> mysqli -> query($sql) or die($this -> mysqli -> error);
		if (!$res) {
			return -1;
		} else {
			if ($this -> mysqli -> affected_rows == 0) {
				return -1;
			} else {
				return 1;
			}
		}
	}
	
	public function get_length($sql){
		$res = $this -> mysqli ->query($sql);
		return $res;
	}

	//关闭自动提交
	function auto_commit() {
		$this -> mysqli -> autocommit(FALSE);
	}

	//确认提交
	function my_commit() {
		$this -> mysqli -> commit();
	}
	//回滚 
	function my_rollback() {
		$this-> mysqli-> rollback();
	}
	//获得最新的id
	function get_id() {
		return $this -> mysqli -> insert_id;
	}

	function for_close() {
		$this -> mysqli -> close();
	}
}
?>