<?php
	//通用费用
	$config['version'] = array(
		'android'=>array('1_1_0',1,'https://m.yeeyi.com/mobile/client/download/android.apk'),
		'ios'=>array('1_1_0',0,'https://itunes.apple.com/us/app/yeeyi-yi-yi-ao-zhou-zui-da/id1157314837?l=zh&ls=1&mt=8'),
	);
	//开屏广告
	$config['splash'] = array(
		array(
			"pic"=>"https://apps.yeeyi.com/public/splash/kp_015.jpg",
			'url'=>'https://www.yeeyi.com/ads/out.php?perm=zhenpinappkaiping',
			'duration'=>5,
		),
//		array(//默认
//			"pic"=>"https://apps.yeeyi.com/public/splash/yeeyi_170613.jpeg",
//			'url'=>'https://m.yeeyi.com',
//			'duration'=>2
//		),
	);
//    新闻广告页
    $config['article_ad']= array(
		'title'=>'28+年英国老牌外汇交易商，30天零交易成本*',
		'pic_style'=>'large',
		'pic'=>'https://apps.yeeyi.com/public/splash/news_005.jpg',
		'froms'=>'CMC Markets',
		'url'=>'https://www.yeeyi.com/ads/out.php?perm=yeeyiAPP',
		'status'=>3,//3有广告,4无广告
		'status_to'=>7,//无广告8，有广告7
	);
    //汇率广告
    $config['rate'] = array(
		'froms'=>'一基金',//客户名称
		'pic'=>'https://apps.yeeyi.com/public/splash/market0825.jpg',//logo
		'url'=>'https://m.yeeyi.com/mobile/?app=topic&act=view&tid=3915668',//跳转地址
		'share'=>array(
			"share_url"=>"http://www.shuitest.com/",
            "share_title"=>"汇率分享标题修改",
			"share_logo"=>"http://116.62.51.6:8005/img/logo/yylogo.png"
		),
		//'interface_url'=>'http://www.yeeyi.com/addon/ad/index_1/rate.txt',//接口地址
	);
