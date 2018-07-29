<?php
	class MySql {
		var $queryCount = 0;
		var $conn;
		var $result;
		static $mysqlobj = null;
		//$mysql = Mysql::newMysql();
		private function MySql(){
			if(!function_exists('mysql_connect')){
				die('服务器PHP不支持MySql数据库');
			}
			require(ROOT_PATH . VERSION.'/config/config.php');
			$this->conn = mysql_connect($config['dbhost'],$config['dbuser'],$config['dbpass']) or die("连接数据库失败,可能是数据库用户名或密码错误");
			mysql_query("SET NAMES gbk");
			mysql_select_db($config['dbname'], $this->conn) OR die("未找到指定数据库");			
		}
		static function newMysql() {
			if(self::$mysqlobj == null) {
				self::$mysqlobj = new Mysql();
			}
			return self::$mysqlobj;
		}
		function __destruct() {
			$this->close();
		}
		function close(){
			return mysql_close($this->conn);
		}
		function query($sql){
			$this->result = mysql_query($sql,$this->conn);
			$this->queryCount++;
			if (!$this->result){
				die("SQL语句执行错误：$sql <br />".$this->geterror($sql));
			}else{
				return $this->result;
			}
		} 
		function fetch_all_array($sql){
			$all_array = array();
			$query = $this->query($sql);
			while($list_item = $this->fetch_array($query)){
				$all_array[] = $list_item;
			}
			return $all_array;
		}
		function fetch_all_row($sql){
			$all_row = array();
			$query = $this->query($sql);
			while($list_item = $this -> fetch_row($query)){
				$all_row[] = $list_item;
			}
			return $all_row;
		}
		function fetch_array($query){
			return mysql_fetch_array($query);
		}
		function once_fetch_array($sql){
			$this->result = $this->query($sql);
			return $this->fetch_array($this->result);
		}
		function fetch_row($query){
			return mysql_fetch_row($query);
		}
		function fetch_all_assoc($sql,$max=0){
			$all_array = array();
			$query = $this->query($sql);
			$current_index=0;
			while($list_item = $this->fetch_assoc($query)){
				$current_index ++;
				if($current_index > $max && $max != 0){
					break;
				}
				$all_array[] = $list_item;
			}
			return $all_array;
		}
		function fetch_assoc($query){
			return mysql_fetch_assoc($query);
		}
		function once_fetch_assoc($sql){
			$list 	= $this->query($sql);
			$list_array = $this->fetch_assoc($list);
			return $list_array;
		}
		function num_rows($query){
			return mysql_num_rows($query);
		}
		function once_num_rows($sql){
			$query=$this->query($sql);
			return mysql_num_rows($query);
		}
		function num_fields($query){
			return mysql_num_fields($query);
		}
		function insert_id(){
			return mysql_insert_id($this->conn);
		}
		function insertArr($arrData,$table,$where=''){
			$Item = array();
			foreach($arrData as $key=>$data){
				$Item[] = "$key='$data'";
			}
			$intStr = implode(',',$Item);
			$sql = "insert into $table  SET $intStr $where";
			$this->query("insert into $table  SET $intStr $where");
			return mysql_insert_id($this->conn);
		}
		function updateArr($arrData,$table,$where=''){
			$Item = array();
			foreach($arrData as $key => $date)
			{
				$Item[] = "$key='$date'";
			}
			$upStr = implode(',',$Item);
			$this->query("UPDATE $table  SET  $upStr $where");
			return true;
		}
		function geterror($sql=''){
			/*$error = mysql_error();
			$file = date('Y_m_d');
			$file = './log/log_mysql_'.$file.".txt";
			$fp = fopen($file,'a+');
			$str = date('G:i:s').$sql." ".$error."\r\n\r\n";
			fwrite($fp,$str);
			fclose($fp);

			return $error;*/
		}
		function affected_rows(){
			return mysql_affected_rows();
		}
		function getMysqlVersion(){
			return @mysql_get_server_info();
		}
	}