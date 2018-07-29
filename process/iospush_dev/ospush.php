<?php
	date_default_timezone_set('Australia/Melbourne');
	echo '1';
	//配置区
	$deviceToken = "aa1e552125ab41854e1627ebef7ded0fce3802b4fe2f42d38e6d83929c1b0d9b";
	
	$passphrase = 'yJ34qgRXPEXxmJ'; //密码
	$ctx = stream_context_create();
	stream_context_set_option($ctx, "ssl", "local_cert", "ck.pem");
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);  
	
	$fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
	var_dump($fp);
	if(!$fp) {
		echo "ERROR: $errno - $errstr<br />\n";
	}
	if (!$fp) {
		die('Server Error');
	}

	/*
	$body = array(
			"aps" => array(
				"alert" => '萌化！考拉宝宝怀抱毛绒玩具 走出丧母伤痛',
				"badge" => 1,
				'sound' => 'bingbong.aiff',
				'i'=>time(),
				't'=>1,
				'd'=>152338,
				'm'=>'萌化！考拉宝宝怀抱毛绒玩具 走出丧母伤痛'
			),
			'data' => array(
				'i'=>time(),
				't'=>1,
				'd'=>152338,
				'm'=>'萌化！考拉宝宝怀抱毛绒玩具 走出丧母伤痛'
			)
	);
	*/
	$body = array(
		"aps" => array(
			"alert" => '萌化！考拉宝宝怀抱毛绒玩具 走出丧母伤痛',
			"badge" => 1,
			'sound' => 'bingbong.aiff',

		),
		'i'=>time(),
		't'=>1,
		'id'=>152338,
		'm'=>'萌化！考拉宝宝怀抱毛绒玩具 走出丧母伤痛'
	);
	//$body = array("aps" => array("alert" => array('title'=>'测试新的内容','body'=>'内容',"action-loc-key" =>"PLAY"), "badge" => 1, 'sound' => 'bingbong.aiff'));
	$payload = json_encode($body);
	$msg = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
	$result = fwrite($fp, $msg);
	var_dump($result);
    fclose($fp);
?>
