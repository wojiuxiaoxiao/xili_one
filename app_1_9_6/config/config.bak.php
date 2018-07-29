<?php 
	date_default_timezone_set('Australia/Melbourne');
	$config=array (
		'dbhost' => '10.118.30.217:8066',
		'dbname' => 'yeeyico_new',//需要修改
		'dbpass' => '85nsxcNTpqatjcfQ',//需要修改
		'dbuser' => 'yeeyico_yicoeei',//需要修改
		'charset'=>'utf-8',
		'memHost' => '127.0.0.1',
		'memPost' => '11888',
	);

	/**
	 * 删帖 delList
	 * 锁定 lockList
	 * 禁言 denyList
	 * 举报 reportList
	 */

	$config['delList'] = array(
		array('违规广告','违规广告'),
		array('发布内容与话题不符','发布内容与话题不符'),
		array('涉嫌发布虚假信息','涉嫌发布虚假信息'),
		array('重复发帖','重复发帖'),
		array('恶意灌水','恶意灌水'),
		array('色情低俗','色情低俗'),
		array('禁止曝光隐私信息','禁止曝光隐私信息'),
	);

	$config['lockList'] = array(
		array('违规广告','违规广告'),
		array('发布内容与话题不符','发布内容与话题不符'),
		array('涉嫌发布虚假信息','涉嫌发布虚假信息'),
		array('重复发帖','重复发帖'),
		array('恶意灌水','恶意灌水'),
		array('色情低俗','色情低俗'),
		array('禁止曝光隐私信息','禁止曝光隐私信息'),
	);

	$config['denyList'] = array(
		array('违规广告','违规广告'),
		array('发布内容与话题不符','发布内容与话题不符'),
		array('涉嫌发布虚假信息','涉嫌发布虚假信息'),
		array('重复发帖','重复发帖'),
		array('恶意灌水','恶意灌水'),
		array('色情低俗','色情低俗'),
		array('禁止曝光隐私信息','禁止曝光隐私信息'),
	);

	$config['reportList'] = array(
		array('违规广告','违规广告'),
		array('发布内容与话题不符','发布内容与话题不符'),
		array('涉嫌发布虚假信息','涉嫌发布虚假信息'),
		array('重复发帖','重复发帖'),
		array('恶意灌水','恶意灌水'),
		array('色情低俗','色情低俗'),
		array('禁止曝光隐私信息','禁止曝光隐私信息'),
	);

	//话题板块对应
	$config['hot_forum'] = array(
		array(
			'forum_name'=>'同城生活',
			'fid'=>92,
			'fid_in'=>'92',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'同城互助，分享生活资讯',
			'views'=>'10',
		),
		array(
			'forum_name'=>'休闲旅游',
			'fid'=>619,
			'fid_in'=>'619',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'诗和远方',
			'views'=>'10',
		),
		array(
			'forum_name'=>'澳洲校园',
			'fid'=>294,
			'fid_in'=>'294',
			'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'校园里的新鲜事儿',
			'views'=>'10',
		),
		array(
			'forum_name'=>'家在澳洲',
			'fid'=>732,
			'fid_in'=>'732',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'澳洲置业资讯交流',
			'views'=>'10',
		),
		array(
			'forum_name'=>'车迷天下',
			'fid'=>319,
			'fid_in'=>'319',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'侃车秀座驾',
			'views'=>'10',
		),
		array(
			'forum_name'=>'宠物之家',
			'fid'=>318,
			'fid_in'=>'318',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'铲屎官集中营',
			'views'=>'10',
		),
		array(
			'forum_name'=>'留学移民',
			'fid'=>93,
			'fid_in'=>'93',
			'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'留学和移民澳洲的那些事儿',
			'views'=>'10',
		),
		array(
			'forum_name'=>'不吐不快',
			'fid'=>646,
			'fid_in'=>'646',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'有什么不痛快的，说来听听？',
			'views'=>'10',
		),
		array(
			'forum_name'=>'谈婚论嫁',
			'fid'=>606,
			'fid_in'=>'606',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'聊聊婚嫁及周边事宜',
			'views'=>'10',
		),
		array(
			'forum_name'=>'美食厨房',
			'fid'=>36,
			'fid_in'=>'36',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'秀美食，晒厨艺',
			'views'=>'10',
		),
		array(
			'forum_name'=>'雅思翻译',
			'fid'=>269,
			'fid_in'=>'269',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'英语学习和考试准备',
			'views'=>'10',
		),
		array(
			'forum_name'=>'投资创业',
			'fid'=>309,
			'fid_in'=>'309',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'投资与创业信息交流',
			'views'=>'10',
		),

	);

	$config['other_forum'] = array(
		array(
			'forum_name'=>'情感世界',
			'fid'=>212,
			'fid_in'=>'212',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'谈谈情，说说爱',
			'views'=>'10',
		),
		array(
			'forum_name'=>'家庭亲子',
			'fid'=>313,
			'fid_in'=>'313',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'家长里短，带娃心得',
			'views'=>'10',
		),
		array(
			'forum_name'=>'摄影自拍',
			'fid'=>15,
			'fid_in'=>'15',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'澳洲摄影爱好者聚集地',
			'views'=>'10',
		),
		array(
			'forum_name'=>'电竞动漫',
			'fid'=>240,
			'fid_in'=>'240',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'游戏迷、动漫迷看过来',
			'views'=>'10',
		),
		array(
			'forum_name'=>'团购打折',
			'fid'=>325,
			'fid_in'=>'325',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'本地折扣信息一网打尽',
			'views'=>'10',
		),
		array(
			'forum_name'=>'休闲运动',
			'fid'=>310,
			'fid_in'=>'310',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'休闲活动组织交流',
			'views'=>'10',
		),
		array(
			'forum_name'=>'潮流风尚',
			'fid'=>268,
			'fid_in'=>'268',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'美肤护肤、时尚穿搭秀场',
			'views'=>'10',
		),
		array(
			'forum_name'=>'数码广场',
			'fid'=>602,
			'fid_in'=>'602',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'数码产品及周边',
			'views'=>'10',
		),
		array(
			'forum_name'=>'E2吧',
			'fid'=>217,
			'fid_in'=>'217',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'闲聊和灌水专区',
			'views'=>'10',
		),
		array(
			'forum_name'=>'三国杀',
			'fid'=>327,
			'fid_in'=>'327,638,636,637,639',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'桌游组织和讨论',
			'views'=>'10',
		),
		array(
			'forum_name'=>'意见反馈',
			'fid'=>234,
			'fid_in'=>'234',
			'isPhone'=>0,'mustPic'=>0,'allowGuest'=>0,
			'description'=>'问题反馈和意见征集',
			'views'=>'10',
		),


	);

	/*
	 * 分类信息配置
	 * */
	$city = array(
		array('2','悉尼 NSW',array('name'=>'suburb','key'=>'NSW','value'=>array(
			array('Ashfield','Ashfield'),
			array('Auburn','Auburn'),
			array('Burwood','Burwood'),
			array('Campsie','Campsie'),
			array('Chatswood','Chatswood'),
			array('Eastwood','Eastwood'),
			array('Epping','Epping'),
			array('Haymarket','Haymarket'),
			array('Hurstville','Hurstville'),
			array('Kingsford','Kingsford'),
			array('Marsfield','Marsfield'),
			array('Parramatta','Parramatta'),
			array('Rhodes','Rhodes'),
			array('Ryde','Ryde'),
			array('Strathfield','Strathfield'),
			array('Sydney City','Sydney City'),
			array('Ultimo','Ultimo'),
			array('Waterloo','Waterloo'),
			array('Zetland','Zetland'),
		))),
		array('12','卧龙岗 NSW',array('name'=>'suburb','key'=>'NSW','value'=>array(
			array('Ashfield','Ashfield'),
			array('Auburn','Auburn'),
			array('Burwood','Burwood'),
			array('Campsie','Campsie'),
			array('Chatswood','Chatswood'),
			array('Eastwood','Eastwood'),
			array('Epping','Epping'),
			array('Haymarket','Haymarket'),
			array('Hurstville','Hurstville'),
			array('Kingsford','Kingsford'),
			array('Marsfield','Marsfield'),
			array('Parramatta','Parramatta'),
			array('Rhodes','Rhodes'),
			array('Ryde','Ryde'),
			array('Strathfield','Strathfield'),
			array('Sydney City','Sydney City'),
			array('Ultimo','Ultimo'),
			array('Waterloo','Waterloo'),
			array('Zetland','Zetland'),
		))),
		array('13','中央海岸 NSW',array('name'=>'suburb','key'=>'NSW','value'=>array(
			array('Ashfield','Ashfield'),
			array('Auburn','Auburn'),
			array('Burwood','Burwood'),
			array('Campsie','Campsie'),
			array('Chatswood','Chatswood'),
			array('Eastwood','Eastwood'),
			array('Epping','Epping'),
			array('Haymarket','Haymarket'),
			array('Hurstville','Hurstville'),
			array('Kingsford','Kingsford'),
			array('Marsfield','Marsfield'),
			array('Parramatta','Parramatta'),
			array('Rhodes','Rhodes'),
			array('Ryde','Ryde'),
			array('Strathfield','Strathfield'),
			array('Sydney City','Sydney City'),
			array('Ultimo','Ultimo'),
			array('Waterloo','Waterloo'),
			array('Zetland','Zetland'),
		))),
		array('1','墨尔本 VIC',array('name'=>'suburb','key'=>'VIC','value'=>array(
			array('Albert Park','Albert Park'),
			array('Bentleigh','Bentleigh'),
			array('Bentleith East','Bentleith East'),
			array('Burwood','Burwood'),
			array('Burwood East','Burwood East'),
			array('Brighton','Brighton'),
			array('Bundoora','Bundoora'),
			array('Box Hill','Box Hill'),
			array('Clayton','Clayton'),
			array('Carlton','Carlton'),
			array('Carnegie','Carnegie'),
			array('Camberwell','Camberwell'),
			array('Docklands','Docklands'),
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
			array('Glen Waverley','Glen Waverley'),
			array('Hawthorn','Hawthorn'),
			array('Malvern','Malvern'),
			array('Malvern East','Malvern East'),
			array('Melbourne City','Melbourne City'),
			array('Mount Waverley','Mount Waverley'),
			array('Mckinnon;','Mckinnon'),
			array('North Melbourne','North Melbourne'),
			array('Preston','Preston'),
			array('Piont Cook','Piont Cook'),
			array('South Bank','South Bank'),
			array('Reservoir','Reservoir'),
			array('Oakleigh','Oakleigh'),
			array('Oakleigh East','Oakleigh East'),
			array('Ormond','Ormond'),
			array('Ringwood','Ringwood'),
			array('Ringwood East','Ringwood East'),
			array('Vermont','Vermont'),
			array('Vermont South','Vermont South'),
		))),
		array('14','吉朗 VIC',array('name'=>'suburb','key'=>'VIC','value'=>array(
			array('Albert Park','Albert Park'),
			array('Bentleigh','Bentleigh'),
			array('Bentleith East','Bentleith East'),
			array('Burwood','Burwood'),
			array('Burwood East','Burwood East'),
			array('Brighton','Brighton'),
			array('Bundoora','Bundoora'),
			array('Box Hill','Box Hill'),
			array('Clayton','Clayton'),
			array('Carlton','Carlton'),
			array('Carnegie','Carnegie'),
			array('Camberwell','Camberwell'),
			array('Docklands','Docklands'),
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
			array('Glen Waverley','Glen Waverley'),
			array('Hawthorn','Hawthorn'),
			array('Malvern','Malvern'),
			array('Malvern East','Malvern East'),
			array('Melbourne City','Melbourne City'),
			array('Mount Waverley','Mount Waverley'),
			array('Mckinnon;','Mckinnon'),
			array('North Melbourne','North Melbourne'),
			array('Preston','Preston'),
			array('Piont Cook','Piont Cook'),
			array('South Bank','South Bank'),
			array('Reservoir','Reservoir'),
			array('Oakleigh','Oakleigh'),
			array('Oakleigh East','Oakleigh East'),
			array('Ormond','Ormond'),
			array('Ringwood','Ringwood'),
			array('Ringwood East','Ringwood East'),
			array('Vermont','Vermont'),
			array('Vermont South','Vermont South'),
		))),
		array('15','巴拉瑞特 VIC',array('name'=>'suburb','key'=>'VIC','value'=>array(
			array('Albert Park','Albert Park'),
			array('Bentleigh','Bentleigh'),
			array('Bentleith East','Bentleith East'),
			array('Burwood','Burwood'),
			array('Burwood East','Burwood East'),
			array('Brighton','Brighton'),
			array('Bundoora','Bundoora'),
			array('Box Hill','Box Hill'),
			array('Clayton','Clayton'),
			array('Carlton','Carlton'),
			array('Carnegie','Carnegie'),
			array('Camberwell','Camberwell'),
			array('Docklands','Docklands'),
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
			array('Glen Waverley','Glen Waverley'),
			array('Hawthorn','Hawthorn'),
			array('Malvern','Malvern'),
			array('Malvern East','Malvern East'),
			array('Melbourne City','Melbourne City'),
			array('Mount Waverley','Mount Waverley'),
			array('Mckinnon;','Mckinnon'),
			array('North Melbourne','North Melbourne'),
			array('Preston','Preston'),
			array('Piont Cook','Piont Cook'),
			array('South Bank','South Bank'),
			array('Reservoir','Reservoir'),
			array('Oakleigh','Oakleigh'),
			array('Oakleigh East','Oakleigh East'),
			array('Ormond','Ormond'),
			array('Ringwood','Ringwood'),
			array('Ringwood East','Ringwood East'),
			array('Vermont','Vermont'),
			array('Vermont South','Vermont South'),
		))),
		array('4','布里斯班 QLD',array('name'=>'suburb','key'=>'QLD','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('3','黄金海岸 QLD',array('name'=>'suburb','key'=>'QLD','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('6','堪培拉 ACT',array('name'=>'suburb','key'=>'ACT','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('5','阿德莱德 SA',array('name'=>'suburb','key'=>'SA','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('7','珀斯 WA',array('name'=>'suburb','key'=>'WA','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('8','达尔文 NT',array('name'=>'suburb','key'=>'NT','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('10','霍巴特 TAS',array('name'=>'suburb','key'=>'TAS','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('11','其他',array('name'=>'suburb','key'=>'','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
	);

	$config['inPutCity'] = $city; //城市配置

	$cityFilter  = array(
		array('2','悉尼 NSW',array('name'=>'suburb','value'=>array(
			array('Ashfield','Ashfield'),
			array('Auburn','Auburn'),
			array('Burwood','Burwood'),
			array('Campsie','Campsie'),
			array('Chatswood','Chatswood'),
			array('Eastwood','Eastwood'),
			array('Epping','Epping'),
			array('Haymarket','Haymarket'),
			array('Hurstville','Hurstville'),
			array('Kingsford','Kingsford'),
			array('Marsfield','Marsfield'),
			array('Parramatta','Parramatta'),
			array('Rhodes','Rhodes'),
			array('Ryde','Ryde'),
			array('Strathfield','Strathfield'),
			array('Sydney City','Sydney City'),
			array('Ultimo','Ultimo'),
			array('Waterloo','Waterloo'),
			array('Zetland','Zetland'),
		))),
		array('12','卧龙岗 NSW',array('name'=>'suburb','value'=>array(
			array('Ashfield','Ashfield'),
			array('Auburn','Auburn'),
			array('Burwood','Burwood'),
			array('Campsie','Campsie'),
			array('Chatswood','Chatswood'),
			array('Eastwood','Eastwood'),
			array('Epping','Epping'),
			array('Haymarket','Haymarket'),
			array('Hurstville','Hurstville'),
			array('Kingsford','Kingsford'),
			array('Marsfield','Marsfield'),
			array('Parramatta','Parramatta'),
			array('Rhodes','Rhodes'),
			array('Ryde','Ryde'),
			array('Strathfield','Strathfield'),
			array('Sydney City','Sydney City'),
			array('Ultimo','Ultimo'),
			array('Waterloo','Waterloo'),
			array('Zetland','Zetland'),
		))),
		array('13','中央海岸 NSW',array('name'=>'suburb','value'=>array(
			array('Ashfield','Ashfield'),
			array('Auburn','Auburn'),
			array('Burwood','Burwood'),
			array('Campsie','Campsie'),
			array('Chatswood','Chatswood'),
			array('Eastwood','Eastwood'),
			array('Epping','Epping'),
			array('Haymarket','Haymarket'),
			array('Hurstville','Hurstville'),
			array('Kingsford','Kingsford'),
			array('Marsfield','Marsfield'),
			array('Parramatta','Parramatta'),
			array('Rhodes','Rhodes'),
			array('Ryde','Ryde'),
			array('Strathfield','Strathfield'),
			array('Sydney City','Sydney City'),
			array('Ultimo','Ultimo'),
			array('Waterloo','Waterloo'),
			array('Zetland','Zetland'),
		))),
		array('1','墨尔本 VIC',array('name'=>'suburb','value'=>array(
			array('Albert Park','Albert Park'),
			array('Bentleigh','Bentleigh'),
			array('Bentleith East','Bentleith East'),
			array('Burwood','Burwood'),
			array('Burwood East','Burwood East'),
			array('Brighton','Brighton'),
			array('Bundoora','Bundoora'),
			array('Box Hill','Box Hill'),
			array('Clayton','Clayton'),
			array('Carlton','Carlton'),
			array('Carnegie','Carnegie'),
			array('Camberwell','Camberwell'),
			array('Docklands','Docklands'),
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
			array('Glen Waverley','Glen Waverley'),
			array('Hawthorn','Hawthorn'),
			array('Malvern','Malvern'),
			array('Malvern East','Malvern East'),
			array('Melbourne City','Melbourne City'),
			array('Mount Waverley','Mount Waverley'),
			array('Mckinnon;','Mckinnon'),
			array('North Melbourne','North Melbourne'),
			array('Preston','Preston'),
			array('Piont Cook','Piont Cook'),
			array('South Bank','South Bank'),
			array('Reservoir','Reservoir'),
			array('Oakleigh','Oakleigh'),
			array('Oakleigh East','Oakleigh East'),
			array('Ormond','Ormond'),
			array('Ringwood','Ringwood'),
			array('Ringwood East','Ringwood East'),
			array('Vermont','Vermont'),
			array('Vermont South','Vermont South'),
		))),
		array('14','吉朗 VIC',array('name'=>'suburb','value'=>array(
			array('Albert Park','Albert Park'),
			array('Bentleigh','Bentleigh'),
			array('Bentleith East','Bentleith East'),
			array('Burwood','Burwood'),
			array('Burwood East','Burwood East'),
			array('Brighton','Brighton'),
			array('Bundoora','Bundoora'),
			array('Box Hill','Box Hill'),
			array('Clayton','Clayton'),
			array('Carlton','Carlton'),
			array('Carnegie','Carnegie'),
			array('Camberwell','Camberwell'),
			array('Docklands','Docklands'),
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
			array('Glen Waverley','Glen Waverley'),
			array('Hawthorn','Hawthorn'),
			array('Malvern','Malvern'),
			array('Malvern East','Malvern East'),
			array('Melbourne City','Melbourne City'),
			array('Mount Waverley','Mount Waverley'),
			array('Mckinnon;','Mckinnon'),
			array('North Melbourne','North Melbourne'),
			array('Preston','Preston'),
			array('Piont Cook','Piont Cook'),
			array('South Bank','South Bank'),
			array('Reservoir','Reservoir'),
			array('Oakleigh','Oakleigh'),
			array('Oakleigh East','Oakleigh East'),
			array('Ormond','Ormond'),
			array('Ringwood','Ringwood'),
			array('Ringwood East','Ringwood East'),
			array('Vermont','Vermont'),
			array('Vermont South','Vermont South'),
		))),
		array('15','巴拉瑞特 VIC',array('name'=>'suburb','value'=>array(
			array('Albert Park','Albert Park'),
			array('Bentleigh','Bentleigh'),
			array('Bentleith East','Bentleith East'),
			array('Burwood','Burwood'),
			array('Burwood East','Burwood East'),
			array('Brighton','Brighton'),
			array('Bundoora','Bundoora'),
			array('Box Hill','Box Hill'),
			array('Clayton','Clayton'),
			array('Carlton','Carlton'),
			array('Carnegie','Carnegie'),
			array('Camberwell','Camberwell'),
			array('Docklands','Docklands'),
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
			array('Glen Waverley','Glen Waverley'),
			array('Hawthorn','Hawthorn'),
			array('Malvern','Malvern'),
			array('Malvern East','Malvern East'),
			array('Melbourne City','Melbourne City'),
			array('Mount Waverley','Mount Waverley'),
			array('Mckinnon;','Mckinnon'),
			array('North Melbourne','North Melbourne'),
			array('Preston','Preston'),
			array('Piont Cook','Piont Cook'),
			array('South Bank','South Bank'),
			array('Reservoir','Reservoir'),
			array('Oakleigh','Oakleigh'),
			array('Oakleigh East','Oakleigh East'),
			array('Ormond','Ormond'),
			array('Ringwood','Ringwood'),
			array('Ringwood East','Ringwood East'),
			array('Vermont','Vermont'),
			array('Vermont South','Vermont South'),
		))),
		array('4','布里斯班 QLD',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('3','黄金海岸 QLD',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('6','堪培拉 ACT',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('5','阿德莱德 SA',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('7','珀斯 WA',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('8','达尔文 NT',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('10','霍巴特 TAS',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
		array('11','其他',array('name'=>'suburb','value'=>array(
			array('Doncaster','Doncaster'),
			array('Footscray','Footscray'),
		))),
	);

	$config['filterCity'] = $cityFilter; //城市配置
	$forumList = array(
		'section_1'=>array(
			array('fid'=>291,'typeid'=>0,'forumname'=>'汽车出售','picList'=>1,'isPhone'=>1,'mustPic'=>1,'allowGuest'=>0),
			array('fid'=>142,'typeid'=>0,'forumname'=>'房屋租赁','picList'=>1,'isPhone'=>1,'mustPic'=>1,'allowGuest'=>0),
			array('fid'=>161,'typeid'=>0,'forumname'=>'岗位招聘','picList'=>0,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>715,'typeid'=>0,'forumname'=>'车辆求购','picList'=>0,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>680,'typeid'=>0,'forumname'=>'房屋求租','picList'=>0,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>714,'typeid'=>0,'forumname'=>'个人求职','picList'=>0,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
		),
		'section_2'=>array(
			array('fid'=>305,'typeid'=>0,'forumname'=>'房屋交易','picList'=>1,'isPhone'=>1,'mustPic'=>1,'allowGuest'=>0),
			array('fid'=>681,'typeid'=>0,'forumname'=>'房屋求购','picList'=>0,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>89,'typeid'=>0,'forumname'=>'超级市场','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>716,'typeid'=>0,'forumname'=>'生意买卖','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>304,'typeid'=>0,'forumname'=>'二手市场','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>679,'typeid'=>0,'forumname'=>'二手教材','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>919,'forumname'=>'二手回收','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>650,'forumname'=>'旅游机票','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>402,'forumname'=>'清洁通渠','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>401,'forumname'=>'机场接送','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>929,'forumname'=>'物流搬运','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>1158,'forumname'=>'快递服务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>1161,'forumname'=>'车辆租赁','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>404,'forumname'=>'汽车综合','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>1162,'forumname'=>'驾校招生','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>649,'forumname'=>'金融保险','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>403,'forumname'=>'建筑家装','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>917,'forumname'=>'园艺绿化','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>925,'forumname'=>'金属机械','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>474,'forumname'=>'电器服务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>480,'forumname'=>'留学移民','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>405,'forumname'=>'教育培训','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>481,'forumname'=>'翻译服务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>479,'forumname'=>'医疗健康','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>884,'forumname'=>'手机数码','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>407,'forumname'=>'电脑网络','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>1156,'forumname'=>'印刷喷绘','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>1165,'forumname'=>'设计策划','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),


			array('fid'=>651,'typeid'=>471,'forumname'=>'摄影婚礼','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>400,'forumname'=>'餐饮美食','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>1166,'forumname'=>'休闲娱乐','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>472,'forumname'=>'美容美发','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>406,'forumname'=>'会计税务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>1159,'forumname'=>'贷款服务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>918,'forumname'=>'律师服务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>928,'forumname'=>'保姆月嫂','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),

			array('fid'=>651,'typeid'=>1306,'forumname'=>'裁缝修补','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>398,'forumname'=>'其它服务','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
			array('fid'=>651,'typeid'=>399,'forumname'=>'求助咨询','picList'=>1,'isPhone'=>1,'mustPic'=>0,'allowGuest'=>0),
		),
	);
	$config['forumList'] = $forumList; //板块配置;

	$inputAry = array();
	//车辆出售
	$inputAry['f291_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'postcode',
				'label' => '邮编',
				'type' => 'text',
			),
			array(
				'name' => 'carfrom',
				'label' => '车辆类型',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','私人二手'),
					array('2','商家二手'),
					array('3','新车'),
				),
			),
			array(
				'name' => 'carmake',
				'label' => '车辆品牌',
				'isnull' => 'not',
				'type' => 'api',
				'api' => 'https://app.yeeyi.com/index.php?app=tools&act=getCarModel',
			),
			array(
				'name' => 'bodytype',
				'label' => '车型',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','请选择'),
					array('1','轿车'),
					array('2','SUV越野车'),
					array('3','MPV商务车'),
					array('4','跑车'),
					array('5','面包车'),
					array('6','卡车'),
				),
			),
			array(
				'name' => 'transmission',
				'label' => '变速箱',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','手动'),
					array('2','自动'),
					array('3','手自一体'),
				),
			),
			array(
				'name' => 'colour',
				'label' => '颜色',
				'type' => 'select',
				'value' => array(
					array('0','请选择'),
					array('1','黑色'),
					array('2','白色'),
					array('3','银灰色'),
					array('4','深灰色'),
					array('5','棕色'),
					array('6','红色'),
					array('7','粉色'),
					array('8','橙色'),
					array('9','绿色'),
					array('10','蓝色'),
					array('11','咖啡色'),
					array('12','紫色'),
					array('13','金色'),
					array('14','香槟色'),
					array('15','多彩色'),
					array('16','黄色'),
					array('17','其它'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'drives',
				'label' => '驱动',
				'type' => 'select',
				'value' => array(
					array('1','前驱'),
					array('2','后驱'),
					array('3','四驱'),
				),
			),
			array(
				'name' => 'seats',
				'label' => '座位数',
				'type' => 'select',
				'value' => array(
					array('none','请选择'),
					array('2','2座'),
					array('4','4座'),
					array('5','5座'),
					array('6','6座'),
					array('7','7座'),
					array('8','7座以上'),
				),
			),
			array(
				'name' => 'doors',
				'label' => '门数',
				'type' => 'select',
				'value' => array(
					array('2','2门'),
					array('3','3门'),
					array('4','4门'),
					array('5','5门'),
				),
			),
			array(
				'name' => 'fueltype',
				'label' => '燃油类型',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','汽油'),
					array('2','柴油'),
					array('3','油电混合'),
					array('4','电动'),
				),
			),
			array(
				'name' => 'displace',
				'label' => '排量',
				'type' => 'text',
			),
			array(
				'name' => 'kilometres',
				'label' => '行驶里程',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'havemaintenance',
				'label' => '保养记录',
				'type' => 'select',
				'value' => array(
					array('1','有'),
					array('2','无'),
				),
			),
			array(
				'name' => 'marktime',
				'label' => '首次上牌日期',
				'type' => 'date',
			),
			array(
				'name' => 'car_price',
				'label' => '价格',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '车辆详细介绍',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//车辆求购
	$inputAry['f715_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'postcode',
				'label' => '邮编',
				'type' => 'text',
			),
			array(
				'name' => 'carfrom',
				'label' => '车辆来源',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','私人'),
					array('2','商家'),
					array('3','新车'),
				),
			),
			array(
				'name' => 'carmake',
				'label' => '车辆品牌',
				'isnull' => 'not',
				'type' => 'api',
				'api' => 'https://app.yeeyi.com/index.php?app=tools&act=getCarModel',
			),
		),
		'section_3'=>array(
			array(
				'name' => 'carprice',
				'label' => '期望价格',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('不限','不限'),
					array('5K以下','5K以下'),
					array('5K-10K','5K-10K'),
					array('10K-20K','10K-20K'),
					array('20K-30K','20K-30K'),
					array('30k-40k','30k-40k'),
					array('40k以上','40k以上'),
				),
			),
			array(
				'name' => 'carage',
				'label' => '期望车龄',
				'type' => 'select',
				'value' => array(
					array('不限','不限'),
					array('1年以内','1年以内'),
					array('1-3年','1-3年'),
					array('3-5年','3-5年'),
					array('5-8年','5-8年'),
					array('8-10年','8-10年'),
					array('10年以上','10年以上'),
				),
			),
			array(
				'name' => 'bodytype',
				'label' => '期望车型',
				'type' => 'select',
				'value' => array(
					array('0','请选择'),
					array('1','轿车'),
					array('2','SUV越野车'),
					array('3','MPV商务车'),
					array('4','跑车'),
					array('5','面包车'),
					array('6','卡车'),
				),
			),
			array(
				'name' => 'kilometres',
				'label' => '里程',
				'type' => 'select',
				'value' => array(
					array('不限','不限'),
					array('1万公里内','1万公里内'),
					array('3万公里内','3万公里内'),
					array('6万公里内','6万公里内'),
					array('10万公里内','10万公里内'),
					array('10万公里以上','10万公里以上'),
				),
			),
			array(
				'name' => 'transmission',
				'label' => '变速箱',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','手动'),
					array('2','自动'),
					array('3','手自一体'),
				),
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '附言',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//个人求职
	$inputAry['f714_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'text',
			),
			array(
				'name' => 'postcode',
				'label' => '邮编',
				'type' => 'text',
			),
			array(
				'name' => 'position',
				'label' => '期望职位',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','职位分类'),
					array('1','技师/工人/学徒'),
					array('2','编辑/翻译/律师'),
					array('3','传媒/印刷/艺术/设计'),
					array('4','网管/IT安装/程序员'),
					array('5','财务/人力资源/行政/文秘'),
					array('6','互联网/通讯'),
					array('7','清洁/搬运/库管/司机'),
					array('8','公关/演艺/模特/摄影'),
					array('9','销售/市场/业务'),
					array('10','医护/按摩/美容/发型'),
					array('11','教师/教练/家教'),
					array('12','游戏代练/游戏推广'),
					array('13','店员/收银/客服'),
					array('14','厨师/服务员/帮工/外卖'),
					array('15','旅行/导游'),
					array('16','保姆/月嫂/钟点工'),
					array('17','实习机会/义工'),
					array('18','兼职信息'),
				),
			),
			array(
				'name' => 'salary_form',
				'label' => '期望薪资',
				'type' => 'switcher',
				'switcher' => array(
					array(
						'0','请选择',array('name'=>'salary','value'=>array(
						array('0','不限'),
					))
					),
					array(
						'1','Hourly rates',array('name'=>'salary','value'=>array(
						array('1','$15以下'),
						array('2','$15－$30'),
						array('3','$30－$60'),
						array('4','$60－$100'),
						array('5','$100以上'),
					))
					),
					array(
						'2','Annually rates',array('name'=>'salary','value'=>array(
						array('6','$30K以下'),
						array('7','$30K－$60K'),
						array('8','$60K－$100K'),
						array('9','$100K－$150K'),
						array('10','$150K-$200K'),
						array('11','$200K以上'),
					))
					),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'ages',
				'label' => '年龄',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'education',
				'label' => '最高学历',
				'type' => 'select',
				'value' => array(
					array('none','请选择'),
					array('1','completed Year 9-11'),
					array('2','completed High School(year 12)'),
					array('3','Diploma'),
					array('4','TAFE/Trade Certificate'),
					array('5','Undergraduate'),
					array('6','Post Graduate Degree'),
					array('7','Masters'),
					array('8','PhD'),
				),
			),
			array(
				'name' => 'property',
				'label' => '工作性质',
				'type' => 'select',
				'isnull' => 'not',
				'value' => array(
					array('全职','全职'),
					array('兼职','兼职'),
					array('合同工','合同工'),
					array('实习','实习'),
					array('临时','临时'),
				),
			),
			array(
				'name' => 'visa',
				'label' => '签证状态',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('PR','PR'),
					array('工作签','工作签'),
					array('学生签','学生签'),
					array('澳洲国籍','澳洲国籍'),
				),
			),
			array(
				'name' => 'worktime',
				'label' => '可工作时间',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '自我介绍',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//岗位招聘
	$inputAry['f161_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'text',
			),
			array(
				'name' => 'company',
				'label' => '公司名称',
				'type' => 'text',
			),
			array(
				'name' => 'position',
				'label' => '招聘职位',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('none','职位分类'),
					array('1','技师/工人/学徒'),
					array('2','编辑/翻译/律师'),
					array('3','传媒/印刷/艺术/设计'),
					array('4','网管/IT安装/程序员'),
					array('5','财务/人力资源/行政/文秘'),
					array('6','互联网/通讯'),
					array('7','清洁/搬运/库管/司机'),
					array('8','公关/演艺/模特/摄影'),
					array('9','销售/市场/业务'),
					array('10','医护/按摩/美容/发型'),
					array('11','教师/教练/家教'),
					array('12','游戏代练/游戏推广'),
					array('13','店员/收银/客服'),
					array('14','厨师/服务员/帮工/外卖'),
					array('15','旅行/导游'),
					array('16','保姆/月嫂/钟点工'),
					array('17','实习机会/义工'),
					array('18','兼职信息'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'property',
				'label' => '工作性质',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('不限','不限'),
					array('全职','全职'),
					array('兼职','兼职'),
					array('合同工','合同工'),
					array('实习','实习'),
					array('临时','临时'),
				),
			),
			array(
				'name' => 'visa',
				'label' => '签证状态',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('不限','不限'),
					array('PR','PR'),
					array('工作签','工作签'),
					array('学生签','学生签'),
					array('澳洲国籍','澳洲国籍'),
				),
			),
			array(
				'name' => 'experience',
				'label' => '经验要求',
				'type' => 'select',
				'value' => array(
					array('需要','需要'),
					array('不需要','不需要'),
				),
			),
			array(
				'name' => 'education',
				'label' => '学历要求',
				'type' => 'select',
				'value' => array(
					array('none','请选择'),
					array('1','completed Year 9-11'),
					array('2','completed High School(year 12)'),
					array('3','Diploma'),
					array('4','TAFE/Trade Certificate'),
					array('5','Undergraduate'),
					array('6','Post Graduate Degree'),
					array('7','Masters'),
					array('8','PhD'),
				),
			),
			array(
				'name' => 'p_num',
				'label' => '招聘人数',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'salary_form',
				'label' => '工资待遇',
				'type' => 'switcher',
				'switcher' => array(
					array(
						'0','请选择',array('name'=>'salary','value'=>array(
						array('0','不限'),
					))
					),
					array(
						'3','面议',array('name'=>'salary','value'=>array(
						array('0','不限'),
					))
					),
					array(
						'1','Hourly rates',array('name'=>'salary','value'=>array(
						array('1','$15以下'),
						array('2','$15－$30'),
						array('3','$30－$60'),
						array('4','$60－$100'),
						array('5','$100以上'),
					))
					),
					array(
						'2','Annually rates',array('name'=>'salary','value'=>array(
						array('6','$30K以下'),
						array('7','$30K－$60K'),
						array('8','$60K－$100K'),
						array('9','$100K－$150K'),
						array('10','$150K-$200K'),
						array('11','$200K以上'),
					))
					),
				),
			),
			array(
				'name' => 'annualleave',
				'label' => 'Annual leave',
				'type' => 'select',
				'value' => array(
					array('有','有'),
					array('无','无'),
				),
			),
			array(
				'name' => 'superannua',
				'label' => 'Superannuation',
				'type' => 'select',
				'value' => array(
					array('有','有'),
					array('无','无'),
				),
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '职位描述&公司简介',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//房屋租赁
	$inputAry['f142_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),

		),
		'section_2'=>array(

			array(
				'name' => 'address',
				'label' => '地址',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'validity',
				'label' => '有效期',
				'type' => 'select',
				'value' => array(
					array('0','永久有效'),
					array('259200','三天'),
					array('432000','五天'),
					array('604800','七天'),
					array('2592000','一个月'),
					array('7776000','三个月'),
					array('15552000','半年'),
					array('31536000','一年'),
				),
			),
						array(
				'name' => 'house_from',
				'label' => '来源',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','个人'),
					array('2','中介'),
				),
			),
			array(
				'name' => 'iscity',
				'label' => '房源是否在City',
				'type' => 'select',
				'value' => array(
					array('1','不在'),
					array('2','在'),
				),
			),
			array(
				'name' => 'house_type',
				'label' => '类型',
				'type' => 'select',
				'isnull' => 'not',
				'value' => array(
					array('1','公寓Apartment'),
					array('2','小区Unit'),
					array('3','平房Bungalow'),
					array('4','别墅House'),
					array('5','厂房Factory Building'),
					array('6','写字楼Office'),
					array('7','商铺Commercial'),
					array('8','车位Garage'),
					array('9','地下室Basement'),
				),
			),
			array(
				'name' => 'house_room',
				'label' => '室',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
					array('6','6'),
					array('7','7'),
					array('8','8'),
					array('9','9'),
					array('10','10'),
				),
			),
			array(
				'name' => 'house_hall',
				'label' => '厅',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
				),
			),
			array(
				'name' => 'house_toilet',
				'label' => '卫',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
				),
			),
			array(
				'name' => 'house_balcony',
				'label' => '阳台',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
				),
			),

			array(
				'name' => 'house_ku',
				'label' => '车库',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','0'),
					array('2','1'),
					array('3','2'),
					array('4','3'),
				),
			),
		),
		'section_3'=>array(

			array(
				'name' => 'house_rents',
				'label' => '租金',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'rent_type',
				'label' => '出租方式',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','整租'),
					array('2','转租'),
					array('3','单间'),
					array('4','客厅'),
					array('5','合租'),
					array('6','其它'),
				),
			),
			array(
				'name' => 'in_date',
				'label' => '可入住时间',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'house_sex',
				'label' => '性别要求',
				'type' => 'select',
				'value' => array(
					array('1','男女不限'),
					array('2','限女生'),
					array('3','限男生'),
				),
			),
			array(
				'name' => 'house_equipment',
				'label' => '配套设施',
				'type' => 'checkbox',
				'value' => array(
					array('1','包水'),
					array('2','包电'),
					array('3','包煤气'),
					array('4','包宽带'),
					array('5','有线电视'),
					array('6','床'),
					array('7','冰箱'),
					array('8','洗衣机'),
					array('9','热水器'),
					array('10','空调'),
					array('11','停车位'),
					array('12','家俱'),
					array('13','全包'),
				),
			),
			array(
				'name' => 'bus_info',
				'label' => '周边设施',
				'type' => 'checkbox',
				'value' => array(
					array('1','火车站'),
					array('2','公交站'),
					array('3','学校'),
					array('4','超市'),
					array('5','健身房'),
					array('6','游泳馆'),
				),
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//房屋求租
	$inputAry['f680_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'validity',
				'label' => '有效期|validity',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','永久有效'),
					array('259200','三天'),
					array('432000','五天'),
					array('604800','七天'),
					array('2592000','一个月'),
					array('7776000','三个月'),
					array('15552000','半年'),
					array('31536000','一年'),
				),
			),
			array(
				'name' => 'address',
				'label' => '地址',
				'type' => 'text',
			),
		),
		'section_3'=>array(
			array(
				'name' => 'rent_type',
				'label' => '求租方式',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','整租'),
					array('2','转租'),
					array('3','单间'),
					array('4','客厅'),
					array('5','Share'),
					array('6','均可'),
				),
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//房屋交易
	$inputAry['f305_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'validity',
				'label' => '有效期|validity',
				'type' => 'select',
				'value' => array(
					array('0','永久有效'),
					array('259200','三天'),
					array('432000','五天'),
					array('604800','七天'),
					array('2592000','一个月'),
					array('7776000','三个月'),
					array('15552000','半年'),
					array('31536000','一年'),
				),
			),
			array(
				'name' => 'description',
				'label' => '房屋特色',
				'type' => 'text',
			),
			array(
				'name' => 'house_type',
				'label' => '房屋类型|House Type',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','别墅/house'),
					array('2','联排别墅/townhouse'),
					array('3','单元房/unit'),
					array('4','公寓/apartment'),
					array('5','土地/land'),
					array('6','商铺/commercial'),
				),
			),
		),
		'section_3'=>array(

			array(
				'name' => 'address',
				'label' => '地址|Address',
				'type' => 'text',
			),
			array(
				'name' => 'iscity',
				'label' => '房源是否在City',
				'type' => 'select',
				'value' => array(
					array('1','不在'),
					array('2','在'),
				),
			),
			array(
				'name' => 'price',
				'label' => '出售售价(万元)',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'showtime',
				'label' => '看房时间|Inspection',
				'type' => 'text',
			),

			array(
				'name' => 'readyhouse',
				'label' => '现房/期房',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','现房Established'),
					array('2','期房Off plan'),
				),
			),
			array(
				'name' => 'house_room',
				'label' => '室',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
					array('6','6'),
					array('7','7'),
					array('8','8'),
					array('9','9'),
					array('10','10'),
				),
			),
			array(
				'name' => 'house_hall',
				'label' => '厅',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
				),
			),
			array(
				'name' => 'house_toilet',
				'label' => '卫',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
				),
			),
			array(
				'name' => 'house_balcony',
				'label' => '阳台',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','0'),
					array('1','1'),
					array('2','2'),
					array('3','3'),
					array('4','4'),
					array('5','5'),
				),
			),
			array(
				'name' => 'house_ku',
				'label' => '车库',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','0'),
					array('2','1'),
					array('3','2'),
					array('4','3'),
				),
			),
			array(
				'name' => 'allowforeigner',
				'label' => '海外人士购买',
				'type' => 'select',
				'value' => array(
					array('1','是Yes'),
					array('2','否No'),
				),
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//房屋求购
	$inputAry['f681_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(
			array(
				'name' => 'validity',
				'label' => '有效期|validity',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('0','永久有效'),
					array('259200','三天'),
					array('432000','五天'),
					array('604800','七天'),
					array('2592000','一个月'),
					array('7776000','三个月'),
					array('15552000','半年'),
					array('31536000','一年'),
				),
			),
			array(
				'name' => 'house_position',
				'label' => '目标区域',
				'type' => 'text',
			),
		),
		'section_3'=>array(
			array(
				'name' => 'house_type',
				'label' => '求购类型',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','别墅/house'),
					array('2','联排别墅/townhouse'),
					array('3','单元房/unit'),
					array('4','公寓/apartment'),
					array('5','土地/land'),
					array('6','商铺/commercial'),
				),
			),
			array(
				'name' => 'iscity',
				'label' => '房源是否在City',
				'type' => 'select',
				'value' => array(
					array('1','不在'),
					array('2','在'),
				),
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),

	);
	//二手市场
	$inputAry['f304_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(

			array(
				'name' => 'postcode',
				'label' => 'postcode',
				'type' => 'text',
			),
			array(
				'name' => 'typeid',
				'label' => '类别',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('743','女性'),
					array('744','男性'),
					array('745','杂七杂八'),
					array('746','食品其它'),
					array('747','家具用品'),
					array('748','电脑网络'),
					array('1214','亲子用品'),
					array('1188','手机数码'),
					array('749','图书音像'),
					array('905','摄影器材'),
					array('751','其他'),
				),
			),
			array(
				'name' => 'delivery',
				'label' => '是否送货',
				'type' => 'select',
				'value' => array(
					array('1','送货'),
					array('2','不送'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'fromtype',
				'label' => '来源',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','个人'),
					array('2','商家'),
				),
			),
			array(
				'name' => 'markettype',
				'label' => '需求',
				'type' => 'select',
				'isnull' => 'not',
				'value' => array(
					array('1','求购'),
					array('2','出售'),
				),
			),
			array(
				'name' => 'price',
				'label' => '价格',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),



	);
	//超级市场
	$inputAry['f89_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(

			array(
				'name' => 'typeid',
				'label' => '类别',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('94','服装鞋帽'),
					array('101','手机数码'),
					array('99','家居用品'),
					array('823','母婴用品'),
					array('95','游戏娱乐'),
					array('1210','车饰配件'),
					array('475','办公用品'),
					array('103','成人用品'),
					array('477','美容美体'),
					array('478','体育用品'),
					array('476','箱包首饰'),
					array('102','食品饮品'),
					array('98','书刊杂志'),
					array('96','电脑配件'),
					array('742','建筑材料'),
					array('93','代购'),
					array('100','问答'),
					array('92','其它'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'price',
				'label' => '价格',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//生意买卖
	$inputAry['f716_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(

			array(
				'name' => 'hangye',
				'label' => '行业类型',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'company_name',
				'label' => '公司名称',
				'type' => 'text',
			),
			array(
				'name' => 'company_address',
				'label' => '公司地址',
				'type' => 'text',
			),
		),
		'section_3'=>array(
			array(
				'name' => 'price',
				'label' => '价格',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//二手教材
	$inputAry['f679_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(

			array(
				'name' => 'school',
				'label' => '学校',
				'type' => 'select',
				'value' => array(
					array('TAFE','TAFE'),
					array('MQ','MQ'),
					array('USYD','USYD'),
					array('UNSW','UNSW'),
					array('UTS','UTS'),
					array('UWS','UWS'),
					array('UOW','UOW'),
					array('ANU','ANU'),
					array('UofMELB','UofMELB'),
					array('MONASH','MONASH'),
					array('DEAKIN','DEAKIN'),
					array('LATROBE','LATROBE'),
					array('RMIT','RMIT'),
					array('CURTIN','CURTIN'),
					array('UQ','UQ'),
					array('UWA','UWA'),
					array('ADELAIDE','ADELAIDE'),
					array('0','其他大学'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'xuqiu',
				'label' => '需求',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1','求购'),
					array('2','出售'),
				),
			),
			array(
				'name' => 'typeid',
				'label' => '类型',
				'isnull' => 'not',
				'type' => 'select',
				'value' => array(
					array('1002','学习器材'),
					array('1003','学习资料'),
				),
			),
			array(
				'name' => 'price',
				'label' => '价格',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);
	//生活服务
	$inputAry['f651_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'subject',
				'label' => '标题',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'isnull' => 'not',
				'type' => 'text',
			),
		),
		'section_2'=>array(

			array(
				'name' => 'typeid',
				'label' => '服务分类',
				'type' => 'select',
				'value' => array(
					array('400','餐饮美食'),
					array('1166','休闲娱乐'),
					array('472','美容美发'),
					array('402','清洁通渠'),
					array('928','保姆月嫂'),
					array('401','机场接送'),
					array('929','物流搬运'),
					array('1158','快递服务'),
					array('1161','车辆租赁'),
					array('650','旅游机票'),
					array('917','园艺绿化'),
					array('403','建筑家装'),
					array('471','摄影婚礼'),
					array('407','电脑网络'),
					array('884','手机数码'),
					array('474','电器服务'),
					array('1156','印刷喷绘'),
					array('1165','设计策划'),
					array('1162','驾校招生'),
					array('404','汽车综合'),
					array('405','教育培训'),
					array('480','留学移民'),
					array('406','会计税务'),
					array('918','律师服务'),
					array('481','翻译服务'),
					array('1159','贷款服务'),
					array('649','金融保险'),
					array('479','医疗健康'),
					array('925','金属机械'),
					array('919','二手回收'),
					array('1306','裁缝修补'),
					array('398','其它服务'),
					array('399','求助咨询'),
				),
			),

		),
		'section_3'=>array(
			array(
				'name' => 'company_name',
				'label' => '公司名称',
				'type' => 'text',
			),
			array(
				'name' => 'company_address',
				'label' => '公司地址',
				'type' => 'text',
			),
			array(
				'name' => 'company_website',
				'label' => '公司网址',
				'type' => 'text',
			),
			array(
				'name' => 'company_info',
				'label' => '公司简介',
				'type' => 'text',
			),
			array(
				'name' => 'company_service',
				'label' => '服务项目',
				'type' => 'text',
			),
			array(
				'name' => 'company_area',
				'label' => '服务区域',
				'type' => 'text',
			),
		),
		'section_4'=>array(
			array(
				'name' => 'message',
				'label' => '详细信息',
				'isnull' => 'not',
				'type' => 'long',
			),
		),
		'section_5'=>array(
			array(
				'name' => 'poster',
				'label' => '联系人',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'tel',
				'label' => '电话',
				'isnull' => 'not',
				'type' => 'text',
			),
			array(
				'name' => 'weixin',
				'label' => '微信',
				'type' => 'text',
			),
			array(
				'name' => 'qq',
				'label' => 'QQ',
				'type' => 'text',
			),
			array(
				'name' => 'email',
				'label' => '邮箱',
				'type' => 'text',
			),
		),
	);

    //输入参数
    $config['inputParam'] = $inputAry;
    //过滤参数
    $filterAry = array();
    $filterAry['f291_0'] = array(
        'section_1'=>array(
			array(
				'name' => 'carfrom',
				'label' => '车辆类型',
				'type' => 'select',
				'value' => array(
					array('1','私人二手'),
					array('2','商家二手'),
					array('3','新车'),
				),
			),
			array(
				'name' => 'carmake',
				'label' => '车辆品牌',
				'type' => 'api',
				'api' => 'https://app.yeeyi.com/index.php?app=tools&act=getCarModel',
			),
			array(
				'name' => 'bodytype',
				'label' => '车型',
				'type' => 'select',
				'value' => array(
					array('0','请选择'),
					array('1','轿车'),
					array('2','SUV越野车'),
					array('3','MPV商务车'),
					array('4','跑车'),
					array('5','面包车'),
					array('6','卡车'),
				),
			),
		),
        'section_2'=>array(
			array(
				'name' => 'transmission',
				'label' => '变速箱',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','手动'),
					array('2','自动'),
					array('3','手自一体'),
				),
			),
			array(
				'name' => 'fueltype',
				'label' => '燃油类型',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','汽油'),
					array('2','柴油'),
					array('3','油电混合'),
					array('4','电动'),
				),
			),
		),
        'section_3'=>array(
			array(
				'name' => 'kilometres',
				'label' => '里程',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','1万公里内'),
					array('2','3万公里内'),
					array('3','6万公里内'),
					array('4','10万公里内'),
					array('5','10万公里以上'),
				),
			),
		),
    );
    //车辆求购
    $filterAry['f715_0'] = array(
        'section_1'=> array(
			array(
				'name' => 'carmake',
				'label' => '车辆品牌',
				'type' => 'api',
				'api' => 'https://app.yeeyi.com/index.php?app=tools&act=getCarModel',
			),
		),
        'section_2'=> array(
			array(
				'name' => 'carprice',
				'label' => '期望价格',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','5K以下'),
					array('2','5K-10K'),
					array('3','10K-20K'),
					array('4','20K-30K'),
					array('5','30k-40k'),
					array('6','40k以上'),
				),
			),
		),
        'section_3'=>array(
			array(
				'name' => 'transmission',
				'label' => '变速箱',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','手动'),
					array('2','自动'),
					array('3','手自一体'),
				),
			),
		),
    );
    //个人求职
    $filterAry['f714_0'] = array(
        'section_1'=> array(
				array(
					'name' => 'visa',
					'label' => '签证状态',
					'type' => 'select',
					'value' => array(
						array('0','不限'),
						array('PR','PR'),
						array('工作签','工作签'),
						array('学生签','学生签'),
						array('澳洲国籍','澳洲国籍'),
					),
				),
		),
		'section_2'=> array(
			array(
				'name' => 'property',
				'label' => '工作性质',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('全职','全职'),
					array('兼职','兼职'),
					array('合同工','合同工'),
					array('实习','实习'),
					array('临时','临时'),
				),
			),
		),
		'section_3'=> array(
			array(
				'name' => 'position',
				'label' => '期望职位',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','技师/工人/学徒'),
					array('2','编辑/翻译/律师'),
					array('3','传媒/印刷/艺术/设计'),
					array('4','网管/IT安装/程序员'),
					array('5','财务/人力资源/行政/文秘'),
					array('6','互联网/通讯'),
					array('7','清洁/搬运/库管/司机'),
					array('8','公关/演艺/模特/摄影'),
					array('9','销售/市场/业务'),
					array('10','医护/按摩/美容/发型'),
					array('11','教师/教练/家教'),
					array('12','游戏代练/游戏推广'),
					array('13','店员/收银/客服'),
					array('14','厨师/服务员/帮工/外卖'),
					array('15','旅行/导游'),
					array('16','保姆/月嫂/钟点工'),
					array('17','实习机会/义工'),
					array('18','兼职信息'),
				),
			),
		),
    );
    //岗位招聘
    $filterAry['f161_0'] = array(
		'section_1'=> array(
			array(
				'name' => 'visa',
				'label' => '签证状态',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('PR','PR'),
					array('工作签','工作签'),
					array('学生签','学生签'),
					array('澳洲国籍','澳洲国籍'),
				),
			),
		),
		'section_2'=> array(
			array(
				'name' => 'property',
				'label' => '工作性质(可多选)',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('全职','全职'),
					array('兼职','兼职'),
					array('合同工','合同工'),
					array('实习','实习'),
					array('临时','临时'),
				),
			),
		),
		'section_3'=> array(
			array(
				'name' => 'position',
				'label' => '期望职位',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','技师/工人/学徒'),
					array('2','编辑/翻译/律师'),
					array('3','传媒/印刷/艺术/设计'),
					array('4','网管/IT安装/程序员'),
					array('5','财务/人力资源/行政/文秘'),
					array('6','互联网/通讯'),
					array('7','清洁/搬运/库管/司机'),
					array('8','公关/演艺/模特/摄影'),
					array('9','销售/市场/业务'),
					array('10','医护/按摩/美容/发型'),
					array('11','教师/教练/家教'),
					array('12','游戏代练/游戏推广'),
					array('13','店员/收银/客服'),
					array('14','厨师/服务员/帮工/外卖'),
					array('15','旅行/导游'),
					array('16','保姆/月嫂/钟点工'),
					array('17','实习机会/义工'),
					array('18','兼职信息'),
				),
			),
		),
    );
    //房屋租赁
    $filterAry['f142_0'] = array(
        'section_1'=> array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'select',
				'value' => array(),
			),
			array(
				'name' => 'house_type',
				'label' => '类型',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','公寓Apartment'),
					array('2','小区Unit'),
					array('3','平房Bungalow'),
					array('4','别墅House'),
					array('5','厂房Factory Building'),
					array('6','写字楼Office'),
					array('7','商铺Commercial'),
					array('8','车位Garage'),
					array('9','地下室Basement'),
				),
			),
			array(
				'name' => 'house_from',
				'label' => '来源',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','个人'),
					array('2','中介'),
				),
			),
		),
        'section_2'=> array(
			array(
				'name' => 'rent_type',
				'label' => '出租方式',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','整租'),
					array('2','转租'),
					array('3','单间'),
					array('4','客厅'),
					array('5','合租'),
					array('6','其它'),
				),
			),
			array(
				'name' => 'postdate',
				'label' => '发布时间',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','1天内'),
					array('2','3天内'),
					array('3','7天内'),
					array('7','30天内'),
				),
			),
		),
        'section_3'=> array(
			array(
				'name' => 'rent_price',
				'label' => '租金($/week)',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('0|100','100$/week以下'),
					array('100|150','100-150$/week'),
					array('150|200','150-200$/week'),
					array('200|300','200-300$/week'),
					array('300|500','300-500$/week'),
					array('500|1000','500-1000$/week'),
					array('1000|20000','1000$/week以上'),
				),
			),
		),
    );
    //房屋求租
    $filterAry['f680_0'] = array(
        'section_1'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'select',
				'value' => array(),
			),
		),
		'section_2'=>array(
			array(
				'name' => 'rent_type',
				'label' => '求租方式',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','整租'),
					array('2','转租'),
					array('3','单间'),
					array('4','客厅'),
					array('5','Share'),
					array('6','均可'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'validity',
				'label' => '有效期|validity',
				'type' => 'select',
				'value' => array(
					array('0','永久有效'),
					array('259200','三天'),
					array('432000','五天'),
					array('604800','七天'),
					array('2592000','一个月'),
					array('7776000','三个月'),
					array('15552000','半年'),
					array('31536000','一年'),
				),
			),
		),
    );
    //房屋交易
    $filterAry['f305_0'] = array(
        'section_1'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'select',
				'value' => array(),
			),
			array(
				'name' => 'house_type',
				'label' => '房屋类型|House Type',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','别墅/house'),
					array('2','联排别墅/townhouse'),
					array('3','单元房/unit'),
					array('4','公寓/apartment'),
					array('5','土地/land'),
					array('6','商铺/commercial'),
				),
			),
		),
        'section_2'=>array(
			array(
				'name' => 'house_price',
				'label' => '售价',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('0|50','50万元以下'),
					array('50|100','50-100万元'),
					array('100|200','100-200万元'),
					array('200|500','200-500万元'),
					array('500|1000','500-1000万元'),
					array('1000|20000','1000万元以上'),
				),
			),
		),
        'section_3'=> array(
			array(
				'name' => 'readyhouse',
				'label' => '现房/期房',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','现房Established'),
					array('2','期房Off plan'),
				),
			),
		),
    );
    //房屋求购
    $filterAry['f681_0'] = array(
		'section_1'=>array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'select',
				'value' => array(),
			),
		),
		'section_2'=>array(
			array(
				'name' => 'house_type',
				'label' => '求购类型',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','别墅/house'),
					array('2','联排别墅/townhouse'),
					array('3','单元房/unit'),
					array('4','公寓/apartment'),
					array('5','土地/land'),
					array('6','商铺/commercial'),
				),
			),
		),
		'section_3'=>array(
			array(
				'name' => 'validity',
				'label' => '有效期|validity',
				'type' => 'select',
				'value' => array(
					array('0','永久有效'),
					array('259200','三天'),
					array('432000','五天'),
					array('604800','七天'),
					array('2592000','一个月'),
					array('7776000','三个月'),
					array('15552000','半年'),
					array('31536000','一年'),
				),
			),
		),
    );
    //二手市场
    $filterAry['f304_0'] = array(
        'section_1'=>array(
			array(
				'name' => 'typeid',
				'label' => '类别',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('743','女性'),
					array('744','男性'),
					array('745','杂七杂八'),
					array('746','食品其它'),
					array('747','家具用品'),
					array('748','电脑网络'),
					array('1214','亲子用品'),
					array('1188','手机数码'),
					array('749','图书音像'),
					array('905','摄影器材'),
					array('751','其他'),
				),
			),
			array(
				'name' => 'fromtype',
				'label' => '来源',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','个人'),
					array('2','商家'),
				),
			),
		),
        'section_2'=> array(
			array(
				'name' => 'postdate',
				'label' => '发布时间',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','1天内'),
					array('2','3天内'),
					array('3','7天内'),
					array('7','30天内'),
				),
			),
		),
		'section_3'=> array(
			array(
				'name' => 'markettype',
				'label' => '需求',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','求购'),
					array('2','出售'),
				),
			),
		),
    );
    //超级市场
    $filterAry['f89_0'] = array(
        'section_1'=>array(
			array(
				'name' => 'typeid',
				'label' => '类别',
				'type' => 'select',
				'value' => array(
					array('94','服装鞋帽'),
					array('101','手机数码'),
					array('99','家居用品'),
					array('823','母婴用品'),
					array('95','游戏娱乐'),
					array('1210','车饰配件'),
					array('475','办公用品'),
					array('103','成人用品'),
					array('477','美容美体'),
					array('478','体育用品'),
					array('476','箱包首饰'),
					array('102','食品饮品'),
					array('98','书刊杂志'),
					array('96','电脑配件'),
					array('742','建筑材料'),
					array('93','代购'),
					array('100','问答'),
					array('92','其它'),
				),
			),
		),
    );
    //二手教材
    $filterAry['f679_0'] = array(
        'section_1'=> array(
			array(
				'name' => 'suburb',
				'label' => 'Suburb',
				'type' => 'select',
				'value' => array(),
			),
			array(
				'name' => 'school',
				'label' => '学校',
				'type' => 'select',
				'value' => array(
					array('TAFE','TAFE'),
					array('MQ','MQ'),
					array('USYD','USYD'),
					array('UNSW','UNSW'),
					array('UTS','UTS'),
					array('UWS','UWS'),
					array('UOW','UOW'),
					array('ANU','ANU'),
					array('UofMELB','UofMELB'),
					array('MONASH','MONASH'),
					array('DEAKIN','DEAKIN'),
					array('LATROBE','LATROBE'),
					array('RMIT','RMIT'),
					array('CURTIN','CURTIN'),
					array('UQ','UQ'),
					array('UWA','UWA'),
					array('ADELAIDE','ADELAIDE'),
					array('0','不限'),
				),
			),
		),
		'section_2'=> array(
			array(
				'name' => 'typeid',
				'label' => '类型',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1002','学习器材'),
					array('1003','学习资料'),
				),
			),
		),
        'section_3'=> array(
			array(
				'name' => 'xuqiu',
				'label' => '需求',
				'type' => 'select',
				'value' => array(
					array('0','不限'),
					array('1','求购'),
					array('2','出售'),
				),
			),
		)
    );
	//生活服务
	$filterAry['f651_0'] = array(
		'section_1'=>array(

		),
	);
    //过滤参数
    $config['filterParam'] = $filterAry;

	//选择参数
	$config['param']['291'] =
		array(
			'carfrom' => array(
				'1'=>'私人二手',
				'2'=>'商家二手',
				'3'=>'新车',
			),
			'bodytype' => array(
				'0'=>'',
				'1'=>'轿车',
				'2'=>'SUV越野车',
				'3'=>'MPV商务车',
				'4'=>'跑车',
				'5'=>'面包车',
				'6'=>'卡车',
			),
			'transmission' => array(
				'1'=>'手动',
				'2'=>'自动',
				'3'=>'手自一体',
			),
			'colour' => array(
				'0'=>'请选择',
				'1'=>'黑色',
				'2'=>'白色',
				'3'=>'银灰色',
				'4'=>'深灰色',
				'5'=>'棕色',
				'6'=>'红色',
				'7'=>'粉色',
				'8'=>'橙色',
				'9'=>'绿色',
				'10'=>'蓝色',
				'11'=>'咖啡色',
				'12'=>'紫色',
				'13'=>'金色',
				'14'=>'香槟色',
				'15'=>'多彩色',
				'16'=>'黄色',
				'17'=>'其它',
			),
			'drives' => array(
				'1'=>'前驱',
				'2'=>'后驱',
				'3'=>'四驱',
			),
			'seats' => array(
				'none'=>'',
				'2'=>'2座',
				'4'=>'4座',
				'5'=>'5座',
				'6'=>'6座',
				'7'=>'7座',
				'8'=>'7座以上',
			),
			'doors' => array(
				'2'=>'2门',
				'3'=>'3门',
				'4'=>'4门',
				'5'=>'5门',
			),
			'fueltype' => array(
				'1'=>'汽油',
				'2'=>'柴油',
				'3'=>'油电混合',
				'4'=>'电动',
			),
			'havemaintenance' => array(
				'1'=>'有',
				'2'=>'无',
			),
		);

	$config['param']['715'] = array(
		'carfrom'=>array(
			'0'=>'不限',
			'1'=>'私人',
			'2'=>'商家',
			'3'=>'新车',
		),
		'carprice'=>array(
			'不限'=>'不限',
			'5K以下'=>'5K以下',
			'5K-10K'=>'5K-10K',
			'10K-20K'=>'10K-20K',
			'20K-30K'=>'20K-30K',
			'30k-40k'=>'30k-40k',
			'40k以上'=>'40k以上',
		),
		'carage'=>array(
			'不限'=>'不限',
			'1年以内'=>'1年以内',
			'1-3年'=>'1-3年',
			'3-5年'=>'3-5年',
			'5-8年'=>'5-8年',
			'8-10年'=>'8-10年',
			'10年以上'=>'10年以上',
		),
		'bodytype'=>array(
			'0'=>'请选择',
			'1'=>'轿车',
			'2'=>'SUV越野车',
			'3'=>'MPV商务车',
			'4'=>'跑车',
			'5'=>'面包车',
			'6'=>'卡车',
		),
		'kilometres'=>array(
			'不限'=>'不限',
			'1万公里内'=>'1万公里内',
			'3万公里内'=>'3万公里内',
			'6万公里内'=>'6万公里内',
			'10万公里内'=>'10万公里内',
			'10万公里以上'=>'10万公里以上',
		),
		'transmission'=>array(
			'0'=>'不限',
			'1'=>'手动',
			'2'=>'自动',
			'3'=>'手自一体',
		)
	);

	$config['param']['714'] = array(
		'salary_form'=>array(
			'0'=>'不限',
			'1'=>'Hourly rates',
			'2'=>'Annually rates',
		),
		'salary'=>array(
			'0'=>'不限',
			'1'=>'$15以下',
			'2'=>'$15－$30',
			'3'=>'$30－$60',
			'4'=>'$60－$100',
			'5'=>'$100以上',
			'6'=>'$30K以下',
			'7'=>'$30K－$60K',
			'8'=>'$60K－$100K',
			'9'=>'$100K－$150K',
			'10'=>'$150K-$200K',
			'11'=>'$200K以上',
		),
		'position'=>array(
			'0'=>'职位分类',
			'1'=>'技师/工人/学徒',
			'2'=>'编辑/翻译/律师',
			'3'=>'传媒/印刷/艺术/设计',
			'4'=>'网管/IT安装/程序员',
			'5'=>'财务/人力资源/行政/文秘',
			'6'=>'互联网/通讯',
			'7'=>'清洁/搬运/库管/司机',
			'8'=>'公关/演艺/模特/摄影',
			'9'=>'销售/市场/业务',
			'10'=>'医护/按摩/美容/发型',
			'11'=>'教师/教练/家教',
			'12'=>'游戏代练/游戏推广',
			'13'=>'店员/收银/客服',
			'14'=>'厨师/服务员/帮工/外卖',
			'15'=>'旅行/导游',
			'16'=>'保姆/月嫂/钟点工',
			'17'=>'实习机会/义工',
			'18'=>'兼职信息',
		),
		'education'=>array(
			'none'=>'请选择',
			'1'=>'completed Year 9-11',
			'2'=>'completed High School(year 12)',
			'3'=>'Diploma',
			'4'=>'TAFE/Trade Certificate',
			'5'=>'Undergraduate',
			'6'=>'Post Graduate Degree',
			'7'=>'Masters',
			'8'=>'PhD',
		),
		'property'=>array(
			'全职'=>'全职',
			'兼职'=>'兼职',
			'合同工'=>'合同工',
			'实习'=>'实习',
			'临时'=>'临时',
		),
		'visa'=>array(
			'PR'=>'PR',
			'工作签'=>'工作签',
			'学生签'=>'学生签',
			'澳洲国籍'=>'澳洲国籍',
		),
	);

	$config['param']['161'] = array(
		'position'=>array(
			'none'=>'职位分类',
			'1'=>'技师/工人/学徒',
			'2'=>'编辑/翻译/律师',
			'3'=>'传媒/印刷/艺术/设计',
			'4'=>'网管/IT安装/程序员',
			'5'=>'财务/人力资源/行政/文秘',
			'6'=>'互联网/通讯',
			'7'=>'清洁/搬运/库管/司机',
			'8'=>'公关/演艺/模特/摄影',
			'9'=>'销售/市场/业务',
			'10'=>'医护/按摩/美容/发型',
			'11'=>'教师/教练/家教',
			'12'=>'游戏代练/游戏推广',
			'13'=>'店员/收银/客服',
			'14'=>'厨师/服务员/帮工/外卖',
			'15'=>'旅行/导游',
			'16'=>'保姆/月嫂/钟点工',
			'17'=>'实习机会/义工',
			'18'=>'兼职信息',
		),
		'experience'=>array(
			'需要'=>'需要',
			'不需要'=>'不需要',
		),
		'education'=>array(
			'none'=>'请选择',
			'1'=>'completed Year 9-11',
			'2'=>'completed High School(year 12)',
			'3'=>'Diploma',
			'4'=>'TAFE/Trade Certificate',
			'5'=>'Undergraduate',
			'6'=>'Post Graduate Degree',
			'7'=>'Masters',
			'8'=>'PhD',
		),
		'salary_form'=>array(
			'0'=>'请选择',
			'1'=>'Hourly rates',
			'2'=>'Annually rates',
		),
		'salary'=>array(
			'0'=>'不限',
			'1'=>'$15以下',
			'2'=>'$15－$30',
			'3'=>'$30－$60',
			'4'=>'$60－$100',
			'5'=>'$100以上',
			'6'=>'$30K以下',
			'7'=>'$30K－$60K',
			'8'=>'$60K－$100K',
			'9'=>'$100K－$150K',
			'10'=>'$150K-$200K',
			'11'=>'$200K以上',
		),
		'annualleave'=>array(
			'有'=>'有',
			'无'=>'无',
		),
		'superannua'=>array(
			'有'=>'有',
			'无'=>'无',
		),
	);

	//房屋租赁
	$config['param']['142'] = array(
		'validity'=>array(
			'0'=>'永久有效',
			'259200'=>'三天',
			'432000'=>'五天',
			'604800'=>'七天',
			'2592000'=>'一个月',
			'7776000'=>'三个月',
			'15552000'=>'半年',
			'31536000'=>'一年',
		),
		'house_from'=>array(
			'1'=>'个人',
			'2'=>'中介',
		),
		'iscity'=>array(
			'1'=>'不在',
			'2'=>'在',
		),
		'house_type'=>array(
			'1'=>'公寓Apartment',
			'2'=>'小区Unit',
			'3'=>'平房Bungalow',
			'4'=>'别墅House',
			'5'=>'厂房Factory Building',
			'6'=>'写字楼Office',
			'7'=>'商铺Commercial',
			'8'=>'车位Garage',
			'9'=>'地下室Basement',
		),
		'house_room'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_hall'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_toilet'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_balcony'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_ku'=>array(
			'1'=>'0',
			'2'=>'1',
			'3'=>'2',
			'4'=>'3',
		),
		'rent_type'=>array(
			'1'=>'整租',
			'2'=>'转租',
			'3'=>'单间',
			'4'=>'客厅',
			'5'=>'合租',
			'6'=>'其它',
		),
		'house_sex'=>array(
			'1'=>'男女不限',
			'2'=>'限女生',
			'3'=>'限男生',
		),
		'house_equipment'=>array(
			'1'=>'包水',
			'2'=>'包电',
			'3'=>'包煤气',
			'4'=>'包宽带',
			'5'=>'有线电视',
			'6'=>'床',
			'7'=>'冰箱',
			'8'=>'洗衣机',
			'9'=>'热水器',
			'10'=>'空调',
			'11'=>'停车位',
			'12'=>'家俱',
			'13'=>'全包',
		),
		'bus_info'=>array(
			'1'=>'火车站',
			'2'=>'公交站',
			'3'=>'学校',
			'4'=>'超市',
			'5'=>'健身房',
			'6'=>'游泳馆',
		),
	);

	$config['param']['680'] = array(
		'validity'=>array(
			'0'=>'永久有效',
			'259200'=>'三天',
			'432000'=>'五天',
			'604800'=>'七天',
			'2592000'=>'一个月',
			'7776000'=>'三个月',
			'15552000'=>'半年',
			'31536000'=>'一年',
		),
		'rent_type'=>array(
			'1'=>'整租',
			'2'=>'转租',
			'3'=>'单间',
			'4'=>'客厅',
			'5'=>'Share',
			'6'=>'均可',
		)
	);

	//房屋出售
	$config['param']['305'] = array(

		'validity'=>array(
			'0'=>'永久有效',
			'259200'=>'三天',
			'432000'=>'五天',
			'604800'=>'七天',
			'2592000'=>'一个月',
			'7776000'=>'三个月',
			'15552000'=>'半年',
			'31536000'=>'一年',
		),
		'house_type'=>array(
			'1'=>'别墅/house',
			'2'=>'联排别墅/townhouse',
			'3'=>'单元房/unit',
			'4'=>'公寓/apartment',
			'5'=>'土地/land',
			'6'=>'商铺/commercial',
		),
		'iscity'=>array(
			'1'=>'不在',
			'2'=>'在',
		),
		'readyhouse'=>array(
			'1'=>'现房Established',
			'2'=>'期房Off plan',
		),
		'house_room'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_hall'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_toilet'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_balcony'=>array(
			'0'=>'0',
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
		),
		'house_ku'=>array(
			'1'=>'0',
			'2'=>'1',
			'3'=>'2',
			'4'=>'3',
		),
		'allowforeigner'=>array(
			'1'=>'是Yes',
			'2'=>'否No',
		),
	);
	//房屋求租
	$config['param']['681'] = array(
		'validity'=>array(
			'0'=>'永久有效',
			'259200'=>'三天',
			'432000'=>'五天',
			'604800'=>'七天',
			'2592000'=>'一个月',
			'7776000'=>'三个月',
			'15552000'=>'半年',
			'31536000'=>'一年',
		),
		'house_type'=>array(
			'1'=>'别墅/house',
			'2'=>'联排别墅/townhouse',
			'3'=>'单元房/unit',
			'4'=>'公寓/apartment',
			'5'=>'土地/land',
			'6'=>'商铺/commercial',
		),
		'iscity'=>array(
			'1'=>'不在',
			'2'=>'在',
		),
	);

	//二手市场
	$config['param']['304'] = array(
		'typeid'=>array(
			'743'=>'女性',
			'744'=>'男性',
			'745'=>'杂七杂八',
			'746'=>'食品其它',
			'747'=>'家具用品',
			'748'=>'电脑网络',
			'1214'=>'亲子用品',
			'1188'=>'手机数码',
			'749'=>'图书音像',
			'905'=>'摄影器材',
			'751'=>'其他',
		),
		'delivery'=>array(
			'1'=>'送货',
			'0'=>'不送',
		),
		'fromtype'=>array(
			'1'=>'个人',
			'2'=>'商家',
		),
		'markettype'=>array(
			'1'=>'求购',
			'2'=>'出售',
		),
	);

	//超级市场
	$config['param']['89'] = array(
		'typeid'=>array(
			'94'=>'服装鞋帽',
			'101'=>'手机数码',
			'99'=>'家居用品',
			'823'=>'母婴用品',
			'95'=>'游戏娱乐',
			'1210'=>'车饰配件',
			'475'=>'办公用品',
			'103'=>'成人用品',
			'477'=>'美容美体',
			'478'=>'体育用品',
			'476'=>'箱包首饰',
			'102'=>'食品饮品',
			'98'=>'书刊杂志',
			'96'=>'电脑配件',
			'742'=>'建筑材料',
			'93'=>'代购',
			'100'=>'问答',
			'92'=>'其它',
		),
	);
	$config['param']['716'] = array(

	);

	$config['param']['679'] = array(
		'school'=>array(
			'TAFE'=>'TAFE',
			'MQ'=>'MQ',
			'USYD'=>'USYD',
			'UNSW'=>'UNSW',
			'UTS'=>'UTS',
			'UWS'=>'UWS',
			'UOW'=>'UOW',
			'ANU'=>'ANU',
			'UofMELB'=>'UofMELB',
			'MONASH'=>'MONASH',
			'DEAKIN'=>'DEAKIN',
			'LATROBE'=>'LATROBE',
			'RMIT'=>'RMIT',
			'CURTIN'=>'CURTIN',
			'UQ'=>'UQ',
			'UWA'=>'UWA',
			'ADELAIDE'=>'ADELAIDE',
			'0'=>'其他大学',
		),
		'xuqiu'=>array(
			'1'=>'求购',
			'2'=>'出售',
		),
		'typeid'=>array(
			'1002'=>'学习器材',
			'1003'=>'学习资料',
		),
	);

	$config['param']['651'] = array(
		'typeid'=>array(
			'400'=>'餐饮美食',
			'1166'=>'休闲娱乐',
			'472'=>'美容美发',
			'402'=>'清洁通渠',
			'928'=>'保姆月嫂',
			'401'=>'机场接送',
			'929'=>'物流搬运',
			'1158'=>'快递服务',
			'1161'=>'车辆租赁',
			'650'=>'旅游机票',
			'917'=>'园艺绿化',
			'403'=>'建筑家装',
			'471'=>'摄影婚礼',
			'407'=>'电脑网络',
			'884'=>'手机数码',
			'474'=>'电器服务',
			'1156'=>'印刷喷绘',
			'1165'=>'设计策划',
			'1162'=>'驾校招生',
			'404'=>'汽车综合',
			'405'=>'教育培训',
			'480'=>'留学移民',
			'406'=>'会计税务',
			'918'=>'律师服务',
			'481'=>'翻译服务',
			'1159'=>'贷款服务',
			'649'=>'金融保险',
			'479'=>'医疗健康',
			'925'=>'金属机械',
			'919'=>'二手回收',
			'1306'=>'裁缝修补',
			'398'=>'其它服务',
			'399'=>'求助咨询',
		),
	);





