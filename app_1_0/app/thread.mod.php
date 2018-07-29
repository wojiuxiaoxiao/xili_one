<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if($this->Act == 'uploadPic'){
			$this->uploadPic();
		}
		else if($this->Act == 'getHotTopic'){
			$this->getHotTopic();
		}
		else if($this->Act == 'getTopicInfo'){
			$this->getTopicInfo();
		}
		else if($this->Act == 'getForumConfig'){
			$this->getForumConfig();
		}
		else if($this->Act == 'getSuburb'){
			$this->getSuburb();
		}
		else if($this->Act == 'getThreadList'){
			$this->getThreadList();
		}
		else if($this->Act == 'getThreadContent'){
			$this->getThreadContent();
		}
		else if($this->Act == 'getThreadModify'){
			$this->getThreadModify();
		}
		else if($this->Act == 'getThreadReply'){
			$this->getThreadReply();
		}
		else if($this->Act == 'getAttachInfo'){
			$this->getAttachInfo();
		}
		else if($this->Act == 'doPostThread'){
			$this->doPostThread();
		}
		else if($this->Act == 'favoriteThread'){
			$this->favoriteThread();
		}
		else if($this->Act == 'likeThread'){
			$this->likeThread();
		}
		else if($this->Act == 'removeFavorite'){
			$this->removeFavorite();
		}
		else if($this->Act == 'doReply'){
			$this->doReply();
		}
		else if($this->Act == 'doModifyThread'){
			$this->doModifyThread();
		}
		else if($this->Act == 'deleteThread'){
			$this->deleteThread();
		}
		else if($this->Act == 'refreshThread'){
			$this->refreshThread();
		}

	}
	function index(){
		die('Error');
	}

	function favoriteThread(){
        if(MEMBER_ID<1){
            $return['status'] = 5100;
            $this->outjson($return);
        }
		$cid = intval($this->Post['cid']);
		$tid = intval($this->Post['tid']);
		if($tid>0){
			$threadInfo = $this->Db->once_fetch_assoc("select * from pre_forum_thread where tid=".$tid);
			if($threadInfo['tid']>0){
				$this->Db->query("insert into pre_home_favorite(uid,id,idtype,title,dateline,description) values('".MEMBER_ID."','".$tid."','tid','".addslashes($threadInfo['subject'])."','".time()."','')");
			}
		}
		if($cid>0){
			$threadInfo = $this->Db->once_fetch_assoc("select * from pre_forum_thread where tid=".$cid);
			if($threadInfo['tid']>0){
				$this->Db->query("insert into pre_home_favorite(uid,id,idtype,title,dateline,description) values('".MEMBER_ID."','".$cid."','cid','".addslashes($threadInfo['subject'])."','".time()."','')");
			}
		}
        $return['status'] = 2210;
        if($threadInfo['tid']<1){
            $return['status'] = 5210;
        }

		$this->outjson($return);
	}

	function removeFavorite(){
		if(MEMBER_ID<1){
			$return['status'] = 5100;
			$this->outjson($return);
		}
		$tid = intval($this->Post['tid']);
		$cid = intval($this->Post['cid']);
		$this->Db->query("delete from pre_home_favorite where idtype='tid' and uid='".MEMBER_ID."' and id=".$tid);
		$this->Db->query("delete from pre_home_favorite where idtype='cid' and uid='".MEMBER_ID."' and id=".$cid);
		$return['status'] = 2211;
		$this->outjson($return);
	}

	function refreshThread(){
		$return['status'] = 2701;
		$this->outjson($return);
		
		
		if(MEMBER_ID<1){
			$return['status'] = 5100;
			$this->outjson($return);
		}
		$tid = intval($this->Post['tid']);
		$lastFresh = getVar('refresh_thread_'.$tid);
		$nexttime = time() + mt_rand(8,30)*60;
		setVar('refresh_thread_'.$tid,$nexttime);
		if(time()<$lastFresh){
			$return['status'] = 5701;
			$this->outjson($return);
		}

		$threadInfo = $this->Db->once_fetch_assoc("select * from pre_forum_thread where tid=".$tid);
		if($threadInfo['authorid'] == MEMBER_ID){
			$this->Db->query("update pre_forum_thread set lastpost=".time()." where tid=".$tid);
			$return['status'] = 2701;
		}
		else{
			$return['status'] = 5701;
		}
		$this->outjson($return);
	}


	function getHotTopic(){
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		if($start>0){
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT * FROM `topic_list` where isHot>0 and topic_id<".$start." order by isHot desc limit 0,$amount");
		}
		else{
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT * FROM `topic_list` where isHot>0 order by isHot desc limit 0,$amount");
		}

		$topicList = array();
		foreach($topicListTmp as $topic){
			$tmp = array();
			$tmp['topic_id'] = $topic['topic_id'];
			$tmp['topic_pic'] = "http://www.yeeyi.com".$topic['hot_pic'];
			$tmp['topic_name'] = $topic['topic_name'];
			$tmp['counts'] = $topic['total_nums'];
			$topicList[] = $tmp;
		}
		$return['status'] = 2800;
		$return['topicList'] = changeCode($topicList);
		$this->outjson($return);

	}

	function getTopicInfo(){
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		$topic_id = intval($this->Post['topic_id']);
		$topicInfoTmp = $this->Db->once_fetch_assoc("select * from topic_list where topic_id=".$topic_id);
		$topicInfo = array();
		$topicInfo['topic_name'] = $topicInfoTmp['topic_name'];
		$topicInfo['topic_pic'] = "http://www.yeeyi.com".$topicInfoTmp['pic1'];
		$topicInfo['counts'] = $topicInfoTmp['total_nums'];


		if($start>0){
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT topic_content_list.cid,c_type,topic_id,c_title,c_imgstr,pre_forum_thread.tid,news_article.aid,news_article.froms,news_article.pubdate, pre_forum_thread.author,pre_forum_thread.authorid,pre_forum_thread.dateline,pre_forum_thread_pic.description,pre_forum_thread_pic.pic,pre_forum_thread.views,pre_forum_thread.replies FROM `topic_content_list` left join pre_forum_thread on topic_content_list.c_tid=pre_forum_thread.tid left join news_article on news_article.aid=topic_content_list.c_aid left join pre_forum_thread_pic on pre_forum_thread_pic.tid=pre_forum_thread.tid where topic_id=".$topic_id." and topic_content_list.cid<$start order by topic_content_list.cid desc limit 0,$amount");
		}
		else{
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT topic_content_list.cid,c_type,topic_id,c_title,c_imgstr,pre_forum_thread.tid,news_article.aid,news_article.froms,news_article.pubdate, pre_forum_thread.author,pre_forum_thread.authorid,pre_forum_thread.dateline,pre_forum_thread_pic.description,pre_forum_thread_pic.pic,pre_forum_thread.views,pre_forum_thread.replies FROM `topic_content_list` left join pre_forum_thread on topic_content_list.c_tid=pre_forum_thread.tid left join news_article on news_article.aid=topic_content_list.c_aid left join pre_forum_thread_pic on pre_forum_thread_pic.tid=pre_forum_thread.tid where topic_id=".$topic_id." order by topic_content_list.cid desc limit 0,$amount");
		}

		$topicContentList = array();
		foreach($topicListTmp as $topic){
			$tmp = array();
			if($topic['c_type'] == 1){
				//新闻
				$tmp['c_type'] = 1;
				$tmp['cid'] = $topic['cid'];
				$tmp['c_title'] = $topic['c_title'];
				$tmp['c_aid'] = $topic['aid'];
				$tmp['c_from'] = $topic['froms'];
				$tmp['c_dateline'] = $topic['pubdate'];
				if($topic['c_imgstr']){
					$tmp['c_imgstr'] = "http://".str_replace('"','',$topic['c_imgstr']);
				}
				else{
					$tmp['c_imgstr'] = '';
				}

			}
			else{
				//帖子
				$tmp['c_type'] = 2;
				$tmp['cid'] = $topic['cid'];
				$tmp['c_title'] = $topic['c_title'];
				$tmp['c_tid'] = $topic['tid'];
				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$topic['authorid']."&size=middle";
				$tmp['author'] = $topic['author'];
				$tmp['authorid'] = $topic['authorid'];
				$tmp['description'] = $topic['description'];
				$tmp['dateline'] = $topic['dateline'];
				$tmp['pic'] = unserialize($topic['pic']);
				$tmp['views'] = $topic['views'];
				$tmp['replies'] =$topic['replies'];

			}
			$topicContentList[] = $tmp;
		}
		$return['status'] = 2900;
		$return['topicInfo'] = changeCode($topicInfo);
		$return['topicContentList'] = changeCode($topicContentList);
		$this->outjson($return);

	}


	function getForumConfig(){
		$version  = 'v_10_25_16_49';
		$vPost = $this->Post['version'];
		if($vPost == $version){
			$return = array();
			$return['status'] = 1001;
			$return['version'] = $version;
			$this->outjson($return);
		}


		$cityInput = $this->Config['inPutCity'];
		$cityFilter = $this->Config['filterCity'];
		$forumList = $this->Config['forumList'];
		$inputParam = $this->Config['inputParam'];
		foreach($inputParam as $k=>$v){
			foreach($v as $kk=>$vv){
				foreach($vv as $kkk=>$vvv){
					if($vvv['type'] == 'api'){
						$inputParam[$k][$kk][$kkk]['api'] = $this->getCarModel();
					}
					/*if($vvv['name'] == 'suburb'){
						$inputParam[$k][$kk][$kkk] = $this->getInputCity();
					}
					*/
				}
			}

		}
		$filterParam = $this->Config['filterParam'];

		foreach($filterParam as $k=>$v){
			foreach($v as $kk=>$vv){
				foreach($vv as $kkk=>$vvv){
					if($vvv['type'] == 'api'){
						$filterParam[$k][$kk][$kkk]['api'] = $this->getCarModel();
					}
					/*if($vvv['name'] == 'suburb'){
						$filterParam[$k][$kk][$kkk] = $this->getFilterCity();
					}
					*/
				}
			}

		}

		//话题首页聚合
		//板块列表
		$forumHot = array();
		foreach($this->Config['hot_forum'] as $forum){
			if($forum['fid'] == 277){
				continue;
			}
			$threadsAry = $this->Db->once_fetch_assoc("select threads from pre_forum_forum where fid=".$forum['fid']);
			$forum['views'] = intval($threadsAry['threads']);
			$type = array();
			$typeStrAry = $this->Db->once_fetch_assoc("SELECT threadtypes FROM `pre_forum_forumfield` WHERE `fid` = ".$forum['fid']);
			$typeAryTmp = unserialize($typeStrAry['threadtypes']);
			if(is_array($typeAryTmp['types'])){
				foreach($typeAryTmp['types'] as $key=>$val){
					$type[] = array($key,$val);
				}
			}
			$forum['types'] = changeCode($type);
			$forumHot[] = $forum;
		}

		$forumOther = array();
		foreach($this->Config['other_forum'] as $forum){
			$threadsAry = $this->Db->once_fetch_assoc("select threads from pre_forum_forum where fid=".$forum['fid']);
			$forum['views'] = intval($threadsAry['threads']);
			$type = array();
			$typeStrAry = $this->Db->once_fetch_assoc("SELECT threadtypes  FROM `pre_forum_forumfield` WHERE `fid` = ".$forum['fid']);
			$typeAryTmp = unserialize($typeStrAry['threadtypes']);
			if(is_array($typeAryTmp['types'])){
				foreach($typeAryTmp['types'] as $key=>$val){
					$type[] = array($key,$val);
				}
			}
			$forum['types'] = changeCode($type);
			$forumOther[] = $forum;
		}


		$forumAry = array();
		$forumAry['section_1'] = $forumHot;
		$forumAry['section_2'] = $forumOther;



		//排序字段
		$return = array();
		$return['status'] = 1000;
		$return['version'] = $version;
		$return['cityInput'] = $cityInput;
		$return['cityFilter'] = $cityFilter;
		$return['forumList'] = $forumList;
		$return['topicForum'] = $forumAry;
		$return['inputParam'] = $inputParam;
		$return['filterParam'] = $filterParam;
		//删除禁言锁定举报
		$return['delList'] = $this->Config['delList'];
		$return['lockList'] = $this->Config['lockList'];
		$return['denyList'] = $this->Config['denyList'];
		$return['reportList'] = $this->Config['reportList'];
		//$return = changeCode($return);
		$this->outjson($return);
	}

	function getCarModel(){
		$returnAry = array();
		$returnAry['value'] = array();
		$returnAry['child'] = array();
		$returnAry['child']['label'] = '车辆型号';
		$returnAry['child']['name'] = 'model';
		$returnAry['child']['value'] = array();
		$hotCarmake = array('Alfa Romeo','Renault','Audi','BMW','Fiat','Ford','Great Wall','Holden','Honda','Hyundai','Infiniti','Jaguar','Jeep','Kia','Land Rover','Mazda','Mercedes-Benz','Mini','Mitsubishi','Nissan','Peugeot','Subaru','Suzuki','Toyota','Volkswagen','Volvo');
		$carMakeAry = $this->Db->fetch_all_assoc("select make from professional_car_model where make not in('Alfa Romeo','Renault','Audi','BMW','Fiat','Ford','Great Wall','Holden','Honda','Hyundai','Infiniti','Jaguar','Jeep','Kia','Land Rover','Mazda','Mercedes-Benz','Mini','Mitsubishi','Nissan','Peugeot','Subaru','Suzuki','Toyota','Volkswagen','Volvo') group by make");
		foreach($hotCarmake as $carmake){
			$tmpAry = array('make'=>$carmake);
			array_unshift($carMakeAry, $tmpAry); //插入数组到最前面

		}



		foreach($carMakeAry as $make){
			$tmp = array();
			$returnAry['value'][] = array($make['make'],$make['make']);
			$modelAry = $this->Db->fetch_all_assoc("select model from  professional_car_model where make='".$make['make']."'");
			foreach($modelAry as $model){
				if(strstr($model['model'],'(')){
					continue;
				}
				$tmp[] = array($model['model'],$model['model']);
			}
			$returnAry['child']['value'][] = $tmp;
		}
		return $returnAry;
	}

	function getInputCity(){
		/*$array = array(
			'name' => 'city',
			'label' => '地区',
			'type' => 'switcher',
			'switcher' => array(
				array('2','悉尼 NSW',array('name'=>'suburb','value'=>$this->getSuburb(2))),
				array('6','堪培拉 ACT',array('name'=>'suburb','value'=>$this->getSuburb(6))),
				array('1','墨尔本 VIC',array('name'=>'suburb','value'=>$this->getSuburb(1))),
				array('4','布里斯班 QLD',array('name'=>'suburb','value'=>$this->getSuburb(4))),
				array('3','黄金海岸 QLD',array('name'=>'suburb','value'=>$this->getSuburb(3))),
				array('5','阿德莱德 SA',array('name'=>'suburb','value'=>$this->getSuburb(5))),
				array('7','珀斯 WA',array('name'=>'suburb','value'=>$this->getSuburb(7))),
				array('8','达尔文 NT',array('name'=>'suburb','value'=>$this->getSuburb(8))),
				array('10','霍巴特 TAS',array('name'=>'suburb','value'=>$this->getSuburb(10))),
				array('11','其他',array('name'=>'suburb','value'=>array())),
			),
		);
		return $array;
		*/
	}
	function getFilterCity(){
		/*$array = array(
			'name' => 'cityFilter',
			'label' => '地区',
			'type' => 'switcher',
			'switcher' => array(
				array('2|6','悉尼&堪培拉 – NSW&ACT',array('name'=>'suburb','value'=>$this->getSuburb('2|6'))),
				array('1','墨尔本 – VIC',array('name'=>'suburb','value'=>$this->getSuburb(1))),
				array('4','布里斯班 – QLD',array('name'=>'suburb','value'=>$this->getSuburb(4))),
				array('5','阿德莱德 – SA',array('name'=>'suburb','value'=>$this->getSuburb(5))),
				array('11','其它- WA&NT&TAS',array('name'=>'suburb','value'=>$this->getSuburb(11))),
			),
		);
		return $array;
		*/
	}

	function getSuburb(){
		$return = array();
		$subAry = array();
		$cityAry = array(1,2,3,4,5,6,7,8,10,12,13,14,15);
		foreach($cityAry as $cityId){
			$cityName = 'city_'.$cityId;
			$cityDb = $this->Db->fetch_all_row("select suburb,suburb from api_city_suburb where city=".$cityId);
			$subAry[$cityName] = $cityDb;
		}
		$return['suburb'] = $subAry;
		$this->outjson($return);
	}


	//列表
	function getThreadList(){
		$fid = intval($this->Post['fid']);
		$typeid = intval($this->Post['typeid']);
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		$keyword = trim($this->Post['search']);
        load::logic("ThreadList");
        $listObj = new ThreadList($fid,$typeid);
		if($keyword){
			$threadlist = $listObj->getList_search($start,$amount);
		}
		else{
			$threadlist = $listObj->getList($start,$amount);
		}
		$threadlist = changeCode($threadlist);
		//处理下面的问题
		$return = array();
		$return['status'] = 2500;
		$return['threadlist'] = $threadlist;
		$this->outjson($return);
	}

	//帖子内容

	function getThreadContent(){
		//ini_set("display_errors","on");
		$tid = intval($this->Post['tid']);
		$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid from `pre_forum_thread` t left join `pre_forum_post` p on t.tid=p.tid where t.tid=".$tid." and p.`first`=1 and t.`displayorder`>=0");
		//$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid from `pre_forum_thread` t left join `pre_forum_post` p on t.tid=p.tid where t.tid=".$tid." and p.`first`=1");
		if($threadInfoTmp['tid']<1){
			$return['status'] = 4501;
			$this->outjson($return);
		}
		$threadInfo = array();
		$threadInfoTmp['mustPic'] = 0;
		//转换fid
		if(in_array($threadInfoTmp['fid'],array(653,635,634,633,660,291))){
			$threadInfoTmp['fid'] = 291;
			$threadInfoTmp['mustPic'] = 1;
		}

		if(in_array($threadInfoTmp['fid'],array(161,630,631,632))){
			$threadInfoTmp['fid'] = 161;
		}
		if(in_array($threadInfoTmp['fid'],array(142,622,623,624,625,626,627))){
			$threadInfoTmp['fid'] = 142;
			$threadInfoTmp['mustPic'] = 1;
		}

		if(in_array($threadInfoTmp['fid'],array(305,677))){
			$threadInfoTmp['fid'] = 305;
			$threadInfoTmp['mustPic'] = 1;
		}

		if(in_array($threadInfoTmp['fid'],array(304,641,642,643))){
			$threadInfoTmp['fid'] = 304;
		}

		if(in_array($threadInfoTmp['fid'],array(651,652,316,662))){
			$threadInfoTmp['fid'] = 651;
		}

		$threadInfo['section_1'] = array();//第一部分图片
		//第二部分帖子信息
		$section_2 = array();
		$section_2['fid'] = $threadInfoTmp['fid'];
		$section_2['tid'] = $threadInfoTmp['tid'];
		$section_2['pid'] = $threadInfoTmp['pid'];
		$section_2['subject'] = $threadInfoTmp['subject'];
		$section_2['author'] = $threadInfoTmp['author'];
		$section_2['authorid'] = $threadInfoTmp['authorid'];
		$section_2['dateline'] = $threadInfoTmp['dateline'];
		$section_2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$threadInfoTmp['authorid']."&size=middle";
		$section_2['views'] = $threadInfoTmp['views'];
		$section_2['replies'] = $threadInfoTmp['replies'];
		$section_2['likes'] = $threadInfoTmp['likes'];
		$section_2['url'] = "https://m.yeeyi.com";
		$section_2['mustPic'] = $threadInfoTmp['mustPic'];
		//发帖人心细
		$uid = intval($threadInfoTmp['authorid']);
		$sql = "select yeeyico_new.pre_common_member.uid,pre_common_member.regdate,pre_common_member.groupid,yeeyico_new.pre_common_member.username,yeeyico_new.pre_common_member.credits,yeeyico_new.pre_common_member.groupid,yeeyico_new.pre_phone_verify.status as istel,yeeyico_new.pre_phone_verify.phone as tel from yeeyico_new.pre_common_member left join yeeyico_new.pre_phone_verify on yeeyico_new.pre_phone_verify.uid=yeeyico_new.pre_common_member.uid where yeeyico_new.pre_common_member.uid=".$uid;
		$userInfo = $this->Db->once_fetch_assoc($sql);
		$otherInfo = $this->Db->once_fetch_assoc("select * from pre_common_member_count where uid=".$uid);
		$groupInfo = $this->Db->once_fetch_assoc("select * from yeeyico_new.pre_common_usergroup where groupid='".$userInfo['groupid']."'");

		$profile = array();
		$profile['group'] = $groupInfo['grouptitle'];
		$profile['regdate'] = date("Y-m-d G:i:s",$userInfo['regdate']);
		$profile['credits'] = $userInfo['credits'];
		$profile['money'] = $otherInfo['extcredits2']." YB";
		$profile['flower'] = $otherInfo['extcredits4']."";
		$section_2['userInfo'] = $profile;

		//判断收藏
		$checkFavorite = $this->Db->once_fetch_assoc("select * from pre_home_favorite where idtype='tid' and id=".$tid." and uid='".MEMBER_ID."'");
		if($checkFavorite['id']>0){
			$section_2['isFavourite'] = 1;
		}
		else{
			$section_2['isFavourite'] = 0;
		}
		//判断是否可编辑
		if($threadInfoTmp['authorid'] == MEMBER_ID){
			$section_2['allowModify'] = 1;
		}
		else{
			$section_2['allowModify'] = 0;
		}






		load::logic("ThreadView");
		$viewthread = new ThreadView();
		if(in_array($threadInfoTmp['fid'],array(653,635,634,633,660,291))){
			$threadTmp = $viewthread->viewThread291($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 715){
			$threadTmp = $viewthread->viewThread715($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 714){
			$threadTmp = $viewthread->viewThread714($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 161){
			$threadTmp = $viewthread->viewThread161($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 142){
			$threadTmp = $viewthread->viewThread142($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
			$houseParam = $threadTmp['houseParam'];
			unset($threadTmp['houseParam']);
			foreach($houseParam as $h_k=>$h_v){
				$section_2[$h_k] = $h_v;
			}
		}
		else if($threadInfoTmp['fid'] == 680){
			$threadTmp = $viewthread->viewThread680($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 305){
			$threadTmp = $viewthread->viewThread305($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
			$houseParam = $threadTmp['houseParam'];
			unset($threadTmp['houseParam']);
			unset($threadTmp['houseParam']);
			foreach($houseParam as $h_k=>$h_v){
				$section_2[$h_k] = $h_v;
			}

		}
		else if($threadInfoTmp['fid'] == 681){
			$threadTmp = $viewthread->viewThread681($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 304){
			$threadTmp = $viewthread->viewThread304($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 89){
			$threadTmp = $viewthread->viewThread89($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}else if($threadInfoTmp['fid'] == 716){
			$threadTmp = $viewthread->viewThread716($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 679){
			$threadTmp = $viewthread->viewThread679($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 651){
			$threadTmp = $viewthread->viewThread651($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}

		$threadInfo['section_2'] = $section_2; //第二部分帖子基本信息,包含其他配置的信息
		if($threadTmp){
			$threadInfo['section_3'] = $threadTmp['s3'];//配置信息
			$threadInfo['section_4']['message'] = $threadTmp['s4']['message'];
			$threadInfo['section_5'] = $threadTmp['s5'];

			//第一部分图片,按照顺序输出
			/*$tableid = getattachtableid($tid);
			$messageDetail = stripslashes($threadTmp['s4']['message']);
			$messageDetail = parsesmiles2($messageDetail);
			$threadInfo['section_4']['message'] = $messageDetail;
			preg_match_all("/\[attach.*\](.*)\[\/attach.*\]/isU",$messageDetail,$attAryTmp);
			$attAry = $attAryTmp[1];
			$attNums = count($attAry);
			if($attNums>0){
				$picAry = array();
				$picResult = $this->Db->query("select aid,attachment from pre_forum_attachment_".$tableid." WHERE `aid` IN(".implode(',',$attAry).")");
				while($picInfo = $this->Db->fetch_assoc($picResult)){
					$picAry[$picInfo['aid']] = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$picInfo['attachment'];
				}
				foreach($attAry as $attId){
					$threadInfo['section_1'][] = $picAry[$attId];
				}
			}
			*/
			$picAry = array();
			$tableid = getattachtableid($tid);
			$attTableName = "pre_forum_attachment_".$tableid;
			$attachAry = $this->Db->fetch_all_assoc("select attachment from $attTableName where tid=".$tid." order by aid asc limit 9");
			foreach($attachAry as $atta){
				$picAry[] = "http://www.yeeyi.com/bbs/data/attachment/forum/".$atta['attachment'];
			}
			$threadInfo['section_1'] = $picAry;
		}
		else{
			$message = stripslashes($threadInfoTmp['message']);
			$postmessage = $this->getImgAttachment($threadInfoTmp['pid'],$message);
			$postmessage = getImg($postmessage);
			$postmessage = parsesmiles2($postmessage);
			$postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
			$postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
			$postmessage = nl2br($postmessage);
			$postmessage = stripslashes($postmessage);
			$threadInfo['section_3'] = array();//配置信息
			$threadInfo['section_4']['message'] = $postmessage;
			$threadInfo['section_5'] = array();
		}
		$content = "<p>".$threadInfo['section_4']['message']."</p>";
		$content = getImg($content);
		//处理
		$content = preg_replace("/\[youtube\](.*)\[\/youtube\]/isU",'<iframe width="320" height="240" src="https://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>',$content);
		preg_match_all("/\[mp3\](.*)\[\/mp3\]/isU",$content,$newcon);
		foreach($newcon[1] as $mp3){
			$content = preg_replace("/\[mp3\](.*)\[\/mp3\]/isU","<p style='text-align:center;'><audio style='width:250px;' src='".$mp3."' controls></audio></p>",$content,1);
		}
		$content = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $content);
		$content = preg_replace("/\{\:\d+\:\}/isU", '', $content);
		$content = preg_replace("/\[.*\]/isU",'',$content);
		$threadInfo['section_4']['message'] = $content;
		$return['status'] = 2501;
        //话题
        $topic = array();
        $topicInfoTmp = $this->Db->once_fetch_assoc("select topic_list.* from topic_content_list left join topic_list on topic_list.topic_id=topic_content_list.topic_id where topic_content_list.c_aid=0");
        if($topicInfoTmp['aid']){
            $topic['topic_id'] = $topicInfoTmp['topic_id'];
            $topic['topic_name'] = $topicInfoTmp['topic_name'];
            $topic['topic_pic'] = array($topicInfoTmp['pic1'],$topicInfoTmp['pic2'],$topicInfoTmp['pic3']);
            $threadInfo['section_4']['topic'] = $topic;
        }
        
		$return['threadInfo'] = changeCode($threadInfo);
		$return['share'] = array(
			'thumbnail'=>$return['threadInfo']['section_1'][0],
			'title'=>$return['threadInfo']['section_2']['subject'],
			'summary'=>$return['threadInfo']['section_2']['subject'],
			'url'=>'https://m.yeeyi.com/mobile/view.php?tid='.$tid
		);
		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}
		$this->outjson($return);
	}

	function getThreadModify(){
		$tid = intval($this->Post['tid']);
		$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid from `pre_forum_thread` t left join `pre_forum_post` p on t.tid=p.tid where t.tid=".$tid." and p.`first`=1 and t.`displayorder`>=0");
		if($threadInfoTmp['tid']<1){
			$return['status'] = 4511;
			$this->outjson($return);
		}
		//第一部分图片
		$threadInfo = array();
		$threadInfo['pic'] = array();//第一部分图片
		//第二部分帖子信息
		$threadInfo['tid'] = $threadInfoTmp['tid'];
		$threadInfo['pid'] = $threadInfoTmp['pid'];
		$threadInfo['subject'] = $threadInfoTmp['subject'];
		load::logic("ThreadView");
		$viewthread = new ThreadView();
		if(in_array($threadInfoTmp['fid'],array(653,635,634,633,660,291))){
			$threadTmp = $viewthread->getModify291($tid);
		}
		else if($threadInfoTmp['fid'] == 715){
			$threadTmp = $viewthread->getModify715($tid);
		}
		else if($threadInfoTmp['fid'] == 714){
			$threadTmp = $viewthread->getModify714($tid);
		}
		else if($threadInfoTmp['fid'] == 161){
			$threadTmp = $viewthread->getModify161($tid);
		}
		else if($threadInfoTmp['fid'] == 142){
			$threadTmp = $viewthread->getModify142($tid);
		}
		else if($threadInfoTmp['fid'] == 680){
			$threadTmp = $viewthread->getModify680($tid);
		}
		else if($threadInfoTmp['fid'] == 305){
			$threadTmp = $viewthread->getModify305($tid);
		}
		else if($threadInfoTmp['fid'] == 681){
			$threadTmp = $viewthread->getModify681($tid);
		}
		else if($threadInfoTmp['fid'] == 304){
			$threadTmp = $viewthread->getModify304($tid);
		}
		else if($threadInfoTmp['fid'] == 89){
			$threadTmp = $viewthread->getModify89($tid);
		}
		else if($threadInfoTmp['fid'] == 716){
			$threadTmp = $viewthread->getModify716($tid);
		}
		else if($threadInfoTmp['fid'] == 679){
			$threadTmp = $viewthread->getModify679($tid);
		}
		else if($threadInfoTmp['fid'] == 651){
			$threadTmp = $viewthread->getModify651($tid);
		}

		if(!$threadTmp){
			//旧帖子
			$return['status'] = 4511;
			$this->outjson($return);
		}
		//处理图片
		$message = stripslashes($threadTmp['message']);
		$tableid = getattachtableid($tid);
		preg_match_all("/\[attach\](.*)\[\/attach\]/isU",$message,$attAryTmp);
		$attAry = $attAryTmp[1];
		$attNums = count($attAry);
		if($attNums>0){
			$picAry = array();
			$picResult = $this->Db->query("select aid,attachment from pre_forum_attachment_".$tableid." WHERE `aid` IN(".implode(',',$attAry).")");
			while($picInfo = $this->Db->fetch_assoc($picResult)){
				$picAry[$picInfo['aid']] = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$picInfo['attachment'];
			}
			foreach($attAry as $attId){
				$threadTmp['pic'][] =array('[attach]'.$attId.'[/attach]',$picAry[$attId]);
			}

		}
		//图片结束
		$threadTmp['message'] = preg_replace("/\[attach\].*\[\/attach\]/isU","",$threadTmp['message']);
		$threadTmp['message'] = preg_replace("/\{\:\d+\:\}/isU","",$threadTmp['message']);
		foreach($threadTmp as $k=>$v){
			$threadInfo[$k] = $v;
		}
		$return['status'] = 2511;
		$return['threadInfo'] = changeCode($threadInfo);
		$this->outjson($return);
	}


	function getImgAttachment($pid,$message){
		if(!empty($pid)){
			$query = $this->Db->query("select aid,tableid from `pre_forum_attachment` where pid=".$pid);
			while($img = $this->Db->fetch_assoc($query)){
				if($img['aid']){
					$ro = $this->Db->once_fetch_assoc("select attachment from pre_forum_attachment_".$img['tableid']." where aid=".$img['aid']);
					if($ro){
						$attachmentUrl = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$ro['attachment'];
						$imgStr = "<p style='text-align:center;width:100%;'><img style='width:98%' src='".$attachmentUrl."'></p>";
						$message = str_replace('[attach]'.$img['aid'].'[/attach]',$imgStr,$message);
						$message = str_replace('[attachimg]'.$img['aid'].'[/attachimg]',$imgStr,$message);
					}

				}

			}
		}
		return $message;
	}
	//获取跟帖
	function getThreadReply(){
		$tid = intval($this->Post['tid']);
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		if($start>0){
			$replySql = "select message,author,authorid,pid,dateline,tid from `pre_forum_post` where tid=".$tid." and first=0 and invisible>=0 and pid<$start order by pid desc limit 0,$amount";
		}
		else{
			$replySql = "select message,author,authorid,pid,dateline,tid from `pre_forum_post` where tid=".$tid." and first=0 and invisible>=0 order by pid desc limit 0,$amount";
		}

		$replyTmp = $this->Db->fetch_all_assoc($replySql);
		$replyAry = array();
		$upPid = array();
		$upPidInfo = array();
		foreach($replyTmp as $k=>$reply){
			$message = stripslashes($reply['message']);
			//获取上级的
			preg_match("/\[quote\].*pid=([0-9]+)&ptid.*\[\/quote\]/isU",$message,$uppidAry);
			if($uppidAry[1]>0){
				$upPid[$reply['pid']] = intval($uppidAry[1]);
			}
			$postmessage = $this->getImgAttachment($reply['pid'],$message);
			//$postmessage = parseQuote($postmessage); //获取上级评论的
			$postmessage = getImg($postmessage);
			$postmessage = parsesmiles2($postmessage);
			$postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
			//$postmessage = getMp3($postmessage); [mp3]音乐地址[/mp3]
			$postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
			$postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
			$postmessage = nl2br($postmessage);
			$postmessage = stripslashes($postmessage);
			$replyTmp[$k]['message'] = nl2br(trim(str_replace("<br />","\r\n",$postmessage)));
			$replyTmp[$k]['address'] = changeCode('火星网友','utf-8','gbk');
			$replyTmp[$k]['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['authorid']."&size=middle";
			$replyTmp[$k]['replies'] = 0;
			$replyTmp[$k]['likes'] = 0;
			$replyAry[$reply['pid']] = $replyTmp[$k];
			$replyAry[$reply['pid']]['upReply'] = array();
		}
		if(count($upPid)>0){
			$upInfoAry = $this->Db->fetch_all_assoc("select pid,message,author,authorid,dateline from pre_forum_post where pid in(".implode(',',$upPid).")");
			foreach($upInfoAry as $reply){
				$message = stripslashes($reply['message']);
				$postmessage = $this->getImgAttachment($reply['pid'],$message);
				//$postmessage = parseQuote($postmessage); //获取上级评论的
				$postmessage = getImg($postmessage);
				$postmessage = parsesmiles2($postmessage);
				$postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
				//$postmessage = getMp3($postmessage); [mp3]音乐地址[/mp3]
				$postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
				$postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
				$postmessage = nl2br($postmessage);
				$postmessage = stripslashes($postmessage);
				$reply['message'] = nl2br(trim(str_replace("<br />","\r\n",$postmessage)));

				foreach($upPid as $k=>$v){
					if($v == $reply['pid']){
						$replyAry[$k]['upReply'] = $reply;
					}
				}
			}
		}
		$returnAry = array();
		foreach($replyAry as $reply){
			if(count($reply['upReply'])<1){
				unset($reply['upReply']);
			}
			$returnAry[] = $reply;
		}
		$return['status'] = 2502;
		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}
		$return['replylist'] = changeCode($returnAry);
		$this->outjson($return);
	}

	//发表评论
	function doReply(){
		if(MEMBER_ID<1){
			$return['status'] = 5100;
			$this->outjson($return);
		}
		$tid = intval($this->Post['tid']);
		$threadInfo = $this->Db->once_fetch_assoc("select * from pre_forum_thread where tid=".$tid);
		$uppid = intval($this->Post['uppid']);
		//
		$sql = "INSERT INTO pre_forum_post_tableid SET `pid`=''";
		$result = $this->Db->query($sql);
		$pid = intval($this->Db->insert_id());
		$time = time();
		$message = $this->Post['message'];
		$message = strip_tags($message);

		$ip = client_ip();
		//判断附件数量
		preg_match_all("/\[attach\](.*)\[\/attach\]/isU",$message,$attAryTmp);
		$attAry = $attAryTmp[1];
		$attNums = count($attAry);
		if($attNums>0){
			//有附件的情况下
			$picAry = array();
			//判断tabid
			$tableid = getattachtableid($tid);
			$attTableName = "pre_forum_attachment_".$tableid;
			$attachAry = $this->Db->once_fetch_assoc("SELECT * FROM pre_forum_attachment_unused WHERE `aid` IN(".implode(',',$attAry).")");
			foreach($attachAry as $atta){
				$this->Db->query("REPLACE INTO ".$attTableName." SET `readperm`='' , `price`='0' , `tid`='".$tid."' , `pid`='".$pid."' , `uid`='".$this->G['uid']."' , `description`='' , `aid`='".$atta['aid']."' , `dateline`='".$atta['dateline']."' , `filename`='".$atta['filename']."' , `filesize`='".$atta['filesize']."' , `attachment`='".$atta['attachment']."' , `remote`='0' , `isimage`='1' , `width`='".$atta['width']."' , `thumb`='0'");
				$this->Db->query("UPDATE  pre_forum_attachment SET `tid`='".$tid."' , `pid`='".$tid."' , `tableid`='".$tableid."' WHERE `aid`='".$atta['aid']."'");
				$this->Db->query("DELETE FROM pre_forum_attachment_unused WHERE `aid`='".$atta['aid']."'");
				$picAry[] = "/home/yeeyico/bbs/data/attachment/forum/".$atta['attachment']."_thread.jpg";
			}
		}
		$message = changeCode($message,'utf-8','gbk');
		$bbcodeoff = -1;
		//添加评论
		if($uppid>0){
			//有上级评论
			$upReplyInfo = $this->Db->once_fetch_assoc("select * from pre_forum_post where pid=".$uppid);
			$upReplyInfo['message'] = preg_replace("/\[.*\]/isU",'',$upReplyInfo['message']);
			$labelStr = "发表于";
			$labelStr = changeCode($labelStr,'utf-8','gb2312');
			$upInfo = "[quote][size=2][url=forum.php?mod=redirect&goto=findpost&pid=".$uppid."&ptid=".$tid."][color=#999999]".$upReplyInfo['author']." ".$labelStr." ".date("Y-m-d G:i:s")."[/color][/url][/size]\r\n".trim(strip_tags($upReplyInfo['message']))."[/quote]\n\n";
			$message = $upInfo.$message;
			$bbcodeoff = 0;
			if($upReplyInfo['authorid']>0){
				pushThreadReply($upReplyInfo['authorid']);
			}
		}
		pushThreadReply($threadInfo['authorid']);


		$this->Db->query("INSERT INTO pre_forum_post SET `fid`='".$threadInfo['fid']."' , `tid`='".$tid."' , `first`='0' , `author`='".$this->G['username']."' , `authorid`='".$this->G['uid']."' , `subject`='' , `dateline`='".$time."' , `message`='".$message."' , `useip`='".$ip."' , `port`='63602' , `invisible`='0' , `anonymous`='0' , `usesig`='1' , `htmlon`='0' , `bbcodeoff`='".$bbcodeoff."' , `smileyoff`='-1' , `parseurloff`=0 , `attachment`='".$attNums."' , `status`='1024' , `pid`='".$pid."'");

		$this->Db->query("UPDATE  pre_forum_forum SET `lastpost`='".$tid."	".$this->G['uid']."	".$time."	".$this->G['username']."' WHERE `fid`='".$threadInfo['fid']."'");
		$this->Db->query("UPDATE pre_forum_forum SET posts=posts+'1', todayposts=todayposts+'1' WHERE `fid`='".$threadInfo['fid']."'");
		$this->Db->query("UPDATE pre_forum_thread SET `lastposter`='".$this->G['username']."',`replies`=`replies`+'1',`lastpost`='".$time."' WHERE `tid`='".$tid."'");

		$return['tid'] = $tid;
		$return['pid'] = $pid;
		$return['status'] = 2503;
		$this->outjson($return);
	}
	//发布帖子
	function doPostThread(){
		if(MEMBER_ID<1){
			$return['status'] = 5100;
			$this->outjson($return);
		}
		$subject = trim($this->Post['subject']);
		if(strlen($subject)<1){
			$return['status'] = 5404;
			$this->outjson($return);
		}

		$return = array();
		$fid = intval($this->Post['fid']);
		load::logic("ThreadPost");
		$postObj = new ThreadPost();
		switch($fid){
			case 291:$return = $postObj->post291();break;
			case 715:$return = $postObj->post715();break;
			case 714:$return = $postObj->post714();break;
			case 161:$return = $postObj->post161();break;
			case 142:$return = $postObj->post142();break;
			case 680:$return = $postObj->post680();break;
			case 305:$return = $postObj->post305();break;
			case 681:$return = $postObj->post681();break;
			case 304:$return = $postObj->post304();break;
			case 89:$return = $postObj->post89();break;
			case 716:$return = $postObj->post716();break;
			case 679:$return = $postObj->post679();break;
			case 651:$return = $postObj->post651();break;
			default:$return['status']=5400;break;
		}
		$this->outjson($return);
	}
	//修改帖子
	function doModifyThread(){
		if(MEMBER_ID<1){
			$return['status'] = 5100;
			$this->outjson($return);
		}
		$tid = intval($this->Post['tid']);
		$pid = intval($this->Post['pid']);
		$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid from `pre_forum_thread` t left join `pre_forum_post` p on t.tid=p.tid where t.tid=".$tid." and p.`first`=1 and t.`displayorder`>=0");
		if($threadInfoTmp['tid']<1){
			$return['status'] = 4521;
			$this->outjson($return);
		}
		//第二部分帖子信息
		$threadInfo['tid'] = $threadInfoTmp['tid'];
		load::logic("ThreadPost");
		$postthread = new ThreadPost();
		if(in_array($threadInfoTmp['fid'],array(653,635,634,633,660,291))){
			$upThread = $postthread->update291();
		}
		else if($threadInfoTmp['fid'] == 715){
			$upThread = $postthread->update715();
		}
		else if($threadInfoTmp['fid'] == 714){
			$upThread = $postthread->update714();
		}
		else if($threadInfoTmp['fid'] == 161){
			$upThread = $postthread->update161();
		}
		else if($threadInfoTmp['fid'] == 142){
			$upThread = $postthread->update142();
		}
		else if($threadInfoTmp['fid'] == 680){
			$upThread = $postthread->update680();
		}
		else if($threadInfoTmp['fid'] == 305){
			$upThread = $postthread->update305();
		}
		else if($threadInfoTmp['fid'] == 681){
			$upThread = $postthread->update681();
		}
		else if($threadInfoTmp['fid'] == 304){
			$upThread = $postthread->update304();
		}
		else if($threadInfoTmp['fid'] == 89){
			$upThread = $postthread->update89();
		}
		else if($threadInfoTmp['fid'] == 716){
			$upThread = $postthread->update716();
		}
		else if($threadInfoTmp['fid'] == 679){
			$upThread = $postthread->update679();
		}
		else if($threadInfoTmp['fid'] == 651){
			$upThread = $postthread->update651();
		}
		else{
			$upThread['status'] = 4521;
		}
		$this->outjson($upThread);
	}
	//删除帖子
	function deleteThread(){
		$tid = intval($this->Post['tid']);
		$time = time();
		$reason = "用户个人删除";

		$threadInfo = $this->Db->once_fetch_assoc("select tid,authorid from pre_forum_post where tid=".$tid);
		$uid = $threadInfo['authorid'];
		if(MEMBER_ID != $uid){
			$return['status'] = 4600;
			$this->outjson($return);
		}


		$this->Db->query("UPDATE  pre_forum_thread SET `displayorder`='-1' , `digest`='0' , `moderated`='1' WHERE `tid` IN('".$tid."')");
		$this->Db->query("UPDATE  pre_forum_post SET `invisible`='-1' WHERE `tid` IN('".$tid."')");
		$sql = "INSERT INTO pre_common_member_crime SET `uid`='".$uid."' , `operatorid`='".MEMBER_ID."' , `operator`='".MEMBER_NAME."' , `action`='1' , `reason`='".$reason." &nbsp; <a href=\"forum.php?mod=redirect&goto=findpost&pid=0&ptid=".$tid."\" target=\"_blank\" class=\"xi2\">查看详情</a>' , `dateline`='".$time."'";
		$sql = changeCode($sql,'utf-8','gbk');
		$this->Db->query($sql);

		$sql ="INSERT INTO pre_forum_threadmod SET `tid`='".$tid."' , `uid`='".MEMBER_ID."' , `username`='".MEMBER_NAME."' , `dateline`='".$time."' , `action`='DEL' , `expiration`='0' , `status`='1' , `reason`='".$reason."'";
		$sql = changeCode($sql,'utf-8','gbk');
		$this->Db->query($sql);


		$return['status'] = 2600;
		$this->outjson($return);
	}
	//点赞
	function likeThread(){
		$pid = intval($this->Post['pid']);
		$return['status'] = 2700;
		$return['likeNum'] = mt_rand(10,30);
		$this->outjson($return);
	}


	function postThread($fid,$subject,$message,$dateline,$typeid=0){
		$subject = stripslashes($subject);
		$subject = addslashes($subject);
		$messageNoSlashes = stripslashes($message);
		$message = addlslashes($messageNoSlashes);
		$ip = client_ip();
		//写入了
		$result = $this->Db->query("insert into `pre_forum_thread` (`fid`,`typeid`,`author`,`authorid`,`subject`,`attachment`,`dateline`,`lastpost`,`lastposter`,`views`,`status`) values ('".$fid."','".$typeid."','".$this->G['username']."','".$this->G['uid']."','".$subject."','','".$dateline."','".$dateline."','".$this->G['username']."',0,'32')");
		if($result == false){
			$return['status'] = 5400;
			$this->outjson($return);
		}
		$tid = $this->Db->insert_id();
		//监控发帖
		$this->Db->query("insert into a_thread_log(tid,uid,dateline,subject,ipaddress,agent) values('".$tid."','".$this->G['uid']."','".time()."','".$subject."','".$ip."','mobile_".addslashes($_SERVER['HTTP_USER_AGENT'])."')");
		if(in_array($this->G['usergroup'],array(8,9,10,11))){
			$this->Db->query("insert into `pre_new_user_check` values('','".$this->G['uid']."','thread','[web]{$subject}','{$dateline}','{$tid}')");
		}
		//帖子内容
		$this->Db->query("insert into pre_forum_post_tableid values ('')");
		$pid = $this->Db->insert_id();
		if($pid<1){
			$this->Db->query("delete from pre_forum_thread where tid=".$tid);
			$return['status'] = 5400;
			$this->outjson($return);
		}
		$postSql = "insert into pre_forum_post (`pid`,`fid`,`tid`,`first`,`subject`,`author`,`authorid`,`dateline`,`message`,`useip`,`usesig`,`attachment`,`smileyoff`) values ('{$pid}','".$fid."','".$tid."',1,'".$subject."','".$this->G['username']."','".$this->G['uid']."','".$dateline."','".$message."','".client_ip()."',1,'','-1')";
		$postResult = $this->Db->query($postSql);
		if($postResult == false){
			$this->Db->query("delete from pre_forum_thread where tid=".$tid);
			$return['status'] = 5400;
			$this->outjson($return);
		}
		$pid = $this->Db->insert_id();
		//更新板块
		$this->Db->query("update `pre_forum_forum` set `threads` = `threads` + 1,`posts` = `posts` + 1,`todayposts` = `todayposts` + 1,`lastpost` = '".$tid."\t".$subject."\t".$dateline."\t".$this->G['username']."' where `fid` = '".$fid."'");
		$this->Db->query("update pre_common_member_count set `posts` = `posts` + 1,`threads` = `threads` + 1 where `uid` = '".$this->G['uid']."'");
		//处理附件
		preg_match_all("/\[attach\](.*)\[\/attach\]/isU",$messageNoSlashes,$attAryTmp);
		$attAry = $attAryTmp[1];
		$attNums = count($attAry);
		if($attNums>0){
			//有附件的情况下
			$picAry = array();
			//判断tabid
			$tableid = getattachtableid($tid);
			$attTableName = "pre_forum_attachment_".$tableid;
			$attachAry = $this->Db->once_fetch_assoc("SELECT * FROM pre_forum_attachment_unused WHERE `aid` IN(".implode(',',$attAry).")");
			foreach($attachAry as $atta){
				$this->Db->query("REPLACE INTO ".$attTableName." SET `readperm`='' , `price`='0' , `tid`='".$tid."' , `pid`='".$pid."' , `uid`='".$this->G['uid']."' , `description`='' , `aid`='".$atta['aid']."' , `dateline`='".$atta['dateline']."' , `filename`='".$atta['filename']."' , `filesize`='".$atta['filesize']."' , `attachment`='".$atta['attachment']."' , `remote`='0' , `isimage`='1' , `width`='".$atta['width']."' , `thumb`='0'");
				$this->Db->query("UPDATE  pre_forum_attachment SET `tid`='".$tid."' , `pid`='".$pid."' , `tableid`='".$tableid."' WHERE `aid`='".$atta['aid']."'");
				$this->Db->query("DELETE FROM pre_forum_attachment_unused WHERE `aid`='".$atta['aid']."'");
				$picAry[] = "/home/yeeyico/bbs/data/attachment/forum/".$atta['attachment']."_thread.jpg";
			}
			//判断那些缩略图存在
			$picAryStatus = myFileExists($picAry);
			$picAry = array();
			foreach($picAryStatus as $k=>$picInfo){
				if($picInfo['exist']){
					$truePath = str_replace("/home/yeeyico/","http://www.yeeyi.com/",$picInfo['filepath']);
					$picAry[] = $truePath;
				}
			}
			if(count($picAry)>0){
				$picStr = serialize($picAry);
				$this->Db->query("replace into pre_forum_thread_pic set pic='".addslashes($picStr)."',tid=".$tid);
			}
			$this->Db->query("UPDATE  pre_forum_thread SET `attachment`='".$attNums."' WHERE `tid`='".$tid."'");
			$this->Db->query("UPDATE  pre_forum_post SET `attachment`='".$attNums."' WHERE `pid`='".$pid."'");
			$this->Db->query("UPDATE  pre_forum_post SET `attachment`='".$attNums."' WHERE `pid`='".$pid."'");
		}
		$return['status'] = 2400;
		$return['tid'] = $tid;
		$return['pid'] = $pid;
		$this->outjson($return);
	}

	function uploadPic(){
		//pic
		if($_FILES['pic']['name'] && $_FILES['pic']['error'] == 0 && $_FILES['pic']['size']>0){
			//curl传递
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,"http://www.yeeyi.com/apptools/index.php?act=uploadAtt");
			curl_setopt($ch, CURLOPT_POST, true);
			$post = array(
				"pic"=>"@".$_FILES['pic']['tmp_name'],
				"filetype"=>$_FILES['pic']['type'],
			);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			$response = curl_exec($ch);
			//curl传递结束

			$upAry = json_decode($response,true);
			if($upAry['status'] == 200){
				$url = $upAry['url'];
				$attachment = $upAry['attachement'];
				$filename = $upAry['filename'];
				$fileSize = $upAry['size'];
				$width = $upAry['width'];
				$thumUrl = $upAry['thumbUrl'];
				$result = $this->Db->query("INSERT INTO pre_forum_attachment SET `tid`='0' , `pid`='0' , `uid`='1' , `tableid`='127'");
				$attId = $this->Db->insert_id();
				if($attId>0){
					$result = $this->Db->query("INSERT INTO pre_forum_attachment_unused SET `aid`='".$attId."' , `dateline`='".time()."' , `filename`='".addslashes($filename)."' , `filesize`='".$fileSize."' , `attachment`='".$attachment."' , `isimage`='1' , `uid`='".$this->G['uid']."' , `thumb`='0' , `remote`='0' , `width`='".$width."'");
					if($result){
						$return['status'] = 2300;
						$return['attId'] = $attId;
						$return['index'] = intval($this->Post['index']);
						$return['url'] = $url;
						$return['thumbUrl'] = $thumUrl;
						$return['imgStr'] = '[attach]'.$attId.'[/attach]';
						$this->outjson($return);
					}
				}
			}

		}
		$return['status'] = 5300;
		$this->outjson($return);
	}

	function getAttachInfo(){
		$attId = intval($this->Post['attId']);
		$attInfo = $this->Db->once_fetch_assoc("select tableid from pre_forum_attachment where aid=".$attId);
		$tableId = $attInfo['tableid'];
		if($tableId == 127){
			$pathInfo = $this->Db->once_fetch_assoc("select attachment from pre_forum_attachment_unused where aid=".$attId);
			$url = $pathInfo['attachment'];
		}
		else if($tableId>=0 and $tableId<=9){
			$pathInfo = $this->Db->once_fetch_assoc("select attachment from pre_forum_attachment_".$tableId." where aid=".$attId);
			$url = $pathInfo['attachment'];
		}
		if($url){
			$return['status'] = 2301;
			$return['url'] = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$url;
			$truePath = "/home/yeeyico/bbs/data/attachment/forum/".$url;
			if(myFileExists($truePath."_thread.jpg")){
				$return['thumbUrl'] = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$url."_thread.jpg";
			}
			else{
				$return['thumbUrl'] = '';
			}
			$this->outjson($return);
		}
		else{
			$return['status'] = 5301;
			$this->outjson($return);
		}
	}
}