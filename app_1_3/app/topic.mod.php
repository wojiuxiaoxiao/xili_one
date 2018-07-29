<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if($this->Act == 'topicHome'){
			$this->topicHome();
		}
		else if($this->Act == 'hotTopic'){
			$this->hotTopic();
		}
		else if($this->Act == 'topicList'){
			$this->topicList();
		}
		else if($this->Act == 'topicNewList'){
			$this->topicNewList();
		}
		else if($this->Act == 'topicView'){
			$this->topicView();
		}
		else if($this->Act == 'postTopic'){
			$this->postTopic();
		}
		else if($this->Act == 'replyTopic'){
			$this->replyTopic();
		}
		else if($this->Act == 'getReply'){
			$this->getReply();
		}
		else if($this->Act == 'topicLike'){
			$this->topicLike();
		}
		else if($this->Act == 'topicSearch'){
			$this->topicSearch();
		}
		else if($this->Act == 'hotKeyWords'){
			$this->hotKeyWords();
		}
		else if($this->Act=='testReply'){
		    $this->testReply();
        }
		else if($this->Act=='postLike'){
			$this->postLike();
		}
	}
	function index(){
		die('Error');
	}


    /**
     * Replay interface for test
     * create by mosagx
     *
     */
	function testReply(){
        $tid        = 3881129;
        $pid = getattachtableid($tid);
        $return ['pid']          = $pid;

//        $message = changeCode($message,'utf-8','gbk');
        $this->outjson($return);
    }

	/**
	 * 对内容点赞
	 * @param $cid
	 */
	function topicLike(){
		$cid = intval($this->Post['cid']);
		$topic_id = intval($this->Post['topic_id']);
		$return['status'] = 2700;
		$return['likeNum'] = mt_rand(10,30);
		$this->outjson($return);
	}

	/**
	 * 热门搜索词汇
	 */
	function hotKeyWords(){
		$return = array();
		$keyword = array();
		$return['status'] = 2109;
        $return['hotkeyword'] = $keyword;
        $this->outjson($return);
	}

	/**
	 * 话题首页
	 * 显示最热门4个话题，然后是板块列表
	 */
	function topicHome(){
		//热门话题 ERIC 修改于20170130 加入priority排序
		$topicListTmp = $this->Db->fetch_all_assoc("SELECT topic_id,topic_name FROM `topic_list` where isHot>0 order by priority desc limit 4");
		//板块列表
		$forumHot = array();
		foreach($this->Config['hot_forum'] as $forum){
			$type = array();
			$typeStrAry = $this->Db->once_fetch_assoc("SELECT threadtypes  FROM `pre_forum_forumfield` WHERE `fid` = ".$forum['fid']);
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


		$forumList = array();
		$forumList['section_1'] = $forumHot;
		$forumList['section_2'] = $forumOther;


		//分类配置
		$typeAry = $this->Db->fetch_all_assoc("select * from topic_type order by type_id desc");
		$return = array();
		$return['homeHot'] = changeCode($topicListTmp);
		$return['forumList'] = $forumList;
		$return['typeConfig'] = changeCode($typeAry);
		$return['status'] = 2100;
		$this->outjson($return);
	}

	/**
	 * 热门话题
	 * @param $start
	 * @param $amount
     * @param $type_id
	 */
	function topicSearch(){
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		$keyword = trim($this->Post['keyword']);
		$keyword = changeCode($keyword,'utf-8','gbk');
		if($start>0){
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT * FROM `topic_list` where topic_name like '%".$keyword."%' and topic_id<".$start." order by topic_id desc limit 0,$amount");
		}
		else{
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT * FROM `topic_list` where topic_name like '%".$keyword."%' order by topic_id desc limit 0,$amount");
		}
		$topicList = array();
		foreach($topicListTmp as $topic){
			$tmp = array();
			$tmp['topic_id'] = $topic['topic_id'];
			$tmp['topic_pic'] = "http://www.yeeyi.com".$topic['hot_pic'];
			$tmp['topic_name'] = $topic['topic_name'];
			$tmp['counts'] = $topic['total_nums'];
			$tmp['createtime'] = $topic['isHot'];//创建时间需要添加
			$topicList[] = $tmp;
		}
		$return['status'] = 2108;
		$return['keyword'] = trim($this->Post['keyword']);
		$return['topicList'] = changeCode($topicList);
		$this->outjson($return);
	}


	/**
	 * 热门搜索
	 * @param $start
	 * @param $amount
	 */
	function hotTopic(){
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		$type_id = intval($this->Post['type_id']);
		//Eric 20170130 修改  加入priority排序
		if($start>0){
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT * FROM `topic_list` where isHot>0 and isHot<".$start." order by priority desc limit 0,$amount");
		}
		else{
			$topicListTmp = $this->Db->fetch_all_assoc("SELECT * FROM `topic_list` where isHot>0 order by priority desc limit 0,$amount");
		}
		$topicList = array();
		foreach($topicListTmp as $topic){
			$tmp = array();
			$tmp['topic_id'] = $topic['topic_id'];
			$tmp['topic_pic'] = "http://www.yeeyi.com".$topic['hot_pic'];
			$tmp['topic_name'] = $topic['topic_name'];
			$tmp['counts'] = $topic['total_nums'];
			$tmp['createtime'] = $topic['isHot'];//创建时间需要添加
			$topicList[] = $tmp;
		}
		$return['status'] = 2101;
		$return['topicList'] = changeCode($topicList);
		$this->outjson($return);
	}

	/**
	 * 论坛发现最新200条帖子
	 */
	function topicNewList(){
		$uid=intval($this->Post['uid']);

		$fidArr = $favoritefid = array();
		if($uid>0) {
			$sqlfavorite = "select id,title, description from pre_home_favorite where  idtype='fid' and id in(92,646,212,606,732,313,36,318,294,269,93,309,277,310,619,319,234,602,15,240,268) and uid=" . $uid;
			$favoritefid = $this->Db->fetch_all_assoc($sqlfavorite);
			if(!empty($favoritefid)){
				foreach($favoritefid as $fk=>$fvid){
					if($fvid['id']){
						$fidArr[] = $fvid['id'];//关注
					}
				}
			}
		}
		$fidguanzhu = array(15,36,92,277,318,319,619,646);//热门
		//$fidguanzhu = array(92);//热门
		$fidArr = array_unique(array_merge($fidguanzhu,$fidArr));
		foreach($fidArr as $fk=>$v){
			if($v==234)unset($fidArr[$fk]);
		}
		$fidArr = array_values($fidArr);

		$typeAryResult = $this->Db->query("select `typeid`,`name` from pre_forum_threadclass where fid in(".implode(',',$fidArr).")");
		$typeAry = array();
		while($row = $this->Db->fetch_assoc($typeAryResult)){
			$typeAry[$row['typeid']] = $row['name'];
		}

		$page = intval($this->Post['page']) ? intval($this->Post['page']) : 1;
		$amount = intval($this->Post['amount']);
		$start = $page > 1 ? ($page-1)*$amount : 0;
		//$halfhour = time()-1800;//半小时前 and pre_forum_thread.lastpost < $halfhour
		$topicArray = $this->Db->fetch_all_assoc("
						select pre_common_member.groupid,pre_forum_thread.tid,
						pre_forum_thread.views,
						pre_forum_thread.author,
						pre_forum_thread.fid,
						pre_forum_thread.subject,
						pre_forum_thread.author,
						pre_forum_thread.authorid,
						pre_forum_thread.dateline,
						pre_forum_thread.replies,
						'0' as likes,
						pre_forum_thread_pic.pic,
						pre_forum_thread_refresh.refresh,
						pre_forum_thread.typeid
						from pre_forum_thread
						left join pre_forum_thread_pic
						on pre_forum_thread.tid=pre_forum_thread_pic.tid
						left join pre_common_member
						on pre_forum_thread.authorid=pre_common_member.uid
						left join pre_forum_post as b
				        on pre_forum_thread.tid = b.tid
				        and b.first = 1
				        left join pre_forum_thread_refresh
                        on pre_forum_thread.tid = pre_forum_thread_refresh.tid
						where pre_forum_thread.displayorder>-1
						and pre_forum_thread.fid in(".implode(',',$fidArr).")
						and b.status != 1
						order by pre_forum_thread_refresh.refresh
						desc
						limit 150"
		);


		if(is_array($topicArray)){
			foreach($topicArray as $t){

				$groupInfo = $this->Db->once_fetch_assoc("select grouptitle from yeeyico_new.pre_common_usergroup where groupid='".$t['groupid']."'");
				$groupInfo = changeCode($groupInfo);
				$checkFavorite = $this->Db->once_fetch_assoc("select * from pre_home_favorite where idtype='cid' and id=".$t['tid']." and uid='".$uid."'");
				$postlast = $this->Db->once_fetch_assoc("select dateline from yeeyico_new.pre_forum_post where tid='".$t['tid']."'order by dateline desc limit 1");

				if(isset($typeAry[$t['typeid']]) && $typeAry[$t['typeid']]){
					$t['subject'] = '['.$typeAry[$t['typeid']].'] '.$t['subject'];
				}
				$tmp = array();
//				if(date('Y-m-d H:i:s',$postlast['dateline'])>date('Y-m-d H:i:s',$t['dateline'])){//回帖时间优先，发帖其次
//					$tmp['timesort'] = date('Y-m-d H:i:s',$postlast['dateline']);
//				}else{
//					$tmp['timesort'] = date('Y-m-d H:i:s',$t['dateline']);
//				}

				if(date('Y-m-d H:i:s',$postlast['dateline'])>date('Y-m-d H:i:s',$t['dateline'])){//回帖时间优先，发帖其次
					$tmp['timesort'] = date('Y-m-d H:i:s',$postlast['dateline']);
				}else{
					$tmp['timesort'] = date('Y-m-d H:i:s',$t['dateline']);
				}

//				$tmp['fatie'] = $t['dateline'] ? date('Y-m-d H:i:s',$t['dateline']) : '';
//				$tmp['huitie'] = $postlast['dateline'] ?  date('Y-m-d H:i:s',$postlast['dateline']) : '';
//				$tmp['ceshi'] = $postlast['dateline'];

				$tmp['id'] = $t['refresh'];
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
				$tmp['dateline'] = $t['refresh'];
				$tmp['replies'] = $t['replies'];
				$tmp['likes'] = $t['likes'];
				$tmp['pic'] = $this->getPicList($t['tid']);
				$tmp['fid'] = intval($t['fid']);
				$tmp['tname'] = changeCode($this->Config['topic_list'][$t['fid']]['forum_name'],'utf-8','gbk');//$from='gbk',$to='utf-8'

				$tmp['views'] = $t['views'];//阅读数
				$tmp['author'] = $t['author'];//用户名
				$tmp['group_name'] = changeCode($groupInfo['grouptitle'],'utf-8','gbk');//用户组
				$tmp['lastpost'] = $t['refresh'];//回复时间


				$tmp['share']= array(
					'thumbnail'=>$tmp['pic'][0],
					'title'=>$tmp['subject'],
					'summary'=>$tmp['subject'],
					'url'=>'https://m.yeeyi.com/mobile/view.php?tid='.$tmp['tid']
				);
				$tmp['isFavourite'] = $checkFavorite['id'] > 0 ? 1 : 0;;

				$listAry[] = $tmp;
			}

			foreach ( $listAry as $list_key => $list_val ){
				$num1[$list_key] = $list_val ['timesort'];
			}
			array_multisort($num1, SORT_DESC ,$listAry);
		}



		//分页适配
		$return['page_num'] = ceil(count($listAry)/$amount);
		$listAry = array_slice($listAry,$start,$amount);

		$return['status'] = 0;
		$return['listAry'] = changeCode($listAry);

		$this->outjson($return);
	}


	/**
	 * 对应话题的内容列表
	 * @param $topic_id <10为论坛,大于10为帖子
	 * @param $start
	 * @param $amount
	 *
	 */
	function topicList(){
		$topic_id = intval($this->Post['topic_id']);
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);

		$fid = intval($this->Post['fid']);
		$typeid = intval($this->Post['typeid']? $this->Post['typeid']: 0);

		$listAry = array();
		/* 2017.05.22 edit by arion 如果fid为92(同城生活) 返回 地区分类 */
		$typeAryTmp = array();
		array_push($typeAryTmp,  array('name' =>'全部', 'typeid'=>0 ));

		if($fid>0){
			$fidAry = array();
			if($fid == 723){
				$fidAry = array(28,721,722,723,724,725,726);
			}
			else if($fid == 327){
				$fidAry = array(327,638,636,637,639);
			}
			else{
				$fidAry[] = $fid;
			}
			$typeAryResult = $this->Db->query("select `typeid`,`name` from pre_forum_threadclass where fid in(".implode(',',$fidAry).")");

			$typeAry = array();

			while($row = $this->Db->fetch_assoc($typeAryResult)){
				$typeAry[$row['typeid']] = $row['name'];
				$typetemp = array();
				$typetemp["name"] = changeCode($row['name']);
				$typetemp["typeid"] = $row['typeid']+0;
				array_push( $typeAryTmp, $typetemp);
			}

			/* 2017.05.23 edit by arion 加入 $typeid 过滤  只有 fid 92 中生效 因此加在此处 */
			if($start>0){
				if ($typeid == 0) {
					$listTmp = $this->Db->fetch_all_assoc("
						select pre_forum_thread.tid,
						pre_forum_thread.subject,
						pre_forum_thread.author,
						pre_forum_thread.authorid,
						pre_forum_thread.dateline,
						pre_forum_thread.replies,
						'0' as likes,
						pre_forum_thread_pic.pic,
						pre_forum_thread_refresh.refresh,
						pre_forum_thread.typeid
						from pre_forum_thread
						left join pre_forum_thread_pic
						on pre_forum_thread.tid=pre_forum_thread_pic.tid
						left join pre_forum_post as b
				        on pre_forum_thread.tid = b.tid
				        and b.first = 1
				        left join pre_forum_thread_refresh
                        on pre_forum_thread.tid = pre_forum_thread_refresh.tid
						where pre_forum_thread.fid in(".implode(',',$fidAry).")
						and b.status != 1
						and displayorder>-1
						and pre_forum_thread_refresh.refresh<$start
						order by pre_forum_thread_refresh.refresh
						desc
						limit $amount"
					);
				}else{
					$listTmp = $this->Db->fetch_all_assoc("
						select pre_forum_thread.tid,
						pre_forum_thread.subject,
						pre_forum_thread.author,
						pre_forum_thread.authorid,
						pre_forum_thread.dateline,
						pre_forum_thread.replies,
						'0' as likes,
						pre_forum_thread_pic.pic,
						pre_forum_thread_refresh.refresh,
						pre_forum_thread.typeid
						from pre_forum_thread
						left join pre_forum_thread_pic
						on pre_forum_thread.tid=pre_forum_thread_pic.tid
						left join pre_forum_post as b
				        on pre_forum_thread.tid = b.tid
				        and b.first = 1
				        left join pre_forum_thread_refresh
                        on pre_forum_thread.tid = pre_forum_thread_refresh.tid
						where pre_forum_thread.fid in(".implode(',',$fidAry).")
						and b.status != 1
						and pre_forum_thread.typeid=$typeid
						and displayorder>-1
						and pre_forum_thread_refresh.refresh<$start
						order by pre_forum_thread_refresh.refresh
						desc
						limit $amount"
					);
				}
			}
			else{
				if ($typeid == 0) {
					$listTmp = $this->Db->fetch_all_assoc("
						select pre_forum_thread.tid,
						pre_forum_thread.subject,
						pre_forum_thread.author,
						pre_forum_thread.authorid,
						pre_forum_thread.dateline,
						pre_forum_thread.replies,
						'0' as likes,
						pre_forum_thread_pic.pic,
						pre_forum_thread_refresh.refresh,
						pre_forum_thread.typeid
						from pre_forum_thread
						left join pre_forum_thread_pic
						on pre_forum_thread.tid=pre_forum_thread_pic.tid
						left join pre_forum_post as b
				        on pre_forum_thread.tid = b.tid
				        and b.first = 1
				        left join pre_forum_thread_refresh
                        on pre_forum_thread.tid = pre_forum_thread_refresh.tid
						where pre_forum_thread.fid in(".implode(',',$fidAry).")
						and b.status != 1
						and displayorder>-1
						order by pre_forum_thread_refresh.refresh
						desc
						limit $amount"
					);
				}else{
					$listTmp = $this->Db->fetch_all_assoc("
						select pre_forum_thread.tid,
						pre_forum_thread.subject,
						pre_forum_thread.author,
						pre_forum_thread.authorid,
						pre_forum_thread.dateline,
						pre_forum_thread.replies,
						'0' as likes,
						pre_forum_thread_pic.pic,
						pre_forum_thread_refresh.refresh,
						pre_forum_thread.typeid
						from pre_forum_thread
						left join pre_forum_thread_pic
						on pre_forum_thread.tid=pre_forum_thread_pic.tid
						left join pre_forum_post as b
				        on pre_forum_thread.tid = b.tid
				        and b.first = 1
				        left join pre_forum_thread_refresh
                        on pre_forum_thread.tid = pre_forum_thread_refresh.tid
						where pre_forum_thread.fid in(".implode(',',$fidAry).")
						and b.status != 1
						and displayorder>-1
						and pre_forum_thread.typeid=$typeid
						order by pre_forum_thread_refresh.refresh
						desc
						limit $amount"
					);
				}
			}



			if(is_array($listTmp)){
				foreach($listTmp as $t){
					//加入分类
					if(isset($typeAry[$t['typeid']]) && $typeAry[$t['typeid']]){
						$t['subject'] = '['.$typeAry[$t['typeid']].'] '.$t['subject'];
					}

					$tmp = array();
					$tmp['id'] = $t['refresh'];
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
					$tmp['dateline'] = $t['refresh'];
					$tmp['replies'] = $t['replies'];
					$tmp['likes'] = $t['likes'];
					/*$picAry = unserialize($t['pic']);
					if(!is_array($picAry)){
						$picAry = array();
					}

					$tmp['pic'] = $picAry;*/
					$tmp['pic'] = $this->getPicList($t['tid']);

					$listAry[] = $tmp;
				}
			}
			$shareUrl = "https://m.yeeyi.com/mobile/list.php?fid=".$fid;
		}

		else{
			if($start>0){
				$listTmp = $this->Db->fetch_all_assoc("select * from (select topic_content_list.cid,c_title,c_type,c_tid,c_aid,c_imgstr,author,authorid,dateline,replies,'0' as likes,'' as froms,'' as tourl,'' as pic from topic_content_list left  join pre_forum_thread on topic_content_list.c_tid=pre_forum_thread.tid where c_type=2 and c_tid=0 and topic_id ='".$topic_id."' union select topic_content_list.cid,c_title,c_type,c_tid,c_aid,c_imgstr,'' as author,'' as authorid,pubdate as dateline,comments as replies,good as likes,froms,tourl,pic from topic_content_list left  join news_article on topic_content_list.c_aid=news_article.aid where topic_content_list.status=0 and c_type=1 and c_tid=0 and topic_id ='".$topic_id."') c where c.cid<".$start." order by cid desc limit $amount");
			}
			else{
				//可用
				$listTmp = $this->Db->fetch_all_assoc("select * from (select topic_content_list.cid,c_title,c_type,c_tid,c_aid,c_imgstr,author,authorid,dateline,replies,'0' as likes,'' as froms,'' as tourl,'' as pic from topic_content_list left  join pre_forum_thread on topic_content_list.c_tid=pre_forum_thread.tid where c_type=2 and c_tid=0 and topic_id ='".$topic_id."' union select topic_content_list.cid,c_title,c_type,c_tid,c_aid,c_imgstr,'' as author,'' as authorid,pubdate as dateline,comments as replies,good as likes,froms,tourl,pic from topic_content_list left  join news_article on topic_content_list.c_aid=news_article.aid where topic_content_list.status=0  and c_type=1 and c_tid=0 and topic_id ='".$topic_id."') c order by cid desc limit $amount");
			}

			if(is_array($listTmp)){
				foreach($listTmp as $t){
					$tmp = array();
					$tmp['id'] = $t['cid'];
					if($t['c_tid']>0){
						$tmp['tid'] = $t['c_tid'];
						$tmp['aid'] = 0;
						$tmp['isThread'] = '1';
						$tmp['isNews'] = '0';
					}
					else{
						$tmp['tid'] = 0;
						$tmp['aid'] = $t['c_aid'];
						$tmp['isThread'] = '0';
						$tmp['isNews'] = '1';
						$t['author'] = changeCode('亿忆新闻哥','utf-8','gbk');
						$t['authorid'] = 5122650;
					}
					$tmp['address'] = changeCode('火星网友','utf-8','gbk');
					$tmp['author'] = $t['author'];
					$tmp['authorid'] = $t['authorid'];
					$tmp['face'] = "http://center.yeeyi.com/avatar.php?uid=".$t['authorid']."&size=middle";
					$tmp['subject'] = $t['c_title'];
					$tmp['dateline'] = $t['dateline'];
					$tmp['replies'] = $t['replies'];
					$tmp['likes'] = $t['likes'];
					$tmp['froms'] = $t['froms'] ? $t['froms'] : $t['author'];
					$tmp['isNews'] = 1;

					if($t['pic']&&$t['pic']!='nopic'){
						if(!strstr($t['pic'],'http')){
							$tmp['image'] = "http://www.yeeyi.com/".$t['pic'];
						}
					}else{
						if(!strstr($t['pic'],'http')){
							$tmp['image'] = "https://apps.yeeyi.com/public/splash/zhantiinfo.jpg";
						}
					}
					$imgStr = trim($t['c_imgstr']);
					$imgAry = array();

					$imgAryTmp = json_decode($imgStr,true);
					if(is_array($imgAryTmp)){
						if($t['c_tid']>0){
							/*foreach($imgAryTmp as $img){
								if(strstr($img,'http://')){
									$imgAry[] = $img;
								}
								else{
									$imgAry[] = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$img;
								}

							}
							*/
							$imgAry = $this->getPicList($t['tid']);
						}
						else{
							foreach($imgAryTmp as $img){

								if(strstr($img,'http://')){
									$imgAry[] = $img;
								}
								else{
									$imgAry[] = 'http://www.yeeyi.com/'.$img;
								}
							}
						}
					}
					$tmp['pic'] = $imgAry;
					$listAry[] = $tmp;
				}
			}
			//$shareUrl = "https://m.yeeyi.com/mobile/list.php?topic_id=".$topic_id;
			$shareUrl = "https://m.yeeyi.com/mobile/index.php?app=article&act=topic&tid=".$topic_id;
		}
		//话题信息
		$topicInfo = array();
		$topicInfo['topic_id'] = $topic_id;
		if($fid>0){

			/* edit by allen qu 2017.04.12 判断是否已关注 */
			if (MEMBER_ID < 1) {
				$uid = 0;
			}else {
				$uid = MEMBER_ID;
			}
			$sql="select * from pre_home_favorite where idtype='fid' and uid=".$uid." and id=".$fid;
			$favid=$this->Db->once_fetch_assoc($sql);
			if(!empty($favid)) {
				$topicInfo['isFavorite'] = 1;
			}else{
				$topicInfo['isFavorite'] = 0;
			}

			$forumInfo = $this->Db->once_fetch_assoc("select `name`,threads from pre_forum_forum where fid=".$fid);
			$forumInfo = changeCode($forumInfo);
			$topicInfo['counts'] = $forumInfo['threads'];
			$topicInfo['topic_pic'] = '';
			$topicInfo['topic_name'] = str_replace('澳洲旅游','休闲旅游',strip_tags($forumInfo['name']));
			$topicInfo['topic_desc'] = '';
		}
		else{
			$topic_tmp = $this->Db->once_fetch_assoc("select * from topic_list where topic_id=".$topic_id);
			$topic_tmp = changeCode($topic_tmp);
			$topicInfo['counts'] = $topic_tmp['total_nums'];
			$topicInfo['topic_pic'] = "http://www.yeeyi.com/".$topic_tmp['pic1'];
			$topicInfo['topic_name'] = str_replace('澳洲旅游','休闲旅游',$topic_tmp['topic_name']);
			$topicInfo['topic_desc'] = $topic_tmp['topic_content'];
			$topicInfo['isFavorite'] = 0;
		}
		$return = array();
		$return['status'] = 2102;
		$return['topicInfo'] = $topicInfo;
		if ($fid) {
			$return['topicInfo']['topic_pic'] = "https://apps.yeeyi.com/public/splash/topic/topic_".$fid.".jpg";
		}
		$return['share'] = array(
			'thumbnail'=>$topicInfo['topic_pic'],
			'title'=>strip_tags($topicInfo['topic_name']),
			'summary'=>strip_tags($topicInfo['topic_name']),
			'url'=>$shareUrl
		);
		/* 2017.05.19 edit by neek li isPhone都改为0 */
		$return['postRule'] = array(
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
		);

		/* 2017.05.22 edit by arion 如果fid为92(同城生活) 返回 地区分类 */
		if ($fid == 92) {
			$return['typeAry'] = $typeAryTmp;
		}

		$return['listAry'] = changeCode($listAry);
		$this->outjson($return);
	}

	/**
	 * 话题内容的展示页，可能是新闻也可能是帖子
	 * @param $topic_id
	 * @param $cid  传递的即为tid的值
	 * 如果传递的是fid的话，那么cid就是tid，否则的话，需要去topic_list_content里面提取
	 */
	function topicView(){
		$topic_id = intval($this->Post['topic_id']);
		$cid = intval($this->Post['cid']);
		if($cid<1 || $topic_id<0){
			$return  = array();
			$return['status'] = 0;
			$return['message'] = '已经删除或帖子不存在';
			$this->outjson($return);
		}
		$tid = $cid;
		$this->getThreadContent($tid,$topic_id,$cid);
		/*if((isset($this->Config['topic_forum'][$topic_id]) && $this->Config['topic_forum'][$topic_id]['fid']>0) || $topic_id==0) {
			//属于属于板块的帖子,$cid就是tid
			$tid = $cid;
			$this->getThreadContent($tid,$topic_id,$cid);
		}
		else{
			$topicInfoTmp = $this->Db->once_fetch_assoc("select * from topic_content_list where cid=".$cid);
			if($topicInfoTmp['topic_id']!=$topic_id){
				$return  = array();
				$return['status'] = 4103;
				$this->outjson($return);
			}
			if($topicInfoTmp['c_tid']>0){
				$this->getThreadContent($topicInfoTmp['c_tid'],$topic_id,$cid);
			}
			else{
				$this->getNewsContent($topicInfoTmp['c_aid'],$topic_id,$cid);
			}
		}
		*/
	}

	/**
	 * 发布话题
	 * @param $topicId
	 * @param authcode;
	 * @param content;
	 */
	function postTopic(){
		$topic_id = intval($this->Post['topic_id']);
		$fid = intval($this->Post['fid']);
		$subject = trim($this->Post['subject']);
		$content = trim($this->Post['content']);
		$typeid = intval($this->Post['typeid']);
		$return = array();
		$isForum = 0;
		if(MEMBER_ID<1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		/* 2017.06.13 edit by allen qu 禁言不能发帖 */
		/*
		if (MEMBER_GROUP == 4) {

			$return['status'] = 10003;
			$return['message'] = '抱歉，您的账号已被禁止发帖，请联系管理员解禁';
			$this->outjson($return);
		}
		*/

		/* 2017.06.07 edit by allen qu 三分钟内不能重复发帖 */
		$lastPostTopic = getVar('last_topic_'.MEMBER_ID);

		if(time()<$lastPostTopic){
			$return['status'] = 5101;
			$return['time'] = ceil(($lastPostTopic - time()) / 60);
			//$return['message'] = changeCode('发帖频率过高, 请于'.$return['time'].'后再发帖', 'utf-8', 'gbk');
			$return['message'] = '发帖频率过高, 请于'.$return['time'].'分钟后再发帖';
			$this->outjson($return);

		}else {
			$nexttime = time() + 3*60;
			setVar('last_topic_'.MEMBER_ID,$nexttime);
		}
		/* edit end */


		if($fid>0){
			$isForum = 1;//进入板块
		}
		else{//专题详情页逻辑
			$fidInfo = $this->Db->once_fetch_assoc("select * from topic_list where topic_id=".$topic_id);
			$fid = intval($fidInfo['fid']);
			$typeid = intval($fidInfo['typeid']);
			if($fid<1){
				$return['status'] = 1;
				$return['message'] = '话题配置错误';
				$this->outjson($return);
			}

			if(strlen($content)<10){
				$return['status'] = 1;
				$return['message'] = '内容字数少于5字';
				$this->outjson($return);
			}
			$noTagContent = preg_replace("/\[attach\](.*)\[\/attach\]/isU","",stripslashes($content));
			if(mb_strlen($noTagContent,'utf-8')>30){
				$subject = mb_substr($noTagContent,0,30,'utf-8').'...';
			}
			else{
				$subject = $noTagContent;
			}
			if(strlen($subject) == 0){
				$subject = '图片分享';
			}
		}

		if(strlen($subject)<1){
			$return['status'] = 5404;
			$this->outjson($return);
		}
    

		load::logic("ThreadPost");
		$postObj = new ThreadPost();
		$dateline = time();
		$post = $postObj->postThread($fid,$subject,$content,$dateline,$typeid);
		$tid = $post['tid'];
		$pid = $post['pid'];
		$cid = $tid;
		if($isForum == 0){//专题详情发布逻辑,已弃用
			//插入话题
			$picAry = array();
			$query = $this->Db->query("select aid,tableid from `pre_forum_attachment` where pid=".$pid);
			while($img = $this->Db->fetch_assoc($query)){
				if($img['aid']){
					$ro = $this->Db->once_fetch_assoc("select attachment from pre_forum_attachment_".$img['tableid']." where aid=".$img['aid']);
					if($ro){
						$attachmentUrl = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$ro['attachment'];
						$picAry[] = $attachmentUrl;
					}
				}
			}
			$c_imgstr = json_encode($picAry);
			$c_url = "http://www.yeeyi.com/bbs/forum.php?mod=viewthread&tid=".$tid;
			$newsSql2 =array('topic_id'=>$topic_id,'c_title'=>changeCode($subject,'utf-8','gb2312'),'c_index'=>0,'c_type'=>2,'c_aid'=>0,'c_tid'=>$tid,'c_imgstr'=>$c_imgstr,'c_url'=>$c_url);
			$res=$this->Db->insertArr($newsSql2,'topic_content_list');
			$this->Db->query("update topic_list set total_nums=	total_nums+1 where topic_id=".$topic_id);
			$cid = $res;//返回刚刚插入的id;

		}

		/* 2017.06.07 edit by allen qu  发布话题增加40YB */
		$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 + 40 where uid=".MEMBER_ID);//增加40YB
		//$return['yb_message'] = changeCode('发帖成功, 金钱+40YB', 'utf-8', 'gbk');
		$return['message'] = '发帖成功, 金钱+40YB';
		/* edit end */


		$return['status'] = 0;
		$return['topic_id'] = $topic_id;
		$return['cid'] = $tid;
		$return['tid'] = $tid;
		$this->outjson($return);
	}

	/**
	 * @param $topic_id 话题id
	 * @param $cid 内容id
	 * @param $upid 上级的评论id
	 * @param $message
	 * @param $location
	 * @param $geolocation
	 * @param @authcode
	 */
	function replyTopic(){
		$return = array();
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
		$topic_id = intval($this->Post['topic_id']);
		$cid = intval($this->Post['cid']);
		$upid = intval($this->Post['upid']);
		$uid = intval($this->Post['uid']);
		$message = trim($this->Post['message']);
		$location = trim($this->Post['location']);
		$geolocation = trim($this->Post['geolocation']);
		$location = changeCode($location,'utf-8','gbk');
		$geolocation = changeCode($geolocation,'utf-8','gbk');
		$fromuid = intval($this->Post['fromuid']);


		$tid = 0;
		$aid = 0;
		$isForum = 0;
		$isNews = 0;
		$tid = $cid;

		/* 2017.06.07 edit by allen qu 30秒内不能评论同一篇帖子 */

		$lastTopicReply = getVar('last_topic_reply_'.$tid.'_'.MEMBER_ID);

		if(time()<$lastTopicReply){
			$return['status'] = 5101;
			//$return['time'] = ceil(($lastTopicReply - time()) / 60);
			//$return['message'] = changeCode('30秒内不得重复回复同一帖子', 'utf-8', 'gbk');
			$return['message'] = '30秒内不得重复回复同一帖子';
			$this->outjson($return);

		}else {
			$nexttime = time() + 30;
			setVar('last_topic_reply_'.$tid.'_'.MEMBER_ID,$nexttime);
		}
		/* edit end */

		$reply = $this->doReplyThread($tid, $upid, $message, $location, $geolocation,$uid,$fromuid);

		/*推送*/
        $push = $reply['push'];
        $up   = $this->Db->once_fetch_assoc("select * from app_user_getui_client where uid=" . $fromuid);
        $this->Db->query("INSERT INTO yeeyico_new.app_unread_msg_record values('','{$fromuid}','{$this->G['uid']}','4')");

		$return['msg'] = $reply;
		$return['status'] = 0;
		$return['topic_id'] = $topic_id;
		$return['cid'] = $cid;

		/* 2017.06.07 edit by allen qu  评论增加12YB */
		$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 + 12 where uid=".MEMBER_ID);//增加12YB
		//$return['yb_message'] = changeCode('评论成功, 金钱+12YB', 'utf-8', 'gbk');
		$return['message'] = '评论成功, 金钱+12YB';

//		$this->outjsonpush($return);
//        echo json_encode($return);

		//执行推送
        if ($this->G['uid'] != $fromuid) {
            if ($up['uid'] > 0 && $up['client_id'] != "") {
                $push['cid'] = $up['client_id'];
                Load::functions('getui');
                pushMessageToSingle($push);
            }
        }

        $this->outjson($return);
	}

	/*
	 * 帖子点赞
	 * */
	function postLike(){

		$uid = intval($this->Post['uid']);
		$id = intval($this->Post['id']);
		$type = trim($this->Post['type']);//tid:帖子  aid:新闻  tid_rp:帖子回帖    aid_p新闻评论

		$status = $this->Db->once_fetch_assoc("select * from yeeyico_new.app_post_like where idtype='".$type."' and uid=".$uid." and id=".$id);
		$count = $this->Db->once_fetch_assoc("select count(*) as num from yeeyico_new.app_post_like where idtype='".$type."'and id=".$id." group by id;");

		if($status){
			$return['status'] = 1;
			$return['message'] = '用户已点赞';
			$return['likeNum'] = intval($count['num']);
			$this->outjson($return);
		}   
		$this->Db->query("INSERT INTO yeeyico_new.app_post_like values('',$id,'$type',$uid)");
		$count = $this->Db->once_fetch_assoc("select count(*) as num from yeeyico_new.app_post_like where idtype='".$type."'and id=".$id." group by id;");

		$return['status'] = 0;
		//$return['message'] = '点赞成功';
		$return['likeNum'] = intval($count['num']);
		$this->outjson($return);
	}

	/**
	 * @param $topic_id
	 * @param $cid
	 * @param $start
	 * @param $amount
	 * @param $type hot all
	 * @param @rootid;
	 */
	function getReply(){

		$topic_id = intval($this->Post['topic_id']);
		$cid = intval($this->Post['cid']);
		$type = trim($this->Post['type']);
		$start = intval($this->Post['start']);
		$amount = intval($this->Post['amount']);
		$rootid = intval($this->Post['rootid']);
		$tid = 0;
		$aid = 0;
		$isForum = 0;
		$isNews = 0;
        if((isset($this->Config['topic_forum'][$topic_id]) && $this->Config['topic_forum'][$topic_id]['fid']>0) || $topic_id==0) {
            $fid = $this->Config['topic_forum'][$topic_id]['fid'];
			$tid = $cid;
			$isForum = 1;
		}
		else{
			$cInfo = $this->Db->once_fetch_assoc("select * from topic_content_list where cid=".$cid);
			if($cInfo['c_type'] == 1){
				$isNews = 1;
				$aid = $cInfo['c_aid'];
			}
			else{
				$isForum = 1;
				$tid = $cInfo['c_tid'];
			}
		}

		if($isForum){
			if($type == 'hot'){
				$reply = $this->getThreadReply($tid,0,5);
			}
			else{
				$reply = $this->getThreadReply($tid,$start,$amount);
			}
		}
		else{
			$reply = $this->getNewsReply($aid,$start,$amount,$type,$rootid);
		}
		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}

		/* edit by mosagx create at 2017-09-04 */
		$reply = changeCode($reply);
        foreach ($reply as &$item)
        {
            $str_data = $item['message'];
            if  (strpos($str_data,'发自手机亿忆')){
                $str = "<p style=\"text-align: right\">发自手机亿忆</p>";
                $str = changeCode($str,'utf-8','gbk');
                $str = changeCode($str);
                $str_res = str_replace('发自手机亿忆',$str,$str_data);
                $item['message'] = $str_res;
            }
        }

		$return['status'] = 0;
		$return['replyList'] = $reply;
		$this->outjson($return);
	}

	/**
	 * 返回话题帖子内容
	 * @param $tid
	 * @param $topic_id 话题编号
	 * @param $cid 话题的内容编号，
	 */
	function getThreadContent($tid,$topic_id,$cid){
		$tid = intval($tid);
		$return = array();
		$threadInfoTmp = $this->Db->once_fetch_assoc("select t.fid,t.tid,t.`subject`,t.author,t.authorid,t.closed,t.dateline,t.views,t.replies,t.attachment,p.message,p.anonymous,p.pid,m.groupid
                                                      from `pre_forum_thread` t
                                                      left join `pre_forum_post` p
                                                      on t.tid=p.tid
                                                      left join pre_common_member m
                                                      on t.authorid=m.uid
                                                      where t.tid=".$tid." and p.`first`=1 and t.`displayorder`>=0");

		$groupInfo = $this->Db->once_fetch_assoc("select grouptitle from yeeyico_new.pre_common_usergroup where groupid='".$threadInfoTmp['groupid']."'");
		$groupInfo = changeCode($groupInfo);

		/*edit by neek li 更新阅读数*/
		$this->Db->query("update pre_forum_thread set views=views+1 where tid=".$tid);

		if($threadInfoTmp['tid']<1){   
			$this->Db->query("delete from topic_content_list where c_tid=".$tid);
			$return['status'] = 0;
			$this->outjson($return);
		}
		if($cid == 0){
			$cid = $tid;
		}
		$topicInfo = array();
        if($topic_id == 0){
			if(in_array($threadInfoTmp['fid'],array(327,638,636,637,639))){
				$threadInfoTmp['fid'] = 327;
			}
			$topicTmp['topic_id'] = '0';
			$topicTmp['fid'] = $threadInfoTmp['fid'];
			$topicTmp['topic_name'] = '';
			foreach($this->Config['hot_forum'] as $tmpForum){
				if($tmpForum['fid'] == $threadInfoTmp['fid']){
					$topicTmp['topic_name'] = $tmpForum['forum_name'];
					break;
				}
			}
			if(strlen($topicTmp['topic_name'])<2){
				foreach($this->Config['other_forum'] as $tmpForum){
					if($tmpForum['fid'] == $threadInfoTmp['fid']){
						$topicTmp['topic_name'] = $tmpForum['forum_name'];
						break;
					}
				}
			}
			$topicInfo[] = $topicTmp;
        }
		else{
			$threadInfoTmp['fid'] = 0;
		}

		$threadInfo = array();
		//是否点赞
		$threadInfo['isLike'] = 0;
		if(MEMBER_ID>0){
			//uid,id,idtype
			$checkFavoriate = $this->Db->once_fetch_assoc("select * from app_post_like where uid=".MEMBER_ID." and id=".$tid." and idtype='tid'");
			if($checkFavoriate['id']>0){
				$threadInfo['isLike'] = 1;
			}
		}
		$count = $this->Db->once_fetch_assoc("select count(*) as num from yeeyico_new.app_post_like where idtype='tid' and id=".$tid." group by id;");

		$threadInfo['likes'] = (int)$count['num'];//add by neek li
		$threadInfo['topic_id'] = $topic_id;
		$threadInfo['cid'] = $cid;
		$threadInfo['aid'] = 0;
		$threadInfo['tid'] = $threadInfoTmp['tid'];
		$threadInfo['fid'] = $threadInfoTmp['fid'];
		$threadInfo['pid'] = $threadInfoTmp['pid'];
		$threadInfo['subject'] = $threadInfoTmp['subject'];
		$threadInfo['author'] = $threadInfoTmp['author'];
		$threadInfo['group_name'] = changeCode($groupInfo['grouptitle'],'utf-8','gbk');//add by neek li

		$threadInfo['authorid'] = $threadInfoTmp['authorid'];
		$threadInfo['dateline'] = $threadInfoTmp['dateline'];
		$threadInfo['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$threadInfoTmp['authorid']."&size=middle";
		$threadInfo['views'] = intval($threadInfoTmp['views']);
		/* 2017.06.14 edit by allen qu  实际查询 pre_forum_post表中数据 */
		$replyCount = $this->Db->once_fetch_assoc("select count(*) as counts from pre_forum_post where first = 0 and invisible = 0 and tid=".$tid);
		$threadInfo['replies'] = intval($replyCount['counts']);
		$threadInfo['allowReply'] = '1';
		$threadInfo['allowGuest'] = '0';
		if (isset($threadInfo['address'])) {
			$addr = explode('|', $threadInfo['address']);
			array_pop($addr);
			$threadInfo['address'] = implode(",", $addr);
		} else {
			$threadInfo['address'] = changeCode('火星网友','utf-8','gbk');
		}
		//判断收藏
		$checkFavorite = $this->Db->once_fetch_assoc("select * from pre_home_favorite where idtype='cid' and id=".$tid." and uid='".MEMBER_ID."'");
		if($checkFavorite['id']>0){
			$threadInfo['isFavourite'] = 1;
		}
		else{
			$threadInfo['isFavourite'] = 0;
		}


		//内容
		/* 2017.05.19 edit by allen qu 为兼容ios, 这里需要加个p标签 */
		$message = '<p>'.stripslashes($threadInfoTmp['message']).'</p>';
		$postmessage = $this->getImgAttachment($threadInfoTmp['pid'],$message);
		$postmessage = preg_replace("/\[youtube\](.*)\[\/youtube\]/isU",'<iframe width="320" height="240" src="https://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>',$postmessage);

		$postmessage = getImg($postmessage);
		/* 2017.05.15 edit by allen qu 匹配替换[url] */
		$postmessage = getHref($postmessage);
		$postmessage = parsesmiles2($postmessage);

		preg_match_all("/\[mp3\](.*)\[\/mp3\]/isU",$postmessage,$newcon);
		foreach($newcon[1] as $mp3){
			$postmessage = preg_replace("/\[mp3\](.*)\[\/mp3\]/isU","<p style='text-align:center;'><audio style='width:250px;' src='".$mp3."' controls></audio></p>",$postmessage,1);
		}
		$postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
		$postmessage = preg_replace("/\{\:\d+\:\}/isU", '', $postmessage);

		/*edit by neek li app端居中加粗处理*/
		$postmessage = str_replace("[b]","<strong>",$postmessage);
		$postmessage = str_replace("[/b]","</strong>",$postmessage);
		$postmessage = str_replace("[align=center]","<p style='text-align: center;'>",$postmessage);
		$postmessage = str_replace("[align=left]","<p style='text-align: left;'>",$postmessage);
		$postmessage = str_replace("[/align]","</p>",$postmessage);

		$postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
		$postmessage = nl2br($postmessage);
		$threadInfo['message'] = $postmessage;


		//取图片
		preg_match("/<img[^>]+src=[\'\"](.*)[\'\"]/isU",stripslashes($postmessage),$tmpPic);
		$return['status'] = 0;
		$return['topicContent'] = changeCode($threadInfo);
		//对应的topicinfo
		$topicAry = $this->Db->fetch_all_assoc("SELECT topic_list.topic_id,topic_list.topic_name FROM `topic_content_list` left join topic_list on topic_content_list.topic_id=topic_list.topic_id where c_tid=".$threadInfoTmp['tid']);
		$topicAry = changeCode($topicAry);
		foreach($topicAry as $topicTmp){
			$topicTmp['fid'] = '0';
			$topicInfo[] = $topicTmp;
		}
		$return['topicAry'] = $topicInfo;
		$return['share'] = array(
			'thumbnail'=>$tmpPic[1]?$tmpPic[1]:'',
			'title'=>strip_tags($return['topicContent']['subject']),
			'summary'=>strip_tags($return['topicContent']['subject']),
			'url'=>'https://m.yeeyi.com/mobile/view.php?tid='.$threadInfo['tid']
		);
		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}
		$this->outjson($return);
	}

	/**
	 * 获取新闻评论
	 * @param $aid
	 * @param $start
	 * @param $amount
	 * @param $type hot all
	 * @param @rootid;
	 * message,author,authorid,pid,dateline,id,message,userface,upReply,replies,likes
	 */
	function getNewsReply($aid,$start,$amount,$type,$rootid){
		$return = array();
		$replyAry = array();
		if($rootid>0){
			//获取二级评论
			//root信息
			$rootAry = $this->Db->once_fetch_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,'none' as address,a.commnum as replies
													from news_comment a left join pre_common_member m
													 on a.userid = m.uid  where a.id=".$rootid);

			/*过滤禁言*/
			if ($rootAry['groupid'] == 4) {

				$rootAry['content'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
			}
			$return['rootReply'] = changeCode($rootAry);
			$replyTmp = $this->Db->fetch_all_assoc(
				"select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,b.id as upid,b.username as upusername,b.addtime as upaddtime,b.del_status as updel_status ,b.content as upcontent ,'none' as address,a.commnum as replies
				from news_comment a
				left join news_comment b
				on a.replyid=b.id
				left join pre_common_member m
				on a.userid = m.uid
				where a.aid=".$aid."
				and a.rootid=".$rootid."
				and a.id>$start
				order by a.id asc
				limit 0,$amount");
			foreach($replyTmp as $reply){

				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['author'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['dateline'] = $reply['addtime'];
				$tmp['groupid'] = $reply['groupid'];
				if (isset($tmp['address'])) {
					$addr = explode('|', $tmp['address']);
					array_pop($addr);
					$tmp['address'] = implode(",", $addr);
				} else {
					$tmp['address'] = changeCode('火星网友','utf-8','gbk');
				}
				$tmp['authorid'] = $reply['userid'];
				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['message'] = $reply['content'];
				$tmp['replies'] = $reply['replies'];
				$tmp['upid'] = $reply['upid'];
				if($reply['upid'] != $rootid){
					$tmpUp = array();
					$tmpUp['id'] = $reply['upid'];
					$tmpUp['dateline'] = $reply['upaddtime'];
					$tmpUp['author'] = $reply['upusername'];
					$tmpUp['message'] = $reply['upcontent'];
					$tmp['upreply'] = $tmpUp;
				}
				else{
					$tmp['upreply'] = NULL;
				}
				$replyAry[] = $tmp;
			}
		}
		else if($type == 'hot'){
			$replyTmp = $this->Db->fetch_all_assoc(
				"select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,'none' as address,a.commnum as replies
				from news_comment a
				left join pre_common_member m
				on a.userid = m.uid
				where a.aid=".$aid."
				and
				a.rootid=0
				order by a.commnum desc
				limit 0,5");
			foreach($replyTmp as $reply){

				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['author'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['dateline'] = $reply['addtime'];
				$tmp['groupid']  = $reply['groupid'];
				$tmp['authorid'] = $reply['userid'];
				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['message'] = $reply['content'];
				$tmp['replies'] = $reply['replies'];
				$tmp['upreply'] = NULL;
				$childReplyTmpAry = $this->Db->fetch_all_assoc(
					"select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,'none' as address,a.commnum as replies
					from news_comment a
					left join pre_common_member m
					on a.userid = m.uid
					where a.aid=".$aid." and a.rootid=".$reply['id']."
					order by a.id"
				);
				$childReply = array();
				foreach($childReplyTmpAry as $creply){

					$tmp2 = array();
					$tmp2['id'] = $creply['id'];
					$tmp2['author'] = $creply['username'];
					$tmp2['authorid'] = $creply['userid'];
					$tmp2['groupid'] = $creply['groupid'];
					$tmp2['dateline'] = $creply['addtime'];
					$tmp2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$creply['userid']."&size=middle";
					$tmp2['likes'] = $creply['likes'];
					$tmp2['message'] = $creply['content'];
					$tmp2['replies'] = $creply['replies'];
					$childReply[] = $tmp2;
				}
				$tmp['childReply'] = $childReply;
				$replyAry[] = $tmp;
			}

		}
		else if($type == 'all'){
			$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,'none' as address,a.commnum as replies from news_comment a left join pre_common_member m on a.userid = m.uid where a.aid=".$aid." and a.rootid=0 and a.id>$start order by a.id asc limit 0,$amount");
			foreach($replyTmp as $reply){

				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['author'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['dateline'] = $reply['addtime'];
				$tmp['authorid'] = $reply['userid'];
				$tmp['groupid'] = $reply['groupid'];
				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['message'] = $reply['content'];
				$tmp['replies'] = $reply['replies'];
				$tmp['upreply'] = NULL;
				$childReplyTmpAry = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,'none' as address,a.commnum as replies from news_comment a left join pre_common_member m on a.userid = m.uid  where a.aid=".$aid." and a.rootid=".$reply['id']." order by a.id");
				$childReply = array();
				foreach($childReplyTmpAry as $creply){

					$tmp2 = array();
					$tmp2['id'] = $creply['id'];
					$tmp2['author'] = $creply['username'];
					$tmp2['authorid'] = $creply['userid'];
					$tmp2['groupid'] = $creply['groupid'];
					$tmp2['dateline'] = $creply['addtime'];
					$tmp2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$creply['userid']."&size=middle";
					$tmp2['likes'] = $creply['likes'];
					$tmp2['message'] = $creply['content'];
					$tmp2['replies'] = $creply['replies'];
					$childReply[] = $tmp2;
				}
				$tmp['childReply'] = $childReply;
				$replyAry[] = $tmp;
			}
		}

		foreach ($replyAry as $reply)
		{
			/* 禁言人的评论不显示 */
			if ($reply['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$reply['message'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}

			if ($reply['childReply']['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$reply['childReply']['message'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}

			if ($reply['upreply']['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$reply['upreply']['message'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}
		}



		return $replyAry;
	}


	/**
	 * 获取帖子评论
	 * @param $tid
	 * @param $start
	 * @param $amount
	 * message,author,authorid,pid,dateline,id,message,userface,upReply
	 */
	function getThreadReply($tid,$start,$amount){

		if($start>0){
			$replySql = "select p.message, p.author, p.authorid, m.groupid, p.pid, p.dateline, l.location as address
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
			//获取图片附件
			$postmessage = $this->getImgAttachment($reply['pid'],$message);

			//获取图片
			$postmessage = getImg($postmessage);

			//获取表情
			$postmessage = parsesmiles2($postmessage);

			$postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
			$postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
			$postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
			$postmessage = nl2br($postmessage);
			$postmessage = stripslashes($postmessage);
			$replyTmp[$k]['message'] = nl2br(trim(str_replace("<br />","\r\n",$postmessage)));
			$replyTmp[$k]['id'] = $reply['pid'];
			if (isset($replyTmp[$k]['address'])) {
				$addr = explode('|', $replyTmp[$k]['address']);
				array_pop($addr);
				$addr = implode(",", $addr);

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
			}else{
				$replyTmp[$k]['address'] = changeCode('火星网友','utf-8','gbk');
			}

			/* 国外地址倒序 create by chen at 2017-7-28 */
//            if (!$addr){
//                $replyTmp[$k]['address'] = changeCode('火星网友','utf-8','gbk');
//            }
//            else{
//
//            }



			$replyTmp[$k]['replies'] = 0;
			$replyTmp[$k]['likes'] = 0;
			$replyTmp[$k]['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['authorid']."&size=middle";
			$replyAry[$reply['pid']] = $replyTmp[$k];
			$replyAry[$reply['pid']]['upReply'] = array();
		}
		if(count($upPid)>0){
			$upInfoAry = $this->Db->fetch_all_assoc("select p.pid, p.message, p.author, p.authorid, m.groupid, p.dateline, l.location as address
				from pre_forum_post as p
				left join pre_forum_post_location as l
				on p.pid = l.pid
				left join pre_common_member as m
				on p.authorid = m.uid
				where p.pid in(".implode(',',$upPid).")"
			);
			foreach($upInfoAry as &$reply){

				$message = stripslashes($reply['message']);
				$postmessage = $this->getImgAttachment($reply['pid'],$message);
				$postmessage = getImg($postmessage);
				$postmessage = parsesmiles2($postmessage);
				$postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
				$postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
				$postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
				$postmessage = nl2br($postmessage);
				$postmessage = stripslashes($postmessage);
				$reply['message'] = nl2br(trim(str_replace("<br />","\r\n",$postmessage)));
				if (isset($reply['address'])) {
					$addr = explode('|', $reply['address']);
					array_pop($addr);
					$addr = implode(",", $addr);
				}

				/* 国外地址倒序 create by chen at 2017-7-28 */
				if (!$addr){
					$reply['address'] = changeCode('火星网友','utf-8','gbk');
				}
				if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
					$add_arr = explode(',', $addr);
					if (count($add_arr)>2){
						array_pop($add_arr);
					}
					$new_arr = array_reverse($add_arr);
					$reply['address'] = implode(",", $new_arr);

				}else{
					$reply['address'] = $addr;
				}

//				else {
//					$reply['address'] = changeCode('火星网友','utf-8','gbk');
//				}
				foreach($upPid as $k=>$v){
					if($v == $reply['pid']){
						$replyAry[$k]['upReply'] = $reply;
						break;
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

			//添加点赞数量和点赞状态
		    $uid = MEMBER_ID;
			$reply['isLike'] = 0;
			if($uid>0){
				$checkFavoriate = $this->Db->once_fetch_assoc("select * from app_post_like where uid=".$uid." and id=".$reply['pid']." and idtype='tid_rp'");
				if($checkFavoriate['likeid']>0){
					$reply['isLike'] = 1;
				}
			}
			$count = $this->Db->once_fetch_assoc("select count(*) as num from yeeyico_new.app_post_like where idtype='tid_rp' and id=".$reply['pid']." group by id;");
			$reply['likes'] = (int)$count['num'];

			$returnAry[] = $reply;
		}

		$replyAry['teststatus'] = 111;
		return $returnAry;
	}


	/**
	 * 发布帖子评论
	 * @param $tid
	 * @param $uppid
	 * @param $message
	 */
	function doReplyThread($tid, $uppid, $message, $location, $geolocation,$uid=0,$fromuid){
		# 获取主题表
		$threadInfo = $this->Db->once_fetch_assoc("select * from pre_forum_thread where tid=".$tid);
		if($threadInfo['tid']<1){
			$return  = array();
			$return['status'] = 4103;
			$this->outjson($return);
		}
		$sql = "INSERT INTO pre_forum_post_tableid SET `pid`=''";
		$result = $this->Db->query($sql);
		$pid = intval($this->Db->insert_id());
		$time = time();
		$ip = client_ip();

		/* edit by neek li 调用PC端postnew接口 */
		$res = postNew($tid,'reply',$ip,MEMBER_ID,$threadInfo['fid']);

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
        $message   = changeCode($message, 'utf-8', 'gbk');
        $bbcodeoff = -1;
		//添加评论
		if($uppid>0){
			//有上级评论
			$upReplyInfo = $this->Db->once_fetch_assoc("select * from pre_forum_post where pid=".$uppid);
			$upReplyInfo['message'] = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$upReplyInfo['message']);
			$upReplyInfo['message'] = preg_replace("/\[.*\]/isU",'',$upReplyInfo['message']);
			$labelStr = "发表于";
			$labelStr = changeCode($labelStr,'utf-8','gb2312');
			$upInfo = "[quote][size=2][url=forum.php?mod=redirect&goto=findpost&pid=".$uppid."&ptid=".$tid."][color=#999999]".$upReplyInfo['author']." ".$labelStr." ".date("Y-m-d G:i:s")."[/color][/url][/size]\r\n".trim(strip_tags($upReplyInfo['message']))."[/quote]\n\n";
			$message = $upInfo.$message;
			$bbcodeoff = 0;
			if($upReplyInfo['authorid']>0){
				pushTopicReply($upReplyInfo['authorid']);
			}
		}
		pushTopicReply($threadInfo['authorid']);

        /* 添加推送参数 create by chen */
        $push['template']           = "transmission";
        $push['message']['title']   = "";
        $content['action']          = "my_message";
        $content['id']              = "4";
        $content['title']           = "收到一条新评论";
        $push['message']['content'] = json_encode($content);
        $push['message']['body']    = "收到一条新评论";
        //----------------------------------------------------

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
		$this->Db->query("UPDATE pre_forum_thread SET `lastposter`='".changeCode(MEMBER_NAME, 'utf-8', 'gbk')."',`replies`=`replies`+'1' WHERE `tid`='".$tid."'");
		$this->Db->query("UPDATE pre_forum_thread_refresh SET `refresh`='".$time."' WHERE `tid`='".$tid."'");
		/* edit end */
        $return['tid']    = $tid;
        $return['attary'] = $attAry;
        $return['num']    = $attNums;
        $return['pid']    = $pid;
        $return['push']   = $push;
        $return['status'] = 2503;
		return $return;
	}

	/**
	 * 获取附件
	 * @param $pid
	 * @param $message
	 * @return mixed
	 */
	function getImgAttachment($pid,$message){
		if(!empty($pid)){
			$query = $this->Db->query("select aid,tableid from `pre_forum_attachment` where pid=".$pid);
			while($img = $this->Db->fetch_assoc($query)){
				if($img['aid']){
					$ro = $this->Db->once_fetch_assoc("select attachment from pre_forum_attachment_".$img['tableid']." where aid=".$img['aid']);
					if($ro){
						$attachmentUrl = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$ro['attachment'];
						$imgStr = "<p style='text-align:center;width:100%;'><img style='width:98%' src='".$attachmentUrl."'></p>";
						if(strstr($message,'[attach]'.$img['aid'].'[/attach]') || strstr($message,'[attachimg]'.$img['aid'].'[/attachimg]')){
							$message = str_replace('[attach]'.$img['aid'].'[/attach]',$imgStr,$message);
							$message = str_replace('[attachimg]'.$img['aid'].'[/attachimg]',$imgStr,$message);
						}
						else{
							$message .= $imgStr;
						}

					}

				}

			}
		}
		return $message;
	}
	function getMediaList($tid){
		$postInfo = $this->Db->once_fetch_assoc("select pid,message from pre_forum_post where tid=$tid and first=1");
		if(isset($postInfo['message'])&&!empty($postInfo['message'])){
			$data = $this->getNeedBetween( '[media' , '[/media]',$postInfo['message']);
			if($data==""){
				return "";
			}
			$data= $data.'[/media]';
			preg_match('/](.*?)(\[\/media\])/i', $data, $matches);
			$data = $matches[1];
			return $data;
		}else{
			return "";
		}
	}
	/*截取两个字符串中间的字符串，多个存在取第一个*/
	function getNeedBetween($begin,$end,$str){
		if(mb_strpos($str,$begin)==null)
			return "";
		$b = mb_strpos($str,$begin) + mb_strlen($begin);
		$e = mb_strpos($str,$end) - $b;
		return mb_substr($str,$b,$e);
	}
	function getPicList($tid,$type=1){
		$picAry = array();
		if($tid>0){
			$postInfo = $this->Db->once_fetch_assoc("select pid from pre_forum_post where tid=$tid and first=1");
			$pid = intval($postInfo['pid']);
			//判断tabid
			$tableid = getattachtableid($tid);
			$attTableName = "pre_forum_attachment_".$tableid;
			$attachAry = $this->Db->fetch_all_assoc("select attachment from $attTableName where pid=".$pid." order by aid asc limit 9");
			foreach($attachAry as $atta){
				if($type==1){//type 1:缩率图
					$imgurl = "http://www.yeeyi.com/bbs/data/attachment/forum/".$atta['attachment'];
					$picAry[] = isexist_img($imgurl);
				}else{
					$picAry[] = "http://www.yeeyi.com/bbs/data/attachment/forum/".$atta['attachment'];
				}


			}
		}
		return $picAry;
	}

	function doLink($url){
		$array = array();
		$array['tid'] = 0;
		$array['cid'] = 0;
		$array['aid'] = 0;
		$array['topic_id'] = 0;
		$array['url'] = '';
		$tid = 0;
		$aid = 0;
		if(strstr($url,'yeeyi.com')){
			if(preg_match("/thread-([0-9]+)-1/is",$url,$tidAry)){
				if(isset($tidAry[1]) && $tidAry[1]>0){
					$tid = intval($tidAry[1]);
				}
			}
			else if(preg_match("/tid=([0-9]+)/is",$url,$tidAry)){
				if(isset($tidAry[1]) && $tidAry[1]>0){
					$tid = intval($tidAry[1]);
				}
			}
			else if(preg_match("/aid=([0-9]+)/is",$url,$aidAry)){
				if(isset($aidAry[1]) && $aidAry[1]>0){
					$aid = intval($aidAry[1]);
				}
			}

			if($aid == 0 && $tid == 0){
				$array['url'] = $url;
			}
			else if($aid>0){
				$array['aid'] = $aid;
			}
			else if($tid>0){
				$threadInfo = $this->Db->once_fetch_assoc("select fid,author from pre_forum_thread where tid='".$tid."'");
				$fid = intval($threadInfo['fid']);
				if(in_array($fid,array(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657))){
					$array['tid'] = $tid;
					$array['author'] = $threadInfo['author'];
				}
				else{
					$array['cid'] = $tid;
					$array['author'] = $threadInfo['author'];
				}
			}

		}
		else{
			$array['url'] = $url;
		}
		return $array;
	}

}
