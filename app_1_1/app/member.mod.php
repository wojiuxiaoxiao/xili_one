<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if(in_array($this->Act,array('myReply','doReName','myFavorite','changeFace','doChangePwd','sendPm','replyPm','pmList','sysNotice','myReply','replyMe','verifyTel'))){
			if($this->G['uid']<1){
				$return['status'] = 5100;
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
            $this->dologin();
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
	}
	function index(){
		die('Error');
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
		$return['status'] = 2220;
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
			//判断手机
			$userTelTmp = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_phone_verify where phone='".$tel."' and status=1 and uid!=".MEMBER_ID );
			if(isset($userTelTmp['uid']) && $userTelTmp['uid']>0 && $userTelTmp['uid']!=MEMBER_ID){
				$return['status'] = 5933;
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
			$return['status'] = 2931;
			$this->outjson($return);
		}
		else{
			//短信验证码错误，请重新输入
			$return['status'] = 5000;
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
        $return['status'] = 2974;
        $return['list'] = changeCode($list);
        $this->outjson($return);
    }

	/**
	 * 发送消息
	 * @param toUid 发送的uid
	 * @param message 消息内容
	 */
	function sendPm(){
		$toUid = intval($this->Post['toUid']);
		$message = trim($this->Post['message']);
		$message = changeCode($message,'utf-8','gbk');
		$username = changeCode(MEMBER_NAME,'utf-8','gbk');

		$time = time();
		$existUser = $this->Db->once_fetch_assoc("select * from pre_common_member where uid=".$toUid);
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
		$return['status'] = 2970;
		$return['pmid'] = $pmid;
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
				$pmlist[] = $list;
			}
		}
		$return = array();
		$return['status'] = 2972;
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

		$return['status'] = 2973;
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
			$pmView = $this->Db->fetch_all_assoc("select pmid,authorid,message,dateline from  $pmTable where plid=$plid  and pmid<$start order by pmid desc limit $amount");
		}
		else{
			$pmView = $this->Db->fetch_all_assoc("select pmid,authorid,message,dateline from  $pmTable where plid=$plid order by pmid desc limit $amount");
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
		$oldPwd = $this->Post['oldpwd'];
		$newPwd = $this->Post['newpwd'];
		//判断是否为sns用户
		$checkSns = $this->Db->once_fetch_assoc("select sid from sns_user_map where uid=".$this->G['uid']);
		if($checkSns['sid']<1){
			$userInfo = $this->Db->once_fetch_assoc("select username, uid, password, salt FROM centery_main.uc_members WHERE uid=".$this->G['uid']);
			$salt = $userInfo['salt'];
			$pwdOld = md5(md5($oldPwd).$salt);
			if($userInfo['password']!=$pwdOld){
				$return['status'] = 5942;
				$this->outjson($return);
			}
		}

		$userInfo = $this->Db->once_fetch_assoc("select username, uid, password, salt FROM centery_main.uc_members WHERE uid=".$this->G['uid']);
		$salt = $userInfo['salt'];
		$pwd1 = md5(md5($newPwd).$salt);
		$pwd2 = md5($newPwd);
		$this->Db->query("update centery_main.uc_members set password='".$pwd1."' where uid=".$this->G['uid']);
		$this->Db->query("update pre_common_member set password='".$pwd2."' where uid=".$this->G['uid']);
		$return['status'] = 2940;
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
        $return['status'] = 2953;
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
        $return['status'] = 2953;
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
		if($userInfo['allow_rename'] == 0){
			$return['status'] = 5960;
			$this->outjson($return);
		}

		$this->checkName($name);
		//修改用户名
		$username = changeCode($name,'utf-8','gbk');
		$this->Db->query("update centery_main.uc_members set username='".$username."' where uid=".MEMBER_ID);
		$this->Db->query("update pre_common_member set username='".$username."' where uid=".MEMBER_ID);
		$this->Db->query("update yeeyico_new.pre_phone_verify set username='".$username."' where uid=".MEMBER_ID);
		$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".MEMBER_ID."',1)");
		//记录状态
		$this->Db->query("replace into app_change_name(uid,`rename`) values('".MEMBER_ID."',1)");
		//修改已经发布的帖子
		$this->Db->query("update pre_forum_thread set author='".$username."' where authorid=".MEMBER_ID);
		$this->Db->query("update pre_forum_post set author='".$username."' where authorid=".MEMBER_ID);

		$return['status'] = 2960;
		$this->outjson($return);
	}

	/**
	 * 判断用户名
	 * @param string $uname
	 */
	function checkName($uname=''){
		if($this->Post['username']){
			$username = trim($this->Post['username']);
		}
		else if($uname){
			$username = $uname;
		}
		$username = changeCode($username,'utf-8','gbk');
		$checkExist = $this->Db->once_fetch_assoc("select uid from `pre_common_member` where `username` ='".$username."'");
		if($checkExist['uid']){
			$return['status'] = 5962;
			$this->outjson($return);
		}

		if(strstr($username,'e2_') || strstr($username,'yeeyi_') || strstr($username,'admin')){
			$return['status'] = 5961;
			$this->outjson($return);
		}

		if(strlen($username)<=3){
			$return['status'] = 5964;
			$this->outjson($return);
		}
		if(strlen($username)>15){
			$return['status'] = 5964;
			$this->outjson($return);
		}

		if(preg_match("/^[0-9]+/isU",$username)){
			$return['status'] = 5963;
			$this->outjson($return);
		}
		if(false != preg_match('~[\.\<\>\?\@\$\#\[\]\{\}\s\'\"]+~',$username)){
			$return['status'] = 5961;
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
		$type = intval($this->Post['type']);
		$threadList = array();
		if($type == 2){
			if($start>0){
				$threadList = $this->Db->fetch_all_assoc("SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic FROM `pre_forum_thread` left join pre_forum_forum on pre_forum_forum.fid=pre_forum_thread.fid left join pre_forum_thread_pic on pre_forum_thread.tid=pre_forum_thread_pic.tid  where authorid=".$uid." and pre_forum_thread.displayorder>=0 and   pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and tid<$start order by tid desc limit $amount");
			}
			else{
				$threadList = $this->Db->fetch_all_assoc("SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic FROM `pre_forum_thread` left join pre_forum_forum on pre_forum_forum.fid=pre_forum_thread.fid left join pre_forum_thread_pic on pre_forum_thread.tid=pre_forum_thread_pic.tid    where authorid=".$uid." and pre_forum_thread.displayorder>=0 and  pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) order by tid desc limit $amount");
			}
		}
		else{
			if($start>0){
				$listTmp = $this->Db->fetch_all_assoc("SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic FROM `pre_forum_thread` left join pre_forum_forum on pre_forum_forum.fid=pre_forum_thread.fid left join pre_forum_thread_pic on pre_forum_thread.tid=pre_forum_thread_pic.tid   where authorid=".$uid." and pre_forum_thread.displayorder>=0 and   pre_forum_thread.fid not in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and tid<$start order by tid desc limit $amount");
			}
			else{
				$listTmp = $this->Db->fetch_all_assoc("SELECT author,authorid,replies,'0' as likes,pre_forum_forum.name,pre_forum_thread.fid,pre_forum_thread.tid,subject,dateline,pre_forum_thread_pic.pic FROM `pre_forum_thread` left join pre_forum_forum on pre_forum_forum.fid=pre_forum_thread.fid left join pre_forum_thread_pic on pre_forum_thread.tid=pre_forum_thread_pic.tid  where authorid=".$uid." and pre_forum_thread.displayorder>=0 and  pre_forum_thread.fid not in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) order by tid desc limit $amount");
			}
			if(is_array($listTmp)){
				foreach($listTmp as $t){
					$tmp = array();
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
					$tmp['likes'] = $t['likes'];
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
        $return['status'] = 2951;
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
				$list = $this->Db->fetch_all_assoc("select favid,id,idtype,title,dateline,'' as pic from pre_home_favorite where uid=".MEMBER_ID." and idtype='".$type."' and favid<$start order by favid desc limit $amount");
			}
			else{
				$list = $this->Db->fetch_all_assoc("select favid,id,idtype,title,dateline,'' as pic from pre_home_favorite where uid=".MEMBER_ID." and idtype='".$type."' order by favid desc limit $amount");
			}
		}
		if($typeid == 3){
			$type = 'cid';
			if($start>0){
				$list = $this->Db->fetch_all_assoc("select favid,id,idtype,title,dateline,'' as pic from pre_home_favorite where uid=".MEMBER_ID." and idtype='".$type."' and favid<$start order by favid desc limit $amount");
			}
			else{
				$list = $this->Db->fetch_all_assoc("select favid,id,idtype,title,dateline,'' as pic from pre_home_favorite where uid=".MEMBER_ID." and idtype='".$type."' order by favid desc limit $amount");
			}
		}

		if(!is_array($list)){
			$list = array();
		}
        $return['status'] = 2952;
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
			$return['status'] = 2010;
			$this->outjson($return);
		}
		else if($result == -1){
			$return['status'] = 5012;
			$this->outjson($return);
		}
		else{
			$return['status'] = 5011;
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
			$return['status'] = 5930;
			$this->outjson($return);
		}
		$return['status'] = 5931;
        $check = checkSms($tel,$smsCode);
        if($check){
            $return['status'] = 2930;
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
			$return['status'] = 5940;
			$this->outjson($return);
		}
		$successKey = 'sms_check_'.$tel;
		$checkNum = getVar($successKey);
		if($checkNum != $check){
			$return['status'] = 5940;
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
		$return['status'] = 2940;
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
			$this->outjson($return);
		}
		if($uid<1){
			$uid = MEMBER_ID;
		}
		$userInfo = $this->getUserInfo($uid);
		$return['status'] = 2000;
		$return['userInfo'] = $userInfo;
		$this->outjson($return);
	}

	/**
	 * 修改头像
	 * pic
	 */
	function changeFace(){
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
				$return['status'] = 2950;
				$this->outjson($return);
			}
			//curl传递结束
		}
		$return['status'] = 5950;
		$this->outjson($return);
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
		if(substr($username,0,2) == '04'){
			if($smsCode>0){
				$keyCode = 'sms_'.$username;
				$saveCode = getVar($keyCode);
				if($smsCode == $saveCode){
					/**
					 * 有动态效验码的情况下，
					 * 1、判断用户是否存在，如果存在则登录
					 * 2、用户不存在，则直接注册
					 */
					$userInfoTmp = $this->Db->once_fetch_assoc("select uid,username,groupid,status from yeeyico_new.pre_phone_verify where phone='".$username."'");
					if($userInfoTmp['uid']<1){
						/**
						 * 用户不存在，添加用户，完成用户注册
						 */
						$uid = $this->appReg($username,'','');
					}
					else{
						/*
						 *用户存在,完成状态变更
						 * */
						$uid = $userInfoTmp['uid'];
						if($userInfoTmp['status']  != 1){
							$this->Db->query("update yeeyico_new.pre_phone_verify set groupid=10,status=1 where uid=".$uid);
							$this->Db->query("replace into `pre_common_member_verify`(uid,verify1) values('".$uid."',1)");
						}
					}
				}
				else{
					//短信验证码错误，请重新输入
					$return['status'] = 5000;
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
				$return['status'] = 5900;
				$this->outjson($return);
			}
		}
		$userInfo = $this->getUserInfo($uid);
		//authcode $userid::::$username::::time();
		$time = time();
		$key = md5($time."_e2app^");
		$authStr = $userInfo['uid']."::::".$userInfo['username']."::::".$userInfo['groupid']."::::".$devid."::::".time()."::::".$key;
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
		$return['status'] = 2910;
		$return['authcode'] = $authcode;
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
	function appReg($tel,$username='',$password='')
	{
		//随机用户名
		if($username){
			//utf-8模式下判断用户名格式 中文，字母，数字，下划线
			if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$username)){
				$return['status'] = 5961;
				$this->outjson($return);
			}
			$username = changeCode($username,'utf-8','gbk');
			$getMail = $this->Db->once_fetch_assoc("select uid from `pre_common_member` where `username` like '".$username."'");
			if($getMail['uid']){
				$return['status'] = 5962;
				$this->outjson($return);
			}
			//判断
			if(strstr($username,'e2_') || strstr($username,'yeeyi_') || strstr($username,'admin')){
				$return['status'] = 5961;
				$this->outjson($return);
			}

			if(strlen($username)<=3){
				$return['status'] = 5964;
				$this->outjson($return);
			}
			if(strlen($username)>15){
				$return['status'] = 5964;
				$this->outjson($return);
			}

			if(preg_match("/^[0-9]+/isU",$username)){
				$return['status'] = 5963;
				$this->outjson($return);
			}
			if(false != preg_match('~[\<\>\?\@\$\#\[\]\{\}\s\'\"]+~',$username)){
				$return['status'] = 5961;
				$this->outjson($return);
			}
		}
		else{
			$username = 'app_' . time() . '_' . mt_rand(100, 999);
			//随机邮箱
			$email = 'app_' . time() . '_' . mt_rand(10, 99) . '@e2app.yeeyi.com';
			//随机密码
			$password = random(10);
			//随机密码发送短信给用户
			sendPwd($tel,$password);

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
	 * @param 1qq 2weixin 3weibo
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
		$sql = "select yeeyico_new.pre_common_member.uid,pre_common_member.regdate,pre_common_member.groupid,yeeyico_new.pre_common_member.username,yeeyico_new.pre_common_member.credits,yeeyico_new.pre_common_member.groupid,yeeyico_new.pre_phone_verify.status as istel,yeeyico_new.pre_phone_verify.phone as tel from yeeyico_new.pre_common_member left join yeeyico_new.pre_phone_verify on yeeyico_new.pre_phone_verify.uid=yeeyico_new.pre_common_member.uid where yeeyico_new.pre_common_member.uid=".$uid;
		$userInfo = $this->Db->once_fetch_assoc($sql);
		$userInfo['istel'] = strval($userInfo['istel']);
		$userInfo['issns'] = 0;
		$userInfo['allow_rename'] = 0;
		$userInfo['allow_repwd'] = 0;
		unset($userInfo['tel']);
		//$userInfo['tel'] = strval($userInfo['tel']);
		$userInfo['face'] = "http://center.yeeyi.com/avatar.php?uid=".$uid."&size=middle";
		//判断是否可以修改名字
		$checkSns = $this->Db->once_fetch_assoc("select * from sns_user_map where uid=".$uid);
		if($checkSns['uid']>0){
			$userInfo['issns'] = 1;
			$userInfo['allow_repwd'] = 1;
		}
		if($userInfo['issns'] == 1 || $userInfo['istel']==1){
			$checkReNameInfo = $this->Db->once_fetch_assoc("select * from app_change_name where uid=".$uid);
			if(intval($checkReNameInfo['rename']) == 0){
				$userInfo['allow_rename'] = 1;
			}
		}

		//判断是否可以直接修改密码
		$userInfo = changeCode($userInfo);
		$otherInfo = $this->Db->once_fetch_assoc("select * from pre_common_member_count where uid=".$uid);
		$otherInfo = changeCode($otherInfo);
		$lastInfo = $this->Db->once_fetch_assoc("select lastvisit,lastactivity,lastpost from pre_common_member_status where uid=".$uid);
		$groupInfo = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_common_usergroup where groupid='".$userInfo['groupid']."'");
		$groupInfo = changeCode($groupInfo);
		$profileAry = $this->Db->once_fetch_assoc("select gender from pre_common_member_profile where uid=".$uid);
		if($profileAry['gender'] == 1){
			$sex = '男';
		}
		elseif($profileAry['gender'] == 2){
			$sex = '女';
		}
		else{
			$sex = '保密';
		}
		$profile = array();
		$profile[] = array('用户组',$groupInfo['grouptitle']);
		$profile[] = array('性别',$sex);
		$profile[] = array('注册时间',date("Y-m-d G:i:s",$userInfo['regdate']));
		$profile[] = array('最后访问时间',date("Y-m-d G:i:s",$lastInfo['lastvisit']));
		$profile[] = array('最后发表时间',date("Y-m-d G:i:s",$lastInfo['lastpost']));
		$profile[] = array('贴子数',$otherInfo['posts']);
		$profile[] = array('主题数',$otherInfo['threads']);
		$profile[] = array('精华帖',$otherInfo['digestposts']);
		$profile[] = array('积分',$userInfo['credits']);
		$profile[] = array('威望',$otherInfo['extcredits1']." 点");
		$profile[] = array('金钱',$otherInfo['extcredits2']." YB");
		$profile[] = array('贡献值',$otherInfo['extcredits3']." 点");
		$profile[] = array('鲜花',$otherInfo['extcredits4']." 个");
		$profile[] = array('鸡蛋',$otherInfo['extcredits5']." 个");
		$profile[] = array('好评度',$otherInfo['extcredits6']." ");
		$profile[] = array('信誉度',$otherInfo['extcredits7']." ");
		$profile[] = array('金币',$otherInfo['extcredits8']." 枚");
		$userInfo['profile'] = $profile;
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
}