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
		//note by mosagx 2017.7.17
//		if($this->Act == 'getHotNews'){
//			$this->getHotNews();
//		}
//		else
        if($this->Act == 'getNewsList'){
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
		else if($this->Act == 'newsLike'){
			$this->newsLike();
		}
		else if($this->Act == 'replyLike'){
			$this->replyLike();

		}else if ($this->Act == 'searchNews'){
	    $this->searchNews();
    }
    else if ($this->Act == 'sphinxSearch'){
    $this->sphinxSearch();
    }
    else if ($this->Act == 'headNews'){
        $this->headNews();
    }
    else if ($this->Act == 'getHot'){
        $this->getHot();
    }
	}


	function index(){
		die('Error');
	}

	/**
	 * sphinxSearch test
	 * create by mosagx 2017.6.27
	 */
	function sphinxSearch(){
        $keywords = trim($this->Post['keywords']);  //搜索关键字
//	    $keywords = changeCode($keywords, 'utf-8', 'gbk');
        Load::logic("Search");
        $search = new Search();
        $res = $search->searchNews($keywords);
        $return['info'] = $res;
        $return['keywords'] = changeCode($keywords);
        $return['msg'] = 'test from sphinxSearch';
        $this->outjson($return);
    }

    /**
     * searchNews interface
     * create by mosagx 2017.6.22
     */
    function searchNews(){
        $page     = intval($this->Post['page']);    //页码
        $amount   = intval($this->Post['amount']);  //显示条数
        $keywords = trim($this->Post['keywords']);  //搜索关键字
        $keywords = changeCode($keywords, 'utf-8', 'gbk');
        $newsAry  = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,lighten,tourl,essence as orderid from news_article where delstate=0 and essence>0 and title like '%$keywords%' order by essence desc limit " . $amount * ($page - 1) . "," . $amount);
        $topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3,total_nums from topic_list where topic_name like '%$keywords%' order by topic_id desc limit " . $amount * ($page - 1) . "," . $amount);
        $all      = $this->Db->fetch_all_assoc("select aid,froms,tourl,essence as orderid from news_article where delstate=0 and essence>0 and title like '%$keywords%' order by essence desc");
        $page_num = ceil(count($all) / $amount);
        $tmpAry   = array();
        foreach ($newsAry as $news_key => $news) {
            if (strlen($news['tourl']) > 5) {
                if (!strstr($news['tourl'], 'http')) {
                    $news['tourl'] = 'http://' . $news['tourl'];
                }
                $news['outlink'] = $this->doLink($news['tourl']);
                $news['froms']   = $news['outlink']['author'];
            }
            unset($news['tourl']);
            $news['isNews'] = 1;
            if ($news['pic'] && $news['pic'] != 'nopic') {
                if (!strstr($news['pic'], 'http')) {
                    $news['pic']       = "http://www.yeeyi.com/" . $news['pic'];
                    $news['pic_style'] = 'normal';
                }
            } else {
                if (!strstr($news['pic'], 'http')) {
                    $news['pic']       = "";
                    $news['pic_style'] = 'none';
                }
            }
            if ($news['lighten'] == 1 && $news['pic'] != '') {
                $news['pic_style'] = 'large';
            }
            $tmpAry[] = $news;
        }
        foreach ($topicAry as $topic) {
            $tmp                  = array();
            $tmp['isNews']        = 0;
            $tmp['topic_id']      = $topic['topic_id'];
            $tmp['topic_name']    = $topic['topic_name'];
            $tmp['counts']        = $topic['total_nums'];
            $tmp['topic_image'][] = "http://www.yeeyi.com" . $topic['pic1'];
            $tmp['topic_image'][] = "http://www.yeeyi.com" . $topic['pic2'];
            $tmp['topic_image'][] = "http://www.yeeyi.com" . $topic['pic3'];
            $tmpAry[]             = $tmp;
        }
        $tmpAry             = changeCode($tmpAry, 'gbk', 'utf-8');
        $return['status']   = 0;
        $return['newslist'] = $tmpAry;
        $return['page_num'] = $page_num;
        $this->outjson($return);
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

	/* create by mosagx */
	function headNews()
    {
        $headNews          = $this->Db->fetch_all_assoc("select * from news_headnews order by displayorder desc");
        $headNews          = changeCode($headNews, 'gbk', 'utf-8');
        $return['status']  = 0;
        $return['hotNews'] = $headNews;
        $this->outjson($return);
    }

    /* create by mosagx 2017-7-27 */
    function getHot()
    {
        $time              = time() - 604800;
        $hotNews           = $this->Db->fetch_all_assoc("select aid,title,lighten from news_article where delstate=0 and pubdate>" . $time . " order by comments desc,pubdate desc limit 8");
        $hotNews           = changeCode($hotNews, 'gbk', 'utf-8');
        $return['status']  = 0;
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
			$newsAry = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl,aid as orderid,lighten from news_article where ".$whereAid." cid in(".implode(',',$cidAry).") order by pubdate desc limit 0,".$amount);
		}
		else{
            if($startAid == 0){
                $newsAry = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl,essence as orderid,lighten from news_article where delstate=0 and essence>0 order by essence desc limit 0,".$amount);
            }
            else{
                $newsAry = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl,essence as orderid,lighten from news_article where delstate=0 and essence<$startAid and essence>0 order by essence desc limit 0,".$amount);
            }
		}
//		$newsAry = changeCode($newsAry,'gbk','utf-8');
//		var_dump($newsAry);exit;      

		$topicCount = ceil($amount/10);
        if($startTopicId>0){
            $topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3 from topic_list where isHot>0 and topic_id<$startTopicId order by priority DESC,topic_id desc limit 0,$topicCount");
        }
        else{
            $topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3 from topic_list where isHot>0 order by priority DESC, topic_id desc limit 0,$topicCount");
        }
        //$topicAry = $this->Db->fetch_all_assoc("select topic_id,topic_name,pic1,pic2,pic3,total_nums from topic_list order by topic_id desc limit 0,$topicCount");

		$tmpAry = array();
		$immedia_temp = 1;
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


			if($immedia_temp==3 && $cid==0 && $startAid==0 && $this->Config['article_ad']['status']==3){//广告
				$ad = array();
				$ad['title'] = $this->Config['article_ad']['title'];
				$ad['pic'] = $this->Config['article_ad']['pic'];
				$ad['froms'] = $this->Config['article_ad']['froms'];
				$ad['url'] = $this->Config['article_ad']['url'];
				$ad['pic_style'] = $this->Config['article_ad']['pic_style'];
				$ad['isAds'] = 1;
				$ad = changeCode($ad,'utf-8','gbk');
				$tmpAry[] = $ad;
			}
			if($immedia_temp==4 && $cid==0){//无广告4，有广告3
				if(isset($topicAry[0])) {
					$tmp = array();
					$tmp['isNews'] = 0;
					$tmp['topic_id'] = $topicAry[0]['topic_id'];
					$tmp['topic_name'] = $topicAry[0]['topic_name'];
					$tmp['counts'] = $topicAry[0]['total_nums'];
					$tmpImg = array();
					if(!strstr($topicAry[0]['pic1'],'http:')){
						$topicAry[0]['pic1'] = 'http://www.yeeyi.com/'.$topicAry[0]['pic1'];
					}
					if(!strstr($topicAry[0]['pic2'],'http:')){
						$topicAry[0]['pic2'] = 'http://www.yeeyi.com/'.$topicAry[0]['pic2'];
					}
					if(!strstr($topicAry[0]['pic3'],'http:')){
						$topicAry[0]['pic3'] = 'http://www.yeeyi.com/'.$topicAry[0]['pic3'];
					}
					$tmpImg[] = $topicAry[0]['pic1'];
					$tmpImg[] = $topicAry[0]['pic2'];
					$tmpImg[] = $topicAry[0]['pic3'];
					$tmp['topic_image'] = $tmpImg;
					$tmpAry[] = $tmp;
				}
			}
			if($immedia_temp==9 && $cid==0){//无广告8，有广告7
				if(isset($topicAry[1])) {
					$tmp = array();
					$tmp['isNews'] = 0;
					$tmp['topic_id'] = $topicAry[1]['topic_id'];
					$tmp['topic_name'] = $topicAry[1]['topic_name'];
					$tmp['counts'] = $topicAry[1]['total_nums'];
					$tmpImg = array();
					if(!strstr($topicAry[1]['pic1'],'http:')){
						$topicAry[1]['pic1'] = 'http://www.yeeyi.com/'.$topicAry[1]['pic1'];
					}
					if(!strstr($topicAry[1]['pic2'],'http:')){
						$topicAry[1]['pic2'] = 'http://www.yeeyi.com/'.$topicAry[1]['pic2'];
					}
					if(!strstr($topicAry[1]['pic3'],'http:')){
						$topicAry[1]['pic3'] = 'http://www.yeeyi.com/'.$topicAry[1]['pic3'];
					}
					$tmpImg[] = $topicAry[1]['pic1'];
					$tmpImg[] = $topicAry[1]['pic2'];
					$tmpImg[] = $topicAry[1]['pic3'];
					$tmp['topic_image'] = $tmpImg;
					$tmpAry[] = $tmp;
				}
			}
			$immedia_temp++;
		}

		$tmpAry = changeCode($tmpAry,'gbk','utf-8');

        /* add news advertise */
        if ($startAid == 0) {
            $news_ad = get_ad('news',['channel'=>$cid]);
            if ($news_ad['status'] == 1){
                $advertises = $news_ad['data'];
                $i = 0;
                if ($advertises['news_index']){
                    $arr[] = $advertises['news_index'];
					add_show($advertises['news_index']['ad_id']);
                    array_splice($tmpAry, 0, 0, $arr);
                    $i++;
                    unset($arr);
                }
                if ($advertises['news_3']){
                    $arr[] = $advertises['news_3'];
					add_show($advertises['news_3']['ad_id']);
                    array_splice($tmpAry, $i+3, 0, $arr);
                    $i++;
                    unset($arr);
                }
                if ($advertises['news_9']){
                    $arr[] = $advertises['news_9'];
					add_show($advertises['news_9']['ad_id']);
                    array_splice($tmpAry, $i+9, 0, $arr);
                    $i++;
                    unset($arr);
                }
                if ($advertises['news_12']){
                    $arr[] = $advertises['news_12'];
					add_show($advertises['news_12']['ad_id']);
                    array_splice($tmpAry, $i+12, 0, $arr);
                    $i++;
                    unset($arr);
                }
            }
        }
        /* end news advertise add */



		$return = array();
		$return['status'] = 0;
		$return['newslist'] = $tmpAry;
		$this->outjson($return);
	}

	/**
	 *新闻内容页
	 */
	function getNewsContent(){
		$aid = intval($this->Post['aid']);
		$newsAry = $this->Db->once_fetch_assoc("select news_article.aid,news_article.pic,news_article.lighten,news_article.cid,news_article.title,froms,editor,pic,description,pubdate,comments,good,content,bancom,type_1,type_2,type_3,type_4,news_view.viewnum2 AS views
            from news_article
            left join news_date
            on news_date.aid=news_article.aid
            left join news_view
            on news_view.aid = news_article.aid
            where news_article.aid=".$aid);

		// add by chen at 2017-11-9
        if($newsAry['pic']&&$newsAry['pic']!='nopic'){

        }
        if($newsAry['pic']&&$newsAry['pic']!='nopic'){
            if(!strstr($newsAry['pic'],'http')){
                $newsAry['pic_style'] = 'normal';
            }
        }else{
            if(!strstr($newsAry['pic'],'http')){
                $newsAry['pic_style'] = 'none';
            }
        }
        if($newsAry['lighten']==1 && $newsAry['pic']!=''){
            $newsAry['pic_style'] = 'large';
        }
        // --- end add

		if($newsAry['aid']<1){
			$return['status'] = 1;
			$return['message'] = "内容不存在或已被删除";
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

		//print_r(changeCode($newsAry['content']));die;
		/* edit by allen qu 2017.05.09 a标签也必须保留 */
		/* edit by mosagx 2017.08.28 保留strong标签 */
		$newsAry['content'] = strip_tags($newsAry['content'],'<strong><a><p><br><div><img><font><span><iframe><video><audio><embed>');
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
				/* 2017.05.08 edit by allen qu 因app无法显示gif动态图, 所以把该句屏蔽掉 */
				//$newImgSrc = $newImgSrc."_for_app.jpg";
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
		/* 2017.06.13 edit by allen qu 已删除的不显示在列表里 */
		$relevantNewsTmp = $this->Db->fetch_all_assoc("select aid,title,pic,description,pubdate,froms,tourl from news_article where cid=".$cid." and aid!=".$aid." and delstate != 1 order by aid desc limit 0,10");
		$relevantNews = array();
		foreach($relevantNewsTmp as $news){
			$news['isNews'] = 1;

			if($news['pic'] == 'nopic' || $news['pic'] ==''){
			    $news['pic'] = 'https://apps.yeeyi.com/public/splash/zhantiinfo.jpg';
            }
			if(strlen($news['tourl'])>5){
				if(!strstr($news['tourl'],'http')){
					$news['tourl'] = 'http://'.$news['tourl'];
				}
				$news['isNews'] = 1;
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


		$return['status'] = 0;
		$return['newsInfo'] = $newsAry;

		/* 2017.05.09 edit by allen qu 因为后台删除留言没有修改留言的数目, 造成文章表comments字段不准确, 这里查询一次 文章的评论数 */
		/* 2017.06.12 edit by allen qu 把rootid=0的限制去掉 */
		$replyCount = $this->Db->once_fetch_assoc("SELECT COUNT(*) as counts from news_comment where aid=".$aid." and del_status=0");
		$return['replyCount'] = $replyCount['counts'];

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
			$return['status'] = 0;
			$return['replylist'] = array();
			$this->outjson($return);
		}

		if($rootid>0){

            // 修复commnum错误问题
            $this->fix_reply_num($rootid);

			//获取二级评论
			$startId = intval($this->Post['maxid']);
			$amount = intval($this->Post['amount']);
			//root信息
			$rootAry = $this->Db->once_fetch_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,a.address,a.commnum as replies,a.state from news_comment a left join pre_common_member m on a.userid = m.uid where a.id=".$rootid." and a.del_status=0 ");
			$rootAry['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$rootAry['userid']."&size=middle";
			if($rootAry['state']>0){
				$rootAry['username'] = changeCode('匿名用户','utf-8','gbk');
				$rootAry['userface'] = "http://center.yeeyi.com/avatar.php?uid=0&size=middle";
			}
			/*过滤禁言*/
			if ($rootAry['groupid'] == 4) {

				$rootAry['content'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
			}

            /* add by chen at 2017-11-08 */
            $rootAry['title'] = $newsInfo['title'];
            if($newsInfo['pic'] != ''){
                $rootAry['pic'] ='http://www.yeeyi.com'.$newsInfo['pic'];
            }else{
                $rootAry['pic'] = '';
            }
            /* end add */

			$return['rootReply'] = changeCode($rootAry);

			$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid, m.groupid, a.content,a.addtime,a.up as likes,a.del_status,b.id as upid,b.username as upusername,b.addtime as upaddtime,b.del_status as updel_status ,b.content as upcontent ,a.address,a.commnum as replies,a.state,b.state as upstate from news_comment a left join news_comment b on a.replyid=b.id left join pre_common_member m on a.userid = m.uid where a.aid=".$aid." and a.rootid=".$rootid."  and a.del_status=0 and a.id>$startId order by a.id asc limit 0,$amount");

			foreach($replyTmp as $reply){

				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['userid'] = $reply['userid'];
				$tmp['groupid'] = $reply['groupid'];
				if($reply['state']>0){
					$reply['username'] = changeCode('匿名用户','utf-8','gbk');
					$reply['userid'] = 0;
				}
				$tmp['username'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['addtime'] = $reply['addtime'];

				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['content'] = $reply['content'];

				$addr = "";
				if (isset($reply['address'])) {
					$addr = explode("|", $reply['address']);
					array_pop($addr);
					$addr = implode(",", $addr);
				}

				/* 国外地址倒序 create by chen at 2017-7-28 */
				if (!$addr){
				    $tmp['address'] = changeCode('火星网友','utf-8','gbk');
                }
                if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
                    $add_arr = explode(',', $addr);
                    if (count($add_arr)>2){
                        array_pop($add_arr);
                    }
                    $new_arr = array_reverse($add_arr);
				    $tmp['address'] = implode(",", $new_arr);

                }else{
                    $tmp['address'] = $addr;
                }

//				$tmp['address'] = $addr? $addr: changeCode('火星网友','utf-8','gbk');
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
			$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid, m.groupid, a.content,a.addtime,a.up as likes,a.del_status,a.address,a.commnum as replies,a.state from news_comment a left join pre_common_member m on m.uid = a.userid  where a.aid=".$aid." and a.rootid=0   and a.del_status=0 order by a.commnum desc limit 0,5");
			foreach($replyTmp as $reply){

                // 修复commnum错误问题
                $this->fix_reply_num($reply['id']);

				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['userid'] = $reply['userid'];
				$tmp['groupid'] = $reply['groupid'];
				if($reply['state']>0){
					$reply['username'] = changeCode('匿名用户','utf-8','gbk');
					$reply['userid'] = 0;
				}
				$tmp['username'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['addtime'] = $reply['addtime'];

				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['content'] = $reply['content'];

				$addr = "";
				if (isset($reply['address'])) {
					$addr = explode("|", $reply['address']);
					array_pop($addr);
					$addr = implode(",", $addr);
				}

                /* 国外地址倒序 create by chen at 2017-7-28 */
                if (!$addr){
                    $tmp['address'] = changeCode('火星网友','utf-8','gbk');
                }
                if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
                    $add_arr = explode(',', $addr);
                    if (count($add_arr)>2){
                        array_pop($add_arr);
                    }
                    $new_arr = array_reverse($add_arr);
                    $tmp['address'] = implode(",", $new_arr);

                }else{
                    $tmp['address'] = $addr;
                }

//				$tmp['address'] = $addr? $addr: changeCode('火星网友','utf-8','gbk');
				$tmp['replies'] = $reply['replies'];
				//$tmp['upreply'] = NULL;
				$childReplyTmpAry = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,a.address,a.commnum as replies,a.state from news_comment a left join pre_common_member m on m.uid = a.userid  where a.aid=".$aid." and a.rootid=".$reply['id']."  and a.del_status=0  order by a.id");
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
					$tmp2['groupid'] = $creply['groupid'];
					$tmp2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$creply['userid']."&size=middle";
					$tmp2['content'] = $creply['content'];

					$addr = "";
					if (isset($creply['address'])) {
						$addr = explode("|", $creply['address']);
						array_pop($addr);
						$addr = implode(",", $addr);
					}

                    /* 国外地址倒序 create by chen at 2017-7-28 */
                    if (!$addr){
                        $tmp['address'] = changeCode('火星网友','utf-8','gbk');
                    }
                    if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
                        $add_arr = explode(',', $addr);
                        if (count($add_arr)>2){
                            array_pop($add_arr);
                        }
                        $new_arr = array_reverse($add_arr);
                        $tmp['address'] = implode(",", $new_arr);

                    }else{
                        $tmp['address'] = $addr;
                    }

//					$tmp2['address'] = $addr? $addr: changeCode('火星网友','utf-8','gbk');
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
				$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,a.address,a.commnum as replies,a.state from news_comment a left join pre_common_member m on m.uid = a.userid where a.aid=".$aid." and a.rootid=0 and a.del_status=0 and a.id<$startId order by a.id asc limit 0,$amount");
			}
			else{
				$replyTmp = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,a.address,a.commnum as replies,a.state from news_comment a left join pre_common_member m on m.uid = a.userid where a.aid=".$aid." and a.rootid=0 and a.del_status=0 order by a.id asc limit 0,$amount");
			}

			foreach($replyTmp as $reply){

                // 修复commnum错误问题
                $this->fix_reply_num($reply['id']);

				$tmp = array();
				$tmp['id'] = $reply['id'];
				$tmp['userid'] = $reply['userid'];
				$tmp['groupid'] = $reply['groupid'];
				if($reply['state']>0){
					$reply['username'] = changeCode('匿名用户','utf-8','gbk');
					$reply['userid'] = 0;
				}
				$tmp['username'] = $reply['username'];
				$tmp['likes'] = $reply['likes'];
				$tmp['addtime'] = $reply['addtime'];

				$tmp['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['userid']."&size=middle";
				$tmp['content'] = $reply['content'];

				$addr = "";
				if (isset($reply['address'])) {
					$addr = explode("|", $reply['address']);
					array_pop($addr);
					$addr = implode(",", $addr);
				}

                /* 国外地址倒序 create by chen at 2017-7-28 */
                if (!$addr){
                    $tmp['address'] = changeCode('火星网友','utf-8','gbk');
                }
                if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
                    $add_arr = explode(',', $addr);
                    if (count($add_arr)>2){
                        array_pop($add_arr);
                    }
                    $new_arr = array_reverse($add_arr);
                    $tmp['address'] = implode(",", $new_arr);

                }else{
                    $tmp['address'] = $addr;
                }

//				$tmp['address'] = $addr? $addr: changeCode('火星网友','utf-8','gbk');
				$tmp['replies'] = $reply['replies'];
				//$tmp['upreply'] = NULL;
				$childReplyTmpAry = $this->Db->fetch_all_assoc("select a.id,a.username,a.userid,m.groupid,a.content,a.addtime,a.up as likes,a.del_status,a.address,a.commnum as replies,a.state from news_comment a left join pre_common_member m on m.uid = a.userid where a.aid=".$aid." and a.rootid=".$reply['id']." and a.del_status=0 order by a.id");
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
					$tmp2['groupid'] = $creply['groupid'];
					$tmp2['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$creply['userid']."&size=middle";
					$tmp2['content'] = $creply['content'];

					$addr = "";
					if (isset($creply['address'])) {
						$addr = explode("|", $creply['address']);
						array_pop($addr);
						$addr = implode(",", $addr);
					}

                    /* 国外地址倒序 create by chen at 2017-7-28 */
                    if (!$addr){
                        $tmp2['address'] = changeCode('火星网友','utf-8','gbk');
                    }
                    if (preg_match('/[a-zA-Z]/',$addr)||strpos($addr,'澳')){
                        $add_arr = explode(',', $addr);
                        if (count($add_arr)>2){
                            array_pop($add_arr);
                        }
                        $new_arr = array_reverse($add_arr);
                        $tmp2['address'] = implode(",", $new_arr);

                    }else{
                        $tmp2['address'] = $addr;
                    }

//					$tmp2['address'] = $addr? $addr: changeCode('火星网友','utf-8','gbk');
					$tmp2['replies'] = $creply['replies'];
					$childReply[] = $tmp2;
				}
				$tmp['childReply'] = $childReply;
				$replyAry[] = $tmp;
			}
		}

		foreach ($replyAry as $k=>$reply)
		{
			/* 禁言人的评论不显示 */
			if ($reply['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$replyAry[$k]['content'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');

				}
			}

			if ($reply['childReply']['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$replyAry[$k]['childReply']['content'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}

			if ($reply['upreply']['groupid'] == 4) {

				if (!in_array(MEMBER_GROUP, array(1, 2))) {

					$replyAry[$k]['upreply']['content'] = changeCode('提示:作者被禁止或删除,内容自动屏蔽','utf-8','gbk');
				}
			}
		}


		if(in_array(MEMBER_GROUP,array(1,2))){
			$return['isAdmin'] = 1;
		}
		else{
			$return['isAdmin'] = 0;
		}
		$return['status'] = 0;
//        var_dump($replyAry);
		$return['replylist'] = changeCode($replyAry);

		$this->outjson($return);
	}

	function doReply(){
		$ip = client_ip();
		$aid = intval($this->Post['aid']);
		$upid = intval($this->Post['upid']);
		$pluid = intval($this->Post['uid']);//新增评论人的uid
		$content = trim($this->Post['content']);
		$content = strip_tags($content);
		$content = changeCode($content,'utf-8','gbk');
		$location = trim($this->Post['location']);
		$location = changeCode($location,'utf-8','gbk');
        $fromuid  = intval($this->Post['fromuid']);

//		if(MEMBER_ID < 1){
//			$return['status'] = 1;
//			$return['message'] = '未登录';
//			$this->outjson($return);
//		}
		/* 2017.06.20 edit by allen qu 禁言不能发帖 */
		/*
		if (MEMBER_GROUP == 4) {

			$return['status'] = 10003;
			$return['message'] = '抱歉，您的账号已被禁止评论，请联系管理员解禁';
			$this->outjson($return);
		}
		*/

		if(MEMBER_ID<1){
			$uid = 0;
			$username = '亿忆网友'.substr($ip,0,9);
			$username = changeCode($username,'utf-8','gbk');
		}
		else{
			$uid = MEMBER_ID;

			/* 2017.05.16 edit by allen qu  这里改用member_name */
			//$username = $this->G['username'];
			$username = changeCode(MEMBER_NAME, 'utf-8', 'gbk');

			/* 2017.06.07 edit by allen qu 30秒内不能评论同一篇新闻 */

			$lastArticleReply = getVar('last_article_reply_'.$aid.'_'.MEMBER_ID);

			if(time()<$lastArticleReply){
				$return['status'] = 5101;
				//$return['time'] = ceil(($lastArticleReply - time()) / 60);
				$return['message'] = '30秒内不得重复回复同一新闻';
				$this->outjson($return);

			}else {
				$nexttime = time() + 30;
				setVar('last_article_reply_'.$aid.'_'.MEMBER_ID,$nexttime);
			}
			/* edit end */
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
			/*
			if($this->G['uid'] == 277390){
				var_dump($upIdInfo);
			}
			*/

			if($upIdInfo['userid']>0){

				pushNewsReply($upIdInfo['userid']);
			}
		}
		else{
			$rootid = 0;
		}

		$reprr=array('aid'=>$aid,'ipdress'=>$ip,'address'=>$location,'userid'=>$this->G['uid'],'username'=>$username,'rootid'=>$rootid,'replyid'=>$upid,'content'=>$content,'addtime'=>time());
		$addResult = $this->Db->insertArr($reprr,'news_comment');
		if($addResult){
			$this->Db->query("update news_article set comments=comments+1 where aid='$aid'");
			if($upid>0){

				$this->Db->query("update news_comment set commnum=commnum+1 where id='$upid'");
				// delete by chen at 2017-11-14
//				if($rootid>0){
//					$this->Db->query("update news_comment set commnum=commnum+1 where id='$rootid'");
//				}
			}
			$return['status']  = 0;
			$return['message'] = '评论成功';
		}
		else {
			$return['status'] = 5207;
		}

		if (MEMBER_ID > 0) {

			/* 2017.06.07 edit by allen qu  新闻评论增加12YB */
			$this->Db->query("update pre_common_member_count set extcredits2 = extcredits2 + 12 where uid=".MEMBER_ID);//增加12yb
			//$return['yb_message'] = changeCode('评论成功, 金钱+12YB', 'utf-8', 'gbk');
			$return['message'] = '评论成功, 金钱+12YB';

		}
//		$this->outjson($return);
//		header("Content-type: application/json");
//		echo json_encode($return);
        if ($upid > 0) {
            /* 添加推送 create by chen */
            Load::functions('getui');
            $push['template']         = "transmission";
            $push['message']['title'] = "";
            $cont['action']           = "my_message";
            $cont['id']               = "2";
            $cont['title']            = "收到一条新评论";
            $this->Db->query("INSERT INTO yeeyico_new.app_unread_msg_record values('','{$fromuid}','{$pluid}','2')");
            $up = $this->Db->once_fetch_assoc("select * from app_user_getui_client where uid=" . $fromuid);
            if ($this->G['uid'] != $fromuid) {
                if ($up['uid'] > 0 && $up['client_id'] != "") {
                    $push['cid']                = $up['client_id'];
                    $push['message']['content'] = json_encode($cont);
                    $push['message']['body']    = "收到一条新评论";
                    pushMessageToSingle($push);
                }
            }
        }
        $this->outjson($return);
	}

	function delReply(){
		/*
		 * 删除评论，注意权限判断
		 * */

		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		$id = intval($this->Post['id']);
		//
		$replyInfo = $this->Db->once_fetch_assoc("select aid from news_comment where id=".$id);
		if($replyInfo['aid']<1){
			$return['status'] = 5208;
			$this->outjson($return);
		}
		$this->Db->query("update news_comment set del_status=1 where id=".$id);
		$this->Db->query("update news_article set comments=comments-1 where aid=".$replyInfo['aid']." and comments>0");
		$return['status'] = 0;
		$this->outjson($return);
	}

	/*
	 * 收藏
	 * $aid 新闻
	 * */
	function newsFavorite(){
		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		$aid = intval($this->Post['aid']);
		$newsInfo = $this->Db->once_fetch_assoc("select * from news_article where aid=".$aid);
		if($newsInfo['aid']<1){
			$return['status'] = 5210;
			$this->outjson($return);
		}
		$this->Db->query("insert into pre_home_favorite(uid,id,idtype,title,dateline,description) values('".MEMBER_ID."','".$aid."','newsid','".addslashes($newsInfo['title'])."','".time()."','".addslashes($newsInfo['description'])."')");
		$return['status'] = 0;
		$this->outjson($return);
	}

	/*
	 *移除收藏
	 * */
	function removeFavorite(){
		if(MEMBER_ID < 1){
			$return['status'] = 1;
			$return['message'] = '未登录';
			$this->outjson($return);
		}

		$aid = intval($this->Post['aid']);
		$this->Db->query("delete from pre_home_favorite where uid='".MEMBER_ID."' and idtype='newsid' and id=".$aid);
		$return['status'] = 0;
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
		$return['status'] = 0;
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
		$return['status'] = 0;
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

    /**
     * fix reply num problem for version < 1.9
     * crete by chen at 2017-11-13
     * @param $rootId
     */
	function fix_reply_num($rootId){
        $rootReply = $this->Db->fetch_all_assoc("SELECT id FROM `news_comment` where del_status=0 and rootid=".$rootId);
        $rootInfo = $this->Db->once_fetch_assoc("select * from `news_comment` where id=".$rootId);
        $replyNum  = count($rootReply);
        if ($rootInfo['commnum'] != $replyNum){
            $this->Db->query("update `news_comment` set commnum=".$replyNum." where id=".$rootId);
        }
    }

	/**
	 * @增加广告的曝光量
	 */
	function add_shownums($ad_id){
		$created_at = time();
		$this->Db->query("INSERT INTO yeeyico_new.adver_show values('','{$ad_id}','{$created_at}')");
	}

}
