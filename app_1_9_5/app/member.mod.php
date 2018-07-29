<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if(in_array($this->Act,array('myReply','doReName','myFavorite','changeFace','doChangePwd','sendPm','replyPm','pmList','sysNotice','myReply','replyMe','verifyTel','doChangeNamePwdGender','doChangePhone'))){
			if($this->G['uid']<1){
				$return['status'] = 5100;
				$return['message'] = '用户未登录，请登陆后再试';
				$this->outjson($return);
			}
		}

		Load::functions("sms");
        if($this->Act == 'sendmsg'){
            $this->sendmsg();
        }
        if($this->Act == 'checkmsg'){
            $this->checkmsg();
        }
        else if($this->Act == 'dologin'){
            $this->doLogin();
        }
        else if($this->Act == 'findByMail'){
            $this->findByMail();
        }
		else if($this->Act == 'findBySms'){
			$this->findBySms();
		}
		else if($this->Act == 'getUser'){
			$this->getUser();
		}
		else if($this->Act == 'changeFace'){
			$this->changeFace();
		}
		else if($this->Act == 'domesticRegister'){
			$this->domesticRegister();
		}
		else if($this->Act == 'userThread'){
			$this->userThread();
		}
		else if($this->Act == 'myFavorite'){
			$this->myFavorite();
		}
        else if($this->Act == 'delUser'){
            $this->delUser();
        }
        else if($this->Act == 'myReply'){
            $this->myReply();
        }
        else if($this->Act == 'replyMe'){
            $this->replyMe();
        }
		else if($this->Act == 'doReName'){
			$this->doReName();
		}
		else if($this->Act == 'doChangeGender'){
			$this->doChangeGender();
		}
		else if($this->Act == 'checkName'){
			$this->checkName();
		}
		else if($this->Act == 'doChangePwd'){
			$this->doChangePwd();
		}
		else if($this->Act == 'sendPm'){
			$this->sendPm();
		}
		else if($this->Act == 'pmList'){
			$this->pmList();
		}
		else if($this->Act == 'pmView'){
			$this->pmView();
		}
        else if($this->Act == 'sysNotice'){
            $this->sysNotice();
        }
		else if($this->Act == 'verifyTel'){
			$this->verifyTel();
		}
		else if($this->Act == 'feedback'){
			$this->feedback();
		}
		else if($this->Act == 'testSendMail'){
			$this->testSendMail();
		}
		else if($this->Act == 'testRename'){
			$this->testRename();
		}
		else if($this->Act == 'switchInfo'){
			$this->switchInfo();
		}
		else if($this->Act == 'editSwitch'){
			$this->editSwitch();
		}
		else if($this->Act == 'unreadInfo'){
			$this->unreadInfo();
		}
        else if($this->Act == 'saveInfo'){
            $this->saveInfo();
        }
		else if($this->Act == 'emptyNum'){
			$this->emptyNum();
		}else if($this->Act == 'sendPwd'){
			$this->sendFirstPwd();
		}else if($this->Act == 'doChangeNamePwdGender'){
			$this->doChangeNamePwdGender();
		}else if($this->Act == 'doChangePhone'){
			$this->doChangePhone();
		}else if($this->Act == 'testSend'){
			$this->testSend();
		}
	}
	function index(){
		die('Error');
	}


	function saveInfo(){

        if(MEMBER_ID < 1){
            $return['status']  = 1;
            $return['message'] = '未登录';
            $this->outjson($return);
        }

	    $saveAs = trim($this->Post['saveAs']);
	    $value  = trim($this->Post['value']);

	    if ($saveAs == 'birth' && count($value)>0){
	        if (strtotime($value)){
	            $birth = strtotime($value);
	            $year  = date('Y',$birth);
	            $month = date('m',$birth);
	            $day   = date('d',$birth);
	            $this->Db->query("update `pre_common_member_profile` set birthyear=".$year.",birthmonth=".$month.",birthday=".$day." where uid=".MEMBER_ID);
	            $return['status'] = 0;
            }else{
	            $return['status']  = 1;
	            $return['message'] = '日期格式不正确！';
            }
        }else if ($saveAs == 'summary' && count($value)>0){
	        $summary = changeCode($value,'utf-8','gbk');
            $this->Db->query("update `pre_common_member_field_forum` set sightml='".$summary."' where uid=".MEMBER_ID);
            $return['status'] = 0;
        }else{
            $return['status']  = 1;
            $return['message'] = '请求参数错误！';
        }
        $this->outjson($return);
    }

	/*
	 * 更换手机号
	 */
	function doChangePhone()
	{
		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';  //   $return['message'] = '操作成功';
			$this->outjson($return);
		}

		$tel = trim($this->Post['tel']);
		$smsCode = intval(trim($this->Post['smsCode']));
		$keyCode = 'sms_' . $tel;
		$saveCode = getVar($keyCode);
		if (strlen($smsCode) > 1 && $smsCode == $saveCode) {
//			$oldtel = trim($this->Post['oldtel']);  //判断输入的旧手机号是否是该账户的手机号
//			$userTelTmp = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_phone_verify where phone='" . $oldtel . "' and status=1 and uid!=" . MEMBER_ID);
//			if (!isset($userTelTmp['uid']) || $userTelTmp['uid'] != MEMBER_ID) {
//				$return['status'] = 1;
//				$return['message'] = '原绑定手机号输入错误！';
//				$this->outjson($return);
//			}
			//判断新手机号是否与另一个账号绑定

			$userTelTmp = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_phone_verify where phone='" . $tel . "' and status=1 and uid!=" . MEMBER_ID);
			if (isset($userTelTmp['uid']) && $userTelTmp['uid'] > 0 && $userTelTmp['uid'] != MEMBER_ID) {
				$return['status'] = 1;
				$return['message'] = '该新手机号已与另一个账号绑定！';
				$this->outjson($return);
			}

			$userTelTmp = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_phone_verify where phone='" . $tel . "' and status=1");
			if (isset($userTelTmp['uid']) && $userTelTmp['uid'] > 0) {
				$return['status'] = 1;
				$return['message'] = '该新手机号已绑定！';
				$this->outjson($return);
			}

			//更新手机号
			$this->Db->query("update yeeyico_new.pre_phone_verify set phone='" . $tel . "' where uid=".MEMBER_ID);
			$return['status'] = 0;
			$return['message'] = '绑定手机号修改成功！';
			$this->outjson($return);
		} else {
			//短信验证码错误，请重新输入
			$return['status'] = 1;
			$return['message'] = '验证码错误！';
			$this->outjson($return);
		}
	}

	function testSend(){
		$message = "来自亿忆网的短信：您在亿忆网使用手机注册帐号的随机密码是 ".'123456'." ";
		$mobile = '61404357864';
		//$key = md5($mobile."_e2_msgkey");   
		//$return = SendSMSChina($mobile,$message,$key, 0);
		$return = SendSMS($mobile,$message,0);
		var_dump($return);
	}


	/**
	 * 新用户注册修改默认用户名密码性别(20170831dong添加)
	 * @param
	 */
	function doChangeNamePwdGender(){

		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		//获取性别，新老密码，用户名
		$gender = intval($this->Post['gender']);
		$newPwd = $this->Post['newpwd'];
		if(!preg_match('/^(?=.*[A-Z])[a-zA-Z0-9]{6,15}$/',$newPwd)){
			$return['status'] = 1;
			$return['message'] = '密码必须是6-15位字母数字组合,含大写字母';
			$this->outjson($return);
		}
		$name = trim($this->Post['username']);
		$uid = MEMBER_ID;
		//判断用户名是否为空
		if(empty($name)){
			//用户名为空，不处理
			$name = 'nochange';
		}else{
			//判断用户名格式是否正确
			$this->checkName($name);
			//判断是否能修改用户名
			$userInfo = $this->getUserInfo(MEMBER_ID);
			if($userInfo['allow_rename'] == 0){
				$return['status'] = 5960;
				$return['message'] = "用户无权修改用户名!";
				$this->outjson($return);
			}
		}
		if(empty($gender)){
			//性别为空
			$gender = 'nochange';
		}else{
			//判断用户有没有操作性格的权限
			$changeLog = $this->Db->once_fetch_assoc("select * from app_change_user_gender where uid =".$uid);
			if (isset($changeLog['uid'])) {
				$this->outjson(array('status' => 10002));
			}

			//修改性别
			$this->Db->query("update pre_common_member_profile set gender=".$gender." where uid=".$uid);
			$this->Db->query("insert into app_change_user_gender values(".$uid.", 1)");
		}
		//修改密码
		$userInfo = $this->Db->once_fetch_assoc("select username, uid, password, salt FROM centery_main.uc_members WHERE uid=".$uid);
		$salt = $userInfo['salt'];
		$pwd1 = md5(md5($newPwd).$salt);
		$pwd2 = md5($newPwd);
		$this->Db->query("update centery_main.uc_members set password='".$pwd1."' where uid=".$uid);
		$this->Db->query("update pre_common_member set password='".$pwd2."' where uid=".$uid);
		//修改用户名
		if(isset($name)&&$name!='nochange'){
			$username = changeCode($name,'utf-8','gbk');
			$this->Db->query("update centery_main.uc_members set username='".$username."' where uid=".MEMBER_ID);
			$this->Db->query("update pre_common_member set username='".$username."' where uid=".MEMBER_ID);
			$this->Db->query("update yeeyico_new.pre_phone_verify set username='".$username."' where uid=".MEMBER_ID);
			$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".MEMBER_ID."',1)");
			//记录状态
			$this->Db->query("replace into app_change_name(uid,`rename`) values('".MEMBER_ID."',1)");


			/* 2017.05.12 edit by allen qu  修改名称后   authcode也要重新修改 */
			//设备id
			$devid = trim($this->Post['devid']);
			$time = time();
			$key = md5($time."_e2app^");
			$authStr = $userInfo['uid']."::::".$name."::::".$userInfo['groupid']."::::".$devid."::::".time()."::::".$key;
			$authcode = authcode($authStr,86400*720);

			if($devid){
				list($dev,$tmp) = explode('|',$devid);
				if($dev!='null'){
					$devmd5 = md5($dev);
					$checkDevId = $this->Db->once_fetch_assoc("select * from app_user_authcode where devmd5='".$devmd5."'");
					if($checkDevId['devid']){
						$this->Db->query("update app_user_authcode set uid='".$userInfo['uid']."',devid='".$devid."',authcode='".$authcode."' where devmd5='".$devmd5."'");
					}
					else{
						$this->Db->query("insert into app_user_authcode set uid='".$userInfo['uid']."',authcode='".$authcode."',devid='".$devid."',dev='".$dev."',devmd5='".$devmd5."'");
					}
				}
			}
		}
		$return['authcode'] = $authcode;
		$return['status'] = 0;
		//$return['message'] = '修改信息成功';
		$this->outjson($return);
	}
	/**
	 * 新用户注册默认密码短信发送(20170831dong添加)
	 * @param
	 */
	function sendFirstPwd(){
		$tel = trim($this->Post['tel']);
		$password = getVar('61Australia'.$tel);
		if(isset($password) && !empty($password) && $password != false){
			$countryCode=61;
//			$return['tel']=$tel;
//			$return['countryCode']=$countryCode;
//			$return['password']=$password;
			sendPwd($tel,$password, $countryCode);
			setVar($countryCode.'Australia'.$tel,$password,time());
			$return['status']=0;
			$this->outjson($return);
		}else{
			$return['status']=1;
			//$return['password']=$password;
			$this->outjson($return);
		}
		//sendPwd($tel,$password, $countryCode);
	}

	function doChangeGender(){
		$gender = intval($this->Post['gender']);
		$uid = MEMBER_ID;

		if (!in_array($gender, array(0, 1, 2))) {
			$this->outjson(array('status' => 40002));
		}

		$changeLog = $this->Db->once_fetch_assoc("select * from app_change_user_gender where uid =".$uid);

		if(intval($changeLog['changed']) >= 3){    //修改dong
			$this->outjson(array('status' => 10002));
		}

//		if (isset($changeLog['uid'])) {
//			$this->outjson(array('status' => 10002));
//		}

		$this->Db->query("update pre_common_member_profile set gender=".$gender." where uid=".$uid);
//		$this->Db->query("insert into app_change_user_gender values(".$uid.", 1)");  //修改dong
		$this->Db->query("replace into app_change_user_gender(uid,`changed`) values('".MEMBER_ID."',".($changeLog['changed']+1).")");
		$return = array();
		$return['status'] = 0;
		$return['message'] = '修改成功！';
		$return['userInfo'] = $this->getUserInfo($uid);
		$this->outjson($return);
	}

	function testRename()
	{
		if (MEMBER_ID > 1) {

			$this->Db->query("update app_change_name set rename=0  where uid=".MEMBER_ID);

			$this->outjson('success');
		}

	}

	function testSendMail()
	{
		$email = $this->Post['email'];
		$a = $this->sendGetPwdMail($email, 15, 'qusheng', '123456');
		$this->outjson($a);
	}


	/**
	 * 意见反馈
	 * @param $message
	 */
	function feedback(){
		$message = $this->Post['message'];
		load::logic("ThreadPost");
		$postObj = new ThreadPost();
		$dateline = time();
		list($a,$b) = explode('|',$message);
		if($b){
			$subject = mb_substr($b,0,15,'utf-8');
		}
		else{
			$subject = mb_substr($a,0,15,'utf-8');
		}

		$content = $message;
		$post = $postObj->postThread(234,$subject,$content,$dateline,0);
		$return = array();
		$return['status'] = 0;
		$return['message'] = '您的反馈意见成功提交！';
		$this->outjson($return);
	}

	/**
	 * 手机号码认证
	 * @param string $tel
	 * @param string $sms
	 */
    function verifyTel($tel='',$smsCode=''){
		$tel = trim($this->Post['tel']);
		$smsCode = intval(trim($this->Post['smsCode']));
		$keyCode = 'sms_'.$tel;
		$saveCode = getVar($keyCode);
		if(strlen($smsCode)>1 && $smsCode == $saveCode){

		    /* create by chen at 2017-11-15 */
//		    delVar($keyCode);
		    /* -----end create */

			//判断手机
			$userTelTmp = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_phone_verify where phone='".$tel."' and status=1 and uid!=".MEMBER_ID );
			if(isset($userTelTmp['uid']) && $userTelTmp['uid']>0 && $userTelTmp['uid']!=MEMBER_ID){
				$return['status'] = 1;
				$return['message'] = '手机号已与另一个账号绑定';
				$this->outjson($return);
			}

			$userInfoTmp = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_phone_verify where uid=".MEMBER_ID);
			$userInfo = $this->Db->once_fetch_assoc("select * from pre_common_member where uid=".MEMBER_ID);
			if($userInfo['groupid'] == 8){
				$userInfo['groupid'] = 10;
				$this->Db->query("update pre_common_member set groupid=10,emailstatus=1 where uid=".MEMBER_ID);
			}
			if($userInfoTmp['uid']<1){
				//删除该手机其他的未绑定的
				$this->Db->query("delete from yeeyico_new.pre_phone_verify where phone='".$tel."'");
				$this->Db->query("insert into yeeyico_new.pre_phone_verify(uid,username,groupid,dateline,phone,status) values('".MEMBER_ID."','".$userInfo['username']."','".$userInfo['groupid']."','".time()."','".$tel."',1)");
				$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".MEMBER_ID."',1)");
			}
			else{
				if($userInfoTmp['status']  != 1){
					$this->Db->query("update yeeyico_new.pre_phone_verify set groupid=10,status=1,phone='".$tel."' where uid=".MEMBER_ID);
					$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".MEMBER_ID."',1)");

				}
				else{
					if($userInfoTmp['phone']!=$tel){
						$return['status'] = 5933;
						$this->outjson($return);
					}
				}
			}
			$return['status'] = 0;
			$this->outjson($return);
		}
		else{
			//短信验证码错误，请重新输入
			$return['status'] = 1;
			$return['message'] = '短信校验失败';
			$this->outjson($return);
		}

	}

	function delUser(){
        $uid = intval($this->Post['uid']);
        $this->Db->query("delete from  sns_user_map  where uid=".$uid);
        $this->Db->query("delete from yeeyico_new.`pre_phone_verify` where uid=".$uid);
        echo 'Success';
    }

    function sysNotice(){
        $start = intval($this->Post['start']); //lastdateline
        $amount = intval($this->Post['amount']);
        if($start>0){
            $list = $this->Db->fetch_all_assoc("select id,authorid,author,note,dateline from `pre_home_notification` where uid=".MEMBER_ID." and  `type`='system' and id<$start order by id desc limit $amount");
        }
        else{
            $list = $this->Db->fetch_all_assoc("select id,authorid,author,note,dateline from `pre_home_notification` where uid=".MEMBER_ID."  and  `type`='system' order by id desc limit $amount");
        }
        foreach($list as $k=>$v){
            $list[$k]['note'] =strip_tags($v['note']);
        }
		if(!is_array($list)){
			$list = array();
		}
        $return['status'] = 0;
        $return['list'] = changeCode($list);
        $this->outjson($return);
    }

	/**
	 * 发送消息
	 * @param toUid 发送的uid
	 * @param message 消息内容
	 */
	function sendPm(){
        $toUid    = intval($this->Post['toUid']);
        $uid      = intval($this->Post['uid']);
        $message  = trim($this->Post['message']);
        $message  = changeCode($message, 'utf-8', 'gbk');
        $username = changeCode(MEMBER_NAME, 'utf-8', 'gbk');

		$time = time();
		$existUser = $this->Db->once_fetch_assoc("select * from pre_common_member where uid=".$toUid);

		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';  //   $return['message'] = '操作成功';
			$this->outjson($return);
		}
		if($existUser['uid']<1){
			$return['status'] = 5970;
			$this->outjson($return);
		}
		$lastsummary = mb_substr(trim(strip_tags($message)),0,50,'gbk');
		$lastmessage = array('lastauthorid' => MEMBER_ID, 'lastauthor' => $username, 'lastsummary' => $lastsummary);
		$lastmessage = addslashes(serialize($lastmessage));
		if($toUid<MEMBER_ID){
			$min_max = $toUid."_".MEMBER_ID;
		}
		else{
			$min_max = MEMBER_ID."_".$toUid;
		}
		$existPlid = $this->Db->once_fetch_assoc("SELECT plid FROM `centery_main`.uc_pm_lists WHERE min_max='".$min_max."'");
		if($existPlid['plid']>0){
			$plid = $existPlid['plid'];
			$this->Db->query("UPDATE `centery_main`.uc_pm_lists SET lastmessage='".$lastmessage."' WHERE plid='$plid' AND min_max='".$min_max."'");
		}
		else{
			$this->Db->query("INSERT INTO `centery_main`.uc_pm_lists(authorid, pmtype, subject, members, min_max, dateline, lastmessage) VALUES('".MEMBER_ID."', '1', '', 2, '".$min_max."', '".$time."', '$lastmessage')");
			$plid = $this->Db->insert_id();
		}
		$this->Db->query("INSERT INTO `centery_main`.uc_pm_indexes(plid) VALUES('$plid')");
		$pmid = $this->Db->insert_id();
		$this->Db->query("INSERT INTO `centery_main`.uc_".$this->getposttablename($plid)."(pmid, plid, authorid, message, dateline, delstatus) VALUES('$pmid', '$plid', '".MEMBER_ID."', '$message', '".$time."', 0)");
		if($existPlid['plid']>0){
			//判断是否存在
			$checkUExist = $this->Db->once_fetch_assoc("select plid,uid from `centery_main`.uc_pm_members where plid=".$plid." and uid=".MEMBER_ID);
			if($checkUExist['plid']>0){
				$this->Db->query("UPDATE `centery_main`.uc_pm_members SET isnew=1, pmnum=pmnum+1, lastdateline='".$time."' WHERE plid='$plid' AND uid='".MEMBER_ID."'");
			}
			else{
				$this->Db->query("INSERT INTO `centery_main`.uc_pm_members(plid, uid, isnew, pmnum, lastupdate, lastdateline) VALUES('$plid', '".MEMBER_ID."', '0', '1', '".$time."', '".$time."')");
			}

			//判断是否存在
			$checkUExist = $this->Db->once_fetch_assoc("select plid,uid from `centery_main`.uc_pm_members where plid=".$plid." and uid=".$toUid);
			if($checkUExist['plid']>0){
				$this->Db->query("UPDATE `centery_main`.uc_pm_members SET isnew=1, pmnum=pmnum+1, lastdateline='".$time."' WHERE plid='$plid' AND uid='".$toUid."'");
			}
			else{
				$this->Db->query("INSERT INTO `centery_main`.uc_pm_members(plid, uid, isnew, pmnum, lastupdate, lastdateline) VALUES('$plid', '".$toUid."', '0', '1', '".$time."', '".$time."')");
			}
		}
		else{
			$this->Db->query("INSERT INTO `centery_main`.uc_pm_members(plid, uid, isnew, pmnum, lastupdate, lastdateline) VALUES('$plid', '".$toUid."', '1', '1', '0', '".$time."')");
			$this->Db->query("INSERT INTO `centery_main`.uc_pm_members(plid, uid, isnew, pmnum, lastupdate, lastdateline) VALUES('$plid', '".MEMBER_ID."', '0', '1', '".$time."', '".$time."')");
		}
		pushNotice($toUid);

		$this->Db->query("REPLACE INTO `centery_main`.uc_newpm(uid) VALUES(".$toUid.")");
		$return['status'] = 0;
		$return['pmid'] = $pmid;
//		$this->outjson($return);

        /* 添加推送 create by chen */
        Load::functions('getui');
        $push['template']         = "transmission";
        $push['message']['title'] = "";
        $content['action']        = "zhannei_message";
        $content['id']            = $uid;
        $content['title']         = "收到一条站内信";
        //添加未读记录
        $this->Db->query("INSERT INTO yeeyico_new.app_unread_msg_record values('','{$toUid}','{$uid}','1')");
        $up            = $this->Db->once_fetch_assoc("select * from app_user_getui_client where uid=".$toUid);
        if ($this->G['uid'] != $toUid) {
            if ($up['uid'] > 0 && $up['client_id'] != "") {
                $push['cid']                = $up['client_id'];
                $push['message']['content'] = json_encode($content);
                $push['message']['body']    = "收到一条站内信";
                pushMessageToSingle($push);
            }
        }
        //----------------------------------------------------
        $this->outjson($return);
	}


	/**
	 * 消息列表
	 */
	function pmList(){
		$start = intval($this->Post['start']); //lastdateline
		$amount = intval($this->Post['amount']);
		$pmlist = array();
		if($start>0){
			$sql = "SELECT t.plid,uid,pmnum,lastdateline,subject,min_max,lastmessage FROM centery_main.uc_pm_members m LEFT JOIN centery_main.uc_pm_lists t ON t.plid=m.plid WHERE t.plid is not null and m.uid=".MEMBER_ID." and lastdateline<$start ORDER BY lastdateline DESC limit $amount";
		}
		else{
			$sql = "SELECT t.plid,uid,pmnum,lastdateline,subject,min_max,lastmessage FROM centery_main.uc_pm_members m LEFT JOIN centery_main.uc_pm_lists t ON t.plid=m.plid WHERE  t.plid is not null and  m.uid=".MEMBER_ID."  ORDER BY lastdateline DESC limit $amount";
		}

		$res = $this->Db->fetch_all_assoc($sql);

		$result = $this->Db->query($sql);
		$listAryTmp = array();
		$otherUid = array();
		while($pm = $this->Db->fetch_assoc($result)){
			if($pm['plid']<1){
				continue;
			}
			list($min,$max) = explode("_",$pm['min_max']);
			if($min == MEMBER_ID){
				$other = $max;
			}
			else{
				$other = $min;
			}
			$otherUid[]=intval($other);
			$listAryTmp[$other] = $pm;
		}



		if(count($otherUid)>0){
			$userResult = $this->Db->query("select uid,username from centery_main.uc_members where uid in(".implode(',',$otherUid).")");
			while($u = $this->Db->fetch_assoc($userResult)){
				$other = $u['uid'];
				$listAryTmp[$other]['fromName'] = trim(strval($u['username']));
				$listAryTmp[$other]['fromUid'] = $u['uid'];
				$listAryTmp[$other]['fromFace'] = "http://center.yeeyi.com/avatar.php?uid=".$u['uid']."&size=middle";
			}
			foreach($listAryTmp as $list){
				unset($list['min_max']);
				$lastInfo = unserialize($list['lastmessage']);
				unset($list['lastmessage']);
				$list['lastmessage'] = $lastInfo;
				//此处进行统计
				$numsql = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type=1 and sid=".$list['uid']." and fid=".$list['fromUid']);
				$list['countnum'] = $numsql['counts'];
				$pmlist[] = $list;
			}
		}
		$return = array();
		$return['status'] = 0;
		$return['pmList'] = changeCode($pmlist);
		$this->outjson($return);
	}

	/**
	 * start 最小的lastdateline
	 * amount 范围
	 * toUid 聊天的对象
	 */
	function pmView(){
		$start = intval($this->Post['start']); //lastdateline
		$amount = intval($this->Post['amount']);
		$toUid = intval($this->Post['toUid']);

		$return['status'] = 0;
		$return['pmView'] = array();

		if($toUid<MEMBER_ID){
			$min_max = $toUid."_".MEMBER_ID;
		}
		else{
			$min_max = MEMBER_ID."_".$toUid;
		}
		$existPlid = $this->Db->once_fetch_assoc("SELECT plid FROM `centery_main`.uc_pm_lists WHERE min_max='".$min_max."'");
		$plid = intval($existPlid['plid']);
		if($plid<1){
			$this->outjson($return);
		}
		$userInfo = $this->Db->once_fetch_assoc("select uid,username from centery_main.uc_members where uid=".$toUid);
		$userInfo['face'] = "http://center.yeeyi.com/avatar.php?uid=".$toUid."&size=middle";
		$return['toUserInfo'] = changeCode($userInfo);
		$pmTable = "`centery_main`.uc_".$this->getposttablename($plid);
		if($start>0){
			$pmView = $this->Db->fetch_all_assoc("select pmid,authorid,message,dateline from  $pmTable where plid=$plid  and pmid<$start order by dateline");
		}
		else{
			$pmView = $this->Db->fetch_all_assoc("select pmid,authorid,message,dateline from  $pmTable where plid=$plid order by dateline");
		}
		foreach($pmView as $k=>$v){
			$pmView[$k]['message'] = ubb2html($pmView[$k]['message']);
		}
		$return['pmView'] = changeCode($pmView);
		$this->outjson($return);
	}




	/**
	 * 获取消息表的表名字
	 * @param $plid
	 * @return string
	 */
	function getposttablename($plid) {
		$id = substr((string)$plid, -1, 1);
		return 'pm_messages_'.$id;
	}

	/**
	 * 修改密码
	 */
	function doChangePwd(){

		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';  //   $return['message'] = '操作成功';
			$this->outjson($return);
		}
		$oldPwd = $this->Post['oldpwd'];
		$newPwd = $this->Post['newpwd'];
		if(!preg_match('/^(?=.*[A-Z])[a-zA-Z0-9]{6,15}$/',$newPwd)){
			$return['status'] = 1;
			$return['message'] = '密码必须是6-15位字母数字组合,含大写字母';
			$this->outjson($return);
		}
		//判断是否为sns用户
		$checkSns = $this->Db->once_fetch_assoc("select sid from sns_user_map where uid=".$this->G['uid']);
		if($checkSns['sid']<1){
			$userInfo = $this->Db->once_fetch_assoc("select username, uid, password, salt FROM centery_main.uc_members WHERE uid=".$this->G['uid']);
			$salt = $userInfo['salt'];
			$pwdOld = md5(md5($oldPwd).$salt);
			if($userInfo['password']!=$pwdOld){
				$return['status'] = 1;
				$return['message'] = '旧密码错误';
				$this->outjson($return);
			}
		}else{
            //更新修改密码记录
            $this->Db->query("REPLACE INTO app_change_user_pwd SET uid=".$this->G['uid'].",changed=0");
        }

		$userInfo = $this->Db->once_fetch_assoc("select username, uid, password, salt FROM centery_main.uc_members WHERE uid=".$this->G['uid']);
		$salt = $userInfo['salt'];
		$pwd1 = md5(md5($newPwd).$salt);
		$pwd2 = md5($newPwd);
		$this->Db->query("update centery_main.uc_members set password='".$pwd1."' where uid=".$this->G['uid']);
		$this->Db->query("update pre_common_member set password='".$pwd2."' where uid=".$this->G['uid']);
		$return['status'] = 0;
		$this->outjson($return);
	}


    /**
     * 我的评论
     * @param type 1新闻 2生活论坛 3主题
     * @param start 起始位置
     * @param amount 结束位置
     */
    function myReply(){

        $type = intval($this->Post['type']);
        $start = intval($this->Post['start']);
        $amount = intval($this->Post['amount']);
        load::logic("ReplyList");
        $reply = new ReplyList(MEMBER_ID,$type);
        $list = $reply->getList($start,$amount);
        $return = array();
        $return['status'] = 0;
        if($type == 1){
            $return['newsReply'] = $list;
        }
        else if($type == 2){
            $return['threadReply'] = $list;
        }
        else if($type == 3){
            $return['topicReply'] = $list;
        }
        $this->outjson($return);
    }

    function replyMe(){    

        $type = intval($this->Post['type']);
        $start = intval($this->Post['start']);
        $amount = intval($this->Post['amount']);
        load::logic("ReplyList");

        $reply = new ReplyList(MEMBER_ID,$type);
        $return = array();
        $return['status'] = 0;
		if($type == 1){
			$return['reply'] = $reply->getNewsReplyMe($start,$amount);
		}
		else if($type == 2){
			$return['reply'] = $reply->getThreadReplyMe($start,$amount);
		}
		else{
			$return['reply'] = $reply->getThreadReplyMe($start,$amount,3);
		}
        $this->outjson($return);
    }

	function doReName(){
		$name = $this->Post['username'];
		//判断是否能修改用户名
		$userInfo = $this->getUserInfo(MEMBER_ID);


//		if($userInfo['allow_rename'] == 0){
//			$return['status'] = 1;
//			$return['message'] = "用户无权修改用户名!";
//			$this->outjson($return);
//		}

		$this->checkName($name);
		//修改用户名
		$username = changeCode($name,'utf-8','gbk');
		$this->Db->query("update centery_main.uc_members set username='".$username."' where uid=".MEMBER_ID);
		$this->Db->query("update pre_common_member set username='".$username."' where uid=".MEMBER_ID);
		$this->Db->query("update yeeyico_new.pre_phone_verify set username='".$username."' where uid=".MEMBER_ID);
		$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".MEMBER_ID."',1)");
		//记录状态
		$this->Db->query("replace into app_change_name(uid,`rename`) values('".MEMBER_ID."',".($userInfo['num']+1).")");
		//修改已经发布的帖子
		$this->Db->query("update pre_forum_thread set author='".$username."' where authorid=".MEMBER_ID);
		$this->Db->query("update pre_forum_post set author='".$username."' where authorid=".MEMBER_ID);
		/* 2017.05.25 edit by allen qu  修改已经评论的新闻评论 */
		$this->Db->query("update news_comment set username='".$username."' where userid=".MEMBER_ID);
		/* 2017.05.12 edit by allen qu  修改名称后   authcode也要重新修改 */
		//设备id
		$devid = trim($this->Post['devid']);
		$time = time();
		$key = md5($time."_e2app^");
		$authStr = $userInfo['uid']."::::".$name."::::".$userInfo['groupid']."::::".$devid."::::".time()."::::".$key;
		$authcode = authcode($authStr,86400*720);

		if($devid){
			list($dev,$tmp) = explode('|',$devid);
			if($dev!='null'){
				$devmd5 = md5($dev);
				$checkDevId = $this->Db->once_fetch_assoc("select * from app_user_authcode where devmd5='".$devmd5."'");
				if($checkDevId['devid']){
					$this->Db->query("update app_user_authcode set uid='".$userInfo['uid']."',devid='".$devid."',authcode='".$authcode."' where devmd5='".$devmd5."'");
				}
				else{
					$this->Db->query("insert into app_user_authcode set uid='".$userInfo['uid']."',authcode='".$authcode."',devid='".$devid."',dev='".$dev."',devmd5='".$devmd5."'");
				}
			}
		}

		$return['authcode'] = $authcode;

		/* edit end */
		$return['status'] = 0;
		$this->outjson($return);


	}

	/**
	 * 判断用户名
	 * @param string $uname
	 * @param int    $type 2指国内用户
	 */
	function checkName($uname='',$type=1){
		if($this->Post['username']){
			$username = trim($this->Post['username']);
		}
		else if($uname){
			$username = $uname;
		}
		$username = changeCode($username,'utf-8','gbk');
		if($type==1){
			$checkExist = $this->Db->once_fetch_assoc("select username from `pre_common_member` where `username` ='".$username."'");
		}elseif($type==2){
			$checkExist = $this->Db->once_fetch_assoc("select username from yeeyico_new.domestic_adduser where `username` ='".$username."'");
		}

		if($checkExist['username']){
			$return['status'] = 5962;
			$return['message'] = '用户名重复!';
			$this->outjson($return);
		}

		if(strstr($username,'e2_') || strstr($username,'yeeyi_') || strstr($username,'admin')){
			$return['status'] = 5961;
			$return['message'] = '用户名含有非法字符!';
			$this->outjson($return);
		}

		if(countStr($username)<=3){
			$return['status'] = 5964;
			$return['message'] = '用户名长度为4到15个字符!';
			$this->outjson($return);
		}
		if(countStr($username)>15){
			$return['status'] = 5964;
			$return['message'] = '用户名长度为4到15个字符!';
			$this->outjson($return);
		}

		if(preg_match("/^[0-9]+/isU",$username)){
			$return['status'] = 5963;
			$return['message'] = '用户名不能以数字开头!';
			$this->outjson($return);
		}
		if(false != preg_match('~[\.\<\>\?\@\$\#\[\]\{\}\s\'\"]+~',$username)){
			$return['status'] = 5961;
			$return['message'] = '用户名含有非法字符!';
			$this->outjson($return);
		}
		if($uname){

		}
		else{
			$return['status'] = 2961;
			$this->outjson($return);
		}

	}


	/**
	 * 用户帖子查看
	 */
	function userThread(){
	  $uid = intval($this->Post['uid']);
	  $start = intval($this->Post['start']);
	  $amount = intval($this->Post['amount']);
		$type = intval($this->Post['type']); //2 分类 // 3论坛
		$threadList = array();
		if($type == 2){
			/* 2017.05.17 edit by allen qu  加上604,325,679*/
			if($start>0){
				$threadList = $this->Db->fetch_all_assoc("
				SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic
				FROM `pre_forum_thread`
				left join pre_forum_forum on pre_forum_forum.fid=pre_forum_thread.fid
				left join pre_forum_thread_pic
				on pre_forum_thread.tid=pre_forum_thread_pic.tid
				where authorid=".$uid."
				and pre_forum_thread.displayorder>=0
				and pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657, 604,325,679)
				and pre_forum_thread.tid<$start
				order by tid
				desc
				limit $amount"
			);
			}
			else{
				$threadList = $this->Db->fetch_all_assoc("
					SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic
					FROM `pre_forum_thread`
					left join pre_forum_forum
					on pre_forum_forum.fid=pre_forum_thread.fid
					left join pre_forum_thread_pic
					on pre_forum_thread.tid=pre_forum_thread_pic.tid
					where authorid=".$uid."
					and pre_forum_thread.displayorder>=0
					and pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657,604,325,679)
					order by pre_forum_thread.tid
					desc
					limit $amount"
				);
			}

			/* 2017.05.25 edit by allen qu  图片需要反序列化返回*/
			foreach($threadList as $k=>$thread)
			{
				if (!$thread['pic']) {

					$threadList[$k]['pic'] = '';

				}else {

					$picArr = unserialize($thread['pic']);
					$threadList[$k]['pic'] = $picArr[0];
				}

			}
		}
		else{
			if($start>0){
				$listTmp = $this->Db->fetch_all_assoc("
					SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic
					FROM `pre_forum_thread`
					left join pre_forum_forum
					on pre_forum_forum.fid=pre_forum_thread.fid
					left join pre_forum_thread_pic
					on pre_forum_thread.tid=pre_forum_thread_pic.tid
					where authorid=".$uid."
					and pre_forum_thread.displayorder>=0
					and  pre_forum_thread.fid not in(731, 89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657,604,325,679)
					and pre_forum_thread.tid<$start
					order by tid
					desc limit $amount");
			}
			else{
				$listTmp = $this->Db->fetch_all_assoc("
					SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic
					FROM `pre_forum_thread`
					left join pre_forum_forum
					on pre_forum_forum.fid=pre_forum_thread.fid
					left join pre_forum_thread_pic
					on pre_forum_thread.tid=pre_forum_thread_pic.tid
					where authorid=".$uid."
					and pre_forum_thread.displayorder>=0
					and pre_forum_thread.fid not in(731, 89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657,604,325,679)
					order by tid
					desc
					limit $amount"
				);
			}
			if(is_array($listTmp)){
				foreach($listTmp as $t){

					$tmp = array();
					//是否点赞
					$tmp['isLike'] = 0;
					if(MEMBER_ID>0){
						$checkFavoriate = $this->Db->once_fetch_assoc("select * from app_post_like where uid=".MEMBER_ID." and id=".$t['tid']." and idtype='tid'");
						if($checkFavoriate['likeid']>0){
							$tmp['isLike'] = 1;
						}
					}
					$count = $this->Db->once_fetch_assoc("select count(*) as num from yeeyico_new.app_post_like where idtype='tid' and id=".$t['tid']." group by id;");
					$tmp['likes'] = (int)$count['num'];

					$tmp['id'] = $t['tid'];
					$tmp['tid'] = $t['tid'];
					$tmp['aid'] = 0;
					$tmp['isThread'] = '1';
					$tmp['isNews'] = '0';
					$tmp['address'] = changeCode('火星网友','utf-8','gbk');
					$tmp['isNews'] = '0';
					$tmp['author'] = $t['author'];
					$tmp['authorid'] = $t['authorid'];
					$tmp['face'] = "http://center.yeeyi.com/avatar.php?uid=".$t['authorid']."&size=middle";
					$tmp['subject'] = $t['subject'];
					$tmp['dateline'] = $t['dateline'];
					$tmp['replies'] = $t['replies'];
					$picAry = unserialize($t['pic']);
					if(!is_array($picAry)){
						$picAry = array();
					}
					$tmp['pic'] = $picAry;
					$threadList[] = $tmp;
				}
			}

		}
		if(!is_array($threadList)){
			$threadList = array();
		}
	      $threadList = changeCode($threadList);
	      $return = array();
	      $return['status'] = 0;
	      $return['threadlist'] = $threadList;
	      $this->outjson($return);
	 }

	/**
	 * @param start 上次最小的favid
	 * @param amount 每次显示的条数
	 * @param typeid 需要的分类 1:aid,2:tid,3:topicid
	 */
	function myFavorite(){
        $return = array();
        $start = intval($this->Post['start']);
        $amount = intval($this->Post['amount']);
		$typeid = intval($this->Post['typeid']);
		$type = '';
		if($typeid == 1){
			$type = 'newsid';
			if($start>0){
				$list = $this->Db->fetch_all_assoc("select favid,pre_home_favorite.id,pre_home_favorite.idtype,pre_home_favorite.title,pre_home_favorite.dateline,pic,froms from pre_home_favorite left join news_article on  pre_home_favorite.id=news_article.aid where pre_home_favorite.uid=".MEMBER_ID." and idtype='".$type."' and favid<$start order by favid desc limit $amount");
			}
			else{
				$list = $this->Db->fetch_all_assoc("select favid,pre_home_favorite.id,pre_home_favorite.idtype,pre_home_favorite.title,pre_home_favorite.dateline,pic,froms from pre_home_favorite left join news_article on  pre_home_favorite.id=news_article.aid where pre_home_favorite.uid=".MEMBER_ID." and idtype='".$type."' order by favid desc limit $amount");
			}
			foreach($list as $k=>$v){
				if(strlen($v['pic'])>10 && !strstr($v['pic'],"http://")){
					$list[$k]['pic'] = "http://www.yeeyi.com".$v['pic'];
				}
			}
		}
		if($typeid == 2){
			$type = 'tid';
			if($start>0){
				$list = $this->Db->fetch_all_assoc("select favid,f.id,f.idtype,f.title,f.dateline,'' as pic from pre_home_favorite as f left join pre_forum_thread as t on f.id = t.tid where f.uid=".MEMBER_ID." and f.idtype='".$type."' and favid<$start and t.displayorder = 0 order by favid desc limit $amount");
			}
			else{
				$list = $this->Db->fetch_all_assoc("select favid,f.id,f.idtype,f.title,f.dateline,'' as pic from pre_home_favorite as f left join pre_forum_thread as t on f.id = t.tid where f.uid=".MEMBER_ID." and f.idtype='".$type."' and t.displayorder = 0 order by favid desc limit $amount");
			}
		}
		if($typeid == 3){
			$type = 'cid';
			if($start>0){
				$list = $this->Db->fetch_all_assoc("select favid,f.id,f.idtype,f.title,f.dateline,'' as pic from pre_home_favorite as f left join pre_forum_thread as t on f.id = t.tid where f.uid=".MEMBER_ID." and f.idtype='".$type."' and favid<$start and t.displayorder = 0 order by favid desc limit $amount");
			}
			else{
				$list = $this->Db->fetch_all_assoc("select favid,f.id,f.idtype,f.title,f.dateline,'' as pic from pre_home_favorite as f left join pre_forum_thread as t on f.id = t.tid where f.uid=".MEMBER_ID." and f.idtype='".$type."' and t.displayorder = 0 order by favid desc limit $amount");
			}
		}

		if(!is_array($list)){
			$list = array();
		}
        $return['status'] = 0;
        $return['list'] = changeCode($list);
        $this->outjson($return);
    }

    /**
	 * 发送短信
     * 所有的登录，注册，找回密码均使用此短信接口
	 * 添加国家代码 by Eric 20170201
	 */
	function sendmsg(){

		$tel = trim($this->Post['tel']);
		$country_code = isset($this->Post['country_code'])?$this->Post['country_code']:'61';
		$result = loginSMS($tel,$country_code);
		if($result == 1){
			$return['status'] = 0;
			$this->outjson($return);
		}
		else if($result == -1){
			$return['status'] = 1;
			$return['message'] = '短信发送频率太高，请一分钟后再试';
			$this->outjson($return);
		}
		else{
			$return['status'] = 1;
			$return['message'] = '短信发送失败';
			$this->outjson($return);
		}
	}

    /**
     * 校验短信
     * @param tel手机号码
     * @param smsCode 短信
     * @return isOk 是否正确
     * @return token 如果正确，则有此值用于后面操作
     */
    function checkmsg(){
        $tel = trim($this->Post['tel']);
        $smsCode = intval(trim($this->Post['smsCode']));
        $return = array();
		//判断手机号是否绑定用户
		$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username,groupid,status from yeeyico_new.pre_phone_verify where phone='".$tel."'");
		if($userInfoTmp['uid']<1){
			$return['status'] = 1;
			$return['message'] = '该用户不存在';
			$this->outjson($return);
		}
		$return['status'] = 1;
		$return['message'] = '短信校验失败，可能短信过期';
        $check = checkSms($tel,$smsCode);
        if($check){

            /* create by chen at 2017-11-15 */
//            delVar('sms_'.$tel);
            /* -----end create */

            $return['status'] = 0;
            $return['message'] = '';
            $tokenStr = $tel."::::".$check;
            $token = authcode($tokenStr,300);
            $return['token'] = $token;
        }
        $this->outjson($return);
    }

    /**
     * 通过信箱找回密码，发送邮件
	 * @param email
     */
    function findByMail(){
		$email = trim($this->Post['email']);
		$checkMail = $this->Db->once_fetch_assoc("SELECT COUNT(*) as cnt FROM pre_common_member WHERE email='".$email."'");
		if($checkMail['cnt']>1){
			$return['status'] = 5921;
			$this->outjson($return);
		}
		else if($checkMail['cnt'] == 0){
			$return['status'] = 5922;
			$this->outjson($return);
		}
		$checkInfo = $this->Db->once_fetch_assoc("SELECT* FROM pre_common_member WHERE email='".$email."'");
		$uid = $checkInfo['uid'];
		$username = changeCode($checkInfo['username']);
		$time = time();
		$idstring = random(6);
		$this->Db->query("UPDATE  pre_common_member_field_forum SET `authstr`='".$time."\t1\t".$idstring."' WHERE `uid`='".$uid."'");
		$this->sendGetPwdMail($email,$uid,$username,$idstring);
		$return['status'] = 2920;
		$this->outjson($return);
    }

	/**
	 * @param token
	 * @param newpwd
	 */
	function findBySms(){
		$return = array();
		$token = trim($this->Post['token']);
		$password = trim($this->Post['newpwd']);
		$token = authcode($token,'DECODE');
		list($tel,$check) = explode("::::",$token);
		if(strlen($tel)<3 || $check<100){
			$return['status'] = 1;
			$return['message'] = '手机验证失败';
			$this->outjson($return);
		}
		$successKey = 'sms_check_'.$tel;
		$checkNum = getVar($successKey);
		if($checkNum != $check){
			$return['status'] = 1;
			$return['message'] = '手机验证失败';
			$this->outjson($return);
		}
		$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username,groupid,status from yeeyico_new.pre_phone_verify where phone='".$tel."'");
		if($userInfoTmp['uid']<1){
			$return['status'] = 5930;
			$this->outjson($return);
		}

		$userInfo = $this->Db->once_fetch_assoc("select username, uid, password, salt FROM centery_main.uc_members WHERE uid=".$userInfoTmp['uid']);
		$salt = $userInfo['salt'];
		$pwd1 = md5(md5($password).$salt);
		$pwd2 = md5($password);
		$this->Db->query("update centery_main.uc_members set password='".$pwd1."' where uid=".$userInfoTmp['uid']);
		$this->Db->query("update pre_common_member set password='".$pwd2."' where uid=".$userInfoTmp['uid']);
		$return['status'] = 0;
		$return['message'] = '密码重置成功';
		$this->outjson($return);
	}

	/*
	 * 获取用户信息
	 * @param uid 用户uid
	 *

	 * */
	function getUser(){
		$uid = intval($this->Post['uid']);
		if($uid<1 && MEMBER_ID<1){
			$return['status'] = 5100;
			$return['message'] = '用户未登录，请登陆后再试';
			$this->outjson($return);
		}
		if($uid<1){
			$uid = MEMBER_ID;
		}
		$return['status'] = 0;
		$userInfo = $this->getUserInfo($uid);
		if (!$userInfo) {
			$return['status'] = 10001;
		}
		$return['userInfo'] = $userInfo;
		$this->outjson($return);
	}

	/**
	 * 修改头像
	 * pic
	 */
	function changeFace(){

		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';  //   $return['message'] = '操作成功';
			$this->outjson($return);
		}
		//pic
		if($_FILES['pic']['name'] && $_FILES['pic']['error'] == 0 && $_FILES['pic']['size']>0) {
			//curl传递
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, "http://www.yeeyi.com/apptools/index.php?act=uploadFace");
			curl_setopt($ch, CURLOPT_POST, true);
			$post = array(
				"pic" => "@" . $_FILES['pic']['tmp_name'],
				"filetype" => $_FILES['pic']['type'],
				"uid" => MEMBER_ID,
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			$response = curl_exec($ch);
			$upAry = json_decode($response,true);
			if($upAry['status'] == 200){        
				$this->Db->query("UPDATE  pre_common_member SET `avatarstatus`='1' WHERE `uid`='".$this->G['uid']."'");
				$return['status'] = 0;
				$this->outjson($return);
			}
			//curl传递结束
		}
		$return['status'] = 0;
		$this->outjson($return);
	}

	/**
	 *  国内用户注册
	 */
	function domesticRegister(){
		$username = trim($this->Post['username']);//亿忆用户名
//		$username = changeCode($username,'utf-8','gbk');
		$this->checkName($username,2);

        $username = changeCode($username,'utf-8','gbk');
		$tel = trim($this->Post['tel']);
		$checkidExist = $this->Db->once_fetch_assoc("SELECT uid FROM pre_phone_verify WHERE `phone` ='".$tel."'");
		$checkExist = $this->Db->once_fetch_assoc("select tel from yeeyico_new.domestic_adduser where `tel` ='".$tel."'");
		if($checkExist['tel'] || $checkidExist['uid']){
			$return['status'] = 1;//手机号已经存在
			$return['message'] = '电话号码已经被注册';
			$this->outjson($return);
		}

		$realname = trim($this->Post['realname']);//姓名
		$realname = changeCode($realname,'utf-8','gbk');

		$address  = trim($this->Post['address']);
		$address = changeCode($address,'utf-8','gbk');

		$email    = trim($this->Post['email']);
		$wechat   = trim($this->Post['wechat']);
		$pic      = '';
		$status   = 0;
		$ct = time();

		$sq = "INSERT INTO yeeyico_new.domestic_adduser values('','{$username}','{$realname}','{$tel}','{$address}','{$email}','{$wechat}','{$pic}','{$status}','{$ct}')";
		$result = $this->Db->query($sq);

		if($result){
			$return['status'] = 0;
			$return['message'] = '您的注册信息已经收到，审核通过后，会以短信通知您！';
			$this->outjson($return);
		}else{
		    $return['status'] = 1;
		    $this->outjson($return);
        }

	}

	/**
	 * 用户登录
	 * @param $username 用户名可以是手机号码 邮箱 或者用户名
	 * @password 用户密码
	 * @smsCode 动态密码登录
	 */
	function doLogin(){
		$username = trim($this->Post['username']);
		$password = trim($this->Post['password']);
		$smsCode = intval(trim($this->Post['smsCode']));

        //社交登录
        $snsFrom = intval($this->Post['snsFrom']);//1微博 2微信 3qq
        $snsOpenid = trim($this->Post['snsOpenid']);
        $snsName = trim($this->Post['snsUserName']);
        $snsFace = trim($this->Post['snsFace']);
		//设备id
		$devid = trim($this->Post['devid']);

		//客户端id
		$clientid = trim($this->Post['clientid']);

		$uid = 0;
		$return = array();
        //判断社交
        if($snsFrom>0){
            $snsUid = $this->snsReg($snsFrom,$snsOpenid,$snsName,$snsFace);
            if($snsUid>0){
                $uid = $snsUid;
            }
            else{
                $return['status'] = 5913;
                $this->outjson($return);
            }
        }

		//先判断是否为手机
		$countryCode = '0';
		//2017.03.30 edited by allen qu  加入国内号码的判断
		if (strlen($username) == 10 && is_numeric($username) && substr($username,0,2) == '04') { //澳洲

			$countryCode = '61';
		}else if (strlen($username) == 10 && is_numeric($username) && substr($username,0,2) != '04'){
            $return['status'] = 1;
            $return['message'] = '手机号错误';
            $this->outjson($return);
        }

		if (strlen($username) == 11 && is_numeric($username) && substr($username,0,1) == '1') { //中国

			$countryCode = '86';
		}else if(strlen($username) == 11 && is_numeric($username) && substr($username,0,1) != '1'){
            $return['status'] = 1;
            $return['message'] = '手机号错误';
            $this->outjson($return);
        }


		if ($countryCode == '61' || $countryCode == '86') { //手机
			if($smsCode>0){
				$keyCode = 'sms_'.$username;
				$saveCode = getVar($keyCode);
				if($smsCode == $saveCode){ //注释$smsCode == $saveCode

                    /* create by chen at 2017-11-15 */
//                    delVar($keyCode);
                    /* -----end create */

					/**
					 * 有动态效验码的情况下，
					 * 1、判断用户是否存在，如果存在则登录
					 * 2、用户不存在，则直接注册
					 */
					$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username,groupid,status from yeeyico_new.pre_phone_verify where phone='".$username."'");
					if($userInfoTmp['uid']<1){ //注释$userInfoTmp['uid']<1
						/**
						 * 用户不存在，添加用户，完成用户注册
						 */
						$uid = $this->appReg($username,'','', $countryCode);
						$isnew = 1;
						//20170831修改dong新用户注册默认密码短信发送:给前台传送手机号和默认密码
					}
					else{
						/**
						 *用户存在,完成状态变更
						 */
						$uid = $userInfoTmp['uid'];
						if($userInfoTmp['status']  != 1){
							$this->Db->query("update yeeyico_new.pre_phone_verify set groupid=10,status=1 where uid=".$uid);
							$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".$uid."',1)");
						}
					}
				}
				else{
					//短信验证码错误，请重新输入
					$return['status'] = 1;
					$return['message'] = '手机号或验证码错误';
					$this->outjson($return);
				}
			}
			else{
				/**
				 * 没有动态验证码，则使用密码登录，首先获取对应的用户名，转换成用户名
				 */
				$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username,groupid,status from yeeyico_new.pre_phone_verify where phone='".$username."'");
				if($userInfoTmp['status'] != 1){
					$return['status'] = 5911;
                    $return['message'] = '用户名或密码错误';
					$this->outjson($return);
				}
				if($userInfoTmp['uid']<1){
                    $return['status'] = 1;
                    $return['message'] = '用户名或密码错误';
                    $this->outjson($return);
                }
				$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username from centery_main.uc_members where uid=".$userInfoTmp['uid']);
				$username = $userInfoTmp['username'];
				$username = changeCode($username);
			}
		}

		else if(strstr($username,'@') && strstr($username,'.')){
			/**
			 * 有@ 有. 在e2用户名中.是非法字符，所以为邮箱注册
			 * 根据信箱转换成username
			 */
			$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username from centery_main.uc_members where email='".$username."'");
			if($userInfoTmp['uid']>0){
				$username = $userInfoTmp['username'];
				$username = changeCode($username);
			}
			else{
				$return['status'] = 5912;
				$this->outjson($return);
			}
		}
		if($uid<1){
			$uid = $this->loginE2($username,$password);
			if($uid<1){
				$return['status'] = 1;
				$return['message'] = '用户名或密码错误';
				$this->outjson($return);
			}
		}
		$userInfo = $this->getUserInfo($uid);
		//authcode $userid::::$username::::time();
		if (!$userInfo || $userInfo['mstatus'] == -1) {
			$this->outjson(array("status"=>10001));
		}
		$time = time();
		$key = md5($time."_e2app^");
		$authStr = $userInfo['uid']."::::".$userInfo['username']."::::".$userInfo['groupid']."::::".$devid."::::".time()."::::".$key;

        /* 更新设备id create by chen */
        $res = $this->Db->once_fetch_assoc("select * from app_user_getui_client where uid =" . $uid);
        if ($clientid > 0 && $res['uid'] < 1) {
            $this->Db->query("insert into app_user_getui_client set uid='" . $userInfo['uid'] . "',client_id='" . $clientid . "'");
        } elseif ($clientid != $res['clientid']) {
            $this->Db->query("update app_user_getui_client set client_id='" . $clientid . "' where uid=" . $uid);
        }

		$authcode = authcode($authStr,86400*720);
		if($devid){
			list($dev,$tmp) = explode('|',$devid);
			if($dev!='null'){
				$devmd5 = md5($dev);
				$checkDevId = $this->Db->once_fetch_assoc("select * from app_user_authcode where devmd5='".$devmd5."'");
				if($checkDevId['devid']){
					$this->Db->query("update app_user_authcode set uid='".$userInfo['uid']."',devid='".$devid."',authcode='".$authcode."' where devmd5='".$devmd5."'");
				}
				else{
					$this->Db->query("insert into app_user_authcode set uid='".$userInfo['uid']."',authcode='".$authcode."',devid='".$devid."',dev='".$dev."',devmd5='".$devmd5."'");
				}
			}
		}
		$return['status'] = 0;
		$return['authcode'] = $authcode;
		if(isset($isnew)&&$isnew==1)
		$userInfo['isnew']=1;
		$return['userInfo'] = $userInfo;
		$this->outjson($return);
	}

	function loginE2($username,$password){
		$username = changeCode($username,'utf-8','gbk');
		$password = changeCode($password,'utf-8','gbk');
		$this->Db->query("set names gbk");
		$checkUser = $this->Db->once_fetch_assoc("select uid,salt,username,password from centery_main.uc_members where username='{$username}' limit 1");
		if($checkUser['uid'] && $checkUser['salt']){
			$pwd = md5(md5($password).$checkUser['salt']);
			if($pwd != $checkUser['password']){
				return false;
			}
			return $checkUser['uid'];
		}
		else{
			return false;
		}
	}

	/**
	 * 用户注册
	 */
	function appReg($tel,$username='',$password='', $countryCode = '61')
	{
		//随机用户名
		if($username){
			//utf-8模式下判断用户名格式 中文，字母，数字，下划线
			if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$username)){
				$return['status'] = 5961;
				$return['message'] = '用户名含有非法字符!';
				$this->outjson($return);
			}
			$username = changeCode($username,'utf-8','gbk');
			$getMail = $this->Db->once_fetch_assoc("select uid from `pre_common_member` where `username` like '".$username."'");
			if($getMail['uid']){
				$return['status'] = 5962;
				$return['message'] = '用户名重复!';
				$this->outjson($return);
			}
			//判断
			if(strstr($username,'e2_') || strstr($username,'yeeyi_') || strstr($username,'admin')){
				$return['status'] = 5961;
				$return['message'] = '用户名含有非法字符!';
				$this->outjson($return);
			}

			if(countStr($username)<=3){
				$return['status'] = 5964;
				$return['message'] = '用户名长度为4到15个字符!';
				$this->outjson($return);
			}
			if(countStr($username)>15){
				$return['status'] = 5964;
				$return['message'] = '用户名长度为4到15个字符!';
				$this->outjson($return);
			}

			if(preg_match("/^[0-9]+/isU",$username)){
				$return['status'] = 5963;
				$return['message'] = '用户名不能以数字开头!';
				$this->outjson($return);
			}
			if(false != preg_match('~[\<\>\?\@\$\#\[\]\{\}\s\'\"]+~',$username)){
				$return['status'] = 5961;
				$return['message'] = '用户名含有非法字符!';
				$this->outjson($return);
			}
		}
		else{
			$username = 'app_' . time() . '_' . mt_rand(100, 999);
			//随机邮箱
			$email = 'app_' . time() . '_' . mt_rand(10, 99) . '@e2app.yeeyi.com';
			//随机密码
			$password = random(10);
			//随机密码发送短信给用户(20170831修改将信息传给前台dong)
			setVar($countryCode.'Australia'.$tel,$password,3600);

			//sendPwd($tel,$password, $countryCode);
			//(20170831end修改将信息传给前台dong)
		}
		$ip = client_ip();
		$salt = substr(uniqid(rand()), -6);
		$pw = md5(md5($password).$salt);
		$regdate = time();
		$sq = "INSERT INTO centery_main.uc_members values('','{$username}','{$pw}','{$email}','','','{$ip}','{$regdate}',0,'{$regdate}','{$salt}','')";
		$result = $this->Db->query($sq);
		if($result){
			$reg = $this->Db->insert_id();
			if($reg>0){
				$this->Db->query("INSERT INTO centery_main.`uc_memberfields`(uid) values('$reg')");
			}

		}
		else{
			$reg = 0;
		}

		if ($reg <= 0) {
			//注册失败
			$return['status'] = 5901;
			$this->outjson($return);
		} else {
			$uid = $reg;
			$passwd = md5($password);
			$regdate = time();
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member`(uid,email,username,password,status,emailstatus,groupid,regdate) values('{$uid}','{$email}','{$username}','{$passwd}',0,1,10,'{$regdate}')");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_count`(uid,extcredits2) values('{$uid}',10)");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_status`(uid,regip,lastip,lastvisit,lastactivity,lastpost) values('{$uid}','{$ip}','{$ip}',{$regdate},{$regdate},{$regdate})");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_profile` SET `uid`='{$uid}'");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_field_forum` SET `uid`='{$uid}',`customshow`=26");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_field_home` SET `uid`='{$uid}'");
			if($tel){
				//手机注册
				$this->Db->query("insert into yeeyico_new.`pre_phone_verify` set uid='{$uid}',username='{$username}',groupid=10,status=1,phone='{$tel}'");
				$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".$uid."',1)");

			}
			return $uid;
		}
	}

	/**
	 * 用户注册
	 * @param 1weibo 2weixin 3qq
	 * @return $uid int
	 */
	function snsReg($from,$openId,$username='',$face='')
	{
		//如果用户是存在的
        $checkSNS = $this->Db->once_fetch_assoc("select * from sns_user_map where from_sns='".$from."' and openid='".$openId."'");
        if($checkSNS['uid']>0){
            return $checkSNS['uid'];
        }

        //随机用户名
		$username = 'app_' . time() . '_' . mt_rand(100, 999);
		//随机邮箱
		$email = 'app_' . time() . '_' . mt_rand(10, 99) . '@e2app.yeeyi.com';
		//随机密码
		$password = random(10);
		$ip = client_ip();
		$salt = substr(uniqid(rand()), -6);
		$pw = md5(md5($password).$salt);
		$regdate = time();
		$sq = "INSERT INTO centery_main.uc_members values('','{$username}','{$pw}','{$email}','','','{$ip}','{$regdate}',0,'{$regdate}','{$salt}','')";
		$result = $this->Db->query($sq);
		if($result){
			$reg = $this->Db->insert_id();
			if($reg>0){
				$this->Db->query("INSERT INTO centery_main.`uc_memberfields`(uid) values('$reg')");
			}
		}
		else{
			$reg = 0;
		}

		if ($reg <= 0) {
			//注册失败
			$return['status'] = 5901;
			$return['message'] = '注册失败';
			$this->outjson($return);
		} else {
			$uid = $reg;
			$passwd = md5($password);
			$regdate = time();
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member`(uid,email,username,password,status,emailstatus,groupid,regdate) values('{$uid}','{$email}','{$username}','{$passwd}',0,1,10,'{$regdate}')");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_count`(uid,extcredits2) values('{$uid}',10)");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_status`(uid,regip,lastip,lastvisit,lastactivity,lastpost) values('{$uid}','{$ip}','{$ip}',{$regdate},{$regdate},{$regdate})");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_profile` SET `uid`='{$uid}'");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_field_forum` SET `uid`='{$uid}',`customshow`=26");
			$this->Db->query("INSERT INTO yeeyico_new.`pre_common_member_field_home` SET `uid`='{$uid}'");
			$this->Db->query("INSERT INTO yeeyico_new.`app_change_user_pwd` SET `uid`='{$uid}',`changed`=1");
			//修改头像
			if($face){
				$faceContent = @getPage($face);
				if($faceContent){
					$fileName = 'face_'.time()."_".mt_rand(1000,9999).".jpg";
					$faceFileName = "/home/app/public/face/".$fileName;
					@file_put_contents($faceFileName,$faceContent);
					if(file_exists($faceFileName)){
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_VERBOSE, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL, "http://www.yeeyi.com/apptools/index.php?act=uploadFace");
						curl_setopt($ch, CURLOPT_POST, true);
						$post = array(
							"pic" => "@" . $faceFileName,
							"filetype" => "image/jpeg",
							"uid" => $uid,
						);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
						$response = curl_exec($ch);
						$upAry = json_decode($response,true);
						if($upAry['status'] == 200){
							$this->Db->query("UPDATE  pre_common_member SET `avatarstatus`='1' WHERE `uid`='".$uid."'");
						}
					}
				}
			}
			//写入对应的app
			$sql = "insert into sns_user_map set uid='".$uid."',from_sns='".$from."',openid='".$openId."',regtime='".$regdate."',lasttime='".$regdate."'";
			$this->Db->query($sql);
			return $uid;
		}
	}



	/**
	 * 获取用户个人资料
	 * @param $uid
	 * @return array|string
	 * 名字    username
	 * uid     uid
	 * 头像     face
	 * groupid
	 * istel 手机认证
	 */
	function getUserInfo($uid){
		$uid = intval($uid);
		$sql = "select yeeyico_new.
				pre_common_member.uid,
				pre_common_member.regdate,
				pre_common_member.groupid,
				pre_common_member.status as mstatus,
				yeeyico_new.pre_common_member.username,
				yeeyico_new.pre_common_member.credits,
				yeeyico_new.pre_common_member.groupid,
				yeeyico_new.pre_phone_verify.status as istel,
				yeeyico_new.pre_phone_verify.phone as tel
				from yeeyico_new.pre_common_member
				left join yeeyico_new.pre_phone_verify
				on yeeyico_new.pre_phone_verify.uid=yeeyico_new.pre_common_member.uid
				where yeeyico_new.pre_common_member.uid=".$uid;
		$userInfo = $this->Db->once_fetch_assoc($sql);

		# 判断是否可以修改性别
		$changegendertmp = $this->Db->once_fetch_assoc("select * from app_change_user_gender where uid=".$uid);
		if (intval($changegendertmp['changed']) >= 3) {   //修改dong
			$userInfo['allow_change_gender'] = 0;
		}else {
			$userInfo['allow_change_gender'] = 1;
			$userInfo['allow_gender_num'] = (3 - intval($changegendertmp['changed']));
		}

		if (in_array($userInfo['groupid'], array(5, 6))) {
			return false;
		}

		$userInfo['istel'] = strval($userInfo['istel']);
		$userInfo['issns'] = 0;
		$userInfo['allow_rename'] = 0;

		// 判断是否可以直接修改密码
        $repwd = $this->Db->once_fetch_assoc("select * from app_change_user_pwd where uid=".$uid);
        if ($repwd['changed'] == 0){
            $userInfo['allow_repwd'] = 0;
        }else{
            $userInfo['allow_repwd'] = 1;
        }


		// unset($userInfo['tel']);
		//$userInfo['tel'] = strval($userInfo['tel']);
		$userInfo['face'] = "http://center.yeeyi.com/avatar.php?uid=".$uid."&size=middle";
		//判断是否可以修改名字
		$checkSns = $this->Db->once_fetch_assoc("select * from sns_user_map where uid=".$uid);
		if($checkSns['uid']>0){
			$userInfo['issns'] = 1;
		}
		if($userInfo['issns'] == 1 || $userInfo['istel']==1){
			$checkReNameInfo = $this->Db->once_fetch_assoc("select * from app_change_name where uid=".$uid);
			if(intval($checkReNameInfo['rename']) < 3){
				$userInfo['allow_rename'] = 1;
				$userInfo['num'] = $checkReNameInfo['rename'];
			}
		}

		//统计我的消息和站内信的总数
		$mailnum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type=1 and sid=".$uid);
		$myinfonum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type<>1 and sid=".$uid);
		$userInfo['mailnum'] = $mailnum['counts'] ? $mailnum['counts'] : 0;
		$userInfo['myinfonum'] = $myinfonum['counts'] ? $myinfonum['counts'] : 0;
		$userInfo['countnum'] = $userInfo['mailnum'] + $userInfo['myinfonum'];

		//判断是否可以直接修改密码
		$userInfo = changeCode($userInfo);
		$otherInfo = $this->Db->once_fetch_assoc("select * from pre_common_member_count where uid=".$uid);
		$otherInfo = changeCode($otherInfo);
		$lastInfo = $this->Db->once_fetch_assoc("select lastvisit,lastactivity,lastpost from pre_common_member_status where uid=".$uid);
		$groupInfo = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_common_usergroup where groupid='".$userInfo['groupid']."'");
		$groupInfo = changeCode($groupInfo);
		$profileAry = $this->Db->once_fetch_assoc("select gender,birthyear,birthmonth,birthday from pre_common_member_profile where uid=".$uid);
		//添加个人简介
		$summaryAry = $this->Db->once_fetch_assoc("SELECT sightml FROM `pre_common_member_field_forum` where uid=".$uid);
		if($profileAry['gender'] == 1){
			$sex = '男';
		}
		elseif($profileAry['gender'] == 2){
			$sex = '女';
		}
		else{
			$sex = '保密';
		}
//		$profile = array();
//		$profile[] = array('用户组',$groupInfo['grouptitle']);
//		$profile[] = array('性别',$sex);
//        $profile[] = array('生日',$profileAry['birthyear']."-".$profileAry['birthmonth']."-".$profileAry['birthday']);
//		$profile[] = array('注册时间',date("Y-m-d G:i:s",$userInfo['regdate']));
//		$profile[] = array('最后访问时间',date("Y-m-d G:i:s",$lastInfo['lastvisit']));
//		$profile[] = array('最后发表时间',date("Y-m-d G:i:s",$lastInfo['lastpost']));
//		$profile[] = array('帖子数',$otherInfo['posts']);
//		$profile[] = array('主题数',$otherInfo['threads']);
//		$profile[] = array('精华帖',$otherInfo['digestposts']);
//		$profile[] = array('积分',$userInfo['credits']);
//		$profile[] = array('威望',$otherInfo['extcredits1']." 点");
//		$profile[] = array('金钱',$otherInfo['extcredits2']." YB");
//		$profile[] = array('贡献值',$otherInfo['extcredits3']." 点");
//		$profile[] = array('鲜花',$otherInfo['extcredits4']." 个");
//		$profile[] = array('鸡蛋',$otherInfo['extcredits5']." 个");
//		$profile[] = array('好评度',$otherInfo['extcredits6']." ");
//		$profile[] = array('信誉度',$otherInfo['extcredits7']." ");
//		$profile[] = array('金币',$otherInfo['extcredits8']." 枚");
//        $profile[] = array('个人简介',changeCode($summaryAry['sightml']));
//		$userInfo['profile'] = $profile;
        $userInfo['user_group'] = $groupInfo['grouptitle'];
        $userInfo['gender']     = $sex;
        if (empty($profileAry['birthyear'])){
            $userInfo['birthday'] = "0000-00-00";
        }else{
            $userInfo['birthday'] = $profileAry['birthyear'] . "-" . $profileAry['birthmonth'] . "-" . $profileAry['birthday'];
        }
        $userInfo['reg_time']   = date("Y-m-d G:i:s", $userInfo['regdate']);
        $userInfo['money']      = $otherInfo['extcredits2'] . " YB";
        $userInfo['summary']    = changeCode($summaryAry['sightml']);
		return $userInfo;
	}

	function sendGetPwdMail($mail,$uid,$username,$rand){
		$subject = "[澳洲亿忆网] 取回密码说明";
		$message = <<<EOT
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>$subject</title>
</head>
<body>
$subject<br />
取回密码说明<br />
$username ， 这封信是由 澳洲亿忆网 发送的。<br />
<br />
您收到这封邮件，是由于这个邮箱地址在 澳洲亿忆网 被登记为用户邮箱， 且该用户请求使用 Email 密码重置功能所致。<br />
<br />
----------------------------------------------------------------------<br />
重要！<br />
----------------------------------------------------------------------<br />
<br />
如果您没有提交密码重置的请求或不是 澳洲亿忆网 的注册用户，请立即忽略 并删除这封邮件。只有在您确认需要重置密码的情况下，才需要继续阅读下面的 内容。<br />
<br />
----------------------------------------------------------------------<br />
密码重置说明<br />
----------------------------------------------------------------------<br />
<br />
您只需在提交请求后的三天内，通过点击下面的链接重置您的密码：<br />
http://www.yeeyi.com/bbs/member.php?mod=getpasswd&uid=$uid&id=$rand<br />
(如果上面不是链接形式，请将该地址手工粘贴到浏览器地址栏再访问)<br />
在上面的链接所打开的页面中输入新的密码后提交，您即可使用新的密码登录网站了。您可以在用户控制面板中随时修改您的密码。<br />
<br />
<br />
此致<br />
澳洲亿忆网 管理团队. http://www.yeeyi.com/bbs/<br />
</body>
</html>
EOT;
		$Headers[] = 'Content-Type: text/html; charset=utf-8';
		$Headers[] = 'Content-Transfer-Encoding: base64';
		$Headers[] = "From: \"yeeyi.com\" <online@yeeyi.com>";
		$to = $mail;
		$message = chunk_split(base64_encode(str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message)))))));
		return @mail($to,$subject, $message, implode("\r\n", $Headers)) ? true : false;
	}

	/**
	 *  获取推送开关状态
	 *  @param $uid
	 *  uid 用户ID
	 */
	public function switchInfo(){
		$uid = trim($this->Post['uid']);
		$switchInfo =  $this->Db->once_fetch_assoc("select conunsel,myinfo,inmail from app_user_push_ctrl where uid=".$uid);
		$switchInfo = $switchInfo ? changeCode($switchInfo) : $switchInfo = array('uid'=>$uid,'conunsel'=>1,'myinfo'=>1,'inmail'=>1,);

		$return['switchinfo'] = $switchInfo;
		$return['status'] = 0;
		$this->outjson($return);
	}

	/**
	 *  修改推送状态开关
	 *  @param $uid
	 *  @param $conunsel 1:开 0:关
 	 *  @param $myinfo   1:开 0:关
	 *  @param $inmail   1:开 0:关
	 */
	public function editSwitch(){

		$uid = trim($this->Post['uid']);
		$conunsel = trim($this->Post['conunsel']);
		$myinfo = trim($this->Post['myinfo']);
		$inmail = trim($this->Post['inmail']);

//		$conunsel = $conunsel===false ? $conunsel : 1;
//		$myinfo = $myinfo===false ? $myinfo : 1;
//		$inmail = $inmail===false ? $inmail : 1;

        //有数据就做更改，没有就做插入
		$switchInfo =  $this->Db->once_fetch_assoc("select * from app_user_push_ctrl where uid=".$uid);
		if($switchInfo){
			$res = $this->Db->query("update app_user_push_ctrl set conunsel=".$conunsel.",myinfo=".$myinfo.",inmail=".$inmail." where uid=".$uid);
		}else{
			$res = $this->Db->query("insert into app_user_push_ctrl(uid,conunsel,myinfo,inmail,disturb) values('".$uid."','".$conunsel."','".$myinfo."','".$inmail."','1')");
		}

		$return['status'] = $res ? 0 : 6001;
		$this->outjson($return);
	}

	/**
	 *  我的消息中未读消息个数
	 */
	public function unreadInfo(){
		//统计我的消息和站内信的总数
		$uid = trim($this->Post['uid']);

		$newsnum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type=2 and sid=".$uid);
		$catenum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type=3 and sid=".$uid);
		$forumnum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type=4 and sid=".$uid);
		$systemnum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where type=5 and sid=".$uid);

		$return['newsnum'] = $newsnum['counts'] ? intval($newsnum['counts']) : 0;
		$return['catenum'] = $catenum['counts'] ? intval($catenum['counts']) : 0;
		$return['forumnum'] = $forumnum['counts'] ? intval($forumnum['counts']) : 0;
		$return['systemnum'] = $systemnum['counts'] ? intval($systemnum['counts']) : 0;
		$return['status'] = 0;
		$this->outjson($return);
	}

	/**
	 * @清空数字的接口
	 */
	public function emptyNum(){
		//15=个人中心 14=我的消息[uid] 1=站内信[uid] 2=新闻消息[uid] 3=分类消息[uid] 4=论坛消息[uid] 5=系统消息[uid]  10=站内信列表[fromuid]
        $type = intval($this->Post['type']);//var_dump($type);die;
        $fid  = intval($this->Post['fromuid']);
        $sid  = intval($this->Post['uid']);
		switch ($type)
		{
			case 15:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where sid=".$sid);
				break;
			case 14:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type <>1 and sid=".$sid);
				break;
			case 1:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type=1 and sid=".$sid);
				break;
			case 2:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type=2 and sid=".$sid);
				break;
			case 3:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type=3 and sid=".$sid);
				break;
			case 4:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type=4 and sid=".$sid);
				break;
			case 5:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type=5 and sid=".$sid);
				break;
			case 10:
				$res = $this->Db->query("delete from yeeyico_new.app_unread_msg_record where type=1 and fid=".$fid);
				break;
		}

		$return['status'] = $res ? 0 : 6001;
		$this->outjson($return);
	}

}
