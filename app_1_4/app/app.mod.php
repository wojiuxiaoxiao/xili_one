<?php
class AppObject
{
	var $Config=array();
	var $Get,$Post,$Files,$Request,$Cookie,$Session;
	var $Db;
	var $Member;
	var $MemberHandler;
	var $TemplateHandler;
	var $CookieHandler;
	var $Title='';
	var $MetaKeywords='';
	var $MetaDescription='';
	var $Position='';
	var $Module='index';
	var $Code='';
	var $User;
	function AppObject(&$config)
	{
		$this->Config=$config;
		$this->Get     = &$_GET;
		$this->Post    = &$_POST;
		$this->Cookie  = &$_COOKIE;
		$this->Session = &$_SESSION;
		$this->Request = &$_REQUEST;
		$this->Server  = &$_SERVER;
		$this->Files   = &$_FILES;
		$this->Module = trim($this->Post['app']?$this->Post['app']:$this->Get['app']);
		$this->Act   = trim($this->Post['act']?$this->Post['act']:$this->Get['act']);
		$this->logInput();
		Load::lib("Db");
		$this->Db = Mysql::newMysql();
		//memcache发短信必备
		Load::functions("memcache");
		//push信息推送必备
		Load::functions("push");
		$authcode = $this->Post['authcode'];
		if($authcode){
			$authStr = authcode($authcode,'DECODE');
			//$authStr = $userInfo['uid']."::::".$userInfo['username']."::::".$userInfo['groupid']."::::".time()."::::".$key;
			list($uid,$username,$groupid) = explode("::::",$authStr);
		}
		if($uid>0){
			$this->G['uid'] = $uid;
			define('MEMBER_ID',$this->G['uid']);
			$this->G['username'] = changeCode($username,'utf-8','gbk'); //GBK编码
			define('MEMBER_NAME',$username);
			$this->G['usergroup'] = $groupid;
			define('MEMBER_GROUP',$this->G['usergroup']);
		}
	}

	function outjson($return){
		header("Content-type: application/json");
		$return['servertime'] = time();
		$string = json_encode($return);
		echo $string;
		if ($this->Act == "doPostThread" || $this->Act == "postTopic") {
			$this->logThreadPostCount();
		}
		$this->logOutput($string);
		exit;
	}

	function logThreadPostCount(){
		$countLog = $this->Db->once_fetch_assoc("
		select * from count_post_log
		where `date` =".date("ymd")." and `from` ='app'
		");

		if (isset($countLog['id']) && $countLog['id'] > 0) {
			$this->Db->query("update count_post_log set nums=nums+1 where id=".$countLog['id']);
		}
		else{
			$this->Db->query("insert into count_post_log(`date`,`from`,`nums`) values('".date("ymd")."','app',1)");
		}
	}

	function logInput(){
		$uri = $_SERVER['REQUEST_URI'];
		$postStr = serialize($_POST);
		$str = "\r\n\r\n".date("Y-m-d G:i:s")."\r\n";
		$str .= "\r\n".$uri."\r\n";
		$str .= "\r\n".$postStr."\r\n";
		$str .= "\r\n==================================================================================================\r\n";
		$file = './public/log/input_log'.date("Y_m_d").".txt";
		$fp = fopen($file,'a+');
		fwrite($fp,$str);
		fclose($fp);
	}

	function logOutput($strJson){
		$str = "\r\n\r\n".date("Y-m-d G:i:s")."\r\n";
		$str .= "\r\n".$strJson."\r\n";
		$str .= "\r\n==================================================================================================\r\n";
		$file = './public/log/out_log'.date("Y_m_d").".txt";
		$fp = fopen($file,'a+');
		fwrite($fp,$str);
		fclose($fp);
	}
}
