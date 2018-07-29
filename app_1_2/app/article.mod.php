<?php
class ModuleObject extends AppObject{
	function ModuleObject($config)
	{
		$this->AppObject($config);
		$this->Execute();
	}
	function Execute(){
		if(in_array($this->Act,array('delReply','newsFavorite','removeFavorite'))){
			if($this->G['uid']<1){
				$return['status'] = 5100;
				$this->outjson($return);
			}
		}
		if($this->Act == 'getHotNews'){
			$this->getHotNews();
		}
		else if($this->Act == 'getNewsList'){
			$this->getNewsList();
		}
		else if($this->Act == 'getNewsContent'){
			$this->getNewsContent();
		}
		else if($this->Act == 'getNewsReply'){
			$this->getNewsReply();
		}
		else if($this->Act == 'doReply'){
			$this->doReply();
		}
		else if($this->Act == 'delReply'){
			$this->delReply();
		}
		else if($this->Act == 'newsFavorite'){
			$this->newsFavorite();
		}
		else if($this->Act == 'removeFavorite'){
			$this->removeFavorite();
		}
		else if($this->Act == 'doBaoLiao'){
			$this->doBaoLiao();
		}
		else if($this->Act == 'newsLike'){
			$this->newsLike();
		}
		else if($this->Act == 'replyLike'){
			$this->replyLike();
		}
	}
	function index(){
		die('Error');
	}
	/*
	 * 获取热门新闻
	 * 5条
	 *  ●	新闻ID
		●	新闻标题
  		●	新闻缩略图链接（750*380）
	 *
	 * */
	function getHotNews(){
		$hotNews = $this->Db->fetch_all_assoc("select * from news_article where headline>0 order by headline desc limit 0,5");
		foreach($hotNews as $k=>$news){
			$hotNews[$k]['isNews'] = 1;
			if(strstr($news['headpic'],'http://')){

			}
			else{
				$hotNews[$k]['headpic'] = "http://www.yeeyi.com".$news['headpic'];
			}
			if(strlen($news['tourl'])>5){
				if(!strstr($news['tourl'],'http')){
					$news['tourl'] = 'http://'.$news['tourl'];
				}
				$hotNews[$k]['isNews'] = 0;
				$hotNews[$k]['outlink'] = $this->doLink($news['tourl']);
				$hotNews[$k]['froms'] = $hotNews[$k]['outlink']['author'];
			}
		}
		$hotNews = changeCode($hotNews,'gbk','utf-8');
		$return = array();
		$return['status'] = 2200;
		$return['hotNews'] = $hotNews;
		$this->outjson($return);
	}

	function getNewsList(){
		$startAid = intval($this->Post['startAid']);
		$amount = intval($this->Post['amount']);
		$startTopicId =  isset($this->Post['startTopicId'])?intval($this->Post['startTopicId']):0;
		$cid = intval($this->Post['cid']);
		if($startAid == 0){  //hotNews放到这里，只有加载初始列表时调用hotnews置顶，数量=2条
			$whereAid = ' delstate=0 and ';
			/*置顶开始*/
			$hotNews = $this->Db->fetch_all_assoc("select * from news_article where headline>0 order by headline desc limit 0,2");
		foreach($hotNews as $k=>$news){
			$hotNews[$k]['isNews'] = 1;
			if(strstr($news['headpic'],'http://')){

			}
			else{
				$hotNews[$k]['headpic'] = "http://www.yeeyi.com".$news['headpic'];
			}
			if(strlen($news['tourl'])>5){
				if(!strstr($news['tourl'],'http')){
					$news['tourl'] = 'http://'.$news['tourl'];
				}
				$hotNews[$k]['isNews'] = 0;
				$hotNews[$k]['outlink'] = $this->doLink($news['tourl']);
				$hotNews[$k]['froms'] = $hotNews[$k]['outlink']['author'];
			}
		}
		$hotNews = changeCode($hotNews,'gbk','utf-8');
			/*置顶结束*/
		}
		else{
			$whereAid = " delstate=0 and  aid<$startAid and ";
			$hotNews = array(); //置顶为空
		}


		if($cid>0){
			$cidAry = array();
			$cidAry[] = $cid;
			$cidChild = $this->Db->fetch_all_assoc("select cid,catname from news_category where upuid in(".implode(',',$cidAry).")");
			foreach($cidChild as $cidTmp){
				$cidAry[] = $cidTmp['cid'];
			}
			$cidChild = $this->Db->fetch_all_assoc("select cid,catname from news_category where upuid in(".implode(',',$cidAry).")");
			foreach($cidChild as $cidTmp){
				$cidAry[] = $cidTmp['cid'];
			}
			$newsAry = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl,aid as orderid,lighten from news_article where ".$whereAid." cid in(".implode(',',$cidAry).") order by aid desc limit 0,".$amount);
		}
		else{
            if($startAid == 0){
                $newsAry = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl,essence as orderid,lighten from news_article where delstate=0 and essence>0 order by essence desc limit 0,".$amount);
            }
            else{
                $newsAry = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl,essence as orderid,lighten from news_article where delstate=0 and essence<$startAid and essence>0 order by essence desc limit 0,".$amount);
            }
		}

		$topicCount = ceil($amount/10);
        if($startTopicId>0){
            $topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3 from topic_list where isHot>0 and topic_id<$startTopicId order by priority DESC,topic_id desc limit 0,$topicCount");
        }
        else{
            $topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3 from topic_list where isHot>0 order by priority DESC, topic_id desc limit 0,$topicCount");
        }
        //$topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3,total_nums from topic_list order by topic_id desc limit 0,$topicCount");

		$tmpAry = array();
		$step = 1;
		$i = 0;
		foreach($newsAry as $news_key=>$news){
            if(strlen($news['tourl'])>5){
				if(!strstr($news['tourl'],'http')){
					$news['tourl'] = 'http://'.$news['tourl'];
				}
				$news['outlink'] = $this->doLink($news['tourl']);
				$news['froms'] = $news['outlink']['author'];
            }
            unset($news['tourl']);
			$news['isNews'] = 1;

			if($news['pic']&&$news['pic']!='nopic'){
				if(!strstr($news['pic'],'http')){
					$news['pic'] = "http://www.yeeyi.com/".$news['pic'];
					$news['pic_style'] = 'normal';
				}
			}else{
				if(!strstr($news['pic'],'http')){
					$news['pic'] = "";
					$news['pic_style'] = 'none';
				}
			}
			if($news['lighten']==1 && $news['pic']!=''){
				$news['pic_style'] = 'large';
			}
			$tmpAry[] = $news;
			if(++$step % 10 == 0){
				if(isset($topicAry[$i])) {
					$tmp = array();
					$tmp['isNews'] = 0;
					$tmp['topic_id'] = $topicAry[$i]['topic_id'];
					$tmp['topic_name'] = $topicAry[$i]['topic_name'];
					$tmp['counts'] = $topicAry[$i]['total_nums'];
					$tmpImg = array();
                    if(!strstr($topicAry[$i]['pic1'],'http:')){
                        $topicAry[$i]['pic1'] = 'http://www.yeeyi.com/'.$topicAry[$i]['pic1'];
                    }
                    if(!strstr($topicAry[$i]['pic2'],'http:')){
                        $topicAry[$i]['pic2'] = 'http://www.yeeyi.com/'.$topicAry[$i]['pic2'];
                    }
                    if(!strstr($topicAry[$i]['pic3'],'http:')){
                        $topicAry[$i]['pic3'] = 'http://www.yeeyi.com/'.$topicAry[$i]['pic3'];
                    }
					$tmpImg[] = $topicAry[$i]['pic1'];
					$tmpImg[] = $topicAry[$i]['pic2'];
					$tmpImg[] = $topicAry[$i]['pic3'];
					$tmp['topic_image'] = $tmpImg;
					$tmpAry[] = $tmp;
					$i++;
				}
			}

		}
		$tmpAry = changeCode($tmpAry,'gbk','utf-8');
		$return = array();
		$return['status'] = 2201;
		$return['newslist'] = $tmpAry;
		$return['headnews'] = $hotNews;
		$this->outjson($return);
	}

	/**
	 *新闻内容页
	 */
	function getNewsContent(){
		$aid = intval($this->Post['aid']);
		$newsAry = $this->Db->once_fetch_assoc("select news_article.aid,news_article.cid,news_article.title,froms,editor,pic,description,pubdate,comments,good,content,bancom,type_1,type_2,type_3,type_4,news_view.viewnum2 AS views
            from news_article
            left join news_date
            on news_date.aid=news_article.aid
            left join news_view
            on news_view.aid = news_article.aid
            where news_article.aid=".$aid);
		if($newsAry['aid']<1){
			$return['status'] = 5202;
			$this->outjson($return);
		}
		//更新阅读数
		$this->Db->query("update news_view set viewnum=viewnum+1,viewnum2=viewnum2+1 where aid=".$aid);
		//允许评论
		$newsAry['allowReply'] = '1';
		$newsAry['allowGuest'] = '1';
		//判断是否允许评论
		if($newsAry['bancom'] == 1){
			$newsAry['allowReply'] = '0';
			$newsAry['allowGuest'] = '0';
		}


		$newsAry['url'] = "https://m.yeeyi.com/mobile";
		if($newsAry['pic']){
			if(!strstr($newsAry['pic'],'http')){
				$newsAry['pic'] = 'http://www.yeeyi.com/'.$newsAry['pic'];
			}
		}
		$newsAry['content'] = strip_tags($newsAry['content'],'<p><br><div><img><font><span><iframe><video><audio><embed>');
		//处理内容中的图片
		preg_match_all("/<img.*src=[\'\"]([^\'\"]+)[\'\"].*>/isU",$newsAry['content'],$imgTotalAry);
		$tmpImg = array();
		$tmpReplace = array();
		if(is_array($imgTotalAry[1])){
			foreach($imgTotalAry[1] as $k=>$v){
				if(strstr($v,'http:')){
					if(strstr($v,'http://www.yeeyi.com')){
						$localPath = str_replace("http://www.yeeyi.com/","/home/yeeyico/",$v);
					}
					else{
						continue;
					}
				}
				else{
					$localPath = '/home/yeeyico'.$v;
				}
				$smallPath = $localPath."_for_app.jpg";

				$newImgSrc = str_replace("/home/yeeyico/","https://m.yeeyi.com/",$localPath);
				$newImgSrc = $newImgSrc."_for_app.jpg";
				$newImgStr = "<img src='".$newImgSrc."' />";
				$tmpImg[] = $smallPath;
				$tmpReplace[] = array(
					'pic'=>$smallPath,
					'newImg' => $newImgStr,
					'oldImg' => $imgTotalAry[0][$k]
				);

			}
			//判断图片是否存在
			$existsImg = myFileExists($tmpImg);
			if(is_array($existsImg)){
				foreach($existsImg as $exk=>$exv){
					if($exv['exist']){
						$newsAry['content'] = str_replace($tmpReplace[$exk]['oldImg'],$tmpReplace[$exk]['newImg'],$newsAry['content']);
					}
				}
			}


		}

		//$newsAry['pic'] = $newsAry['pic']."_nl.jpg";
		//$newsAry['pic'] = "http://www.yeeyi.com/".$newsAry['pic'];
		//是否搜藏
		$newsAry['isFavorite'] = 0;
		if(MEMBER_ID>0){
			//uid,id,idtype
			$checkFavoriate = $this->Db->once_fetch_assoc("select * from pre_home_favorite where uid=".MEMBER_ID." and id=".$aid." and idtype='newsid'");
			if($checkFavoriate['id']>0){
				$newsAry['isFavorite'] = 1;
			}
		}


		//话题
		$topic = array();
		$topic['topic_id'] = 0; //没有话题
		$topicInfoTmp = $this->Db->once_fetch_assoc("select topic_list.* from topic_content_list left join topic_list on topic_list.topic_id=topic_content_list.topic_id where topic_content_list.c_aid=".$aid);
		if($topicInfoTmp['topic_id']){
			$topic['topic_id'] = $topicInfoTmp['topic_id'];
			$topic['topic_name'] = $topicInfoTmp['topic_name'];
			$topic['counts'] = intval($topicInfoTmp['total_nums']);
			if(!strstr($topicInfoTmp['pic1'],'http:')){
				$topicInfoTmp['pic1'] = "http://www.yeeyi.com/".$topicInfoTmp['pic1'];
			}
			if(!strstr($topicInfoTmp['pic2'],'http:')){
				$topicInfoTmp['pic2'] = "http://www.yeeyi.com/".$topicInfoTmp['pic2'];
			}
			if(!strstr($topicInfoTmp['pic3'],'http:')){
				$topicInfoTmp['pic3'] = "http://www.yeeyi.com/".$topicInfoTmp['pic3'];
			}

			$topic['topic_pic'] = array($topicInfoTmp['pic1'],$topicInfoTmp['pic2'],$topicInfoTmp['pic3']);
		}
		$newsAry['topic'] = $topic;
		$cid = intval($newsAry['cid']);
		//相关新闻
		$relevantNewsTmp = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl from news_article where cid=".$cid." and aid!=".$aid." order by aid desc limit 0,10");
		$relevantNews = array();
		foreach($relevantNewsTmp as $news){
			$news['isNews'] = 1;

			if(strlen($news['tourl'])>5){
				if(!strstr($news['tourl'],'http')){
					$news['tourl'] = 'http://'.$news['tourl'];
				}
				$news['isNews'] = 0;
				$news['outlink'] = $this->doLink($news['tourl']);
				$news['froms'] = $news['outlink']['author'];
			}
			$relevantNews[] = $news;
		}
		$newsAry['relevantNews'] = $relevantNews;
		$newsAry = changeCode($newsAry);
        if($newsAry['type_1'] == 1){
            $newsAry['content'] .= '<p>*文章内容转载自'.$newsAry['froms'].',不代表亿忆网观点，亿忆网或做细微修改。</p>';
        }
        else if($newsAry['type_2'] == 1){
            $newsAry['content'] .= '<p>*亿忆网独家原创文章，未经许可禁止转载。</p>';
        }
        else if($newsAry['type_3'] == 1){
            $newsAry['content'] .= '<p>*亿忆网编辑报道，未经许可禁止转载。</p>';
        }
        else if($newsAry['type_4'] == 1){
            $newsAry['content'] .= '<p>*本篇文章为突发新闻，亿忆网将持续关注，更新相关报道。</p>';
        }


		$return['status'] = 2202;
		$return['newsInfo'] = $newsAry;


		$newsAry['description'] = str_replace("&nbsp;",'',$newsAry['description']);
		$return['share'] = array(
			'thumbnail'=>$newsAry['pic'],
			'title'=>$newsAry['title'],
			'summary'=>trim(strip_tags($newsAry['description'])),
			'url'=>'https://m.yeeyi.com/mobile/article.php?aid='.$newsAry['aid']
		);
		$this->outjson($return);
	}

	/*
	 * ●	评论id
●	评论人昵称(如果是匿名评论，名称规则：亿亿网友+发评论IP前三段，例如：亿亿网友171.29.27.xxx) username
●	评论人头像（120*120） userface
●	评论时间(时间戳) addtime
●	评论正文（纯文本）content
●	评论引用信息（如果父评论被删除或者被禁，最好给明确的标识） upreply
○	父评论ID
○	父评论用户名
○	父评论正文
○	父评论时间(时间戳)
●	点赞数量
●	网友位置(IP解析后的地址文本，例如：来自山东青岛。如果解析不到地址则显示“来自火星”)(服务器端解决，澳洲这边地址要精确到suburb)

	 *
	 * */

	function getNewsReply(){
		$aid = intval($this->Post['aid']);
		$type = trim($this->Post['type']);
		$rootid = intval($this->Post['rootid']);
		$return = array();
		$replyAry = array();

		$newsInfo = $this->Db->once_fetch_assoc("select * from news_article where aid=".$aid);
		if($newsInfo['bancom'] == 1){
			//禁止评论的，评论列表为空
			$return['status'] = 2203;
			$return['replylist'] = array();
			$this->outjson($return);
		}



		if($rootid>0){
			//获取二级评论
			$startId = intval($this->Post['maxid']);
			$amount = intval($this->Post['amount']);
			//root信息
			$rootAry = $this->Db->once_fetch_assoc("select id,username,userid,content,addtime,up as likes,del_status,address,commnum as replies,state from news_comment where id=".$rootid." and del_status=0 ");
			$rootAry['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$rootAry['userid']."&size=middle";
			if($rootAry['state']>0){
				$rootAry['username'] = changeCode('匿名用户','utf-8','gbk');
				$rootAry['userface'] = "http://center.yeeyi.com/avatar.php?uid=0&size=middle";
			}
			$return['rootReply'] = changeCode($rootAry);
			$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,a.content,a.addtime,a.up as likes,a.del_status,b.id as upid,b.username as upusername,b.addtime as upaddtime,b.del_status as updel_status ,b.content as upcontent ,a.address,a.commnum as replies,a.state,b.state as upstate from news_comment a left join news_comment b on a.replyid=b.id where a.aid=".$aid." and a.rootid=".$rootid."  and a.del_status=0 and a.id>$startId order by a.id asc limit 0,$amount");
			foreach($replyTmp as $reply){
				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['userid'] = $reply['userid'];
				if($reply['state']>0){
					$reply['username'] = changeCode('匿名用户','utf-8','gbk');
					$reply['userid'] = 0;
				}
				$tmp['username'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['addtime'] = $reply['addtime'];

				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['content'] = $reply['content'];
				$tmp['address'] = $reply['address']?$reply['address']:changeCode('火星网友','utf-8','gbk');
				$tmp['replies'] = $reply['replies'];
				$tmp['upid'] = $reply['upid'];
				if($reply['upid'] != $rootid){
					$tmpUp = array();
					$tmpUp['id'] = $reply['upid'];
					if($reply['upstate']>0){
						$reply['upusername'] = changeCode('匿名用户','utf-8','gbk');
					}
					$tmpUp['addtime'] = $reply['upaddtime'];
					$tmpUp['username'] = $reply['upusername'];
					$tmpUp['content'] = $reply['upcontent'];
					$tmp['upreply'] = $tmpUp;

				}
				else{
					unset($tmp['upreply']);
				}
				$replyAry[] = $tmp;

			}
		}
		else if($type == 'hot'){
			//$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,a.content,a.addtime,a.up as likes,a.del_status,b.id as upid,b.username as upusername,b.addtime as upaddtime,b.del_status as updel_status ,b.content as upcontent ,'none' as address ,a.commnum as replies from news_comment a left join news_comment b on a.rootid=b.id where a.aid=".$aid." and a.upid=0 order by a.commnum desc limit 0,5");
			$replyTmp = $this->Db->fetch_all_assoc("select id,username,userid,content,addtime,up as likes,del_status,address,commnum as replies,state from news_comment where aid=".$aid." and rootid=0   and del_status=0 order by commnum desc limit 0,5");
			foreach($replyTmp as $reply){
				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['userid'] = $reply['userid'];
				if($reply['state']>0){
					$reply['username'] = changeCode('匿名用户','utf-8','gbk');
					$reply['userid'] = 0;
				}
				$tmp['username'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['addtime'] = $reply['addtime'];

				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['content'] = $reply['content'];
				$tmp['address'] = $reply['address']?$reply['address']:changeCode('火星网友','utf-8','gbk');
				$tmp['replies'] = $reply['replies'];
				//$tmp['upreply'] = NULL;
				$childReplyTmpAry = $this->Db->fetch_all_assoc("select id,username,userid,content,addtime,up as likes,del_status,address,commnum as replies,state from news_comment where aid=".$aid." and rootid=".$reply['id']."  and del_status=0  order by id");
				$childReply = array();
				foreach($childReplyTmpAry as $creply){
					$tmp2 = array();
					$tmp2['id'] = $creply['id'];
					if($creply['state']>0){
						$creply['username'] = changeCode('匿名用户','utf-8','gbk');
					}
					$tmp2['username'] = $creply['username'];
					$tmp2['likes'] = $creply['likes'];
					$tmp2['addtime'] = $creply['addtime'];
					$tmp2['userid'] = $creply['userid'];
					$tmp2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$creply['userid']."&size=middle";
					$tmp2['content'] = $creply['content'];
					$tmp2['address'] = $creply['address'];
					$tmp2['replies'] = $creply['replies'];
					$childReply[] = $tmp2;
				}
				$tmp['childReply'] = $childReply;
				$replyAry[] = $tmp;
			}

		}
		else if($type == 'all'){
			$startId = intval($this->Post['maxid']);
			$amount = intval($this->Post['amount']);
			//$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,a.content,a.addtime,a.up as likes,a.del_status,b.id as upid,b.username as upusername,b.addtime as upaddtime,b.del_status as updel_status ,b.content as upcontent ,'none' as address ,a.commnum as replies from news_comment a left join news_comment b on a.rootid=b.id where a.aid=".$aid." and a.id>$startId order by a.id asc limit 0,$amount");
			if($startId>0){
				$replyTmp = $this->Db->fetch_all_assoc("select id,username,userid,content,addtime,up as likes,del_status,address,commnum as replies,state from news_comment where aid=".$aid." and rootid=0 and del_status=0 and id>$startId order by id asc limit 0,$amount");
			}
			else{
				$replyTmp = $this->Db->fetch_all_assoc("select id,username,userid,content,addtime,up as likes,del_status,address,commnum as replies,state from news_comment where aid=".$aid." and rootid=0  and del_status=0 order by id asc limit 0,$amount");
			}

			foreach($replyTmp as $reply){
				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['userid'] = $reply['userid'];
				if($reply['state']>0){
					$reply['username'] = changeCode('匿名用户','utf-8','gbk');
					$reply['userid'] = 0;
				}
				$tmp['username'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['addtime'] = $reply['addtime'];

				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['content'] = $reply['content'];
				$tmp['address'] = $reply['address']?$reply['address']:changeCode('火星网友','utf-8','gbk');
				$tmp['replies'] = $reply['replies'];
				//$tmp['upreply'] = NULL;
				$childReplyTmpAry = $this->Db->fetch_all_assoc("select id,username,userid,content,addtime,up as likes,del_status,address,commnum as replies,state from news_comment where aid=".$aid." and rootid=".$reply['id']." and del_status=0 order by id");
				$childReply = array();
				foreach($childReplyTmpAry as $creply){
					$tmp2 = array();
					$tmp2['id'] = $creply['id'];
					if($creply['state']>0){
						$creply['username'] = changeCode('匿名用户','utf-8','gbk');
						$creply['userid'] = 0;
					}
					$tmp2['username'] = $creply['username'];
					$tmp2['likes'] = $creply['likes'];
					$tmp2['addtime'] = $creply['addtime'];
					$tmp2['userid'] = $creply['userid'];
					$tmp2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$creply['userid']."&size=middle";
					$tmp2['content'] = $creply['content'];
					$tmp2['address'] = $creply['address']?$creply['address']:changeCode('火星网友','utf-8','gbk');
					$tmp2['replies'] = $creply['replies'];
					$childReply[] = $tmp2;
				}
				$tmp['childReply'] = $childReply;
				$replyAry[] = $tmp;
			}
		}
		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}
		$return['status'] = 2203;
		$return['replylist'] = changeCode($replyAry);
		$this->outjson($return);
	}

	function doReply(){
		$ip = client_ip();
		$aid = intval($this->Post['aid']);
		$upid = intval($this->Post['upid']);
		$content = trim($this->Post['content']);
		$content = strip_tags($content);
		$content = changeCode($content,'utf-8','gbk');
		if(MEMBER_ID<1){
			$uid = 0;
			$username = '亿忆网友'.substr($ip,0,9);
			$username = changeCode($username,'utf-8','gbk');
		}
		else{
			$uid = MEMBER_ID;
			$username = $this->G['username'];
		}

		//判断新闻是否存在
		$newsInfo = $this->Db->once_fetch_assoc("select * from news_article where aid=".$aid);
		if($newsInfo['aid']<1){
			$return['status'] = 5203;
			$this->outjson($return);
		}

		if($newsInfo['bancom'] == 1){
			$return['status'] = 5204;
			$this->outjson($return);
		}

		if($upid > 0){
			$upIdInfo = $this->Db->once_fetch_assoc("select * from news_comment where id=".$upid);
			if($upIdInfo['rootid']>0){
				$rootid = $upIdInfo['rootid'];
			}
			else{
				$rootid = $upid;
			}
			if($this->G['uid'] == 277390){
				var_dump($upIdInfo);
			}

			if($upIdInfo['userid']>0){

				pushNewsReply($upIdInfo['userid']);
			}
		}
		else{
			$rootid = 0;
		}

		//是否禁止匿名
		//是否禁止评论


		//是否禁止游客评论
		//回复位置
		$devid = trim($this->Post['devid']);
		list($dev,$tmp) = explode('|',$devid);
		$devmd5 = md5($dev);
		$getUserInfo = $this->Db->once_fetch_assoc("select * from app_user_authcode where devmd5='".$devmd5."'");
		$location = trim($getUserInfo['geolocation']);
		$locationAry = explode('|',$location);
		$address = '';
		if(is_array($locationAry)){
			$address = array_pop($locationAry);
			$address = array_pop($locationAry);
		}
		$reprr=array('aid'=>$aid,'ipdress'=>$ip,'address'=>addslashes($address),'userid'=>$this->G['uid'],'username'=>$username,'rootid'=>$rootid,'replyid'=>$upid,'content'=>$content,'addtime'=>time());
		$addResult = $this->Db->insertArr($reprr,'news_comment');
		if($addResult){
			$this->Db->query("update news_article set comments=comments+1 where aid='$aid'");
			if($upid>0){
				$this->Db->query("update news_comment set commnum=commnum+1 where id='$upid'");
				if($rootid>0){
					$this->Db->query("update news_comment set commnum=commnum+1 where id='$rootid'");
				}
			}
			$return['status'] = 2204;
		}
		else {
			$return['status'] = 5207;
		}
		$this->outjson($return);
	}

	function delReply(){
		/*
		 * 删除评论，注意权限判断
		 * */
		$id = intval($this->Post['id']);
		//
		$replyInfo = $this->Db->once_fetch_assoc("select aid from news_comment where id=".$id);
		if($replyInfo['aid']<1){
			$return['status'] = 5208;
			$this->outjson($return);
		}
		$this->Db->query("update news_comment set del_status=1 where id=".$id);
		$this->Db->query("update news_article set comments=comments-1 where aid=".$replyInfo['aid']." and comments>0");
		$return['status'] = 2205;
		$this->outjson($return);
	}

	/*
	 * 收藏
	 * $aid 新闻
	 * */
	function newsFavorite(){
		$aid = intval($this->Post['aid']);
		$newsInfo = $this->Db->once_fetch_assoc("select * from news_article where aid=".$aid);
		if($newsInfo['aid']<1){
			$return['status'] = 5210;
			$this->outjson($return);
		}
		$this->Db->query("insert into pre_home_favorite(uid,id,idtype,title,dateline,description) values('".MEMBER_ID."','".$aid."','newsid','".addslashes($newsInfo['title'])."','".time()."','".addslashes($newsInfo['description'])."')");
		$return['status'] = 2210;
		$this->outjson($return);
	}

	/*
	 *移除收藏
	 * */
	function removeFavorite(){
		$aid = intval($this->Post['aid']);
		$this->Db->query("delete from pre_home_favorite where uid='".MEMBER_ID."' and idtype='newsid' and id=".$aid);
		$return['status'] = 2211;
		$this->outjson($return);
	}

	/*
	 * 爆料
	 * ●	content:爆料正文
●	Contact:联系人
●	Phone：电话
●	QQ:qq号
●	Email：电子邮箱
●	wechat：微信

	 * */
	 function doBaoLiao(){
		 $contact = trim($this->Post['contact']);
		 $phone = $this->Post['phone'];
		 $qq = $this->Post['qq'];
		 $email = $this->Post['email'];
		 $weixin = $this->Post['weixin'];
		 $content = $this->Post['content'];

		 $message = "";
		 $message .= "<p>爆料人:".$contact."</p>";
		 $message .= "<p>电话:".$phone."</p>";
		 $message .= "<p>QQ:".$qq."</p>";
		 $message .= "<p>Email:".$email."</p>";
		 $message .= "<p>微信:".$weixin."</p>";
		 $message .= "<p>内容:".$content."</p>";

		 //发送邮件
		 sendMail('news@e2media.com.au','新闻爆料',$message);

		 //写入数据库
		 $message = changeCode($message,'utf-8','gbk');
		 $username = changeCode($contact,'utf-8','gbk');
		 $time = time();
		 $this->Db->query("insert into `pre_feedback` values('','2','{$username}','{$time}','{$message}','0')");
		 $return['status'] = 2212;
		 $this->outjson($return);
	 }

	/*
	 * 新闻点赞
	 * */
	function newsLike(){
		//$return['status'] = 2700;
		//$return['likeNum'] = mt_rand(10,30);
		//$this->outjson($return);
		$aid = intval($this->Post['aid']);
		$this->Db->query("update news_article set good = good+1 where aid=".$aid);
        $likeAry = $this->Db->once_fetch_assoc("select good as likes from news_article where aid=".$aid);
		$return['status'] = 2700;
        $return['likeNum'] = intval($likeAry['likes']);
		$this->outjson($return);
	}

	/*
	 * 评论点赞
	 * */
	function replyLike(){
		$id = intval($this->Post['id']);
		$this->Db->query("update news_comment set up = up +1 where id=".$id);
        $likeAry = $this->Db->once_fetch_assoc("select up as likes from news_comment where id=".$id);
		$return['status'] = 2700;
        $return['likeNum'] = intval($likeAry['likes']);
		$this->outjson($return);
		/**/
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
