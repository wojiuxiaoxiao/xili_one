<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if($this->Act == 'getConfig'){
			$this->getConfig();
		}
		else if($this->Act == 'sync'){
			$this->sync();
		}
		else if($this->Act == 'getRate'){
			$this->getRate();
		}
		else if($this->Act == 'getWeather'){
			$this->getWeather();
		}
		else if($this->Act == 'report'){
			$this->report();
		}
		else if($this->Act == 'doDel'){
			$this->doDel();
		}
		else if($this->Act == 'doDeny'){
			$this->doDeny();
		}
		else if($this->Act == 'doLock'){
			$this->doLock();
		}else if($this->Act == 'getCate'){
			$this->getCate();
		}else if($this->Act == 'getVersion'){
			$this->getVersion();
		}else if($this->Act == 'getSplash'){
			$this->getSplash();
		}else if($this->Act == 'updateVersion'){
			$this->updateVersion();
		}
		else if($this->Act == 'doBaoLiao'){
			$this->doBaoLiao();
		}
		else if($this->Act == 'articleReport'){
			$this->articleReport();
		} else if ($this->Act == 'addClick') {
            $this->addClick();
        } else if ($this->Act == 'addShow') {
            $this->addShow();
        } else if ($this->Act == 'advertisePost') {
			$this->advertisePost();
		}
	}

	function index(){
		die('Error');
	}

	// 爆料
	function doBaoLiao(){

		$fid = 731;
	  $typeid = 1347;

		if(MEMBER_ID>0){
			$subject = MEMBER_NAME ." 爆料:";
		}
		else{
			$return['status'] = 5100;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		$content = strip_tags($this->Post['content']);

		$contact = trim($this->Post['contact']);
		$phone = $this->Post['phone'];
		$qq = $this->Post['qq'];
		$email = $this->Post['email'];
		$weixin = $this->Post['weixin'];

		$message = "";
		$message .= "<p>爆料人:".$contact."</p>";
		$message .= "<p>电话:".$phone."</p>";
		$message .= "<p>QQ:".$qq."</p>";
		$message .= "<p>Email:".$email."</p>";
		$message .= "<p>微信:".$weixin."</p>";
		$message .= "<p>内容:".$content."</p>";

	  load::logic("ThreadPost");
	  $postObj = new ThreadPost();
	  $dateline = time();
	  $post = $postObj->postThread($fid,$subject,$message,$dateline,$typeid);
	  $return['status'] = 0;
	  $return['message'] = '爆料成功';
	  $this->outjson($return);
	}


	function report(){
		$types = $this->Post['type'];  //类型: 1为发帖举报, 2为回帖举报
		$pid   = intval($this->Post['pid']);
		$tid   = intval($this->Post['tid']);
		$reas  = addslashes(strip_tags($this->Post['reason']));

		$fid = 731;
		$typeid = 1348;


		if(MEMBER_ID>0){
			$content = MEMBER_NAME ." 举报:";
		}
		else{
			$return['status'] = 5100;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		if ($types == 1) {

			if (!$tid) {

				$return['status'] = 5400;
				$this->outjson($return);
			}

			$subject = '帖子举报:'.trim(strip_tags($reas));
			$content .= "<a href='http://www.yeeyi.com/bbs/thread-".$tid."-1-1.html'>http://www.yeeyi.com/bbs/thread-".$tid."-1-1.html</a>";

		} elseif ($types == 2) {

			if (!$pid) {

				$return['status'] = 5400;
				$this->outjson($return);
			}


			$threadInfo = $this->Db->once_fetch_assoc("select tid  from pre_forum_post where pid=".$pid);
			$tid = $threadInfo['tid'];

			$subject = '帖子回复举报:'.trim(strip_tags($reas));
			$content .="<a href='http://www.yeeyi.com/bbs/forum.php?mod=redirect&goto=findpost&pid=".$pid."&ptid=".$tid."'>http://www.yeeyi.com/bbs/forum.php?mod=redirect&goto=findpost&pid=".$pid."&ptid=".$tid."</a>";

		}else{

			$return['status'] = 5400;
			$this->outjson($return);
		}


		$content .= $reas;

		load::logic("ThreadPost");
		$postObj = new ThreadPost();
		$dateline = time();
		$post = $postObj->postThread($fid,$subject,$content,$dateline,$typeid);

		$return['status'] = 0;
		$return['message'] = '举报成功';
		$this->outjson($return);
	}


	/**
	 * 文章评论举报
	 */
	public function articleReport()
	{
		$id = intval($this->Post['id']); //评论id
		$report_status = intval($this->Post['report_status']); //举报原因
		$report_con = addslashes(strip_tags($this->Post['report_con'])); //举报说明
		$sql="select aid from news_comment where id=".$id;
		$aids=$this->Db->once_fetch_assoc($sql);

		if(MEMBER_ID < 1){
			$return['status'] = 5100;
			$return['message'] = '未登录';  //   $return['message'] = '操作成功';
			$this->outjson($return);
		}

		if (!$aids) {

			$return['status'] = 5400;
			$this->outjson($return);
		}

		$delarr=array("report_status"=>$report_status, 'report_con'=>$report_con);
		$res=$this->Db->updateArr($delarr,'news_comment',$where="where id='$id'");

		if ($res) {

			$return['status'] = 0;
			$return['message'] = '举报成功';
			$this->outjson($return);

		}else{

			$return['status'] = 5400;
			$this->outjson($return);
		}
	}

	/**
	 * 版本升级
	 */
	public function updateVersion()
	{
		$current_version = trim($_POST['app_ver']); //当前版本

		if ($current_version) {

			$verAry = explode('_',$current_version);
			$current_version_number = $verAry[2] ?  $verAry[0].$verAry[1].$verAry[2] : $verAry[0].$verAry[1];

			if(!$verAry || !is_numeric($current_version_number)) {

				$return['status'] = 5601;
				$this->outjson($return);
			}

			$client = end($verAry); //获取设备名

			if ($current_version_number< 196) { //有更新版本

				$return['info'] = '主公！发现新版本，是否更新？';
				$return['force'] = 0; //是否强制更新
				$return['status'] = 0;

				if ($client == 'android') { //安卓

					$return['url']  = 'https://m.yeeyi.com/mobile/client/download/android.apk';
				}

				if ($client == 'ios') { //ios

					$return['url']  = 'https://itunes.apple.com/us/app/yeeyi-yi-yi-ao-zhou-zui-da/id1157314837?l=zh&ls=1&mt=8';
				}

				$this->outjson($return);

			}else{

				$return['status'] = 1;
				$this->outjson($return);
			}

		}else {

			$return['status'] = 5602;
			$this->outjson($return);
		}



	}


	/**
	 * @param int $tid
	 * @param int $lock
	 * 删除帖子
	 */
	function doDel($tid=0){
		if(!in_array(MEMBER_GROUP,array(1,2))){
			$return['status'] = 1;
			$return['message'] = '无操作权限';
			$this->outjson($return);
		}

		$tid = intval($this->Post['tid']);//帖子
		$id = intval($this->Post['id']);//新闻评论
		$pid = intval($this->Post['pid']);//帖子回复
		$reason = trim($this->Post['reason']);//原因
		$lockuser = intval($this->Post['lockuser']);//是否锁定用户
		$cid = intval($this->Post['cid']);
		$time = time();
		if($tid+$id+$pid+$cid < 1){
			$return['status'] = 1;
			$return['message'] = '操作失败';
			$this->outjson($return);
		}

		if($tid>0 || $cid>0){
			//删除帖子
			if($cid>0){
				$tid = $cid;
			}
			$threadInfo = $this->Db->once_fetch_assoc("select tid,authorid from pre_forum_post where tid=".$tid);
			$uid = $threadInfo['authorid'];
			$this->Db->query("UPDATE  pre_forum_thread SET `displayorder`='-1' , `digest`='0' , `moderated`='1' WHERE `tid` IN('".$tid."')");
			$this->Db->query("UPDATE  pre_forum_post SET `invisible`='-1' WHERE `tid` IN('".$tid."')");
			$sql = "INSERT INTO pre_common_member_crime SET `uid`='".$uid."' , `operatorid`='".MEMBER_ID."' , `operator`='".MEMBER_NAME."' , `action`='1' , `reason`='".$reason." &nbsp; <a href=\"forum.php?mod=redirect&goto=findpost&pid=0&ptid=".$tid."\" target=\"_blank\" class=\"xi2\">查看详情</a>' , `dateline`='".$time."'";
			$sql = changeCode($sql,'utf-8','gbk');
			$this->Db->query($sql);

			//对未读记录表维护
			$sq = "INSERT INTO yeeyico_new.app_unread_msg_record values('','{$uid}','0500','5')";
			$this->Db->query($sq);

			$sql ="INSERT INTO pre_forum_threadmod SET `tid`='".$tid."' , `uid`='".MEMBER_ID."' , `username`='".MEMBER_NAME."' , `dateline`='".$time."' , `action`='DEL' , `expiration`='0' , `status`='1' , `reason`='".$reason."'";
			$sql = changeCode($sql,'utf-8','gbk');
			$this->Db->query($sql);

			$this->Db->query("UPDATE pre_forum_modwork SET count=count+'1', posts=posts+'1' WHERE uid='".MEMBER_ID."' AND modaction='DEL' AND dateline='".date("Y-m-d")."'");
			$this->Db->query("INSERT INTO pre_forum_modwork SET `uid`='".MEMBER_ID."' , `modaction`='DEL' , `dateline`='".date("Y-m-d")."' , `count`='1' , `posts`='1'");

			$msgSql = "INSERT INTO pre_home_notification SET `uid`='".$uid."' , `type`='post' , `new`='1' , `authorid`='0' , `author`='' , `note`='您的主题 <a href=\"forum.php?mod=viewthread&tid=".$tid."\" target=\"_blank\">查询详情</a> 被 <a href=\"home.php?mod=space&uid=".MEMBER_ID."\">".MEMBER_NAME."</a> 删除 <div class=\"quote\"><blockquote>".$reason."</blockquote></div>' , `dateline`='".$time."' , `from_id`='0' , `from_idtype`='moderate_删除' , `from_num`='1' , `category`='1'";
			$msgSql = changeCode($msgSql,'utf-8','gbk');
			$this->Db->query($msgSql);

			$this->Db->query("UPDATE pre_common_member SET `newprompt`=`newprompt`+'1' WHERE uid IN ('".$uid."')");
			$this->Db->query("UPDATE  pre_common_member_newprompt SET `data`='a:2:{s:6:\"system\";i:1;s:4:\"post\";i:1;}' WHERE `uid`='".$uid."'");

			/* 2017.06.07 edit by allen qu 删除帖子, 扣除作者20YB */

			$authorInfo = $this->Db->once_fetch_assoc("select * from pre_common_member_count where uid=".$uid);

			if ($authorInfo['extcredits2'] > 20) {

				$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 - 20 where uid=".$uid);//扣除20YB

				//$return['yb_message'] = changeCode('删除成功, 金钱-20YB', 'utf-8', 'gbk');
				$return['yb_message'] = '删除成功, 金钱-20YB';
			}else{

				if ($authorInfo['extcredits2'] > 0) {

					$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 - {$authorInfo['extcredits2']} where uid=".$uid);//扣除20YB
					//$return['yb_message'] = changeCode('删除成功, 金钱-20YB', 'utf-8', 'gbk');
					$return['yb_message'] = '删除成功, 金钱-20YB';
				}
			}

			/* edit end */

		}
		if($id>0){
			//删除新闻评论
			$replyInfo = $this->Db->once_fetch_assoc("select userid,aid from news_comment where id=".$id);
			if($replyInfo['aid']<1){
				$return['status'] = 5208;
				$this->outjson($return);
			}
			$uid = $replyInfo['userid'];
			$this->Db->query("update news_comment set del_status=1 where id=".$id);
			$this->Db->query("update news_article set comments=comments-1 where aid=".$replyInfo['aid']." and comments>0");

			/* 2017.06.07 edit by allen qu 删除评论, 扣除作者6YB */

			$authorInfo = $this->Db->once_fetch_assoc("select * from pre_common_member_count where uid=".$uid);

			if ($authorInfo['extcredits2'] > 6) {

				$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 - 6 where uid=".$uid);//扣除6YB

				//$return['yb_message'] = changeCode('删除成功, 金钱-6YB', 'utf-8', 'gbk');
				$return['yb_message'] = '删除成功, 金钱-6YB';

			}else{

				if ($authorInfo['extcredits2'] > 0) {

					$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 - {$authorInfo['extcredits2']} where uid=".$uid);//扣除6YB
					//$return['yb_message'] = changeCode('删除成功, 金钱-6YB', 'utf-8', 'gbk');
					$return['yb_message'] = '删除成功, 金钱-6YB';
				}
			}

			/* edit end */
		}
		if($pid>0){
			//删除回复
			$threadInfo = $this->Db->once_fetch_assoc("select tid,authorid from pre_forum_post where pid=".$pid);
			$tid = $threadInfo['tid'];
			$uid = $threadInfo['authorid'];
			if($tid>0 && $uid>0){
				/* 2017.06.15 edit by allen qu thread表中的replies要减1 */
				$this->Db->query("update pre_forum_thread set replies=replies-1 where `tid` = $tid and replies>0");
				$this->Db->query("UPDATE  pre_forum_post SET `invisible`='-5' WHERE `pid` IN('".$pid."')");
				$this->Db->query("DELETE FROM pre_forum_postcomment WHERE `rpid` IN('".$pid."')");
				$this->Db->query("DELETE FROM pre_forum_post_moderate WHERE `id` IN('".$pid."')");
				$this->Db->query("DELETE FROM pre_forum_post_location WHERE `pid` IN('".$pid."')");
				$this->Db->query("DELETE FROM pre_forum_filter_post WHERE `pid` IN('".$pid."')");
				$this->Db->query("DELETE FROM pre_forum_hotreply_number WHERE `pid` IN('".$pid."')");
				$this->Db->query("DELETE FROM pre_forum_hotreply_member WHERE `pid` IN('".$pid."')");
				//帖子信息
				$sql = "INSERT INTO pre_common_member_crime SET `uid`='".$uid."' , `operatorid`='".MEMBER_ID."' , `operator`='".MEMBER_NAME."' , `action`='1' , `reason`='".$reason." &nbsp; <a href=\"forum.php?mod=redirect&goto=findpost&pid=".$pid."&ptid=".$tid."\" target=\"_blank\" class=\"xi2\">查看详情</a>' , `dateline`='".$time."'";
				$sql = changeCode($sql,'utf-8','gbk');
				$this->Db->query($sql);



				/*
				 *
				 	SELECT COUNT(*) FROM pre_forum_post WHERE tid=11 AND invisible=0
					SELECT * FROM pre_forum_post WHERE tid=11 AND invisible=0 ORDER BY dateline DESC  LIMIT 1
					SELECT attachment FROM pre_forum_post WHERE tid=11 AND invisible=0 AND attachment>0 LIMIT 1
					UPDATE  pre_forum_thread SET `replies`='1' , `lastposter`='bluebat2' , `lastpost`='1474869530' , `attachment`='0' WHERE `tid`='11'
					SELECT COUNT(*) AS threads, SUM(replies)+COUNT(*) AS posts FROM pre_forum_thread WHERE fid=2 AND displayorder>=0
					SELECT * FROM pre_forum_thread WHERE fid=2 AND displayorder=0  ORDER BY `lastpost` DESC  LIMIT 1
					UPDATE  pre_forum_forum SET `posts`='19' , `threads`='11' , `lastpost`='12	3r23421rawerfsafasdfsdafasdfa	1474869588	bluebat3' WHERE `fid`='2'
					UPDATE pre_forum_modwork SET count=count+'1', posts=posts+'1' WHERE uid=1 AND modaction='DLP' AND dateline='2016-09-26'
					INSERT INTO pre_forum_modwork SET `uid`='1' , `modaction`='DLP' , `dateline`='2016-09-26' , `count`='1' , `posts`='1'
					SELECT * FROM pre_common_member_field_home WHERE `uid`='4'
				 */

				$this->Db->query("UPDATE pre_forum_modwork SET count=count+'1', posts=posts+'1' WHERE uid='".MEMBER_ID."' AND modaction='DLP' AND dateline='".date("Y-m-d")."'");
				$this->Db->query("INSERT INTO pre_forum_modwork SET `uid`='".MEMBER_ID."' , `modaction`='DLP' , `dateline`='".date("Y-m-d")."' , `count`='1' , `posts`='1'");

				$sqlMsg = "INSERT INTO pre_home_notification SET `uid`='".$uid."' , `type`='post' , `new`='1' , `authorid`='0' , `author`='' , `note`='您在 <a href=\"forum.php?mod=viewthread&tid=11\" target=\"_blank\">查看帖子</a> 的帖子被 <a href=\"home.php?mod=space&uid=".MEMBER_ID."\">".MEMBER_NAME."</a> 删除 <div class=\"quote\"><blockquote>恶意灌水</blockquote></div>' , `dateline`='".$time."' , `from_id`='0' , `from_idtype`='moderate_DLP' , `from_num`='1' , `category`='1'";
				$sqlMsg = changeCode($sqlMsg,'utf-8','gbk');
				$this->Db->query($sqlMsg);
				$this->Db->query("UPDATE pre_common_member SET `newprompt`=`newprompt`+'1' WHERE uid IN ('".$uid."')");
				$this->Db->query("UPDATE  pre_common_member_newprompt SET `data`='a:2:{s:6:\"system\";i:1;s:4:\"post\";i:1;}' WHERE `uid`='".$uid."'");
			}
		}

		if($lockuser>0 && $uid>0){
			$this->doLock($uid);
		}
		$return['status'] = 0;
		$return['message'] = '操作成功';
		$this->outjson($return);
	}

	/**
	 * @param int $uid
	 * 禁言用户
	 */
	function doDeny($uid=0){
		if(!in_array(MEMBER_GROUP,array(1,2))){
			$return['status'] = 1;
			$return['message'] = '无操作权限';
			$this->outjson($return);
		}

		$uid = intval($this->Post['uid']);//帖子回复
		$reason = trim($this->Post['reason']);//原因
		$lockuser = intval($this->Post['lockuser']);//是否锁定用户
		if($uid<1){
			$return['status'] = 1;
			$return['message'] = '操作失败';
			$this->outjson($return);
		}

		$this->Db->query("UPDATE  pre_common_member SET `groupexpiry`='0' , `adminid`='-1' , `groupid`='4' , `status`='0' WHERE `uid`='".$uid."'");
		$this->Db->query("UPDATE  pre_common_member_field_forum SET `groupterms`='' WHERE `uid`='".$uid."'");
		$this->Db->query("INSERT INTO pre_common_member_crime SET `uid`='".$uid."' , `operatorid`='".MEMBER_ID."' , `operator`='".MEMBER_NAME."' , `action`='4' , `reason`='".changeCode($reason,'utf-8','gbk')."' , `dateline`='".time()."'");
		$sql = "INSERT INTO pre_home_notification SET `uid`='".$uid."' , `type`='system' , `new`='1' , `authorid`='0' , `author`='' , `note`='您已被 <a href=\"home.php?mod=space&uid=".MEMBER_ID."\">".MEMBER_NAME."</a> 禁止发言，期限：0天(0：代表永久禁言)，禁言理由：".$reason."' , `dateline`='1474621207' , `from_id`='0' , `from_idtype`='banspeak' , `from_num`='1' , `category`='3'";
		$sql = changeCode($sql,'utf-8','gbk');
		$this->Db->query($sql);

		//对未读记录表维护
		$sq = "INSERT INTO yeeyico_new.app_unread_msg_record values('','{$uid}','0500','5')";
		$this->Db->query($sq);

		$this->Db->query("UPDATE pre_common_member SET `newprompt`=`newprompt`+'1' WHERE uid IN ('".$uid."')");
		$this->Db->query("UPDATE  pre_common_member_newprompt SET `data`='a:1:{s:6:\"system\";i:2;}' WHERE `uid`='".$uid."'");
		if($lockuser>0 && $uid>0){
			$this->doLock($uid);
		}
		$return['status'] = 0;
		$return['message'] = '操作成功';
		$this->outjson($return);
	}

	/**
	 * @param int $uid
	 * 锁定用户
	 */
	function doLock($uid=0){
		$uid = intval($uid);
		$this->Db->query("update `pre_common_member` set status='-1' where uid ='".$uid."'");
		$this->Db->query("update `pre_forum_thread` set displayorder='-1', digest='0', moderated='1' where authorid ='".$uid."'");
		$this->Db->query("update `pre_forum_post` SET invisible='-1' where authorid ='".$uid."'");
		/* 2017.0.6.20 edit by allen qu  新闻评论也要删掉 */
		$this->Db->query("update `news_comment` SET del_status='1' where userid ='".$uid."'");
		$this->Db->query("DELETE FROM `pre_home_comment` WHERE uid='".$uid."' OR authorid ='".$uid."'");
		$this->Db->query("DELETE FROM `pre_forum_postcomment` WHERE authorid ='".$uid."'");
		$this->Db->query("DELETE FROM `pre_portal_comment` WHERE uid ='".$uid."'");
		$this->Db->query("delete from `pre_new_user_check` where uid ='".$uid."'");

		//$getUsername = $this->Db->query("select username from `pre_common_member` where uid='".$uid."'");
		//while($row=mysql_fetch_assoc($getUsername)){
			//$this->Db->query("update `pre_forum_thread` set lastposter='亿忆网友' where lastposter='".$row['username']."'");
		//}

		$time = time();
		$this->Db->query("insert into `pre_common_credit_log`(uid,operation,relatedid,dateline,extcredits2) values(".$uid.",'SUO','','$time','0')");
		$getAllThreads = $this->Db->query("select t.tid,j.id from pre_forum_thread t left join pre_forum_mobjam j on j.tid=t.tid where t.authorid='".$uid."'");
		while($row = mysql_fetch_assoc($getAllThreads)){
			$this->Db->query("insert into `pre_forum_threadmod` values('".$row['tid']."','1','admin','{$time}',0,'DEL','1','0','0','10分钟自动锁帖系统')");
			$this->Db->query("replace into `pre_member_suo_log` values('$uid','{$time}','10分钟自动锁帖系统','admin')");
		}
		$date = time();
		$day = date('Ymd',time());
		$info = '【自动操作：锁定用户】- 相关用户UID:'.$uid;
		$this->Db->query("insert into `pre_ads_logs` values('','自动锁帖系统','{$date}','{$info}','{$day}')");
	}


	function getWeather(){
		$ip = client_ip();
		$cityJson = @getPage("http://ip-api.com/json/".$ip);
		$cityAry = json_decode($cityJson,true);
		$city = $cityAry['city'];
		$weatherJson = @getPage("https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22".urlencode($city)."%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys");
		$weatherAry = json_decode($weatherJson,true);
		$info = $weatherAry['query']['results']['channel']['item']['forecast'][0];
		//http://l.yimg.com/a/i/us/we/52/27.gif
		$low = $info['low'];
		$high = $info['high'];
		$low = intval(($low-32)/1.8);
		$high = intval(($high-32)/1.8);
		$temperature = $low.'/'.$high;
		$code = $info['code'];
		$return = array();
		$return['temperature'] = $temperature;
		$return['code'] = $code;
		$this->outjson($return);
	}

	function getRate(){
		if(getVar('rate_app')){
			$rate = getVar('rate_app');
		}else{
			$rate = @getPage("http://jxfinance.com.au/exchangeRate.php?cur_code=AUDRMB");//接口地址待修改
			$rate = json_decode($rate);
			$rate = $rate->data->rate_in .'/'.$rate->data->rate_out;
			setVar('rate_app',$rate,600);//5小时
		}

		$return = array();
		$return['rate'] = $rate? $rate: "";
        /* add Rate advertise */
        $rate_ad =  get_ad('rate');
        if ($rate_ad['status'] == 1){   
            $advertises = $rate_ad['data'];
            add_show($advertises['ad_id']);
            $return['ad_id'] = $advertises['ad_id'];
            $return['froms'] = $advertises['froms'];
            $return['pic']   = $advertises['pic'];
            $return['url']   = $advertises['url'];

            $return['share']['url']   = $advertises['share_url'];
            $return['share']['title']   = $advertises['share_title'];
            $return['share']['thumbnail']   = $advertises['share_logo'];    
            $return['share']['summary']   = $advertises['share_summary'];
        }else{
            $return = $this->Config['rate_default'];
			add_show($this->Config['rate_default']['ad_id']);
        }

		$return['status'] = 0;
		$this->outjson($return);
	}

	function getConfig(){   
		$return = array();
		//新闻分类
		//$category = $this->Db->fetch_all_assoc("select cid,catname from news_category where upuid in(19,20) order by cid asc");
		//$categoryTmp = changeCode($category,'gbk','utf-8');
		$newsType = array(
			array('cid'=>'0','catname'=>'精华'),
			array('cid'=>'4','catname'=>'澳洲'),
			array('cid'=>'25','catname'=>'公众号'),
			array('cid'=>'18','catname'=>'视频'),
			array('cid'=>'6','catname'=>'地产'),
			array('cid'=>'7','catname'=>'教育'),
			array('cid'=>'8','catname'=>'旅游'),
			array('cid'=>'9','catname'=>'美食'),
			array('cid'=>'10','catname'=>'财经'),
			array('cid'=>'11','catname'=>'汽车'),
			array('cid'=>'13','catname'=>'专访'),
			array('cid'=>'23','catname'=>'综合'),
			array('cid'=>'24','catname'=>'活动'),
			array('cid'=>'94','catname'=>'社区'),
		);

		/*foreach($categoryTmp as $news){
			if($news['cid'] == 25){
				continue;
			}
			$newsType[] = $news;

		}
		*/
		$return['status'] = 1200;
		$return['category'] = $newsType;
		$return['version'] = $this->Config['version'];
		$return['splash'] = $this->Config['splash'];
		$this->outjson($return);
	}

	function getCate()
	{
		$return = array();
		$newsType = array(
			array('cid'=>'0','catname'=>'推荐'),
			array('cid'=>'23','catname'=>'综合'),
			array('cid'=>'4','catname'=>'澳洲'),
			array('cid'=>'102','catname'=>'吐槽'),
			array('cid'=>'107','catname'=>'问答'),
			array('cid'=>'6','catname'=>'地产'),
			array('cid'=>'7','catname'=>'教育'),
			array('cid'=>'105','catname'=>'佛教'),
			array('cid'=>'8','catname'=>'旅游'),
			array('cid'=>'9','catname'=>'美食'),
//			array('cid'=>'25','catname'=>'公众号'),
			array('cid'=>'10','catname'=>'财经'),
			array('cid'=>'11','catname'=>'汽车'),
			array('cid'=>'13','catname'=>'专访'),
			array('cid'=>'103','catname'=>'折扣'),
			array('cid'=>'24','catname'=>'活动'),
			array('cid'=>'94','catname'=>'社区'),
            //array('cid'=>'18','catname'=>'早新闻'),
		);
		$return['status'] = 0;
		$return['category'] = $newsType;
		$this->outjson($return);
	}

	function getVersion()
	{
		$return = array();
		$return['version'] = $this->Config['version'];
		$return['status'] = 1200;
		$this->outjson($return);
	}

	function getSplash()        
	{
		$return = array();

        $rq = array(
            'model'=>'open',
        );
        //$result  =  postData('http://116.62.51.6:8005/api/get_ad',$rq);
		$result  =  postData('http://ad.yeeyi.com/api/get_ad',$rq);
        $open_ad =  json_decode($result,true);
        if ($open_ad['status'] == 1){
            $return['splash'] = $open_ad['data'];
        }else{
			$return['splash'] = $this->Config['splash_default'];
		}

		$return['status'] = 0;
		$this->outjson($return);
	}



	function sync(){    
		$token = $this->Post['token'];
		$sid = $this->Post['uid'];
		$devid = $this->Post['devid'];
		$authcode = $this->Post['authcode'];
		$location = $this->Post['location']; //location 经纬度,使用,分割
		$geolocation = $this->Post['geolocation'];
        $clientid = trim($this->Post['clientid']);//客户端id
        $geolocation = changeCode($geolocation,'utf-8','gbk');
//        $time = date('Y-m-d H:m:s');

//        file_put_contents('index_sync.txt',var_export($time.":  ".$sid."-".$clientid."\n",true),FILE_APPEND);


        /* 更新设备id create by chen */
        if ($sid != 0 && $clientid > 0) {
            $res      = $this->Db->once_fetch_assoc("select * from app_user_getui_client where uid =" . $sid);
            if ($res['uid'] < 1) {
                $this->Db->query("insert into app_user_getui_client set uid='" . $sid . "',client_id='" . $clientid . "'");
            } elseif ($clientid != $res['clientid']) {
                $this->Db->query("update app_user_getui_client set client_id='" . $clientid . "' where uid=" . $sid);
            }
        }


		// 设备位置
		$this->DeviceLocation = $geolocation;
		$this->DeviceGeoLocation = $location;

		if(trim($devid) == ''){
			$return['status'] = 1;
			$return['message'] = '设备号不能为空';
		}
		else{
			if(MEMBER_ID>0){
				$uid = MEMBER_ID;
				$return['authcode'] = $authcode;
			}
			else{
				$uid = 0;
				$authcode = '';
			}
			$return['status'] = 0;
			list($dev,$tmp) = explode('|',$devid);
			if($dev != 'null'){
				$checkDev = md5($dev);
				$checkHave = $this->Db->once_fetch_assoc("select * from app_user_authcode where devmd5='".$checkDev."'");
				if($checkHave['devmd5']){
					$upDate = " set lastactive=".time().",devid='".$devid."'";
					if($token){
						$upDate .= ",token='".$token."'";
					}
					if($location){
						$upDate .= ",location='".$location."'";
					}
					if($geolocation){
						$upDate .= ",geolocation='".$geolocation."'";
					}
					if($location){
						$upDate .= ",authcode='".$authcode."'";
					}
					if($uid){
						$upDate .= ",uid='".$uid."'";

					}
					$this->Db->query("update app_user_authcode ".$upDate." where devmd5='".$checkHave['devmd5']."'");
				}
				else{
					$this->Db->query("replace into app_user_authcode(uid,authcode,devid,os,token,ispush,location,devmd5,geolocation,dev) values('".$uid."','".$authcode."','".$devid."','','".$token."','','".$location."','".$checkDev."','".$geolocation."','".$dev."')");
				}
			}
		}
        if($sid){
			$countnum = $this->Db->once_fetch_assoc("select count(*) as counts from app_unread_msg_record where  sid=".$sid);
			$return['countnum'] = $countnum['counts'] ? $countnum['counts'] : 0;
		}else{
			$return['countnum'] = 0;
		}

        $return['takeaway_url'] = "https://harkhark.com.au/takeaway/mobile.html";
        $return['timeSplash'] = 300;
		$this->outjson($return);        

	}

    /**
     * advertise add click api interface
     * @param ad_id
     * advertise id
     * create by chen
     * create at 2017-11-1
     */
    function addClick()
    {
        $ad_id = intval($this->Post['ad_id']);
		if ($ad_id < 0) {
			$return['status']  = 1;
			$return['message'] = '广告id不存在！';
		} else {
			$result = postData('http://ad.yeeyi.com/api/add_click', array('ad_id'=>$ad_id));
//			$result = postData('http://116.62.51.6:8005/api/add_click', array('ad_id'=>$ad_id));
			$data   = json_decode($result,true);
			if ($data['status'] == 0){
				$return['status']  = 0;
				$return['message'] = 'add click success!';
			}else{
				$return['status']  = 1;
				$return['message'] = $data['message'];
			}
		}
        $this->outjson($return);
    }

    /**
     * advertise add show api interface
     * @param ad_id
     * advertise id
     * create by chen
     * create at 2017-11-1
     */
    function addShow()
    {
        $ad_id = intval($this->Post['ad_id']);
		if ($ad_id < 0) {
			$return['status']  = 1;
			$return['message'] = '广告id不存在！';
		} else {
			$result = postData('http://ad.yeeyi.com/api/add_show', array('ad_id'=>$ad_id));
//			$result = postData('http://116.62.51.6:8005/api/add_show', array('ad_id'=>$ad_id));
			$data   = json_decode($result,true);
			if ($data['status'] == 0){
				$return['status']  = 0;
				$return['message'] = 'add click success!';
			}else{
				$return['status']  = 1;
				$return['message'] = $data['message'];
			}
		}
        $this->outjson($return);
    }

	/**
	 * 广告后台调用更新曝光量和点击量的接口
	 */
	function advertisePost(){
		echo 123;
	}
}
