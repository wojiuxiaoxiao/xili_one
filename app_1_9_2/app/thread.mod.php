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
		}elseif($this->Act == 'favoriteTopic'){
			$this->favoriteTopic();
		}elseif($this->Act == 'delFavoriteTopic'){
			$this->delFavoriteTopic();
		}elseif($this->Act == 'myFavorite'){
			$this->myFavorite();
		}

	}
	function index(){
		die('Error');
	}

	//版块收藏 copy from wap api
	function favoriteTopic(){
   	$uid=intval(MEMBER_ID);
   	$fid=intval($this->Post['id']);
   	$fidarr=$this->Post['name'];
	  // print_r($fidarr);
	   if($uid>0){
   		if($fid>0){
   			$sql="select * from pre_home_favorite where idtype='fid' and uid=".$uid." and id=".$fid;
   			$favid=$this->Db->once_fetch_assoc($sql);
   			if(!empty($favid)){
   			$state=1;
			$mess="您已关注";
   			}else{
   			$fidarr = changeCode($fidarr,'utf-8','gbk');
   			$favarr=array('uid'=>$uid,'id'=>$fid,'idtype'=>'fid','title'=>$fidarr,'dateline'=>time());
           $favres=$this->Db->insertArr($favarr,'pre_home_favorite');
		if($favres){
			$state=0;
			$mess="";
		}else{
			$state=1;
			$mess="关注失败";
		}
	}
		$return = array(
         "status"  =>$state,
         "message"=>$mess
        );
   		}else{
   		$return = array(
         "status"  =>1,
         "message"=>"参数错误"
        );
   	}
   	}else{
   		$return = array(
         "status"  =>1,
         "message"=>"您没有登录，不能关注"
        );
   	}
	$this->outjson($return);
   	}
	   //取消收藏
	function delFavoriteTopic(){
		$uid=intval(MEMBER_ID);
   	$fid=intval($this->Post['id']);
   	if($uid>0){
   		if($fid>0){
   			$sql="delete from pre_home_favorite where idtype='fid' and uid=".$uid." and id=".$fid;
   			$del=$this->Db->query($sql);
   			if($del){
   			$state=0;
			$mess="";
   			}else{
   			$state=1;
			$mess="取消关注失败";
	}
		$return = array(
         "status"  =>$state,
         "message"=>$mess
        );
   		}else{
   		$return = array(
         "status"  =>1,
         "message"=>"参数错误"
        );
   	}
   	}else{
   		$return = array(
         "status"  =>1,
         "message"=>"参数错误"
        );
   	}
	$this->outjson($return);
	}
//个人收藏
	function myFavorite(){
		$uid=intval(MEMBER_ID);
		if($uid>0){
			/* 2017.05.19 edit by allen qu 添加了602,15,240,268 */
			$sqlfavorite="select id,title, description from pre_home_favorite where  idtype='fid' and id in(92,646,212,606,732,313,36,318,294,269,93,309,277,310,619,319,234,602,15,240,268) and uid=".$uid;
		$favoritefid=$this->Db->fetch_all_assoc($sqlfavorite);
		/* edit by allen qu 2017.04.12  为配合app,修改id,title的命名 */
		/* description从config获取 */
		$topicList = $this->Config['topic_list'];

		foreach($favoritefid as $k=>$v)
		{
			$favoritefid[$k]['fid']         = intval($v['id']);
			$favoritefid[$k]['forum_name']  = changeCode($v['title'], 'gbk', 'utf-8');
			$favoritefid[$k]['description'] = $topicList[$favoritefid[$k]['fid']]['description'];
			$favoritefid[$k]['mustPic'] = $topicList[$favoritefid[$k]['fid']]['mustPic'];
			//$favoritefid[$k]['isPhone'] = $topicList[$favoritefid[$k]['fid']]['isPhone'];
			$favoritefid[$k]['isPhone'] = 0;//edit by neek li
			$favoritefid[$k]['allowGuest'] = $topicList[$favoritefid[$k]['fid']]['allowGuest'];
			$favoritefid[$k]['views'] = $topicList[$favoritefid[$k]['fid']]['views'];
		}


		//$favoritefid = changeCode($favoritefid,'gbk','utf-8');
		$return['status'] = 0;
		$return['content'] = $favoritefid;

		}else{
			$return['status'] = 1;
			$return['message'] = '未登录';
			$return['content'] = '未登录';
		}
		$this->outjson($return);
	}

	function favoriteThread(){
        if(MEMBER_ID<1){
            $return['status'] = 1;
			$return['message'] = '未登录';
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
        $return['status'] = 0;
        if($threadInfo['tid']<1){
            $return['status'] = 5210;
        }

		$this->outjson($return);
	}

	function removeFavorite(){
		if(MEMBER_ID<1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}
		$tid = intval($this->Post['tid']);
		$cid = intval($this->Post['cid']);
		$this->Db->query("delete from pre_home_favorite where idtype='tid' and uid='".MEMBER_ID."' and id=".$tid);
		$this->Db->query("delete from pre_home_favorite where idtype='cid' and uid='".MEMBER_ID."' and id=".$cid);
		$return['status'] = 0;
		$this->outjson($return);
	}

    /*
     * edit by neek
     * 顶帖
     */
	function refreshThread(){

		$uid=intval(MEMBER_ID);
		$tid=intval($this->Post['tid']);
		$salt = rand(10000,99999);
		$ip = client_ip();
		$key = md5($uid.'_'.$tid.'_'.$salt."_e2api@");

		$url = "http://pubapi.yeeyi.news/index.php?act=refresh&uid=$uid&tid=$tid&salt=$salt&from=app&key=$key&ip=$ip";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		$output = json_decode($output, true);

		switch ($output['status'])
		{
			case 2000:
				$output['status'] = 0;
				$output['message']='顶帖成功！今天剩余顶帖次数为'.$output['times'].'次';
            break;
			case 4010:
				$output['status'] = 1;
				$output['message']='今天的顶帖次数用完，请明天再来';
			break;
			case 4005:
				$output['status'] = 1;
				$output['message']='非帖子作者';
			break;
			case 4004:
				$output['status'] = 1;
				$output['message']='帖子非正常帖子';
			break;
			case 4003:
				$output['status'] = 1;
				$output['message']='用户非正常用户';
			break;
			case 4001:
				$output['status'] = 1;
				$output['message']='验证错误';
			break;
			case 4000:
				$output['status'] = 1;
				$output['message']='参数错误';
			break;
		}
		$this->outjson($output);
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
		$version  = 'v_10_19_11_14';
		$vPost = $this->Post['version'];
		if($vPost == $version){
			$return = array();
			$return['status'] = 1;
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
						//$inputParam[$k][$kk][$kkk]['api'] = $this->getCarModel();
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
						//$filterParam[$k][$kk][$kkk]['api'] = $this->getCarModel();
					}
					/*if($vvv['name'] == 'suburb'){
						$filterParam[$k][$kk][$kkk] = $this->getFilterCity();
					}
					*/
				}
			}

		}

		$forumAry = array();
		$forumAry['section_1'] = $this->getForumInfo($this->Config['life']);  //生活
		$forumAry['section_2'] = $this->getForumInfo($this->Config['work']);  //学习工作
		$forumAry['section_3'] = $this->getForumInfo($this->Config['entertainment']);  //娱乐
		$forumAry['section_4'] = $this->getForumInfo($this->Config['feedback']);  //反馈


		//排序字段
		$return = array();
		$return['status'] = 0;
		$return['version'] = $version;
		$return['cityInput'] = $cityInput;
//		$return['cityFilter'] = $cityFilter;
		$return['forumList'] = $forumList;
		$return['topicForum'] = $forumAry;
		$return['inputParam'] = $inputParam;
		$return['carMake'] = $this->getCarModel();
		$return['filterParam'] = $filterParam;
		//删除禁言锁定举报
//		$return['delList'] = $this->Config['delList'];
//		$return['lockList'] = $this->Config['lockList'];
//		$return['denyList'] = $this->Config['denyList'];
		$return['reportList'] = $this->Config['reportList'];
		/* 2017.06.08 edit by allen qu  新添加新闻评论举报*/
		$return['articleReportList'] = $this->Config['articleReportList'];
		$return['hello'] = 'ceshi';
		//$return = changeCode($return);
		$this->outjson($return);
	}

	function getCarModel(){
		$returnAry = array();
		//$returnAry['value'] = array();
		//$returnAry['child'] = array();
		//$returnAry['child']['label'] = '车辆型号';
		//$returnAry['child']['name'] = 'model';
		//$returnAry['child']['value'] = array();
		//$hotCarmake = array('Alfa Romeo','Renault','Audi','BMW','Fiat','Ford','Great Wall','Holden','Honda','Hyundai','Infiniti','Jaguar','Jeep','Kia','Land Rover','Mazda','Mercedes-Benz','Mini','Mitsubishi','Nissan','Peugeot','Subaru','Suzuki','Toyota','Volkswagen','Volvo');
		$hotCarmake = array('Audi','BMW','Ford','Holden','Lexus','Mazda','Mercedes-Benz','Nissan','Toyota','Volkswagen');
		$carMakeAry = $this->Db->fetch_all_assoc("select make from professional_car_model group by make");

		foreach($carMakeAry as $carmake){
			//$tmpAry = $carmake1;
			$returnAry['carMakeList'][]=$carmake['make'];
		}
		foreach($hotCarmake as $carmake){
			//$tmpAry = $carmake;
			//array_unshift($carMakeAry, $tmpAry); //插入数组到最前面
			$returnAry['hotCarmake'][]=$carmake;
		}



		foreach($carMakeAry as $make){
			$tmp = array();
			//$returnAry['value'][] = array($make['make'],$make['make']);
			$modelAry = $this->Db->fetch_all_assoc("select model from  professional_car_model where make='".$make['make']."'");
			foreach($modelAry as $model){
				if(strstr($model['model'],'(')){
					continue;
				}
				$tmp[] = $model['model'];
			}
			//$returnAry['child']['value'][] = $tmp;
			$tmp=array_unique($tmp);
			$returnAry['carModelList'][$make['make']] = $tmp;//修改
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
        $stime = microtime(true);
        $return = array();

        $return['time']['start'] = $this->get_time();
        $fid = intval($this->Post['fid']);
		$typeid = intval($this->Post['typeid']);
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		$keyword = trim($this->Post['search']);
        load::logic("ThreadList");

        $return['time']['load ThreadList'] = $this->get_time() - $stime;

        $listObj = new ThreadList($fid,$typeid);
		if($keyword){
			$threadlist = $listObj->getList_search($start,$amount);
		}
		else{
			$threadlist = $listObj->getList($start,$amount);
		}
		$threadlist = changeCode($threadlist);
        $return['time']['load thread infomation'] = $this->get_time() - $stime;

		/* add thread list advertise */
		$cityCode = intval($this->Post['cityFilter']);
		if($start == 0){
            $res_num = count($threadlist);
            $city    = $this->getCity($cityCode);
            $block   = $this->getBlock($fid);
            $return['time']['get advertise param'] = $this->get_time() - $stime;
            $thread_ad = get_ad('topic',['city'=>$city,'block'=>$block]);
            $return['time']['get advertise infomation'] = $this->get_time() - $stime;
            if ($thread_ad['status'] == 1){
                $advertises = $thread_ad['data'];
                $i = 0;
                if ($advertises['topic_5'] && $res_num >= 5){
                    $arr[] = $advertises['topic_5'];
					add_show($advertises['topic_5']['ad_id']);
                    array_splice($threadlist, $i+5, 0, $arr);
                    $i++;
                    unset($arr);
                }
                if ($advertises['topic_10'] && $res_num >= 10){
                    $arr[] = $advertises['topic_10'];
					add_show($advertises['topic_10']['ad_id']);
                    array_splice($threadlist, $i+10, 0, $arr);
                    $i++;
                    unset($arr);
                }
                if ($advertises['topic_15'] && $res_num >= 15){
                    $arr[] = $advertises['topic_15'];
					add_show($advertises['topic_15']['ad_id']);
                    array_splice($threadlist, $i+15, 0, $arr);
                    $i++;
                    unset($arr);
                }
            }
        }
		/* end thread advertise add */
        $return['time']['load advertise'] = $this->get_time() - $stime;
        $return['test'] = 'test infomation';


		//处理下面的问题

		$return['status'] = 0;
		$return['threadlist'] = $threadlist;
		$this->outjson($return);
	}

	//帖子内容

	function getThreadContent(){
		//ini_set("display_errors","on");
		$tid = intval($this->Post['tid']);
		$threadInfoTmp = $this->Db->once_fetch_assoc(
			"select t.lastpost,
			t.fid,
			t.tid,
			t.`subject`,
			t.author,
			t.authorid,
			t.closed,
			t.dateline,
			t.views,
			t.status,
			t.replies,
			t.attachment,
			p.message,
			p.anonymous,
			p.pid,
			pv.phone as author_phone
			from `pre_forum_thread` t
			left join `pre_forum_post` p
			on t.tid=p.tid
			left join pre_phone_verify as pv
			on pv.uid = t.authorid
			where t.tid=".$tid."
			and p.`first`=1
			and t.`displayorder`>=0");
		//$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid from `pre_forum_thread` t left join `pre_forum_post` p on t.tid=p.tid where t.tid=".$tid." and p.`first`=1");
		if($threadInfoTmp['tid']<1){
			$return['status'] = 0;
			$return['msg'] = "内容不存在或已被删除";
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
		$section_2['lastpost'] = $threadInfoTmp['lastpost'];
		$section_2['subject'] = $threadInfoTmp['subject'];
		$section_2['author'] = $threadInfoTmp['author'];
		$section_2['authorid'] = $threadInfoTmp['authorid'];
		$section_2['tel'] = $threadInfoTmp['author_phone'];
		$section_2['dateline'] = $threadInfoTmp['dateline'];
		$section_2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$threadInfoTmp['authorid']."&size=middle";
		$section_2['views'] = $threadInfoTmp['views'];

		/*  2017.06.14 edit by allen qu  实际查询 pre_forum_post表中数据  */
		$replyCount = $this->Db->once_fetch_assoc("select count(*) as counts from pre_forum_post where first = 0 and invisible = 0 and tid=".$tid);
		$section_2['replies'] = $replyCount['counts'];
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

		else if($threadInfoTmp['fid'] == 604){ /* 2017.05.17 edit by allen qu 新添加方法*/
			$threadTmp = $viewthread->viewThread604($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}
		else if($threadInfoTmp['fid'] == 325){ /* 2017.05.17 edit by allen qu 新添加方法*/
			$threadTmp = $viewthread->viewThread325($tid);
			$threadTmp = changeCode($threadTmp,'utf-8','gbk');
		}

		$threadInfo['section_2'] = $section_2; //第二部分帖子基本信息,包含其他配置的信息
		if($threadTmp){

			$threadInfo['related_news'] = $threadTmp['related_news']? $threadTmp['related_news']: [];
			$threadInfo['related_thread'] = $threadTmp['related_thread']?$threadTmp['related_thread']:[];
			$threadInfo['section_3'] = $threadTmp['s3'];//配置信息
			$threadInfo['section_4']['message'] = $threadTmp['s4']['message'];
			$threadInfo['section_5'] = $threadTmp['s5'];

			$picAry = array();
			$tableid = getattachtableid($tid);
			$attTableName = "pre_forum_attachment_".$tableid;

			$attachAry = $this->Db->fetch_all_assoc("select attachment from $attTableName where tid=".$tid." order by aid asc limit 9");
			foreach($attachAry as $atta){
				$picAry[] = "http://www.yeeyi.com/bbs/data/attachment/forum/".$atta['attachment'];
			}


			if ($threadInfoTmp['fid'] == 161 ) {

				$threadInfo['section_6']['name'] = changeCode('公司图片','utf-8','gbk');
				$threadInfo['section_6']['pic'] = $picAry;
			}else {
				$threadInfo['section_1'] = $picAry;
			}

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
		/* 2017.05.15 edit by allen qu 匹配替换[url] */
		$content = getHref($content);
		//处理
		$content = preg_replace("/\[youtube\](.*)\[\/youtube\]/isU",'<iframe width="320" height="240" src="https://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>',$content);
		preg_match_all("/\[mp3\](.*)\[\/mp3\]/isU",$content,$newcon);
		foreach($newcon[1] as $mp3){
			$content = preg_replace("/\[mp3\](.*)\[\/mp3\]/isU","<p style='text-align:center;'><audio style='width:250px;' src='".$mp3."' controls></audio></p>",$content,1);
		}
		$content = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $content);
		/* 2017.05.12 edit by allen qu 修改了无法匹配到[attachimg] 的情况*/
		$content = preg_replace("/\[attachimg\]\d+\[\/attachimg\]/i", '', $content);
		$content = preg_replace("/\{\:\d+\:\}/isU", '', $content);
		$content = preg_replace("/\[.*\]/isU",'',$content);
		$threadInfo['section_4']['message'] = $content;

		$return['status'] = 0;
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
        # 添加阅读量
		$this->Db->query("update  pre_forum_thread set views = views+ 1 where tid ='".$tid."'");
		$this->outjson($return);
	}

	function getThreadModify(){
		$tid = intval($this->Post['tid']);
		$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid from `pre_forum_thread` t left join `pre_forum_post` p on t.tid=p.tid where t.tid=".$tid." and p.`first`=1 and t.`displayorder`>=0");
		if($threadInfoTmp['tid']<1){
			$return['status'] = 1;
			$return['message'] = '获取不到信息';
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
		else if($threadInfoTmp['fid'] == 325){ /* 2017.05.18 团购打折 */
			$threadTmp = $viewthread->getModify325($tid);
		}
		else if($threadInfoTmp['fid'] == 604){ /* 2017.05.18 宠物交易 */
			$threadTmp = $viewthread->getModify604($tid);
		}

		if(!$threadTmp){
			//旧帖子
			$return['status'] = 1;
			$return['message'] = '获取不到信息';
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
			/* edit by allen qu  2017.04.24 因匹配规则不支持linkman和tels两个字段, 这里做一下处理*/
			if ($k == 'linkman') {
				$threadInfo['poster'] = $v;
			}

			if ($k == 'tels') {
				$threadInfo['tel'] = $v;
			}

			if ($k == 'qqnum') {

				$threadInfo['qq'] = $v;
			}

			if ($k == 'emails') {

				$threadInfo['email'] = $v;
			}
		}
		$return['status'] = 0;
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
			$replySql = "
			select p.message, p.author, p.authorid, m.groupid, p.pid, p.dateline, l.location as address
			from pre_forum_post as p
			left join pre_forum_post_location as l
			on p.pid = l.pid
			left join pre_common_member as m
			on p.authorid = m.uid
			where p.tid=".$tid."
			and first=0
			and p.invisible>=0
			and p.pid<$start
			order by p.pid
			desc
			limit 0,$amount";
		}
		else{
			$replySql = "select p.message, p.author, p.authorid, m.groupid, p.pid, p.dateline, l.location as address
			from pre_forum_post as p
			left join pre_forum_post_location as l
			on p.pid = l.pid
			left join pre_common_member as m
			on p.authorid = m.uid
			where p.tid=".$tid."
			and first=0
			and p.invisible>=0
			order by p.pid
			desc
			limit 0,$amount";
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

			$addr = "";
			if (isset($replyTmp[$k]['address'])) {
				$addr = explode('|', $replyTmp[$k]['address']);
				array_pop($addr);
				$addr = implode(",", $addr);
			}


            /* 国外地址倒序 create by chen at 2017-7-28 */
            if (!$addr){
                $replyTmp[$k]['address'] = changeCode('火星网友','utf-8','gbk');
            }
            if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
                $add_arr = explode(',', $addr);
                if (count($add_arr)>2){
                    array_pop($add_arr);
                }
                $new_arr = array_reverse($add_arr);
                $replyTmp[$k]['address'] = implode(",", $new_arr);

            }else{
                $replyTmp[$k]['address'] = $addr;
            }


			$replyTmp[$k]['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['authorid']."&size=middle";
			$replyTmp[$k]['replies'] = 0;
			$replyTmp[$k]['likes'] = 0;

			$replyAry[$reply['pid']] = $replyTmp[$k];
			$replyAry[$reply['pid']]['upReply'] = array();

		}
		if(count($upPid)>0){
			$upInfoAry = $this->Db->fetch_all_assoc("
				select p.pid, p.message, p.author, m.groupid, p.authorid, p.dateline, l.location as address
				from pre_forum_post as p
				left join pre_forum_post_location as l
				on p.pid = l.pid
				left join pre_common_member as m
				on p.authorid = m.uid
				where p.pid in(".implode(',',$upPid).")
				");
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
				if (!isset($reply['address'])) {
					$reply['address'] = changeCode('火星网友','utf-8','gbk');
				}

				foreach($upPid as $k=>$v){
					if($v == $reply['pid']){
						$replyAry[$k]['upReply'] = $reply;
					}
				}
			}
		}
		$returnAry = array();
		/* edit by allen qu 加了是否是仅作者可见的判断 */
		$info = $this->Db->once_fetch_assoc("select status, authorid from `pre_forum_thread` where tid=".$tid." and displayorder >= 0");

		$status = array(2,10,34,42,290); //这些是仅作者可见的状态id

		foreach ($replyAry as $reply)
		{
			if(count($reply['upReply'])<1){
				unset($reply['upReply']);
			}

			/* 禁言人的评论不显示 */
			if ($reply['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$reply['message'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}

			if ($reply['upReply']['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$reply['upReply']['message'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}

			/* 仅作者可见 */
			if ( in_array($info['status'], $status)) {

				if ($info['authorid'] != MEMBER_ID) {  //不是作者本人

					if (count($reply['upReply']) >= 1) {

						//帖子的作者, 评论人, 回复人超级管理员可以看到评论的回复
						/* 2017.06.13 edit by allen qu 加入了管理员的判断 */
						if ($reply['authorid'] != MEMBER_ID || $info['authorid'] != MEMBER_ID || $reply['upReply']['authorid'] != MEMBER_ID || !in_array(MEMBER_GROUP, array(1, 2))) {

							$reply['upReply']['message'] = changeCode('评论内容仅作者可见','utf-8','gbk');
						}
					}

					/* 2017.06.13 edit by allen qu 加入了管理员的判断 */
					if ($reply['authorid'] != MEMBER_ID || !in_array(MEMBER_GROUP, array(1, 2))) { //如果当前登录时评论人本人或者管理员,可以看到自己的评论

						$reply['message'] = changeCode('评论内容仅作者可见','utf-8','gbk');
					}
				}
			}

			$returnAry[] = $reply;
		}

		$return['status'] = 0;
		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}

        /* edit by mosagx create at 2017-09-05 */
        $reply = changeCode($returnAry);
        foreach ($reply as &$item) {
            $str_data = $item['message'];
            if (strpos($str_data, '发自手机亿忆')) {
                $str             = "<p style=\"text-align: right\">发自手机亿忆</p>";
                $str             = changeCode($str, 'utf-8', 'gbk');
                $str             = changeCode($str);
                $str_res         = str_replace('发自手机亿忆', $str, $str_data);
                $item['message'] = $str_res;
            }
        }
		$return['replylist'] = $reply;
		$this->outjson($return);
	}

	//发表评论
	function doReply(){
		if(MEMBER_ID<1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}
		/* 2017.06.20 edit by allen qu 禁言不能发帖 */
		/*
		if (MEMBER_GROUP == 4) {

			$return['status'] = 10003;
			$return['message'] = '抱歉，您的账号已被禁止评论，请联系管理员解禁';
			$this->outjson($return);
		}
		*/

		$tid = intval($this->Post['tid']);
		$uid = intval($this->Post['uid']);
		$threadInfo = $this->Db->once_fetch_assoc("select * from pre_forum_thread where tid=".$tid);
		$uppid = intval($this->Post['uppid']);
		$fromuid = intval($this->Post['fromuid']);

		$location = trim($this->Post['location']);
		$location = changeCode($location,'utf-8','gbk');

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
			$attachAry = $this->Db->fetch_all_assoc("SELECT * FROM pre_forum_attachment_unused WHERE `aid` IN(".implode(',',$attAry).")");
			foreach($attachAry as $atta){
				$this->Db->query("REPLACE INTO ".$attTableName." SET `readperm`='' , `price`='0' , `tid`='".$tid."' , `pid`='".$pid."' , `uid`='".$this->G['uid']."' , `description`='' , `aid`='".$atta['aid']."' , `dateline`='".$atta['dateline']."' , `filename`='".$atta['filename']."' , `filesize`='".$atta['filesize']."' , `attachment`='".$atta['attachment']."' , `remote`='0' , `isimage`='1' , `width`='".$atta['width']."' , `thumb`='0'");
				$this->Db->query("UPDATE  pre_forum_attachment SET `tid`='".$tid."' , `pid`='".$pid."' , `tableid`='".$tableid."' WHERE `aid`='".$atta['aid']."'");
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

		/* edit by neek li 调用PC端postnew接口 */
		$res = postNew($tid,'reply',$ip,MEMBER_ID,$threadInfo['fid']);
		file_put_contents('fenleihuifu.txt',var_export($res,true));

		/* 2017.05.16 edit by allen qu  这里改为member_name */
		//$this->Db->query("INSERT INTO pre_forum_post SET `fid`='".$threadInfo['fid']."' , `tid`='".$tid."' , `first`='0' , `author`='".changeCode($this->G['username'], 'utf-8', 'gbk')."' , `authorid`='".$this->G['uid']."' , `subject`='' , `dateline`='".$time."' , `message`='".$message."' , `useip`='".$ip."' , `port`='63602' , `invisible`='0' , `anonymous`='0' , `usesig`='1' , `htmlon`='0' , `bbcodeoff`='".$bbcodeoff."' , `smileyoff`='-1' , `parseurloff`=0 , `attachment`='".$attNums."' , `status`='1024' , `pid`='".$pid."'");

		//$this->Db->query("UPDATE  pre_forum_forum SET `lastpost`='".$tid."	".$this->G['uid']."	".$time."	".changeCode($this->G['username'], 'utf-8', 'gbk')."' WHERE `fid`='".$threadInfo['fid']."'");
		//$this->Db->query("UPDATE pre_forum_forum SET posts=posts+'1', todayposts=todayposts+'1' WHERE `fid`='".$threadInfo['fid']."'");
		//$this->Db->query("UPDATE pre_forum_thread SET `lastposter`='".changeCode($this->G['username'], 'utf-8', 'gbk')."',`replies`=`replies`+'1',`lastpost`='".$time."' WHERE `tid`='".$tid."'");

		$this->Db->query("
			INSERT INTO pre_forum_post
			SET `fid`='".$threadInfo['fid']."' ,
					`tid`='".$tid."' ,
					`first`='0' ,
					`author`='".changeCode(MEMBER_NAME, 'utf-8', 'gbk')."' ,
					`authorid`='".$this->G['uid']."' ,
					`subject`='' ,
					`dateline`='".$time."' ,
					`message`='".$message."' ,
					`useip`='".$ip."' ,
					`port`='63602' ,
					`invisible`='0' ,
					`anonymous`='0' ,
					`usesig`='1' ,
					`htmlon`='0' ,
					`bbcodeoff`='".$bbcodeoff."' ,
					`smileyoff`='-1' ,
					`parseurloff`=0 ,
					`attachment`='".$attNums."' ,
					`status`='1024' ,
					`pid`='".$pid."'
			");

		if (isset($location)) {
			$this->Db->query("
				insert into pre_forum_post_location
				set pid=".$pid.", tid=".$tid.", location='".$location."'");
		}

		$this->Db->query("UPDATE  pre_forum_forum SET `lastpost`='".$tid."	".$this->G['uid']."	".$time."	".changeCode(MEMBER_NAME, 'utf-8', 'gbk')."' WHERE `fid`='".$threadInfo['fid']."'");
		$this->Db->query("UPDATE pre_forum_forum SET posts=posts+'1', todayposts=todayposts+'1' WHERE `fid`='".$threadInfo['fid']."'");
		$this->Db->query("UPDATE pre_forum_thread SET `lastposter`='".changeCode(MEMBER_NAME, 'utf-8', 'gbk')."',`replies`=`replies`+'1',`lastpost`='".$time."' WHERE `tid`='".$tid."'");
		/* edit end */

		$return['tid'] = $tid;
		$return['pid'] = $pid;
		$return['status'] = 0;

//        echo json_encode($return);

        /* 添加推送 create by chen */
        Load::functions('getui');
        $push['template']         = "transmission";
        $push['message']['title'] = "";
        $content['action']        = "my_message";
        $content['id']            = "3";
        $content['title']         = "收到一条新评论";
        $this->Db->query("INSERT INTO yeeyico_new.app_unread_msg_record values('','{$fromuid}','{$this->G['uid']}','3')");
        $up            = $this->Db->once_fetch_assoc("select * from app_user_getui_client where uid=".$fromuid);
        if ($this->G['uid'] != $fromuid) {
            if ($up['uid'] > 0 && $up['client_id'] != "") {
                $push['cid']                = $up['client_id'];
                $push['message']['content'] = json_encode($content);
                $push['message']['body']    = "收到一条新评论";
                pushMessageToSingle($push);
            }
        }
        //----------------------------------------------------

        $this->outjsonpush($return);
	}


	//发布帖子
	function doPostThread(){
		if(MEMBER_ID<1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}
		$subject = trim($this->Post['subject']);
		if(strlen($subject)<1){
			$return['status'] = 5404;
			$this->outjson($return);
		}

		/* 2017.06.13 edit by allen qu 禁言不能发帖 */
		if (MEMBER_GROUP == 4) {

			$return['status'] = 10003;
			$return['message'] = '抱歉，您的账号已被禁止发帖，请联系管理员解禁';
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
			case 325:$return = $postObj->post325();break; /* 2017.05.17 edit by allen qu 添加了团购打折 */
			case 604:$return = $postObj->post604();break; /* 2017.05.17 edit by allen qu 添加了宠物之家 */
			default:$return['status']=5400;break;
		}
		$return['status'] = 0;
		$this->outjson($return);
	}
	//修改帖子
	function doModifyThread(){
		if(MEMBER_ID<1){
			$return['status'] = 1;
			$return['message'] = '未登录';
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
		else if($threadInfoTmp['fid'] == 325){ /* 2017.05.17 edit by allen qu  添加325*/
			$upThread = $postthread->update325();
		}
		else if($threadInfoTmp['fid'] == 604){/* 2017.05.17 edit by allen qu  添加604*/
			$upThread = $postthread->update604();
		}
		else{
			$upThread['status'] = 4521;
		}
		if($upThread['status']!=4521){
			$upThread['status'] = 0;
		}
		$this->outjson($upThread);
	}
	//删除帖子
	function deleteThread(){
		$tid = intval($this->Post['tid']);
		$type = intval($this->Post['type']);  //1为分类, 2为论坛
		$time = time();
		$reason = "用户个人删除";

		/* 2017.05.31 edit by allen qu 这里加上了first=1的限制, 第一个发帖人才是作者 */
		$threadInfo = $this->Db->once_fetch_assoc("select tid,authorid from pre_forum_post where first = 1 and tid=".$tid);
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


		if ($type == 2) { /* 2017.06.15 edit by allen qu 论坛删帖才会扣YB */

			/* 2017.06.07 edit by allen qu 删除帖子, 扣除作者20YB */

			$authorInfo = $this->Db->once_fetch_assoc("select * from pre_common_member_count where uid=".$uid);

			if ($authorInfo['extcredits2'] > 20) {

				$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 - 20 where uid=".$uid);//扣除20YB

				//$return['yb_message'] = changeCode('删除成功, 金钱-20YB', 'utf-8', 'gbk');
				$return['message'] = '删除成功, 金钱-20YB';

			}else{

				if ($authorInfo['extcredits2'] > 0) {

					$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 - {$authorInfo['extcredits2']} where uid=".$uid);//扣除20YB
					//$return['yb_message'] = changeCode('删除成功, 金钱-20YB', 'utf-8', 'gbk');
					$return['message'] = '删除成功, 金钱-20YB';
				}
			}

			/* edit end */
		}


		$return['status'] = 0;
		$this->outjson($return);
	}
	//点赞
	function likeThread(){
		$url =  "/home/app/public/splash/tupian.jpg";
		load::logic("WaterMask");
		$obj = new WaterMask($url);         //实例化对象
		//var_dump($obj);die;
		$obj->pos = 6;                            //中右
		$obj->transparent = 45;                   //水印透明度
		//$obj->waterImg = "./public/splash/yylogo.png"; //水印图片
		$obj->waterImg = "/home/app/public/splash/yylogo.png"; //水印图片
		$obj->output();
		var_dump(2222);die;


		//var_dump(1111);die;
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
						$return['status'] = 0;
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

	private function getForumInfo($forumArray){
		$result = array();
		foreach($forumArray as &$forum){
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
			/**edit by neek li isPhone 改为0,论坛发现发帖取消验证**/
			$forum['isPhone'] = 0;
			$result[] = $forum;
		}
		return $result;
	}

	private function getCity($cityCode)
    {
        $cityData[1]  = '墨尔本';
        $cityData[2]  = '悉尼';
        $cityData[3]  = '黄金海岸';
        $cityData[4]  = '布里斯班';
        $cityData[5]  = '阿德莱德';
        $cityData[6]  = '堪培拉';
        $cityData[7]  = '珀斯';
        $cityData[8]  = '达尔文';
        $cityData[10] = '霍巴特';
        $cityData[12] = '卧龙岗';
        $cityData[13] = '中央海岸';
        $cityData[14] = '吉朗';
        $cityData[15] = '巴拉瑞特';
        return $cityData[$cityCode];
    }

    private function getBlock($fid)
    {
        $Blocks[142] = '房屋租赁';
        $Blocks[305] = '房屋交易';
        $Blocks[291] = '汽车出售';
        $Blocks[142] = '房屋租赁';
        $Blocks[161] = '招聘信息';
        $Blocks[89]  = '超级市场';
        $Blocks[304] = '二手市场';
        $Blocks[604] = '宠物交易';
        $Blocks[679] = '二手教材';
        $Blocks[716] = '生意买卖';
        $Blocks[325] = '团购打折';
        return $Blocks[$fid];
    }

    private function get_time()
    {
	    $time = explode(' ',microtime());
	    return $time[0]+$time[1];
    }

	/**
	 * @增加广告的曝光量
	 */
	function add_shownums($ad_id){
		$created_at = time();
		$this->Db->query("INSERT INTO yeeyico_new.adver_show values('','{$ad_id}','{$created_at}')");
	}
}
