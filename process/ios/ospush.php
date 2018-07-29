<?php
	date_default_timezone_set('Australia/Melbourne');
	//配置区
	$deviceToken = "dd8d63823914b51fac905169ee5427a80b73ec350a2de503afdc9c5f0c1508fd";
	
	$passphrase = '6DvUzBz4UaXyPw'; //密码
	$ctx = stream_context_create();
	stream_context_set_option($ctx, "ssl", "local_cert", "ck.pem");
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);  
	
	$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
	var_dump($fp);
	if(!$fp) {
		echo "ERROR: $errno - $errstr<br />\n";
	}
	if (!$fp) {
		die('Server Error');
	}

	$con = mysql_connect("localhost", "root", "XZ9abRF4");
	mysql_select_db("yeeyico_new");
	mysql_query("set names utf8");
	while (true) {
		if (!mysql_ping($con)) {
			mysql_close($con);
			$con = mysql_connect("localhost", "root", "XZ9abRF4");
			mysql_select_db("yeeyico_new");
			mysql_query("set names utf8");
		}
		$newPush = mysql_query("select * from app_ios_push");
		while ($pushInfo = mysql_fetch_assoc($newPush)) {
			if (!$fp) {
				fclose($fp);
				$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
				if (!$fp) {
					sleep(10);
					continue;
				}
			}
			if (!mysql_ping($con)) {
				mysql_close($con);
				$con = mysql_connect("localhost", "root", "XZ9abRF4");
				mysql_select_db("yeeyico_new");
				mysql_query("set names utf8");
			}
			mysql_query("delete from app_ios_push where id=".$pushInfo['id']);
			$apnsKey = 'ios_apns_'.$pushInfo['id'];
			$checkApns = getVar($apnsKey);
			if($checkApns){
				//已经推送过就不处理
				continue;
			}
			else{
				setVar($apnsKey,1);
			}
			$body = unserialize($pushInfo['content']);
			$token = $pushInfo['token'];
			$payload = json_encode($body);
			if($token == 'all'){
				if (!mysql_ping($con)) {
					mysql_close($con);
					$con = mysql_connect("localhost", "root", "XZ9abRF4");
					mysql_select_db("yeeyico_new");
					mysql_query("set names utf8");
				}
				$num = 0;
				$tokenResult = mysql_query("select token from app_user_authcode where token!='' order by lastactive desc");
				while($tokenInfo = mysql_fetch_assoc($tokenResult)){
					$deviceToken = $tokenInfo['token'];
					$msg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
					$result = fwrite($fp, $msg);
					logInfo($deviceToken.'--------'.$result.'=========');
					/*if($result == 0){
						fclose($fp);
						sleep(1);
						$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
						fwrite($fp, $msg);
					}
					*/
					if($num++%100 == 0){
						fclose($fp);
						sleep(2);
						$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);

					}
				}
			}
			else{
				$deviceToken = $token;
				$deviceToken = 'dd8d63823914b51fac905169ee5427a80b73ec350a2de503afdc9c5f0c1508fd';
				$msg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
				$result = fwrite($fp, $msg);
				logInfo($deviceToken.'--------'.$result.'=========');
			}
			mysql_query("delete from app_ios_push where id=".$pushInfo['id']);

		}
		sleep(5);
	}

	function changeCode($array,$from='gbk',$to='utf-8'){
		if(is_array($array)){
			foreach($array as $k=>$v){
				if(is_array($v)){
					$array[$k] = changeCode($v,$from,$to);
				}
				else{
					$array[$k] = mb_convert_encoding($v,$to,$from);
				}
			}
			return $array;
		}
		else{
			return mb_convert_encoding($array,$to,$from);
		}
	}

	function logInfo($str){
		$file = 'log_ios_push_'.date("Y_m_d")."_.txt";
		$fp = fopen($file,'a+');
		fwrite($fp,date("m-d G:i:s")."   ".$str."\r\n");
		fclose($fp);
		/**/
	}
	
	/**
	+----------------------------------------------------------
	 * 构造MmCache 对象
	+----------------------------------------------------------
	 * @return object
	+----------------------------------------------------------
	 */
	function getCacheObj()
	{
		$cache = new Memcached();
		$cache->addServer("127.0.0.1",11888);
		return $cache;
	}

	/**
	+----------------------------------------------------------
	 * 读取缓存
	+----------------------------------------------------------
	 * @param string $key 缓存键值
	+----------------------------------------------------------
	 * @return mixed
	+----------------------------------------------------------
	 */
	function getVar($key)
	{
		return getCacheObj()->get($key);
	}


	/**
	+----------------------------------------------------------
	 * 写入缓存
	+----------------------------------------------------------
	 * @param string  $key    缓存键值
	 * @param mixed   $value  被缓存的数据
	+----------------------------------------------------------
	 * @return boolean
	+----------------------------------------------------------
	 */
	function setVar($key, $value, $expire=0)
	{
		return getCacheObj()->set($key, $value,$expire);
	}


?>
