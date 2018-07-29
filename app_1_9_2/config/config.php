<?php
date_default_timezone_set('Australia/Melbourne');
$config = array(
    'dbhost'      => 'localhost',
    'dbname'      => 'yeeyico_new', //需要修改
    'dbpass'      => '85nsxcNTpqatjcfQ', //需要修改
    'dbuser'      => 'yeeyico_yicoeei', //需要修改
    'charset'     => 'utf-8',
    'memHost'     => '127.0.0.1',
    'memPost'     => '11888',
    'get_ad_host' => 'http://116.62.51.6:8005/api/get_ad', //广告获取api地址
);

/**
 * 删帖 delList
 * 锁定 lockList
 * 禁言 denyList
 * 举报 reportList
 */

$config['reportList'] = array(
    array('违规广告', '违规广告'),
    array('发布内容与话题不符', '发布内容与话题不符'),
    array('涉嫌发布虚假信息', '涉嫌发布虚假信息'),
    array('重复发帖', '重复发帖'),
    array('恶意灌水', '恶意灌水'),
    array('色情低俗', '色情低俗'),
    array('禁止曝光隐私信息', '禁止曝光隐私信息'),
);

$config['articleReportList'] = array(

    array('1', '色情淫秽'),
    array('2', '骚扰谩骂'),
    array('3', '广告欺诈'),
    array('4', '反动'),
    array('5', '其他'),

);

//话题板块对应
$config['hot_forum'] = array(
    array(
        'forum_name'  => '同城生活',
        'fid'         => 92,
        'fid_in'      => '92',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '同城互助，分享生活资讯',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '休闲旅游',
        'fid'         => 619,
        'fid_in'      => '619',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '诗和远方',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '澳洲校园',
        'fid'         => 294,
        'fid_in'      => '294',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '校园里的新鲜事儿',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '家在澳洲',
        'fid'         => 732,
        'fid_in'      => '732',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '澳洲置业资讯交流',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '车迷天下',
        'fid'         => 319,
        'fid_in'      => '319',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '侃车秀座驾',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '宠物之家',
        'fid'         => 318,
        'fid_in'      => '318',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '铲屎官集中营',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '留学移民',
        'fid'         => 93,
        'fid_in'      => '93',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '留学和移民澳洲的那些事儿',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '不吐不快',
        'fid'         => 646,
        'fid_in'      => '646',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '有什么不痛快的，说来听听？',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '谈婚论嫁',
        'fid'         => 606,
        'fid_in'      => '606',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '聊聊婚嫁及周边事宜',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '美食厨房',
        'fid'         => 36,
        'fid_in'      => '36',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '秀美食，晒厨艺',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '雅思翻译',
        'fid'         => 269,
        'fid_in'      => '269',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '英语学习和考试准备',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '投资创业',
        'fid'         => 309,
        'fid_in'      => '309',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '投资与创业信息交流',
        'views'       => '10',
    ),

    array(

        'forum_name'  => '同城交友',
        'fid'         => 277,
        'fid_in'      => '277',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '同城交友，分享生活资讯',
        'views'       => '10',
    ),

);

$config['other_forum'] = array(
    array(
        'forum_name'  => '情感世界',
        'fid'         => 212,
        'fid_in'      => '212',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '谈谈情，说说爱',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '家庭亲子',
        'fid'         => 313,
        'fid_in'      => '313',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '家长里短，带娃心得',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '摄影自拍',
        'fid'         => 15,
        'fid_in'      => '15',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '澳洲摄影爱好者聚集地',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '电竞动漫',
        'fid'         => 240,
        'fid_in'      => '240',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '游戏迷、动漫迷看过来',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '团购打折',
        'fid'         => 325,
        'fid_in'      => '325',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '本地折扣信息一网打尽',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '休闲运动',
        'fid'         => 310,
        'fid_in'      => '310',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '休闲活动组织交流',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '潮流风尚',
        'fid'         => 268,
        'fid_in'      => '268',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '美肤护肤、时尚穿搭秀场',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '数码广场',
        'fid'         => 602,
        'fid_in'      => '602',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '数码产品及周边',
        'views'       => '10',
    ),
    array(
        'forum_name'  => 'E2吧',
        'fid'         => 217,
        'fid_in'      => '217',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '闲聊和灌水专区',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '三国杀',
        'fid'         => 327,
        'fid_in'      => '327,638,636,637,639',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '桌游组织和讨论',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '意见反馈',
        'fid'         => 234,
        'fid_in'      => '234',
        'isPhone'     => 0, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '问题反馈和意见征集',
        'views'       => '10',
    ),

);

/*edit by allen qu  2017.04.17 app需要获取topic的description */

/* 2017.05.19 edit by allen qu isPhone都改为1 */
$config['topic_list'] = array(

    92  => array(
        'forum_name'  => '同城生活',
        'fid'         => 92,
        'fid_in'      => '92',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '同城互助，分享生活资讯',
        'views'       => '10',
    ),

    277 => array(

        'forum_name'  => '同城交友',
        'fid'         => 277,
        'fid_in'      => '277',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '同城交友，分享生活资讯',
        'views'       => '10',
    ),

    646 => array(
        'forum_name'  => '不吐不快',
        'fid'         => 646,
        'fid_in'      => '646',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '有什么不痛快的，说来听听？',
        'views'       => '10',
    ),
    212 => array(
        'forum_name'  => '情感世界',
        'fid'         => 212,
        'fid_in'      => '212',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '谈谈情，说说爱',
        'views'       => '10',
    ),
    606 => array(
        'forum_name'  => '谈婚论嫁',
        'fid'         => 606,
        'fid_in'      => '606',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '聊聊婚嫁及周边事宜',
        'views'       => '10',
    ),
    732 => array(
        'forum_name'  => '家在澳洲',
        'fid'         => 732,
        'fid_in'      => '732',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '澳洲置业资讯交流',
        'views'       => '10',
    ),
    313 => array(
        'forum_name'  => '家庭亲子',
        'fid'         => 313,
        'fid_in'      => '313',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '家长里短，带娃心得',
        'views'       => '10',
    ),
    36  => array(
        'forum_name'  => '美食厨房',
        'fid'         => 36,
        'fid_in'      => '36',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '秀美食，晒厨艺',
        'views'       => '10',
    ),
    318 => array(
        //修改
        'forum_name'  => '宠物之家',
        'fid'         => 318,
        'fid_in'      => '318',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '铲屎官集中营',
        'views'       => '10',
    ),
    294 => array(
        'forum_name'  => '澳洲校园',
        'fid'         => 294,
        'fid_in'      => '294',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '校园里的新鲜事儿',
        'views'       => '10',
    ),
    269 => array(
        'forum_name'  => '雅思翻译',
        'fid'         => 269,
        'fid_in'      => '269',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '英语学习和考试准备',
        'views'       => '10',
    ),
    93  => array(
        'forum_name'  => '留学移民',
        'fid'         => 93,
        'fid_in'      => '93',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '留学和移民澳洲的那些事儿',
        'views'       => '10',
    ),
    309 => array(
        'forum_name'  => '投资创业',
        'fid'         => 309,
        'fid_in'      => '309',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '投资与创业信息交流',
        'views'       => '10',
    ),
    310 => array(
        'forum_name'  => '休闲运动',
        'fid'         => 310,
        'fid_in'      => '310',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '休闲活动组织交流',
        'views'       => '10',
    ),
    619 => array(
        'forum_name'  => '休闲旅游',
        'fid'         => 619,
        'fid_in'      => '619',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '诗和远方',
        'views'       => '10',
    ),
    319 => array(
        'forum_name'  => '车迷天下',
        'fid'         => 319,
        'fid_in'      => '319',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '侃车秀座驾',
        'views'       => '10',
    ),
    15  => array(
        'forum_name'  => '摄影自拍',
        'fid'         => 15,
        'fid_in'      => '15',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '澳洲摄影爱好者聚集地',
        'views'       => '10',
    ),
    268 => array(
        'forum_name'  => '潮流风尚',
        'fid'         => 268,
        'fid_in'      => '268',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '美肤护肤、时尚穿搭秀场',
        'views'       => '10',
    ),
    602 => array(
        'forum_name'  => '数码广场',
        'fid'         => 602,
        'fid_in'      => '602',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '数码产品及周边',
        'views'       => '10',
    ),
    240 => array(
        'forum_name'  => '电竞动漫',
        'fid'         => 240,
        'fid_in'      => '240',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '游戏迷、动漫迷看过来',
        'views'       => '10',
    ),

    234 => array(
        'forum_name'  => '意见反馈',
        'fid'         => 234,
        'fid_in'      => '234',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '问题反馈和意见征集',
        'views'       => '10',
    ),

);

$config['life'] = array(
    array(
        'forum_name'  => '同城生活',
        'fid'         => 92,
        'fid_in'      => '92',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '同城互助，分享生活资讯',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '同城交友',
        'fid'         => 277,
        'fid_in'      => '277',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '同城交友，分享生活资讯',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '不吐不快',
        'fid'         => 646,
        'fid_in'      => '646',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '有什么不痛快的，说来听听？',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '情感世界',
        'fid'         => 212,
        'fid_in'      => '212',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '谈谈情，说说爱',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '谈婚论嫁',
        'fid'         => 606,
        'fid_in'      => '606',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '聊聊婚嫁及周边事宜',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '家在澳洲',
        'fid'         => 732,
        'fid_in'      => '732',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '澳洲置业资讯交流',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '家庭亲子',
        'fid'         => 313,
        'fid_in'      => '313',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '家长里短，带娃心得',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '美食厨房',
        'fid'         => 36,
        'fid_in'      => '36',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '秀美食，晒厨艺',
        'views'       => '10',
    ),
    array(
        //修改
        'forum_name'  => '宠物之家',
        'fid'         => 318,
        'fid_in'      => '318',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '铲屎官集中营',
        'views'       => '10',
    ),

);

$config['work'] = array(
    array(
        'forum_name'  => '澳洲校园',
        'fid'         => 294,
        'fid_in'      => '294',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '校园里的新鲜事儿',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '雅思翻译',
        'fid'         => 269,
        'fid_in'      => '269',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '英语学习和考试准备',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '留学移民',
        'fid'         => 93,
        'fid_in'      => '93',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '留学和移民澳洲的那些事儿',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '投资创业',
        'fid'         => 309,
        'fid_in'      => '309',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '投资与创业信息交流',
        'views'       => '10',
    ),
);

//2017.05.05 edit by allen qu isPhone改为1
$config['entertainment'] = array(
    array(
        'forum_name'  => '休闲运动',
        'fid'         => 310,
        'fid_in'      => '310',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '休闲活动组织交流',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '休闲旅游',
        'fid'         => 619,
        'fid_in'      => '619',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '诗和远方',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '车迷天下',
        'fid'         => 319,
        'fid_in'      => '319',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '侃车秀座驾',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '摄影自拍',
        'fid'         => 15,
        'fid_in'      => '15',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '澳洲摄影爱好者聚集地',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '潮流风尚',
        'fid'         => 268,
        'fid_in'      => '268',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '美肤护肤、时尚穿搭秀场',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '数码广场',
        'fid'         => 602,
        'fid_in'      => '602',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '数码产品及周边',
        'views'       => '10',
    ),
    array(
        'forum_name'  => '电竞动漫',
        'fid'         => 240,
        'fid_in'      => '240',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '游戏迷、动漫迷看过来',
        'views'       => '10',
    ),

);

$config['feedback'] = array( //2017.05.05 edit by allen qu isPhone改为1
    array(
        'forum_name'  => '意见反馈',
        'fid'         => 234,
        'fid_in'      => '234',
        'isPhone'     => 1, 'mustPic' => 0, 'allowGuest' => 0,
        'description' => '问题反馈和意见征集',
        'views'       => '10',
    ),
);
/*
 * 分类信息配置
 * */
$city = array(
    array(
        'value'   => '2',
        'name'    => '悉尼 NSW',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'NSW',
            'value' => array(
                'Ashfield',
                'Auburn',
                'Burwood',
                'Campsie',
                'Chatswood',
                'Eastwood',
                'Epping',
                'Haymarket',
                'Hurstville',
                'Kingsford',
                'Marsfield',
                'Parramatta',
                'Rhodes',
                'Ryde',
                'Strathfield',
                'Sydney City',
                'Ultimo',
                'Waterloo',
                'Zetland',
            )
        )
    ),
    array(
        'value'   => '12',
        'name'    => '卧龙岗 NSW',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'NSW',
            'value' => array(
                'Fairy Meadow',
                'Gwynneville',
                'Mount Ousley',
                'North Wollongong',
                'Shellharbour',
                'Wollongong',
            )
        )
    ),
    array(
        'value'   => '13',
        'name'    => '中央海岸 NSW',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'NSW',
            'value' => array(
                'Berkeley Vale',
                'Killarney Vale',
                'The Entrance',
            )
        )
    ),
    array(
        'value'   => '1',
        'name'    => '墨尔本 VIC',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'VIC',
            'value' => array(
                'Albert Park',
                'Bentleigh',
                'Bentleith East',
                'Burwood',
                'Burwood East',
                'Brighton',
                'Bundoora',
                'Box Hill',
                'Clayton',
                'Carlton',
                'Carnegie',
                'Camberwell',
                'Docklands',
                'Doncaster',
                'Footscray',
                'Glen Waverley',
                'Hawthorn',
                'Malvern',
                'Malvern East',
                'Melbourne City',
                'Mount Waverley',
                'Mckinnon',
                'North Melbourne',
                'Preston',
                'Piont Cook',
                'South Bank',
                'Reservoir',
                'Oakleigh',
                'Oakleigh East',
                'Ormond',
                'Ringwood',
                'Ringwood East',
                'Vermont',
                'Vermont South',
            )
        )
    ),
    array(
        'value'   => '14',
        'name'    => '吉朗 VIC',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'VIC',
            'value' => array(
                'East Geelong',
                'Geelong city centre',
                'Geelong West',
                'Newtown',
                'South Geelong',
                'Whittington',
            )
        )
    ),
    array(
        'value'   => '15',
        'name'    => '巴拉瑞特 VIC',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'VIC',
            'value' => array(
                'Alfredton',
                'Ballarat Central',
                'Redan',
            )
        )
    ),
    array(
        'value'   => '4',
        'name'    => '布里斯班 QLD',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'QLD',
            'value' => array(
                'Brisbane City',
                'South Brisbane',
                'St Lucia',
                'West End',
            )
        )
    ),
    array(
        'value'   => '3',
        'name'    => '黄金海岸 QLD',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'QLD',
            'value' => array(
                'Broadbeach Waters',
                'Bundall',
                'Clear Island Waters',
                'Mermaid Waters',
                'Surfers Paradise',
            )
        )
    ),
    array(
        'value'   => '6',
        'name'    => '堪培拉 ACT',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'ACT',
            'value' => array(
                'Acton',
                'Ainslie',
                'Braddon',
                'Canberra Central',
                'Dickson',
                'O\'Connor',
                'Turner',
            )
        )
    ),
    array(
        'value'   => '5',
        'name'    => '阿德莱德 SA',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'SA',
            'value' => array(
                'Adelaide city',
                'Campbelltown',
                'Klemzig',
                'Mawson Lakes',
                'Marion',
                'Melrose Park',
                'Oaklands Park',
            )
        )
    ),
    array(
        'value'   => '7',
        'name'    => '珀斯 WA',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'WA',
            'value' => array(
                'Perth City',
                'Morley',
                'Nedlands',
            )
        )
    ),
    array(
        'value'   => '8',
        'name'    => '达尔文 NT',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'NT',
            'value' => array(
                'Darwin City',
                'Stuart Park',
                'The Gardens',
            )
        )
    ),
    array(
        'value'   => '10',
        'name'    => '霍巴特 TAS',
        'options' => array(
            'name'  => 'suburb',
            'key'   => 'TAS',
            'value' => array(
                'Hobart City',
                'Moonah',
                'New Town',
                'Sandy Bay',
            )
        )
    ),
    array(
        'value'   => '11',
        'name'    => '其他',
        'options' => array(
            'name'  => 'suburb',
            'key'   => '',
            'value' => array(
                'Other',
            )
        )
    ),
);

$config['inPutCity'] = $city; //城市配置

$forumList = array(
    'section_1' => array(
        array('fid' => 142, 'typeid' => 0, 'forumname' => '房屋租赁', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 305, 'typeid' => 0, 'forumname' => '房屋交易', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 1, 'allowGuest' => 0),
        array('fid' => 291, 'typeid' => 0, 'forumname' => '汽车出售', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 1, 'allowGuest' => 0),
        array('fid' => 161, 'typeid' => 0, 'forumname' => '招聘信息', 'picList' => 0, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 89, 'typeid' => 0, 'forumname' => '超级市场', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 304, 'typeid' => 0, 'forumname' => '二手市场', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 604, 'typeid' => 0, 'forumname' => '宠物交易', 'picList' => 0, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 679, 'typeid' => 0, 'forumname' => '二手教材', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 716, 'typeid' => 0, 'forumname' => '生意买卖', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 325, 'typeid' => 0, 'forumname' => '团购打折', 'picList' => 0, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
    ),

    'section_2' => array(
        array('fid' => 651, 'typeid' => 1158, 'forumname' => '代购快递', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 929, 'forumname' => '物流搬运', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 400, 'forumname' => '餐饮美食', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 402, 'forumname' => '清洁通渠', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),

    ),
    'section_3' => array(
        array('fid' => 651, 'typeid' => 403, 'forumname' => '建筑家装', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 917, 'forumname' => '园艺绿化', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 919, 'forumname' => '二手回收', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 471, 'forumname' => '摄影婚礼', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 928, 'forumname' => '保姆月嫂', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1166, 'forumname' => '休闲娱乐', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 479, 'forumname' => '医疗健康', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 650, 'forumname' => '旅游机票', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
    ),
    'section_4' => array(
        array('fid' => 651, 'typeid' => 401, 'forumname' => '机场接送', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1161, 'forumname' => '车辆租赁', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1162, 'forumname' => '驾校招生', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 404, 'forumname' => '汽车综合', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
    ),

    'section_5' => array(
        array('fid' => 651, 'typeid' => 405, 'forumname' => '教育培训', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),

    ),
    'section_6' => array(
        array('fid' => 651, 'typeid' => 472, 'forumname' => '美容美发', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 406, 'forumname' => '会计税务', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 481, 'forumname' => '翻译服务', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1159, 'forumname' => '贷款服务', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 649, 'forumname' => '金融保险', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1306, 'forumname' => '裁缝修补', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 480, 'forumname' => '留学移民', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 918, 'forumname' => '律师服务', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        //array('fid'=>651,'typeid'=>123,'forumname'=>'律师服务','picList'=>0,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
    ),
    'section_7' => array(
        array('fid' => 651, 'typeid' => 407, 'forumname' => '电脑网络', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 884, 'forumname' => '手机数码', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 474, 'forumname' => '电器服务', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1156, 'forumname' => '印刷喷绘', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 1165, 'forumname' => '设计策划', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 925, 'forumname' => '金属机械', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 398, 'forumname' => '其它服务', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
        array('fid' => 651, 'typeid' => 399, 'forumname' => '求助咨询', 'picList' => 1, 'isPhone' => 1, 'mustPic' => 0, 'allowGuest' => 0),
    ),
);
$config['forumList'] = $forumList; //板块配置;

$inputAry = array();
//车辆出售
$inputAry['f291_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'carfrom',
            'label'  => '车辆类型',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '私人二手'),
                array('2', '商家二手'),
                array('3', '新车'),
            ),
        ),
        array(
            'name'   => 'carmake',
            'label'  => '车辆品牌',
            'isnull' => 'not',
            'type'   => 'api',
        ),
        array(
            'name'   => 'model',
            'label'  => '车辆型号',
            'isnull' => 'not',
            'type'   => 'api',
        ),
        array(
            'name'   => 'bodytype',
            'label'  => '车型',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '轿车'),
                array('2', 'SUV越野车'),
                array('3', 'MPV商务车'),
                array('4', '跑车'),
                array('5', '面包车'),
                array('6', '卡车'),
            ),
        ),
        array(
            'name'   => 'transmission',
            'label'  => '变速箱',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '手动'),
                array('2', '自动'),
                array('3', '手自一体'),
            ),
        ),
        array(
            'name'  => 'colour',
            'label' => '颜色',
            'type'  => 'select',
            'value' => array(
                array('1', '黑色'),
                array('2', '白色'),
                array('3', '银灰色'),
                array('4', '深灰色'),
                array('5', '棕色'),
                array('6', '红色'),
                array('7', '粉色'),
                array('8', '橙色'),
                array('9', '绿色'),
                array('10', '蓝色'),
                array('11', '咖啡色'),
                array('12', '紫色'),
                array('13', '金色'),
                array('14', '香槟色'),
                array('15', '多彩色'),
                array('16', '黄色'),
                array('17', '其它'),
            ),
        ),
    ),
    'section_3' => array(
        array(
            'name'  => 'drives',
            'label' => '驱动',
            'type'  => 'select',
            'value' => array(
                array('1', '前驱'),
                array('2', '后驱'),
                array('3', '四驱'),
            ),
        ),
        array(
            'name'  => 'seats',
            'label' => '座位数',
            'type'  => 'select',
            'value' => array(
                array('2', '2座'),
                array('4', '4座'),
                array('5', '5座'),
                array('6', '6座'),
                array('7', '7座'),
                array('8', '7座以上'),
            ),
        ),
        array(
            'name'  => 'doors',
            'label' => '门数',
            'type'  => 'select',
            'value' => array(
                array('2', '2门'),
                array('3', '3门'),
                array('4', '4门'),
                array('5', '5门'),
            ),
        ),
        array(
            'name'   => 'fueltype',
            'label'  => '燃油类型',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '汽油'),
                array('2', '柴油'),
                array('3', '油电混合'),
                array('4', '电动'),
            ),
        ),
        array(
            'name'  => 'displace',
            'label' => '排量',
            'type'  => 'text',
        ),
        array(
            'name'   => 'kilometres',
            'label'  => '行驶里程',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'havemaintenance',
            'label' => '保养记录',
            'type'  => 'select',
            'value' => array(
                array('1', '有'),
                array('2', '无'),
            ),
        ),
        array(
            'name'  => 'marktime',
            'label' => '首次上牌日期',
            'type'  => 'date',
        ),
        array(
            'name'  => 'car_price',
            'label' => '价格',
            'type'  => 'text',
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '车辆详细介绍',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//车辆求购
// $inputAry['f715_0'] = array(
//     'section_1'=>array(
//         array(
//             'name' => 'subject',
//             'label' => '标题',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//     ),
//     'section_2'=>array(
//         array(
//             'name' => 'suburb',
//             'label' => 'Suburb',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'postcode',
//             'label' => '邮编',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'carfrom',
//             'label' => '车辆来源',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('0','不限'),
//                 array('1','私人'),
//                 array('2','商家'),
//                 array('3','新车'),
//             ),
//         ),
//         array(
//             'name' => 'carmake',
//             'label' => '车辆品牌',
//             'isnull' => 'not',
//             'type' => 'api',
//             /*'api' => 'https://app.yeeyi.com/index.php?app=tools&act=getCarModel',*/
//         ),
//     ),
//     'section_3'=>array(
//         array(
//             'name' => 'carprice',
//             'label' => '期望价格',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('不限','不限'),
//                 array('5K以下','5K以下'),
//                 array('5K-10K','5K-10K'),
//                 array('10K-20K','10K-20K'),
//                 array('20K-30K','20K-30K'),
//                 array('30k-40k','30k-40k'),
//                 array('40k以上','40k以上'),
//             ),
//         ),
//         array(
//             'name' => 'carage',
//             'label' => '期望车龄',
//             'type' => 'select',
//             'value' => array(
//                 array('不限','不限'),
//                 array('1年以内','1年以内'),
//                 array('1-3年','1-3年'),
//                 array('3-5年','3-5年'),
//                 array('5-8年','5-8年'),
//                 array('8-10年','8-10年'),
//                 array('10年以上','10年以上'),
//             ),
//         ),
//         array(
//             'name' => 'bodytype',
//             'label' => '期望车型',
//             'type' => 'select',
//             'value' => array(
//                 array('0','请选择'),
//                 array('1','轿车'),
//                 array('2','SUV越野车'),
//                 array('3','MPV商务车'),
//                 array('4','跑车'),
//                 array('5','面包车'),
//                 array('6','卡车'),
//             ),
//         ),
//         array(
//             'name' => 'kilometres',
//             'label' => '里程',
//             'type' => 'select',
//             'value' => array(
//                 array('不限','不限'),
//                 array('1万公里内','1万公里内'),
//                 array('3万公里内','3万公里内'),
//                 array('6万公里内','6万公里内'),
//                 array('10万公里内','10万公里内'),
//                 array('10万公里以上','10万公里以上'),
//             ),
//         ),
//         array(
//             'name' => 'transmission',
//             'label' => '变速箱',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('0','不限'),
//                 array('1','手动'),
//                 array('2','自动'),
//                 array('3','手自一体'),
//             ),
//         ),
//     ),
//     'section_4'=>array(
//         array(
//             'name' => 'message',
//             'label' => '附言',
//             'type' => 'long',
//         ),
//     ),
//     'section_5'=>array(
//         array(
//             'name' => 'poster',
//             'label' => '联系人',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'tel',
//             'label' => '电话',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'weixin',
//             'label' => '微信',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'qq',
//             'label' => 'QQ',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'email',
//             'label' => '邮箱',
//             'type' => 'text',
//         ),
//     ),
// );
//个人求职
// $inputAry['f714_0'] = array(
//     'section_1'=>array(
//         array(
//             'name' => 'subject',
//             'label' => '标题',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//     ),
//     'section_2'=>array(
//         array(
//             'name' => 'suburb',
//             'label' => 'Suburb',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'postcode',
//             'label' => '邮编',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'position',
//             'label' => '期望职位',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('0','职位分类'),
//                 array('1','技师/工人/学徒'),
//                 array('2','编辑/翻译/律师'),
//                 array('3','传媒/印刷/艺术/设计'),
//                 array('4','网管/IT安装/程序员'),
//                 array('5','财务/人力资源/行政/文秘'),
//                 array('6','互联网/通讯'),
//                 array('7','清洁/搬运/库管/司机'),
//                 array('8','公关/演艺/模特/摄影'),
//                 array('9','销售/市场/业务'),
//                 array('10','医护/按摩/美容/发型'),
//                 array('11','教师/教练/家教'),
//                 array('12','游戏代练/游戏推广'),
//                 array('13','店员/收银/客服'),
//                 array('14','厨师/服务员/帮工/外卖'),
//                 array('15','旅行/导游'),
//                 array('16','保姆/月嫂/钟点工'),
//                 array('17','实习机会/义工'),
//                 array('18','兼职信息'),
//             ),
//         ),
//         array(
//             'name' => 'salary_form',
//             'label' => '期望薪资',
//             'type' => 'switcher',
//             'switcher' => array(
//                 array(
//                     '0','请选择',array('name'=>'salary','value'=>array(
//                     array('0','不限'),
//                 ))
//                 ),
//                 array(
//                     '100','Hourly rates',array('name'=>'salary','value'=>array(
//                         array('100','$15以下'),
//                         array('101','$16－$20'),
//                         array('102','$21－$25'),
//                         array('103','$26－$30'),
//                         array('104','$30以上'),
//                     ))
//                 ),
//                 array(
//                     '101','Annually rates',array('name'=>'salary','value'=>array(
//                         array('105','$30K以下'),
//                         array('106','$30－$40'),
//                         array('107','$40－$50'),
//                         array('108','$50－$60'),
//                         array('109','$70以上'),
//                     ))
//                 ),
//             ),
//         ),
//     ),
//     'section_3'=>array(
//         array(
//             'name' => 'ages',
//             'label' => '年龄',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'education',
//             'label' => '最高学历',
//             'type' => 'select',
//             'value' => array(
//                 array('none','请选择'),
//                 array('1','completed Year 9-11'),
//                 array('2','completed High School(year 12)'),
//                 array('3','Diploma'),
//                 array('4','TAFE/Trade Certificate'),
//                 array('5','Undergraduate'),
//                 array('6','Post Graduate Degree'),
//                 array('7','Masters'),
//                 array('8','PhD'),
//             ),
//         ),
//         array(
//             'name' => 'property',
//             'label' => '工作性质',
//             'type' => 'select',
//             'isnull' => 'not',
//             'value' => array(
//                 array('全职','全职'),
//                 array('兼职','兼职'),
//                 array('合同工','合同工'),
//                 array('实习','实习'),
//                 array('临时','临时'),
//             ),
//         ),
//         array(
//             'name' => 'visa',
//             'label' => '签证状态',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('PR','PR'),
//                 array('工作签','工作签'),
//                 array('学生签','学生签'),
//                 array('澳洲国籍','澳洲国籍'),
//             ),
//         ),
//         array(
//             'name' => 'worktime',
//             'label' => '可工作时间',
//             'type' => 'text',
//         ),
//     ),
//     'section_4'=>array(
//         array(
//             'name' => 'message',
//             'label' => '自我介绍',
//             'type' => 'long',
//         ),
//     ),
//     'section_5'=>array(
//         array(
//             'name' => 'poster',
//             'label' => '联系人',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'tel',
//             'label' => '电话',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'weixin',
//             'label' => '微信',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'qq',
//             'label' => 'QQ',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'email',
//             'label' => '邮箱',
//             'type' => 'text',
//         ),
//     ),
// );
//招聘信息
$inputAry['f161_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(
        array(
            'name'  => 'suburb',
            'label' => 'Suburb',
            'type'  => 'text',
        ),
        array(
            'name'   => 'company',
            'label'  => '公司名称',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'position',
            'label'  => '职位分类',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '技师/工人/学徒'),
                array('2', '编辑/翻译/律师'),
                array('3', '传媒/印刷/艺术/设计'),
                array('4', '网管/IT安装/程序员'),
                array('5', '财务/人力资源/行政/文秘'),
                array('6', '互联网/通讯'),
                array('7', '清洁/搬运/库管/司机'),
                array('8', '公关/演艺/模特/摄影'),
                array('9', '销售/市场/业务'),
                array('10', '医护/按摩/美容/发型'),
                array('11', '教师/教练/家教'),
                array('12', '游戏代练/游戏推广'),
                array('13', '店员/收银/客服'),
                array('14', '厨师/服务员/帮工/外卖'),
                array('15', '旅行/导游'),
                array('16', '保姆/月嫂/钟点工'),
                array('17', '实习机会/义工'),
                array('18', '兼职信息'),
            ),
        ),
    ),
    'section_3' => array(
        array(
            'name'   => 'property',
            'label'  => '工作性质',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('不限', '不限'),
                array('全职', '全职'),
                array('兼职', '兼职'),
                array('合同工', '合同工'),
                array('实习', '实习'),
                array('临时', '临时'),
            ),
        ),
        array(
            'name'   => 'visa',
            'label'  => '签证状态',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('不限', '不限'),
                array('PR', 'PR'),
                array('工作签', '工作签'),
                array('学生签', '学生签'),
                array('澳洲国籍', '澳洲国籍'),
            ),
        ),
        array(
            'name'  => 'experience',
            'label' => '经验要求',
            'type'  => 'select',
            'value' => array(
                array('需要', '需要'),
                array('不需要', '不需要'),
            ),
        ),
        array(
            'name'  => 'education',
            'label' => '学历要求',
            'type'  => 'select',
            'value' => array(
                array('none', '请选择'),
                array('1', 'completed Year 9-11'),
                array('2', 'completed High School(year 12)'),
                array('3', 'Diploma'),
                array('4', 'TAFE/Trade Certificate'),
                array('5', 'Undergraduate'),
                array('6', 'Post Graduate Degree'),
                array('7', 'Masters'),
                array('8', 'PhD'),
            ),
        ),
        array(
            'name'  => 'p_num',
            'label' => '招聘人数',
            'type'  => 'text',
        ),
        array(
            'name'     => 'salary_form',
            'label'    => '工资待遇',
            'isnull'   => 'not',
            'type'     => 'switcher',
            'switcher' => array(
                array(
                    'value'   => '0',
                    'label'   => '不限',
                    'options' => array(
                        'name'  => 'salary',
                        'value' => array(
                            array('0', '不限'),
                        ),
                    ),
                ),
                array(
                    'value'   => '100',
                    'label'   => 'Hourly Wage',
                    'options' => array('name' => 'salary', 'value' => array(
                        array('100', '$15以下'),
                        array('101', '$16－$20'),
                        array('102', '$21－$25'),
                        array('103', '$26－$30'),
                        array('104', '$30以上'),
                    )),
                ),
                array(
                    'value'   => '101',
                    'label'   => 'Annual Salary',
                    'options' => array('name' => 'salary', 'value' => array(
                        array('105', '$30K以下'),
                        array('106', '$30K－$40K'),
                        array('107', '$40K－$50K'),
                        array('108', '$50K－$60K'),
                        array('109', '$60K－$70K'),
                        array('110', '$70K以上'),
                    )),
                ),
            ),
        ),
        array(
            'name'  => 'annualleave',
            'label' => 'Annual leave',
            'type'  => 'select',
            'value' => array(
                array('有', '有'),
                array('无', '无'),
            ),
        ),
        array(
            'name'  => 'superannua',
            'label' => 'Superannuation',
            'type'  => 'select',
            'value' => array(
                array('有', '有'),
                array('无', '无'),
            ),
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '职位描述&公司简介',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//房屋租赁
$inputAry['f142_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),

    ),
    'section_2' => array(

        array(
            'name'   => 'address',
            'label'  => '地址',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'validity',
            'label' => '有效期',
            'type'  => 'select',
            'value' => array(
                array('0', '永久有效'),
                array('259200', '三天'),
                array('432000', '五天'),
                array('604800', '七天'),
                array('2592000', '一个月'),
                array('7776000', '三个月'),
                array('15552000', '半年'),
                array('31536000', '一年'),
            ),
        ),
        array(
            'name'   => 'house_from',
            'label'  => '来源',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '个人'),
                array('2', '中介'),
            ),
        ),
        array(
            'name'  => 'iscity',
            'label' => '房源是否在City',
            'type'  => 'select',
            'value' => array(
                array('1', '不在'),
                array('2', '在'),
            ),
        ),
        array(
            'name'   => 'house_type',
            'label'  => '类型',
            'type'   => 'select',
            'isnull' => 'not',
            'value'  => array(
                array('1', '公寓Apartment'),
                array('2', '小区Unit'),
                array('4', '别墅House'),
                array('5', '仓库Warehouse'),
                array('6', '写字楼Office'),
                array('7', '商铺Commercial'),
                array('8', '车位Garage'),
                array('9', '其他'),
            ),
        ),
        array(
            'name'   => 'house_room',
            'label'  => '室',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('0', '0'),
                array('1', '1'),
                array('2', '2'),
                array('3', '3'),
                array('4', '4'),
                array('5', '5'),
                array('6', '6'),
                array('7', '7'),
                array('8', '8'),
                array('9', '9'),
                array('10', '10'),
            ),
        ),
        array(
            'name'   => 'house_toilet',
            'label'  => '卫',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('0', '0'),
                array('1', '1'),
                array('2', '2'),
                array('3', '3'),
                array('4', '4'),
                array('5', '5'),
            ),
        ),
        array(
            'name'   => 'house_ku',
            'label'  => '车库',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '0'),
                array('2', '1'),
                array('3', '2'),
                array('4', '3'),
            ),
        ),
    ),
    'section_3' => array(

        array(
            'name'   => 'house_rents',
            'label'  => '租金',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'rent_type',
            'label'  => '出租方式',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '整租'),
                array('2', '转租'),
                array('3', '单间'),
                array('4', '客厅'),
                array('5', '床位'),
                array('6', '其它'),
            ),
        ),
        array(
            'name'   => 'in_date',
            'label'  => '可入住时间',
            'isnull' => 'not',
            'type'   => 'date',
        ),
        array(
            'name'  => 'house_sex',
            'label' => '性别要求',
            'type'  => 'select',
            'value' => array(
                array('1', '男女不限'),
                array('2', '限女生'),
                array('3', '限男生'),
            ),
        ),
        array(
            'name'  => 'keep_pet',
            'label' => '是否能养宠物',
            'type'  => 'select',
            'value' => array(
                array('0', '否'),
                array('1', '是'),
            ),
        ),
        array(
            'name'  => 'house_equipment',
            'label' => '配套设施',
            'type'  => 'checkbox',
            'value' => array(
                array('1', '包水'),
                array('2', '包电'),
                array('3', '包煤气'),
                array('4', '包宽带'),
                array('5', '有线电视'),
                array('6', '床'),
                array('7', '冰箱'),
                array('8', '洗衣机'),
                array('9', '热水器'),
                array('10', '空调'),
                array('11', '停车位'),
                array('12', '家俱'),
                array('13', '全包'),
            ),
        ),
        array(
            'name'  => 'bus_info',
            'label' => '周边设施',
            'type'  => 'checkbox',
            'value' => array(
                array('1', '火车站'),
                array('2', '公交站'),
                array('3', '学校'),
                array('4', '超市'),
                array('5', '健身房'),
                array('6', '游泳馆'),
            ),
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//房屋求租
// $inputAry['f680_0'] = array(
//     'section_1'=>array(
//         array(
//             'name' => 'subject',
//             'label' => '标题',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'suburb',
//             'label' => 'Suburb',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//     ),
//     'section_2'=>array(
//         array(
//             'name' => 'validity',
//             'label' => '有效期|validity',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('0','永久有效'),
//                 array('259200','三天'),
//                 array('432000','五天'),
//                 array('604800','七天'),
//                 array('2592000','一个月'),
//                 array('7776000','三个月'),
//                 array('15552000','半年'),
//                 array('31536000','一年'),
//             ),
//         ),
//         array(
//             'name' => 'address',
//             'label' => '地址',
//             'type' => 'text',
//         ),
//     ),
//     'section_3'=>array(
//         array(
//             'name' => 'rent_type',
//             'label' => '求租方式',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('1','整租'),
//                 array('2','转租'),
//                 array('3','单间'),
//                 array('4','客厅'),
//                 array('5','Share'),
//                 array('6','均可'),
//             ),
//         ),
//     ),
//     'section_4'=>array(
//         array(
//             'name' => 'message',
//             'label' => '详细信息',
//             'type' => 'long',
//         ),
//     ),
//     'section_5'=>array(
//         array(
//             'name' => 'poster',
//             'label' => '联系人',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'tel',
//             'label' => '电话',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'weixin',
//             'label' => '微信',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'qq',
//             'label' => 'QQ',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'email',
//             'label' => '邮箱',
//             'type' => 'text',
//         ),
//     ),
// );
//房屋交易
$inputAry['f305_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(
        array(
            'name'  => 'validity',
            'label' => '有效期|validity',
            'type'  => 'select',
            'value' => array(
                array('0', '永久有效'),
                array('259200', '三天'),
                array('432000', '五天'),
                array('604800', '七天'),
                array('2592000', '一个月'),
                array('7776000', '三个月'),
                array('15552000', '半年'),
                array('31536000', '一年'),
            ),
        ),
        array(
            'name'  => 'description',
            'label' => '房屋特色',
            'type'  => 'text',
        ),
        array(
            'name'   => 'house_type',
            'label'  => '房屋类型|House Type',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '别墅/house'),
                array('2', '联排别墅/townhouse'),
                array('3', '单元房/unit'),
                array('4', '公寓/apartment'),
                array('5', '土地/land'),
                array('6', '商铺/commercial'),
            ),
        ),
    ),
    'section_3' => array(

        array(
            'name'  => 'address',
            'label' => '地址|Address',
            'type'  => 'text',
        ),
        array(
            'name'  => 'iscity',
            'label' => '房源是否在City',
            'type'  => 'select',
            'value' => array(
                array('1', '不在'),
                array('2', '在'),
            ),
        ),
        array(
            'name'   => 'price',
            'label'  => '出售售价(万元)',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'showtime',
            'label' => '看房时间|Inspection',
            'type'  => 'text',
        ),

        array(
            'name'   => 'readyhouse',
            'label'  => '现房/期房',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '现房Established'),
                array('2', '期房Off plan'),
            ),
        ),
        array(
            'name'   => 'house_room',
            'label'  => '室',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('0', '0'),
                array('1', '1'),
                array('2', '2'),
                array('3', '3'),
                array('4', '4'),
                array('5', '5'),
                array('6', '6'),
                array('7', '7'),
                array('8', '8'),
                array('9', '9'),
                array('10', '10'),
            ),
        ),
        array(
            'name'   => 'house_hall',
            'label'  => '厅',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('0', '0'),
                array('1', '1'),
                array('2', '2'),
                array('3', '3'),
                array('4', '4'),
                array('5', '5'),
            ),
        ),
        array(
            'name'   => 'house_toilet',
            'label'  => '卫',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('0', '0'),
                array('1', '1'),
                array('2', '2'),
                array('3', '3'),
                array('4', '4'),
                array('5', '5'),
            ),
        ),
        array(
            'name'   => 'house_balcony',
            'label'  => '阳台',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('0', '0'),
                array('1', '1'),
                array('2', '2'),
                array('3', '3'),
                array('4', '4'),
                array('5', '5'),
            ),
        ),
        array(
            'name'   => 'house_ku',
            'label'  => '车库',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '0'),
                array('2', '1'),
                array('3', '2'),
                array('4', '3'),
            ),
        ),
        array(
            'name'  => 'allowforeigner',
            'label' => '海外人士购买',
            'type'  => 'select',
            'value' => array(
                array('1', '是Yes'),
                array('2', '否No'),
            ),
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//房屋求购
// $inputAry['f681_0'] = array(
//     'section_1'=>array(
//         array(
//             'name' => 'subject',
//             'label' => '标题',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'suburb',
//             'label' => 'Suburb',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//     ),
//     'section_2'=>array(
//         array(
//             'name' => 'validity',
//             'label' => '有效期|validity',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('0','永久有效'),
//                 array('259200','三天'),
//                 array('432000','五天'),
//                 array('604800','七天'),
//                 array('2592000','一个月'),
//                 array('7776000','三个月'),
//                 array('15552000','半年'),
//                 array('31536000','一年'),
//             ),
//         ),
//         array(
//             'name' => 'house_position',
//             'label' => '目标区域',
//             'type' => 'text',
//         ),
//     ),
//     'section_3'=>array(
//         array(
//             'name' => 'house_type',
//             'label' => '求购类型',
//             'isnull' => 'not',
//             'type' => 'select',
//             'value' => array(
//                 array('1','别墅/house'),
//                 array('2','联排别墅/townhouse'),
//                 array('3','单元房/unit'),
//                 array('4','公寓/apartment'),
//                 array('5','土地/land'),
//                 array('6','商铺/commercial'),
//             ),
//         ),
//         array(
//             'name' => 'iscity',
//             'label' => '房源是否在City',
//             'type' => 'select',
//             'value' => array(
//                 array('1','不在'),
//                 array('2','在'),
//             ),
//         ),
//     ),
//     'section_4'=>array(
//         array(
//             'name' => 'message',
//             'label' => '详细信息',
//             'type' => 'long',
//         ),
//     ),
//     'section_5'=>array(
//         array(
//             'name' => 'poster',
//             'label' => '联系人',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'tel',
//             'label' => '电话',
//             'isnull' => 'not',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'weixin',
//             'label' => '微信',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'qq',
//             'label' => 'QQ',
//             'type' => 'text',
//         ),
//         array(
//             'name' => 'email',
//             'label' => '邮箱',
//             'type' => 'text',
//         ),
//     ),

// );
//二手市场
$inputAry['f304_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(
        array(
            'name'   => 'typeid',
            'label'  => '类别',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('743', '女性'),
                array('744', '男性'),
                array('745', '杂七杂八'),
                array('746', '食品其它'),
                array('747', '家具用品'),
                array('748', '电脑网络'),
                array('1214', '亲子用品'),
                array('1188', '手机数码'),
                array('749', '图书音像'),
                array('905', '摄影器材'),
                array('751', '其他'),
            ),
        ),
        array(
            'name'  => 'delivery',
            'label' => '是否送货',
            'type'  => 'select',
            'value' => array(
                array('1', '送货'),
                array('2', '自取'),
            ),
        ),
    ),
    'section_3' => array(
        array(
            'name'   => 'fromtype',
            'label'  => '来源',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '个人'),
                array('2', '商家'),
            ),
        ),
        array(
            'name'   => 'markettype',
            'label'  => '需求',
            'type'   => 'select',
            'isnull' => 'not',
            'value'  => array(
                array('1', '出售'),
                array('2', '求购'),
            ),
        ),
        array(
            'name'   => 'price',
            'label'  => '价格',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),

);
//超级市场
$inputAry['f89_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(

        array(
            'name'   => 'typeid',
            'label'  => '类别',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('94', '服装鞋帽'),
                array('101', '手机数码'),
                array('99', '家居用品'),
                array('823', '母婴用品'),
                array('95', '游戏娱乐'),
                array('1210', '车饰配件'),
                array('475', '办公用品'),
                array('103', '成人用品'),
                array('477', '美容美体'),
                array('478', '体育用品'),
                array('476', '箱包首饰'),
                array('102', '食品饮品'),
                array('98', '书刊杂志'),
                array('96', '电脑配件'),
                array('742', '建筑材料'),
                array('93', '代购'),
                array('100', '问答'),
                array('92', '其它'),
            ),
        ),
    ),
    'section_3' => array(
        array(
            'name'   => 'price',
            'label'  => '价格',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//生意买卖
$inputAry['f716_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(

        array(
            'name'   => 'hangye',
            'label'  => '行业类型',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'company_name',
            'label' => '公司名称',
            'type'  => 'text',
        ),
        array(
            'name'  => 'company_address',
            'label' => '公司地址',
            'type'  => 'text',
        ),
    ),
    'section_3' => array(
        array(
            'name'  => 'price',
            'label' => '价格',
            'type'  => 'text',
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//二手教材
$inputAry['f679_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(
        array(
            'name'  => 'school',
            'label' => '学校',
            'type'  => 'select',
            'value' => array(
                array('TAFE', 'TAFE'),
                array('MQ', 'MQ'),
                array('USYD', 'USYD'),
                array('UNSW', 'UNSW'),
                array('UTS', 'UTS'),
                array('UWS', 'UWS'),
                array('UOW', 'UOW'),
                array('ANU', 'ANU'),
                array('UofMELB', 'UofMELB'),
                array('MONASH', 'MONASH'),
                array('DEAKIN', 'DEAKIN'),
                array('LATROBE', 'LATROBE'),
                array('RMIT', 'RMIT'),
                array('CURTIN', 'CURTIN'),
                array('UQ', 'UQ'),
                array('UWA', 'UWA'),
                array('ADELAIDE', 'ADELAIDE'),
                array('0', '其他大学'),
            ),
        ),
    ),
    'section_3' => array(
        array(
            'name'   => 'xuqiu',
            'label'  => '需求',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1', '求购'),
                array('2', '出售'),
            ),
        ),
        array(
            'name'   => 'typeid',
            'label'  => '类型',
            'isnull' => 'not',
            'type'   => 'select',
            'value'  => array(
                array('1002', '学习器材'),
                array('1003', '学习资料'),
            ),
        ),
        array(
            'name'   => 'price',
            'label'  => '价格',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//生活服务
$inputAry['f651_0'] = array(
    'section_1' => array(
        array(
            'name'   => 'subject',
            'label'  => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),
    'section_2' => array(

        array(
            'name'  => 'typeid',
            'label' => '服务分类',
            'type'  => 'select',
            'value' => array(
                array('400', '餐饮美食'),
                array('1166', '休闲娱乐'),
                array('472', '美容美发'),
                array('402', '清洁通渠'),
                array('928', '保姆月嫂'),
                array('401', '机场接送'),
                array('929', '物流搬运'),
                array('1158', '快递服务'),
                array('1161', '车辆租赁'),
                array('650', '旅游机票'),
                array('917', '园艺绿化'),
                array('403', '建筑家装'),
                array('471', '摄影婚礼'),
                array('407', '电脑网络'),
                array('884', '手机数码'),
                array('474', '电器服务'),
                array('1156', '印刷喷绘'),
                array('1165', '设计策划'),
                array('1162', '驾校招生'),
                array('404', '汽车综合'),
                array('405', '教育培训'),
                array('480', '留学移民'),
                array('406', '会计税务'),
                array('918', '律师服务'),
                array('481', '翻译服务'),
                array('1159', '贷款服务'),
                array('649', '金融保险'),
                array('479', '医疗健康'),
                array('925', '金属机械'),
                array('919', '二手回收'),
                array('1306', '裁缝修补'),
                array('398', '其它服务'),
                array('399', '求助咨询'),
            ),
        ),

    ),
    'section_3' => array(
        array(
            'name'  => 'company_name',
            'label' => '公司名称',
            'type'  => 'text',
        ),
        array(
            'name'  => 'company_address',
            'label' => '公司地址',
            'type'  => 'text',
        ),
        array(
            'name'  => 'company_website',
            'label' => '公司网址',
            'type'  => 'text',
        ),
        array(
            'name'  => 'company_info',
            'label' => '公司简介',
            'type'  => 'text',
        ),
        array(
            'name'  => 'company_service',
            'label' => '服务项目',
            'type'  => 'text',
        ),
        array(
            'name'  => 'company_area',
            'label' => '服务区域',
            'type'  => 'text',
        ),
    ),
    'section_4' => array(
        array(
            'name'   => 'message',
            'label'  => '详细信息',
            'isnull' => 'not',
            'type'   => 'long',
        ),
    ),
    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),
);
//宠物之家
$inputAry['f604_0'] = array(

    'section_1' => array(
        array(
            'name'   => 'subject', /* 2017.05.15 edit by allen qu message改为subject */
            'label' => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),

    'section_2' => array(
        array(
            'name'  => 'typeid',
            'label' => '类别',
            'type'  => 'select',
            'value' => array(
                array('530', '宠物'),
                array('531', '宠物用品'),
                array('532', '寄养'),
                array('533', '宠物美容'),
                array('0', '不限'),

            ),
        ),

    ),

    'section_3' => array(

        array(

            'name'  => 'ic',
            'label' => '芯片',
            'type'  => 'select',
            'value' => array(
                array('2', '有'),
                array('1', '无'),
                array('0', '不限'),
            ),
        ),
        /*
    array(

    'name'  => 'dateline',
    'label' => '发布时间',
    'type'  => 'select',
    'value' => array(
    array('1', '今天'),
    array('2', '最近三天'),
    array('3', '最近7天'),
    array('4', '最近14天'),
    array('5', '最近30天'),
    array('0', '不限'),
    )
    )
     */
    ),

    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),

    ),

    'section_5' => array(
        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),

);

//团购打折
$inputAry['f325_0'] = array(

    'section_1' => array(
        array(
            'name'   => 'subject', /* 2017.05.15 edit by allen qu message改为subject */
            'label' => '标题',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'suburb',
            'label'  => 'Suburb',
            'isnull' => 'not',
            'type'   => 'text',
        ),
    ),

    'section_2' => array(
        array(
            'name'  => 'typeid',
            'label' => '类别',
            'type'  => 'select',
            'value' => array(
                array('1', '服饰箱包'),
                array('2', '酒店旅游'),
                array('3', '美食'),
                array('4', '生活服务'),
                array('5', '休闲娱乐'),
                array('6', '打折情报'),
                array('92', '其他'),
                array('0', '不限'),

            ),
        ),

    ),

    'section_3' => array(

        /*
    array(

    'name'  => 'dateline',
    'label' => '时间',
    'type'  => 'select',
    'value' => array(
    array('1', '今天'),
    array('2', '最近三天'),
    array('3', '最近7天'),
    array('4', '最近14天'),
    array('5', '最近30天'),
    array('0', '不限'),
    )
    )
     */
    ),
    'section_4' => array(
        array(
            'name'  => 'message',
            'label' => '详细信息',
            'type'  => 'long',
        ),

    ),

    'section_5' => array(

        array(
            'name'   => 'poster',
            'label'  => '联系人',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'   => 'tel',
            'label'  => '电话',
            'isnull' => 'not',
            'type'   => 'text',
        ),
        array(
            'name'  => 'weixin',
            'label' => '微信',
            'type'  => 'text',
        ),
        array(
            'name'  => 'qq',
            'label' => 'QQ',
            'type'  => 'text',
        ),
        array(
            'name'  => 'email',
            'label' => '邮箱',
            'type'  => 'text',
        ),
    ),

);

//输入参数
$config['inputParam'] = $inputAry;
//过滤参数
$filterAry           = array();
$filterAry['f291_0'] = array(
    'select_menu'  => array(
        array(
            'post_key' => 'carmake',
            'label'    => '品牌',
            'type'     => 'api',
            'options'  => array(
                // 'value' => array(),
                // 'child' => array(
                //     'label' => '车辆型号',
                //     'name'  => 'model',
                //     'value' => array(),
                // ),
            ),
        ),
        array(
            'post_key' => 'carprice',
            'label'    => '价格',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '5K以下'),
                array('post_value' => '2', 'label' => '5K-10K'),
                array('post_value' => '3', 'label' => '10K-20K'),
                array('post_value' => '4', 'label' => '20K-30K'),
                array('post_value' => '5', 'label' => '30k-40k'),
                array('post_value' => '6', 'label' => '40k以上'),
            ),
        ),
        array(
            'post_key' => 'kilometres',
            'label'    => '公里数',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '1万公里内'),
                array('post_value' => '2', 'label' => '3万公里内'),
                array('post_value' => '3', 'label' => '6万公里内'),
                array('post_value' => '4', 'label' => '10万公里内'),
                array('post_value' => '5', 'label' => '10万公里以上'),
            ),
        ),
        array(
            'post_key' => '',
            'label'    => '筛选',
            'type'     => 'filters',
            'options'  => array(),
        ),
    ),
    'filter_array' => array(
        array(
            'post_key' => 'carfrom',
            'label'    => '来源',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '1', 'label' => '私人二手'),
                array('post_value' => '2', 'label' => '商家二手'),
                array('post_value' => '3', 'label' => '新车'),
                array('post_value' => '4', 'label' => '个人求购'),
            ),
        ),
        array(
            'post_key' => 'bodytype',
            'label'    => '车型',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '轿车'),
                array('post_value' => '2', 'label' => 'SUV越野车'),
                array('post_value' => '3', 'label' => 'MPV商务车'),
                array('post_value' => '4', 'label' => '跑车'),
                array('post_value' => '5', 'label' => '面包车'),
                array('post_value' => '6', 'label' => '卡车'),
            ),
        ),
        array(
            'post_key' => 'transmission',
            'label'    => '变速箱',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '手动'),
                array('post_value' => '2', 'label' => '自动'),
                array('post_value' => '3', 'label' => '手自一体'),
            ),
        ),
        array(
            'post_key' => 'fueltype',
            'label'    => '燃油类型',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '汽油'),
                array('post_value' => '2', 'label' => '柴油'),
                array('post_value' => '3', 'label' => '油电混合'),
                array('post_value' => '4', 'label' => '电动'),
            ),
        ),
        array(
            'post_key' => 'postdate',
            'label'    => '发布时间',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '1天内'),
                array('post_value' => '2', 'label' => '3天内'),
                array('post_value' => '3', 'label' => '7天内'),
                array('post_value' => '7', 'label' => '30天内'),
            ),
        ),
    ),

);

//岗位招聘
$filterAry['f161_0'] = array(
    'select_menu'  => array(
        array(
            'post_key' => 'position',
            'label'    => '职位',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '技师/工人/学徒'),
                array('post_value' => '2', 'label' => '编辑/翻译/律师'),
                array('post_value' => '3', 'label' => '传媒/印刷/艺术/设计'),
                array('post_value' => '4', 'label' => '网管/IT安装/程序员'),
                array('post_value' => '5', 'label' => '财务/人力资源/行政/文秘'),
                array('post_value' => '6', 'label' => '互联网/通讯'),
                array('post_value' => '7', 'label' => '清洁/搬运/库管/司机'),
                array('post_value' => '8', 'label' => '公关/演艺/模特/摄影'),
                array('post_value' => '9', 'label' => '销售/市场/业务'),
                array('post_value' => '10', 'label' => '医护/按摩/美容/发型'),
                array('post_value' => '11', 'label' => '教师/教练/家教'),
                array('post_value' => '12', 'label' => '游戏代练/游戏推广'),
                array('post_value' => '13', 'label' => '店员/收银/客服'),
                array('post_value' => '14', 'label' => '厨师/服务员/帮工/外卖'),
                array('post_value' => '15', 'label' => '旅行/导游'),
                array('post_value' => '16', 'label' => '保姆/月嫂/钟点工'),
                array('post_value' => '17', 'label' => '实习机会/义工'),
                array('post_value' => '18', 'label' => '兼职信息'),
            ),
        ),
        array(
            'post_key' => 'suburb',
            'label'    => 'Suburb',
            'type'     => 'select',
        ),
        array(
            'post_key' => 'property',
            'label'    => '工作性质(可多选)',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '全职', 'label' => '全职'),
                array('post_value' => '兼职', 'label' => '兼职'),
                array('post_value' => '合同工', 'label' => '合同工'),
                array('post_value' => '实习', 'label' => '实习'),
                array('post_value' => '临时', 'label' => '临时'),
            ),
        ),
        array(
            'post_key' => '',
            'label'    => '筛选',
            'type'     => 'filters',
            'options'  => array(),
        ),
    ),
    'filter_array' => array(
        array(
            'post_key' => 'salary_form',
            'label'    => '工资待遇',
            'type'     => 'switcher',
            'options'  => array(
                array(
                    'post_value' => '0',
                    'label'      => '不限',
                ),
                array(
                    'post_value' => '3',
                    'label'      => '面议',
                ),
                array(
                    'post_value' => '100',
                    'label'      => 'Hourly Wage',
                    'submenu'    => array(
                        'post_key' => 'salary',
                        'options'  => array(
                            array('post_value' => '100', 'label' => '$15以下'),
                            array('post_value' => '101', 'label' => '$16－$20'),
                            array('post_value' => '102', 'label' => '$21－$25'),
                            array('post_value' => '103', 'label' => '$26－$30'),
                            array('post_value' => '104', 'label' => '$30以上'),
                        )),
                ),
                array(
                    'post_value' => '101',
                    'label'      => 'Annual Salary',
                    'submenu'    => array(
                        'post_key' => 'salary',
                        'options'  => array(
                            array('post_value' => '105', 'label' => '$30K以下'),
                            array('post_value' => '106', 'label' => '$30k－$40k'),
                            array('post_value' => '107', 'label' => '$40k－$50k'),
                            array('post_value' => '108', 'label' => '$50k－$60k'),
                            array('post_value' => '109', 'label' => '$60K－$70K'),
                            array('post_value' => '110', 'label' => '$70K以上'),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'post_key' => 'visa',
            'label'    => '签证状态',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => 'PR', 'label' => 'PR'),
                array('post_value' => '工作签', 'label' => '工作签'),
                array('post_value' => '学生签', 'label' => '学生签'),
                array('post_value' => '澳洲国籍', 'label' => '澳洲国籍'),
            ),
        ),
        array(
            'post_key' => 'experience',
            'label'    => '经验要求',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '需要', 'label' => '需要'),
                array('post_value' => '不需要', 'label' => '不需要'),
            ),
        ),
        array(
            'post_key' => 'annualleave',
            'label'    => 'Annual leave',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '有', 'label' => '有'),
                array('post_value' => '无', 'label' => '无'),
            ),
        ),
        array(
            'post_key' => 'superannua',
            'label'    => 'Superannuation',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '有', 'label' => '有'),
                array('post_value' => '无', 'label' => '无'),
            ),
        ),
        array(
            'post_key' => 'postdate',
            'label'    => '发布时间',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '1天内'),
                array('post_value' => '2', 'label' => '3天内'),
                array('post_value' => '3', 'label' => '7天内'),
                array('post_value' => '7', 'label' => '30天内'),
            ),
        ),

    ),
);
//房屋租赁
$filterAry['f142_0'] = array(
    'select_menu'  => array(
        array(
            'post_key' => 'suburb',
            'label'    => 'Suburb',
            'type'     => 'select',
            'options'  => array(),
        ),
        array(
            'post_key' => 'rent_price',
            'label'    => '租金($/week)',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '0|100', 'label' => '100$/week以下'),
                array('post_value' => '100|150', 'label' => '100-150$/week'),
                array('post_value' => '150|200', 'label' => '150-200$/week'),
                array('post_value' => '200|300', 'label' => '200-300$/week'),
                array('post_value' => '300|500', 'label' => '300-500$/week'),
                array('post_value' => '500|1000', 'label' => '500-1000$/week'),
                array('post_value' => '1000|20000', 'label' => '1000$/week以上'),
            ),
        ),
        array(
            'post_key' => 'rent_type',
            'label'    => '出租方式',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '整租'),
                array('post_value' => '2', 'label' => '转租'),
                array('post_value' => '3', 'label' => '单间'),
                array('post_value' => '4', 'label' => '客厅'),
                array('post_value' => '5', 'label' => '床位'),
                array('post_value' => '6', 'label' => '其它'),
            ),
        ),
        array(
            'post_key' => '',
            'label'    => '筛选',
            'type'     => 'filters',
            'options'  => array(),
        ),
    ),
    'filter_array' => array(
        array(
            'post_key' => 'house_type',
            'label'    => '类型',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '公寓Apartment'),
                array('post_value' => '2', 'label' => '小区Unit'),
                array('post_value' => '4', 'label' => '别墅House'),
                array('post_value' => '5', 'label' => '仓库 Warehouse'),
                array('post_value' => '6', 'label' => '写字楼Office'),
                array('post_value' => '7', 'label' => '商铺Commercial'),
                array('post_value' => '8', 'label' => '车位Garage'),
                array('post_value' => '9', 'label' => '其他'),
            ),
        ),
        array(
            'post_key' => 'house_from',
            'label'    => '来源',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '个人'),
                array('post_value' => '2', 'label' => '中介'),
            ),
        ),
        array(
            'post_key' => 'postdate',
            'label'    => '发布时间',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '1天内'),
                array('post_value' => '2', 'label' => '3天内'),
                array('post_value' => '3', 'label' => '7天内'),
                array('post_value' => '7', 'label' => '30天内'),
            ),
        ),
        array(
            'post_key' => 'keep_pet',
            'label'    => '是否能养宠物',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '否'),
                array('post_value' => '2', 'label' => '是'),
            ),
        ),
    ),
);

//房屋交易
$filterAry['f305_0'] = array(
    'select_menu' => array(
        array(
            'post_key' => 'suburb',
            'label'    => 'Suburb',
            'type'     => 'select',
            'options'  => array(),
        ),
        array(
            'post_key' => 'house_type',
            'label'    => '房屋类型|House Type',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '别墅/house'),
                array('post_value' => '2', 'label' => '联排别墅/townhouse'),
                array('post_value' => '3', 'label' => '单元房/unit'),
                array('post_value' => '4', 'label' => '公寓/apartment'),
                array('post_value' => '5', 'label' => '土地/land'),
                array('post_value' => '6', 'label' => '商铺/commercial'),
            ),
        ),
        array(
            'post_key' => 'house_price',
            'label'    => '售价',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '0|50', 'label' => '50万元以下'),
                array('post_value' => '50|100', 'label' => '50-100万元'),
                array('post_value' => '100|200', 'label' => '100-200万元'),
                array('post_value' => '200|500', 'label' => '200-500万元'),
                array('post_value' => '500|1000', 'label' => '500-1000万元'),
                array('post_value' => '1000|20000', 'label' => '1000万元以上'),
            ),
        ),
        array(
            'post_key' => 'readyhouse',
            'label'    => '现房/期房',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '现房Established'),
                array('post_value' => '2', 'label' => '期房Off plan'),
            ),
        ),
    ),
);

//二手市场
$filterAry['f304_0'] = array(
    //201708291124修改
    'select_menu'  => array(
        array(
            'post_key' => 'suburb',
            'label'    => 'Suburb',
            'type'     => 'select',
            'options'  => array(),
        ),
        array(
            'post_key' => 'typeid',
            'label'    => '类别',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '743', 'label' => '女性'),
                array('post_value' => '744', 'label' => '男性'),
                array('post_value' => '745', 'label' => '杂七杂八'),
                array('post_value' => '746', 'label' => '食品其它'),
                array('post_value' => '747', 'label' => '家具用品'),
                array('post_value' => '748', 'label' => '电脑网络'),
                array('post_value' => '1214', 'label' => '亲子用品'),
                array('post_value' => '1188', 'label' => '手机数码'),
                array('post_value' => '749', 'label' => '图书音像'),
                array('post_value' => '905', 'label' => '摄影器材'),
                array('post_value' => '751', 'label' => '其他'),
            ),
        ),
        array(
            'post_key' => 'delivery',
            'label'    => '是否送货',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '送货'),
                array('post_value' => '2', 'label' => '自取'),
            ),
        ),
        array(
            'post_key' => '',
            'label'    => '筛选',
            'type'     => 'filters',
            'options'  => array(),
        ),
    ),
    'filter_array' => array(
        array(
            'post_key' => 'fromtype',
            'label'    => '来源',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '个人'),
                array('post_value' => '2', 'label' => '商家'),
            ),
        ),
        array(
            'post_key' => 'markettype',
            'label'    => '需求',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '求购'),
                array('post_value' => '2', 'label' => '出售'),
            ),
        ),
        array(
            'post_key' => 'postdate',
            'label'    => '发布时间',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '1天内'),
                array('post_value' => '2', 'label' => '3天内'),
                array('post_value' => '3', 'label' => '7天内'),
                array('post_value' => '7', 'label' => '30天内'),
            ),
        ),

    ),
);

//超级市场
$filterAry['f89_0'] = array(
    'select_menu' => array(
        array(
            'post_key' => 'typeid',
            'label'    => '类别',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '94', 'label' => '服装鞋帽'),
                array('post_value' => '101', 'label' => '手机数码'),
                array('post_value' => '99', 'label' => '家居用品'),
                array('post_value' => '823', 'label' => '母婴用品'),
                array('post_value' => '95', 'label' => '游戏娱乐'),
                array('post_value' => '1210', 'label' => '车饰配件'),
                array('post_value' => '475', 'label' => '办公用品'),
                array('post_value' => '103', 'label' => '成人用品'),
                array('post_value' => '477', 'label' => '美容美体'),
                array('post_value' => '478', 'label' => '体育用品'),
                array('post_value' => '476', 'label' => '箱包首饰'),
                array('post_value' => '102', 'label' => '食品饮品'),
                array('post_value' => '98', 'label' => '书刊杂志'),
                array('post_value' => '96', 'label' => '电脑配件'),
                array('post_value' => '742', 'label' => '建筑材料'),
                array('post_value' => '93', 'label' => '代购'),
                array('post_value' => '100', 'label' => '问答'),
                array('post_value' => '92', 'label' => '其它'),
            ),
        ),
    ),
);
//二手教材
$filterAry['f679_0'] = array(
    'select_menu' => array(
        array(
            'post_key' => 'school',
            'label'    => '学校',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => 'TAFE', 'label' => 'TAFE'),
                array('post_value' => 'MQ', 'label' => 'MQ'),
                array('post_value' => 'USYD', 'label' => 'USYD'),
                array('post_value' => 'UNSW', 'label' => 'UNSW'),
                array('post_value' => 'UTS', 'label' => 'UTS'),
                array('post_value' => 'UWS', 'label' => 'UWS'),
                array('post_value' => 'UOW', 'label' => 'UOW'),
                array('post_value' => 'ANU', 'label' => 'ANU'),
                array('post_value' => 'UofMELB', 'label' => 'UofMELB'),
                array('post_value' => 'MONASH', 'label' => 'MONASH'),
                array('post_value' => 'DEAKIN', 'label' => 'DEAKIN'),
                array('post_value' => 'LATROBE', 'label' => 'LATROBE'),
                array('post_value' => 'RMIT', 'label' => 'RMIT'),
                array('post_value' => 'CURTIN', 'label' => 'CURTIN'),
                array('post_value' => 'UQ', 'label' => 'UQ'),
                array('post_value' => 'UWA', 'label' => 'UWA'),
                array('post_value' => 'ADELAIDE', 'label' => 'ADELAIDE'),
                array('post_value' => '0', 'label' => '不限'),
            ),
        ),
        array(
            'post_key' => 'suburb',
            'label'    => 'Suburb',
            'type'     => 'select',
            'options'  => array(),
        ),
        array(
            'post_key' => 'typeid',
            'label'    => '类型',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1002', 'label' => '学习器材'),
                array('post_value' => '1003', 'label' => '学习资料'),
            ),
        ),
        array(
            'post_key' => 'xuqiu',
            'label'    => '需求',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '0', 'label' => '不限'),
                array('post_value' => '1', 'label' => '求购'),
                array('post_value' => '2', 'label' => '出售'),
            ),
        ),
    ),
);
//生活服务
$filterAry['f651_0'] = array(
    'select_menu' => array(
    ),
);

//宠物之家
$filterAry['f604_0'] = array(
    'select_menu' => array(
        array(
            'post_key' => 'typeid',
            'label'    => '类别',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '530', 'label' => '宠物'),
                array('post_value' => '531', 'label' => '宠物用品'),
                array('post_value' => '532', 'label' => '寄养'),
                array('post_value' => '533', 'label' => '宠物美容'),
                array('post_value' => '0', 'label' => '不限'),

            ),
        ),
        array(

            'post_key' => 'ic',
            'label'    => '芯片',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '2', 'label' => '有'),
                array('post_value' => '1', 'label' => '无'),
                array('post_value' => '0', 'label' => '不限'),
            ),
        ),
        array(

            'post_key' => 'dateline',
            'label'    => '发布时间',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '1', 'label' => '今天'),
                array('post_value' => '2', 'label' => '最近三天'),
                array('post_value' => '3', 'label' => '最近7天'),
                array('post_value' => '4', 'label' => '最近14天'),
                array('post_value' => '5', 'label' => '最近30天'),
                array('post_value' => '0', 'label' => '不限'),
            ),
        ),
    ),

);

//团购打折
$filterAry['f325_0'] = array(

    'select_menu' => array(
        array(
            'post_key' => 'typeid',
            'label'    => '类别',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '1', 'label' => '服饰箱包'),
                array('post_value' => '2', 'label' => '酒店旅游'),
                array('post_value' => '3', 'label' => '美食'),
                array('post_value' => '4', 'label' => '生活服务'),
                array('post_value' => '5', 'label' => '休闲娱乐'),
                array('post_value' => '6', 'label' => '打折情报'),
                array('post_value' => '92', 'label' => '其他'),
                array('post_value' => '0', 'label' => '不限'),

            ),
        ),
        array(
            'post_key' => 'dateline',
            'label'    => '时间',
            'type'     => 'select',
            'options'  => array(
                array('post_value' => '1', 'label' => '今天'),
                array('post_value' => '2', 'label' => '最近三天'),
                array('post_value' => '3', 'label' => '最近7天'),
                array('post_value' => '4', 'label' => '最近14天'),
                array('post_value' => '5', 'label' => '最近30天'),
                array('post_value' => '0', 'label' => '不限'),
            ),
        ),
    ),
);

//过滤参数
$config['filterParam'] = $filterAry;

//选择参数

//宠物
$config['param']['318'] = array(
    'typeid'   => array(
        '530' => '宠物',
        '531' => '宠物用品',
        '532' => '寄养',
        '533' => '宠物美容',
        '0'   => '不限',
    ),
    'ic'       => array(
        '1' => '无',
        '2' => '有',
        '0' => '不限',
    ),
    'dateline' => array(
        '1' => '今天',
        '2' => '最近三天',
        '3' => '最近7天',
        '4' => '最近14天',
        '5' => '最近30天',
        '0' => '不限',
    ),
);

//团购打折
$config['param']['325'] = array(
    'typeid'   => array(
        '1'  => '服饰箱包',
        '2'  => '酒店旅游',
        '3'  => '美食',
        '4'  => '生活服务',
        '5'  => '休闲娱乐',
        '6'  => '打折情报',
        '92' => '其他',
        '0'  => '不限',
    ),

    'dateline' => array(
        '1' => '今天',
        '2' => '最近三天',
        '3' => '最近7天',
        '4' => '最近14天',
        '5' => '最近30天',
        '0' => '不限',
    ),
);

//宠物交易  2017.05.17
$config['param']['604'] = array(

    'typeid'   => array(
        '530' => '宠物',
        '531' => '宠物用品',
        '532' => '寄养',
        '533' => '宠物美容',
        '0'   => '不限',
    ),

    'ic'       => array(

        '2' => '有',
        '1' => '无',
        '0' => '不限',
    ),

    'dateline' => array(
        '1' => '今天',
        '2' => '最近三天',
        '3' => '最近7天',
        '4' => '最近14天',
        '5' => '最近30天',
        '0' => '不限',
    ),
);

$config['param']['291'] =
array(
    'carfrom'         => array(
        '1' => '私人二手',
        '2' => '商家二手',
        '3' => '新车',
    ),
    'bodytype'        => array(
        '0' => '',
        '1' => '轿车',
        '2' => 'SUV越野车',
        '3' => 'MPV商务车',
        '4' => '跑车',
        '5' => '面包车',
        '6' => '卡车',
    ),
    'transmission'    => array(
        '1' => '手动',
        '2' => '自动',
        '3' => '手自一体',
    ),
    'colour'          => array(
        '0'  => '请选择',
        '1'  => '黑色',
        '2'  => '白色',
        '3'  => '银灰色',
        '4'  => '深灰色',
        '5'  => '棕色',
        '6'  => '红色',
        '7'  => '粉色',
        '8'  => '橙色',
        '9'  => '绿色',
        '10' => '蓝色',
        '11' => '咖啡色',
        '12' => '紫色',
        '13' => '金色',
        '14' => '香槟色',
        '15' => '多彩色',
        '16' => '黄色',
        '17' => '其它',
    ),
    'drives'          => array(
        '1' => '前驱',
        '2' => '后驱',
        '3' => '四驱',
    ),
    'seats'           => array(
        'none' => '',
        '2'    => '2座',
        '4'    => '4座',
        '5'    => '5座',
        '6'    => '6座',
        '7'    => '7座',
        '8'    => '7座以上',
    ),
    'doors'           => array(
        '2' => '2门',
        '3' => '3门',
        '4' => '4门',
        '5' => '5门',
    ),
    'fueltype'        => array(
        '1' => '汽油',
        '2' => '柴油',
        '3' => '油电混合',
        '4' => '电动',
    ),
    'havemaintenance' => array(
        '1' => '有',
        '2' => '无',
    ),
);

$config['param']['715'] = array(
    'carfrom'      => array(
        '0' => '不限',
        '1' => '私人',
        '2' => '商家',
        '3' => '新车',
    ),
    'carprice'     => array(
        '不限'      => '不限',
        '5K以下'    => '5K以下',
        '5K-10K'  => '5K-10K',
        '10K-20K' => '10K-20K',
        '20K-30K' => '20K-30K',
        '30k-40k' => '30k-40k',
        '40k以上'   => '40k以上',
    ),
    'carage'       => array(
        '不限'    => '不限',
        '1年以内'  => '1年以内',
        '1-3年'  => '1-3年',
        '3-5年'  => '3-5年',
        '5-8年'  => '5-8年',
        '8-10年' => '8-10年',
        '10年以上' => '10年以上',
    ),
    'bodytype'     => array(
        '0' => '请选择',
        '1' => '轿车',
        '2' => 'SUV越野车',
        '3' => 'MPV商务车',
        '4' => '跑车',
        '5' => '面包车',
        '6' => '卡车',
    ),
    'kilometres'   => array(
        '不限'      => '不限',
        '1万公里内'   => '1万公里内',
        '3万公里内'   => '3万公里内',
        '6万公里内'   => '6万公里内',
        '10万公里内'  => '10万公里内',
        '10万公里以上' => '10万公里以上',
    ),
    'transmission' => array(
        '0' => '不限',
        '1' => '手动',
        '2' => '自动',
        '3' => '手自一体',
    ),
);

$config['param']['714'] = array(
    'salary_form' => array(
        '0'   => '不限',
        '1'   => 'Hourly rates',
        '100' => 'Hourly rates',
        '2'   => 'Annually rates',
        '101' => 'Annually rates',
    ),
    'salary'      => array(
        '0'  => '不限',
        '1'  => '$15以下',
        '2'  => '$15－$30',
        '3'  => '$30－$60',
        '4'  => '$60－$100',
        '5'  => '$100以上',
        '6'  => '$30K以下',
        '7'  => '$30K－$60K',
        '8'  => '$60K－$100K',
        '9'  => '$100K－$150K',
        '10' => '$150K-$200K',
        '11' => '$200K以上',
    ),
    'position'    => array(
        '0'  => '职位分类',
        '1'  => '技师/工人/学徒',
        '2'  => '编辑/翻译/律师',
        '3'  => '传媒/印刷/艺术/设计',
        '4'  => '网管/IT安装/程序员',
        '5'  => '财务/人力资源/行政/文秘',
        '6'  => '互联网/通讯',
        '7'  => '清洁/搬运/库管/司机',
        '8'  => '公关/演艺/模特/摄影',
        '9'  => '销售/市场/业务',
        '10' => '医护/按摩/美容/发型',
        '11' => '教师/教练/家教',
        '12' => '游戏代练/游戏推广',
        '13' => '店员/收银/客服',
        '14' => '厨师/服务员/帮工/外卖',
        '15' => '旅行/导游',
        '16' => '保姆/月嫂/钟点工',
        '17' => '实习机会/义工',
        '18' => '兼职信息',
    ),
    'education'   => array(
        'none' => '请选择',
        '1'    => 'completed Year 9-11',
        '2'    => 'completed High School(year 12)',
        '3'    => 'Diploma',
        '4'    => 'TAFE/Trade Certificate',
        '5'    => 'Undergraduate',
        '6'    => 'Post Graduate Degree',
        '7'    => 'Masters',
        '8'    => 'PhD',
    ),
    'property'    => array(
        '全职'  => '全职',
        '兼职'  => '兼职',
        '合同工' => '合同工',
        '实习'  => '实习',
        '临时'  => '临时',
    ),
    'visa'        => array(
        'PR'   => 'PR',
        '工作签'  => '工作签',
        '学生签'  => '学生签',
        '澳洲国籍' => '澳洲国籍',
    ),
);

$config['param']['161'] = array(
    'position'    => array(
        'none' => '职位分类',
        '1'    => '技师/工人/学徒',
        '2'    => '编辑/翻译/律师',
        '3'    => '传媒/印刷/艺术/设计',
        '4'    => '网管/IT安装/程序员',
        '5'    => '财务/人力资源/行政/文秘',
        '6'    => '互联网/通讯',
        '7'    => '清洁/搬运/库管/司机',
        '8'    => '公关/演艺/模特/摄影',
        '9'    => '销售/市场/业务',
        '10'   => '医护/按摩/美容/发型',
        '11'   => '教师/教练/家教',
        '12'   => '游戏代练/游戏推广',
        '13'   => '店员/收银/客服',
        '14'   => '厨师/服务员/帮工/外卖',
        '15'   => '旅行/导游',
        '16'   => '保姆/月嫂/钟点工',
        '17'   => '实习机会/义工',
        '18'   => '兼职信息',
    ),
    'experience'  => array(
        '需要'  => '需要',
        '不需要' => '不需要',
    ),
    'education'   => array(
        'none' => '请选择',
        '1'    => 'completed Year 9-11',
        '2'    => 'completed High School(year 12)',
        '3'    => 'Diploma',
        '4'    => 'TAFE/Trade Certificate',
        '5'    => 'Undergraduate',
        '6'    => 'Post Graduate Degree',
        '7'    => 'Masters',
        '8'    => 'PhD',
    ),
    'salary_form' => array(
        '0'   => '请选择',
        '1'   => 'Hourly rates',
        '100' => 'Hourly rates',
        '2'   => 'Annually rates',
        '101' => 'Annually rates',
    ),
    'salary'      => array(
        '0'   => '面议',
        '1'   => '$15以下',
        '2'   => '$15－$30',
        '3'   => '$30－$60',
        '4'   => '$60－$100',
        '5'   => '$100以上',
        '6'   => '$30K以下',
        '7'   => '$30K－$60K',
        '8'   => '$60K－$100K',
        '9'   => '$100K－$150K',
        '10'  => '$150K-$200K',
        '11'  => '$200K以上',
        '100' => '$15以下',
        '101' => '$16－$20',
        '102' => '$21－$25',
        '103' => '$26－$30',
        '104' => '$30以上',
        '105' => '$30K以下',
        '106' => '$30K－$40K',
        '107' => '$40K－$50K',
        '108' => '$50K－$60K',
        '109' => '$60K－$70K',
        '110' => '$70K以上',
    ),
    'annualleave' => array(
        '有' => '有',
        '无' => '无',
    ),
    'superannua'  => array(
        '有' => '有',
        '无' => '无',
    ),
);

//房屋租赁
$config['param']['142'] = array(
    'validity'        => array(
        '0'        => '永久有效',
        '259200'   => '三天',
        '432000'   => '五天',
        '604800'   => '七天',
        '2592000'  => '一个月',
        '7776000'  => '三个月',
        '15552000' => '半年',
        '31536000' => '一年',
    ),
    'house_from'      => array(
        '1' => '个人',
        '2' => '中介',
    ),
    'iscity'          => array(
        '1' => '不在',
        '2' => '在',
    ),
    'house_type'      => array(
        '1' => '公寓Apartment',
        '2' => '小区Unit',
        '3' => '别墅House',
        '4' => '别墅House',
        '5' => '仓库Warehouse',
        '6' => '写字楼Office',
        '7' => '商铺Commercial',
        '8' => '车位Garage',
        '9' => '其他',
    ),
    'house_room'      => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_hall'      => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_toilet'    => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_balcony'   => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_ku'        => array(
        '1' => '0',
        '2' => '1',
        '3' => '2',
        '4' => '3',
    ),
    'rent_type'       => array(
        '1' => '整租',
        '2' => '转租',
        '3' => '单间',
        '4' => '客厅',
        '5' => '床位',
        '6' => '其它',
    ),
    'house_sex'       => array(
        '1' => '男女不限',
        '2' => '限女生',
        '3' => '限男生',
    ),
    'house_equipment' => array(
        '1'  => '包水',
        '2'  => '包电',
        '3'  => '包煤气',
        '4'  => '包宽带',
        '5'  => '有线电视',
        '6'  => '床',
        '7'  => '冰箱',
        '8'  => '洗衣机',
        '9'  => '热水器',
        '10' => '空调',
        '11' => '停车位',
        '12' => '家俱',
        '13' => '全包',
    ),
    'bus_info'        => array(
        '1' => '火车站',
        '2' => '公交站',
        '3' => '学校',
        '4' => '超市',
        '5' => '健身房',
        '6' => '游泳馆',
    ),
    'keep_pet'        => array('0' => '否', '1' => '是'),
);

$config['param']['680'] = array(
    'validity'  => array(
        '0'        => '永久有效',
        '259200'   => '三天',
        '432000'   => '五天',
        '604800'   => '七天',
        '2592000'  => '一个月',
        '7776000'  => '三个月',
        '15552000' => '半年',
        '31536000' => '一年',
    ),
    'rent_type' => array(
        '1' => '整租',
        '2' => '转租',
        '3' => '单间',
        '4' => '客厅',
        '5' => 'Share',
        '6' => '均可',
    ),
);

//房屋出售
$config['param']['305'] = array(

    'validity'       => array(
        '0'        => '永久有效',
        '259200'   => '三天',
        '432000'   => '五天',
        '604800'   => '七天',
        '2592000'  => '一个月',
        '7776000'  => '三个月',
        '15552000' => '半年',
        '31536000' => '一年',
    ),
    'house_type'     => array(
        '1' => '别墅/house',
        '2' => '联排别墅/townhouse',
        '3' => '单元房/unit',
        '4' => '公寓/apartment',
        '5' => '土地/land',
        '6' => '商铺/commercial',
    ),
    'iscity'         => array(
        '1' => '不在',
        '2' => '在',
    ),
    'readyhouse'     => array(
        '1' => '现房Established',
        '2' => '期房Off plan',
    ),
    'house_room'     => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_hall'     => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_toilet'   => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_balcony'  => array(
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
    ),
    'house_ku'       => array(
        '1' => '0',
        '2' => '1',
        '3' => '2',
        '4' => '3',
    ),
    'allowforeigner' => array(
        '1' => '是Yes',
        '2' => '否No',
    ),
);
//房屋求租
$config['param']['681'] = array(
    'validity'   => array(
        '0'        => '永久有效',
        '259200'   => '三天',
        '432000'   => '五天',
        '604800'   => '七天',
        '2592000'  => '一个月',
        '7776000'  => '三个月',
        '15552000' => '半年',
        '31536000' => '一年',
    ),
    'house_type' => array(
        '1' => '别墅/house',
        '2' => '联排别墅/townhouse',
        '3' => '单元房/unit',
        '4' => '公寓/apartment',
        '5' => '土地/land',
        '6' => '商铺/commercial',
    ),
    'iscity'     => array(
        '1' => '不在',
        '2' => '在',
    ),
);

//二手市场
$config['param']['304'] = array(
    'typeid'     => array(
        '743'  => '女性',
        '744'  => '男性',
        '745'  => '杂七杂八',
        '746'  => '食品其它',
        '747'  => '家具用品',
        '748'  => '电脑网络',
        '1214' => '亲子用品',
        '1188' => '手机数码',
        '749'  => '图书音像',
        '905'  => '摄影器材',
        '751'  => '其他',
    ),
    'delivery'   => array(
        '1' => '送货',
        '2' => '自取',
    ),
    'fromtype'   => array(
        '1' => '个人',
        '2' => '商家',
    ),
    'markettype' => array(
        '1' => '出售',
        '2' => '求购',
    ),
);

//超级市场
$config['param']['89'] = array(
    'typeid' => array(
        '94'   => '服装鞋帽',
        '101'  => '手机数码',
        '99'   => '家居用品',
        '823'  => '母婴用品',
        '95'   => '游戏娱乐',
        '1210' => '车饰配件',
        '475'  => '办公用品',
        '103'  => '成人用品',
        '477'  => '美容美体',
        '478'  => '体育用品',
        '476'  => '箱包首饰',
        '102'  => '食品饮品',
        '98'   => '书刊杂志',
        '96'   => '电脑配件',
        '742'  => '建筑材料',
        '93'   => '代购',
        '100'  => '问答',
        '92'   => '其它',
    ),
);
$config['param']['716'] = array();

$config['param']['679'] = array(
    'school' => array(
        'TAFE'     => 'TAFE',
        'MQ'       => 'MQ',
        'USYD'     => 'USYD',
        'UNSW'     => 'UNSW',
        'UTS'      => 'UTS',
        'UWS'      => 'UWS',
        'UOW'      => 'UOW',
        'ANU'      => 'ANU',
        'UofMELB'  => 'UofMELB',
        'MONASH'   => 'MONASH',
        'DEAKIN'   => 'DEAKIN',
        'LATROBE'  => 'LATROBE',
        'RMIT'     => 'RMIT',
        'CURTIN'   => 'CURTIN',
        'UQ'       => 'UQ',
        'UWA'      => 'UWA',
        'ADELAIDE' => 'ADELAIDE',
        '0'        => '其他大学',
    ),
    'xuqiu'  => array(
        '1' => '求购',
        '2' => '出售',
    ),
    'typeid' => array(
        '1002' => '学习器材',
        '1003' => '学习资料',
    ),
);

$config['param']['651'] = array(
    'typeid' => array(
        '400'  => '餐饮美食',
        '1166' => '休闲娱乐',
        '472'  => '美容美发',
        '402'  => '清洁通渠',
        '928'  => '保姆月嫂',
        '401'  => '机场接送',
        '929'  => '物流搬运',
        '1158' => '快递服务',
        '1161' => '车辆租赁',
        '650'  => '旅游机票',
        '917'  => '园艺绿化',
        '403'  => '建筑家装',
        '471'  => '摄影婚礼',
        '407'  => '电脑网络',
        '884'  => '手机数码',
        '474'  => '电器服务',
        '1156' => '印刷喷绘',
        '1165' => '设计策划',
        '1162' => '驾校招生',
        '404'  => '汽车综合',
        '405'  => '教育培训',
        '480'  => '留学移民',
        '406'  => '会计税务',
        '918'  => '律师服务',
        '481'  => '翻译服务',
        '1159' => '贷款服务',
        '649'  => '金融保险',
        '479'  => '医疗健康',
        '925'  => '金属机械',
        '919'  => '二手回收',
        '1306' => '裁缝修补',
        '398'  => '其它服务',
        '399'  => '求助咨询',
    ),
);
