<?php
	//通用费用
	$config['version_default'] = array(
		'android'=>array('1_1_0',1,'https://m.yeeyi.com/mobile/client/download/android.apk'),
		'ios'=>array('1_1_0',0,'https://itunes.apple.com/us/app/yeeyi-yi-yi-ao-zhou-zui-da/id1157314837?l=zh&ls=1&mt=8'),
	);

	//开屏广告
	$config['splash_default'] = array(//you
//		array(777
//			"ad_id"=> 256,
//            "pic"=> "http://yeeyi-ad-center.oss-ap-southeast-2.aliyuncs.com/7501334.png",
//            "duration"=> 5,
//            "share"=>array(
//	            "url"=> "https://www.yeeyi.com/ads/out.php?perm=ubonusappsplashscreen",
//                "title"=> "微奖网2018澳洲华人线上年货节开幕！万份年货大礼免费领!",
//                "summary"=> "微奖网2018澳洲华人线上年货节开幕！万份年货大礼免费领!",
//                "thumbnail"=> "http://www.yeeyi.com/addon/index/images/logo_share.png"
//			),
//            "url"=> "https://www.yeeyi.com/ads/out.php?perm=ubonusappsplashscreen"
//		),
	);

	//汇率广告
	$config['rate_default'] = array(
//		"rate"=> "5.1516/5.0961",   //777
//		"ad_id"=> 156,
//		"froms"=> "嘉信实时汇率",
//		"pic"=> "http://yeeyi-ad-center.oss-ap-southeast-2.aliyuncs.com/jiaxin logo.png",
//		"url"=> "http://www.jxfinance.com.au",
//		'share'=>array(
//			"url"=> "http://www.jxfinance.com.au",
//			"title"=>"嘉信实时汇率",
//			"summary"=> "嘉信实时汇率",
//			"thumbnail"=>"http://ad.yeeyi.com/img/logo/yylogo.png"
//		),
	);

//    新闻广告页
    $config['article_default']= array(
		"news_index"=>array(),   
		"news_3"=>array(
//			"ad_id"=> 257,   //777
//            "title"=> "微奖网2018澳洲华人线上年货节开幕！万份年货大礼免费领！",
//            "froms"=> "微奖网Ubonus",
//            "isAds"=> 1,
//            "url"=> "https://www.yeeyi.com/ads/out.php?perm=ubonusappnewsfeed",
//            "share"=> array(
//	            "url"=> "https://www.yeeyi.com/ads/out.php?perm=ubonusappnewsfeed",
//                "title"=> "微奖网2018澳洲华人线上年货节开幕！万份年货大礼免费领！",
//                "summary"=> "微奖网2018澳洲华人线上年货节开幕！万份年货大礼免费领！",
//                "thumbnail"=> "http://www.yeeyi.com/addon/index/images/logo_share.png"
//			),
//            "pic_style"=> "large",
//            "ad_pic"=> "http://yeeyi-ad-center.oss-ap-southeast-2.aliyuncs.com/690350dasdadadadas.png"
		),
		"news_9"=>array(),

		"news_12"=>array(
//			"ad_id"=> 185,   //777
//            "title"=> "想了解澳洲最新最低的保健品、奶粉价格吗？尽在珍品宝库!",
//            "froms"=> "珍品宝库",
//            "isAds"=> 1,
//            "url"=> "http://www.yeeyi.com/news/index.php?app=home&act=article&aid=201240",
//            "share"=> array(
//	            "url"=> "http://www.yeeyi.com/news/index.php?app=home&act=article&aid=201240",
//                "title"=> "珍品宝库迎双旦节劲爆人气单品惊喜特惠，万人疯抢!！",
//                "summary"=> "珍品宝库迎双旦节劲爆人气单品惊喜特惠，万人疯抢!！",
//                "thumbnail"=> "http://www.yeeyi.com/addon/index/images/logo_share.png"
//			),
//            "pic_style"=> "large",
//            "ad_pic"=> "http://yeeyi-ad-center.oss-ap-southeast-2.aliyuncs.com/珍品3 - Copy - Copy.png"
		),
	);

//    分类广告页
	$config['thread_default']= array(
//		"topic_5"=>array(   //777
//			"ad_id"=> 179,
//			"title"=> "Ausco双旦福利！买公寓，送巴厘岛七天双人游，免三年物业管理费！",
//			"froms"=> "澳斯柯Ausco",
//			"isAds"=> 1,
//			"url"=> "http://www.yeeyi.com/forum/index.php?app=index&act=house",
//			"pic_style"=> "large",
//			"ad_pic"=> "http://yeeyi-ad-center.oss-ap-southeast-2.aliyuncs.com/信息流_690350.png",
//			"share"=>array(
//				"url"=> "http://www.yeeyi.com/forum/index.php?app=index&act=house",
//				"title"=> "Ausco双旦福利！买公寓，送巴厘岛七天双人游，免三年物业管理费！",
//				"summary"=> "Ausco双旦福利！买公寓，送巴厘岛七天双人游，免三年物业管理费！",
//				"thumbnail"=> "http://ad.yeeyi.com/img/logo/yylogo.png"
//			),
//		),
		"topic_10"=>array(),
		"topic_15"=>array(),
	);

//    发现广告页   //发现是测试数据
	$config['find_default']= array(
//		"find_3"=>array(
//			"ad_id"=> 179,
//			"title"=> "澳斯柯（Ausco）房产建筑集团年底回馈客户，无尽豪礼等你来拿",
//			"froms"=> "澳斯柯Ausco",
//			"isAds"=> 1,
//			"url"=> "http://www.yeeyi.com/forum/index.php?app=index&act=house",
//			"pic_style"=> "large",
//			"ad_pic"=> "http://yeeyi-ad-center.oss-ap-southeast-2.aliyuncs.com/ausco690350.png",
//			"share"=>array(
//				"url"=> "http://www.shuitest.com/",
//				"title"=> "新闻第三条分享标题",
//				"summary"=> "新闻第三条分享标题",
//				"thumbnail"=> "http://ad.yeeyi.com/img/logo/yylogo.png"
//			),
//		),
		"find_3"=>array(),
		"find_9"=>array(),
		"find_13"=>array(),
	);