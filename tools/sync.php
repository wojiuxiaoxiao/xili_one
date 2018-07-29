<?php
	$forumAry = array(304,89,716,679,651);
	foreach($forumAry as $f){
		$endFile = dirname(__FILE__).'/'.$f."_end.txt";
		$con = mysql_connect("localhost","root","XZ9abRF4");
		mysql_select_db("yeeyico_new");
		mysql_query("set names gbk");
		
		if($f == 304){
			//二手市场
			while(true){
				$start = intval(@file_get_contents($endFile));
				$sql = "select pre_forum_thread.fid,pre_forum_thread.tid,pre_forum_thread.typeid,message from pre_forum_thread left join pre_forum_post on pre_forum_thread.tid=pre_forum_post.tid where pre_forum_thread.fid in(304,641,642,643) and first=1 and pre_forum_thread.tid>$start order by pre_forum_thread.tid asc limit 1";
				//echo $sql;
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row['tid']>0){
					@file_put_contents($endFile,$row['tid']);
					$city = 11;
					if($row['fid'] == 643){
						$city = 2;
					}
					if($row['fid'] == 642){
						$city = 1;
					}
					@mysql_query("insert into pre_forum_field_market(tid,city,typeid,message) values('".$row['tid']."','".$city."','".$row['typeid']."','".addslashes($row['message'])."')");
					echo $row['tid']."===\r\n";
					
				}
				else{
					echo '304OK'."\r\n";
					break;
				}
			}
			
		}
		
		if($f == 89){
			//超级市场
			while(true){
				$start = intval(@file_get_contents($endFile));
				$sql = "select pre_forum_thread.fid,pre_forum_thread.tid,pre_forum_thread.typeid,message from pre_forum_thread left join pre_forum_post on pre_forum_thread.tid=pre_forum_post.tid where pre_forum_thread.fid in(89) and first=1 and pre_forum_thread.tid>$start order by pre_forum_thread.tid asc limit 1";
				//echo $sql;
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row['tid']>0){
					@file_put_contents($endFile,$row['tid']);
					$city = 11;
					@mysql_query("insert into pre_forum_field_super_market(tid,city,typeid,message) values('".$row['tid']."','".$city."','".$row['typeid']."','".addslashes($row['message'])."')");
					echo $row['tid']."===\r\n";
					
				}
				else{
					echo '89OK'."\r\n";
					break;
				}
			}
			
		}
		
		if($f == 716){
			//生意买卖
			while(true){
				$start = intval(@file_get_contents($endFile));
				$sql = "select pre_forum_thread.fid,pre_forum_thread.tid,pre_forum_thread.typeid,message from pre_forum_thread left join pre_forum_post on pre_forum_thread.tid=pre_forum_post.tid where pre_forum_thread.fid in(716) and first=1 and pre_forum_thread.tid>$start order by pre_forum_thread.tid asc limit 1";
				//echo $sql;
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row['tid']>0){
					@file_put_contents($endFile,$row['tid']);
					$city = 11;
					if($row['typeid'] == 1145){
						$city = 1;
					}
					if($row['typeid'] == 1144){
						$city = 2;
					}
					if($row['typeid'] == 1146){
						$city = 6;
					}
					if($row['typeid'] == 1147){
						$city = 4;
					}
					@mysql_query("insert into pre_forum_field_business(tid,city,message) values('".$row['tid']."','".$city."','".addslashes($row['message'])."')");
					echo $row['tid']."===\r\n";
					
				}
				else{
					echo '716OK'."\r\n";
					break;
				}
			}
			
		}
	
		if($f == 679){
			//二手书籍
			while(true){
				$start = intval(@file_get_contents($endFile));
				$sql = "select pre_forum_thread.fid,pre_forum_thread.tid,pre_forum_thread.typeid,message from pre_forum_thread left join pre_forum_post on pre_forum_thread.tid=pre_forum_post.tid where pre_forum_thread.fid in(679) and first=1 and pre_forum_thread.tid>$start order by pre_forum_thread.tid asc limit 1";
				//echo $sql;
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row['tid']>0){
					@file_put_contents($endFile,$row['tid']);
					$city = 11;
					$school = '';
					$xuqiu = '';
					
					if($row['typeid'] == 992){
						$school = 'TAFE';
					}
					else if($row['typeid'] == 993){
						$school = 'MQ';
					}
					else if($row['typeid'] == 994){
						$school = 'USYD';
					}
					else if($row['typeid'] == 995){
						$school = 'UNSW';
					}
					else if($row['typeid'] == 996){
						$school = 'UTS';
					}
					else if($row['typeid'] == 1011){
						$school = 'UWS';
					}
					else if($row['typeid'] == 997){
						$school = 'UOW';
					}else if($row['typeid'] == 998){
						$school = 'ANU';
					}else if($row['typeid'] == 999){
						$school = 'UofMELB';
					}else if($row['typeid'] == 1000){
						$school = 'MONASH';
					}else if($row['typeid'] == 1012){
						$school = 'DEAKIN';
					}else if($row['typeid'] == 1005){
						$school = 'LATROBE';
					}
					else if($row['typeid'] == 1006){
						$school = 'RMIT';
					}
					else if($row['typeid'] == 1007){
						$school = 'CURTIN';
					}
					else if($row['typeid'] == 1008){
						$school = 'UQ';
					}
					else if($row['typeid'] == 1009){
						$school = 'UWA';
					}
					else if($row['typeid'] == 1010){
						$school = 'ADELAIDE';
					}
					else if($row['typeid'] == 1001){
						$school = '0';
					}
					else if($row['typeid'] == 1002){
						
					}
					else if($row['typeid'] == 1003){
						
					}
					else if($row['typeid'] == 1004){
						$xuqiu = 1;
					}
					else{
						$row['typeid'] = 0;
					}
					
					@mysql_query("insert into pre_forum_field_book(tid,school,xuqiu,typeid,message) values('".$row['tid']."','".$school."','".$xuqiu."','".$row['typeid']."','".addslashes($row['message'])."')");
					echo $row['tid']."===\r\n";
					
				}
				else{
					echo '716OK'."\r\n";
					break;
				}
			}
			
		}
		
		if($f == 651){
			//生活服务
			while(true){
				$start = intval(@file_get_contents($endFile));
				$sql = "select pre_forum_thread.fid,pre_forum_thread.tid,pre_forum_thread.typeid,message from pre_forum_thread left join pre_forum_post on pre_forum_thread.tid=pre_forum_post.tid where pre_forum_thread.fid in(651,652,316,662) and first=1 and pre_forum_thread.tid>$start order by pre_forum_thread.tid asc limit 1";
				//echo $sql;
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row['tid']>0){
					@file_put_contents($endFile,$row['tid']);
					$city = 11;
					if($row['fid'] == 652){
						$city = 2;
					}
					if($row['fid'] == 316){
						$city = 1;
					}
					if($row['typeid'] == 856){
						$row['typeid'] = 400;
					}
					if($row['typeid'] == 1175){
						$row['typeid'] = 1166;
					}
					if($row['typeid'] == 867){
						$row['typeid'] = 472;
					}
					if($row['typeid'] == 872){
						$row['typeid'] = 403;
					}
					if($row['typeid'] == 858){
						$row['typeid'] = 402;
					}
					if($row['typeid'] == 865){
						$row['typeid'] = 471;
					}
					if($row['typeid'] == 927){
						$row['typeid'] = 928;
					}
					if($row['typeid'] == 1177){
						$row['typeid'] = 401;
					}
					if($row['typeid'] == 857){
						$row['typeid'] = 929;
					}
					if($row['typeid'] == 1167){
						$row['typeid'] = 1158;
					}
					if($row['typeid'] == 856){
						$row['typeid'] = 400;
					}
					if($row['typeid'] == 1170){
						$row['typeid'] = 1161;
					}
					if($row['typeid'] == 868){
						$row['typeid'] = 650;
					}
					if($row['typeid'] == 1179){
						$row['typeid'] = 917;
					}
					if($row['typeid'] == 871){
						$row['typeid'] = 407;
					}
					if($row['typeid'] == 883){
						$row['typeid'] = 884;
					}
					if($row['typeid'] == 869){
						$row['typeid'] = 474;
					}
					if($row['typeid'] == 1155){
						$row['typeid'] = 1156;
					}
					if($row['typeid'] == 1174){
						$row['typeid'] = 1165;
					}
					if($row['typeid'] == 1171){
						$row['typeid'] = 1162;
					}
					if($row['typeid'] == 859){
						$row['typeid'] = 404;
					}
					if($row['typeid'] == 861){
						$row['typeid'] = 405;
					}
					if($row['typeid'] == 862){
						$row['typeid'] = 480;
					}
					if($row['typeid'] == 863){
						$row['typeid'] = 406;
					}
					if($row['typeid'] == 1180){
						$row['typeid'] = 918;
					}
					if($row['typeid'] == 864){
						$row['typeid'] = 481;
					}
					if($row['typeid'] == 1168){
						$row['typeid'] = 1159;
					}
					if($row['typeid'] == 866){
						$row['typeid'] = 649;
					}
					if($row['typeid'] == 860){
						$row['typeid'] = 479;
					}
					if($row['typeid'] == 926){
						$row['typeid'] = 925;
					}
					if($row['typeid'] == 1182){
						$row['typeid'] = 919;
					}
					if($row['typeid'] == 1305){
						$row['typeid'] = 1306;
					}
					if($row['typeid'] == 873){
						$row['typeid'] = 398;
					}
					if($row['typeid'] == 874){
						$row['typeid'] = 399;
					}
					/**/

					@mysql_query("insert into pre_forum_field_service(tid,city,typeid,message) values('".$row['tid']."','".$city."','".$row['typeid']."','".addslashes($row['message'])."')");
					echo $row['tid']."===\r\n";
					
				}
				else{
					echo '651OK'."\r\n";
					break;
				}
			}
			
		}
	
	}

?>