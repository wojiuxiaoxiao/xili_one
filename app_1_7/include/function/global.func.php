<?php 
	if(!function_exists('jaddslashes'))
	{
		function jaddslashes($string, $force = 0, $strip = FALSE) {
			if(!MAGIC_QUOTES_GPC || $force) {
				if(is_array($string)) {
					foreach($string as $key => $val) {
						$string[$key] = jaddslashes($val, $force, $strip);
					}
				} else {
					$string = gbk_addslashes($strip ? stripslashes($string) : $string);
				}
			}
			return $string;
		}
	}
	function gbk_addslashes($text) {
		$OK = '';
		for ( ; ; ) {
			  $i = mb_strpos($text, chr(92), 0, "GBK");
			  if ($i === false) break;
			  $T = mb_substr($text, 0, $i, "GBK") . chr(92) . chr(92);
			  $text = substr($text, strlen($T) - 1);
			  $OK .= $T;
		}
		$text = $OK . $text;
		$text = str_replace(chr(39), chr(92) . chr(39), $text);
		$text = str_replace(chr(34), chr(92) . chr(34), $text);
		return $text;
	}
	
	function gbk_stripslashes($text) {
		$text = str_replace(chr(92) . chr(34), chr(34), $text);
		$text = str_replace(chr(92) . chr(39), chr(39), $text);
		for ( ; ; ) {
			$i = mb_strpos($text, chr(92) . chr(92), 0, "GBK");
			if ($i === false) break;
			$T = mb_substr($text, 0, $i, "GBK") . chr(92);
			$text = substr($text, strlen($T) + 1);
			$OK .= $T;
		}
		$text = $OK . $text;
		return $text;
	}
	
	function RemoveXSS($val) {
		$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);			 
		$search = 'abcdefghijklmnopqrstuvwxyz';
		$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$search .= '1234567890!@#$%^&*()';
		$search .= '~`";:?+/={}[]-_|\'\\';
		for ($i = 0; $i < strlen($search); $i++) {
			$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
			$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
		}
		$ra1 = Array('javascript', 'vbscript', 'expression', 'meta', 'xml', 'blink', 'link', 'script',  'iframe', 'frame', 'frameset', 'ilayer', 'layer',  'title', 'base');
		$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		$ra = array_merge($ra1, $ra2);
                     
		$found = true; 
		while ($found == true) {
			$val_before = $val;
			for ($i = 0; $i < sizeof($ra); $i++) {
				$pattern = '/';
				for ($j = 0; $j < strlen($ra[$i]); $j++) {
					if ($j > 0) {
						$pattern .= '(';
						$pattern .= '(&#[xX]0{0,8}([9ab]);)';
						$pattern .= '|';
						$pattern .= '|(&#0{0,8}([9|10|13]);)';
						$pattern .= ')*';
					}
					$pattern .= $ra[$i][$j];
				}
				$pattern .= '/i';
				$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); 
				$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
				if ($val_before == $val) {
					$found = false;
				}
			}
		}
		return $val;
	}

	function random($length, $numeric = 0) {
		mt_srand((double)microtime() * 1000000);
		if($numeric) {
			$hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
		} else {
			$hash = '';
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			$max = strlen($chars) - 1;
			for($i = 0; $i < $length; $i++) {
				$hash .= $chars[mt_rand(0, $max)];
			}
		}
		return $hash;
	}
	function client_ip(){
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		return $onlineip;
	}
	/*获取网页内容*/
	function getPage($url){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,3);
		curl_setopt($ch,CURLOPT_TIMEOUT,2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}

	function curl_interface($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

	function postData($url,$param=array()){
		$o="";
		foreach ($param as $k=>$v)
		{
			$o.= "$k=".urlencode($v)."&";
		}
		$get_data=substr($o,0,-1);
		if(strstr($url,"?")){
			$url.='&'.$get_data;
		}
		else {
			$url.='?'.$get_data;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1 );  
		curl_setopt($ch,CURLOPT_TIMEOUT,2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $get_data);  
		$result = curl_exec($ch);
		return $result;
	}

	function changeCode($array,$from='gbk',$to='utf-8'){
		if(is_array($array)){
			foreach($array as $k=>$v){
				if(is_array($v)){
					$array[$k] = changeCode($v,$from,$to);
				}
				else{
					$array[$k] = mb_convert_encoding($v,$to,$from);
				}
			}
			return $array;
		}
		else{
			return mb_convert_encoding($array,$to,$from);
		}
	}

	function myFileExists($path){
		if(!is_array($path)){
			$pathAry = array();
			$pathAry[] = $path;
		}
		else{
			$pathAry = $path;
		}
		$jsonStr = json_encode($pathAry);
		$param['filepath'] = $jsonStr;
		$result = postData("http://www.yeeyi.com/apptools/index.php?act=fileIsExists",$param);
		$resultAry = json_decode($result,true);
		if($resultAry['status'] == 200){
			$newPathAry = $resultAry['filepath'];
			if(!is_array($path)){
				return $newPathAry[0]['exist'];
			}
			else{
				return $newPathAry;
			}
		}
		return false;
	}
	//获取tabid
	function dintval($int, $allowarray = false) {
		$ret = intval($int);
		if($int == $ret || !$allowarray && is_array($int)) return $ret;
		if($allowarray && is_array($int)) {
			foreach($int as &$v) {
				$v = dintval($v, true);
			}
			return $int;
		} elseif($int <= 0xffffffff) {
			$l = strlen($int);
			$m = substr($int, 0, 1) == '-' ? 1 : 0;
			if(($l - $m) === strspn($int,'0987654321', $m)) {
				return $int;
			}
		}
		return $ret;
	}
	//论坛的
	function getUrl($message){
		$message = preg_replace("/\[url(=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|synacast){1}:\/\/|www\.|mailto:)?([^\s\[\"']+?))?\](.+?)\[\/url\]/ies", "parseurl('\\1', '\\5', '\\2')", $message);
		return $message;
	}


	function getImgAttachmentCount($pid){
		$query = mysql_query("select aid from `pre_forum_attachment` where pid=".$pid."");
		$img = array();
		while($row = mysql_fetch_assoc($query)){
			$img[] = $row['aid'];
		}
		return $img;
	}

	function parseQuote($message){
		$message = str_replace('[quote]','<p style="background-color:#FAFAFA;border:1px solid #D1D7DC;padding:0.2em;">',$message);
		$message = str_replace('[/quote]','</p>',$message);
		$backImg = '[img]static/image/common/back.gif[/img]';
		$message = str_replace($backImg,'',$message);
		return $message;
	}

	function getImg($content){
		preg_match_all("/\[img.*\](.*)\[\/img\]/isU",$content,$newcon);
		foreach($newcon[1] as $img){
			$content = preg_replace("/\[img.*\](.*)\[\/img\]/isU","<p><img src='".$img."' /></p>",$content,1);
		}
		return $content;
	}

	/* 2017.05 .15 edit by allen qu 匹配[url] 替换为超链接*/

	function getHref($content){

		preg_match_all("/\[url.*\](.*)\[\/url\]/isU",$content,$newcon);

		foreach($newcon[1] as $k=>$text){

			if (preg_match("/([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))/i", $newcon[0][$k], $newhref)) { //如果是邮箱

				$content = preg_replace("/\[url.*\](.*)\[\/url\]/isU", '<a href="mailto:'.$newhref[0].'">'.$text.'</a>', $content, 1);

			}elseif(preg_match('/(http|https|ftp|file){1}(:\/\/)?([\da-z-\.]+)\.([a-z]{2,6})([\/\w \.-?&%-=]*)*\/?/', $newcon[0][$k], $newhref))
			{
				$content = preg_replace("/\[url.*\](.*)\[\/url\]/isU",'<a href="'.$newhref[0].'" >'.$text.'</a>',$content,1);
			}else{

				$content = preg_replace("/\[url.*\](.*)\[\/url\]/isU",'<a href="\\1" >'.$text.'</a>',$content,1);
			}

		}

		return $content;
	}

	/* 2017.05.11 edit by allen qu  上面的getImg 匹配图片有问题 重写一个方法*/
	function getImg_1($content){
		preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$content,$newcon);
		foreach($newcon[0] as $img){
			$content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',"<p>".$img."</p>",$content,1);
		}
		return $content;
	}

	function ubb2html($content)
	{
		$content = eregi_replace(quotemeta("[b]"),quotemeta("<b>"),$content);
		$content = eregi_replace(quotemeta("[/b]"),quotemeta("</b>"),$content);
		$content = eregi_replace(quotemeta("[i]"),quotemeta("<i>"),$content);
		$content = eregi_replace(quotemeta("[/i]"),quotemeta("</i>"),$content);
		$content = eregi_replace(quotemeta("[u]"),quotemeta("<u>"),$content);
		$content = eregi_replace(quotemeta("[/u]"),quotemeta("</u>"),$content);
		$content = eregi_replace(quotemeta("[center]"),quotemeta("<center>"),$content);
		$content = eregi_replace(quotemeta("[/center]"),quotemeta("</center>"),$content);
		$content = eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=_blank>www.\\1</a>",$content);
		$content = eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=_blank>\\1</a>",$content);
		$content = eregi_replace("\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]","<a href=\"\\1\" target=_blank>\\2</a>",$content);
		$content = eregi_replace("\\[email\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\1</a>",$content);

		/* 2017.06.09 edit by allen qu 图片转换 */
		$content = preg_replace("/\[img.*\](.*)\[\/img\]/isU", "<img src=\"\\1\" />" ,$content);
		return $content;
	}

	function parsesmiles2($message) {
		$smiles = array
		(
			'searcharray' => array
			(
				566 => '/\\{\:tus566\:\\}/',
				546 => '/\\{\:tus546\:\\}/',
				545 => '/\\{\:tus545\:\\}/',
				544 => '/\\{\:tus544\:\\}/',
				543 => '/\\{\:tus543\:\\}/',
				542 => '/\\{\:tus542\:\\}/',
				541 => '/\\{\:tus541\:\\}/',
				540 => '/\\{\:tus540\:\\}/',
				539 => '/\\{\:tus539\:\\}/',
				538 => '/\\{\:tus538\:\\}/',
				537 => '/\\{\:tus537\:\\}/',
				536 => '/\\{\:tus536\:\\}/',
				535 => '/\\{\:tus535\:\\}/',
				534 => '/\\{\:tus534\:\\}/',
				533 => '/\\{\:tus533\:\\}/',
				532 => '/\\{\:tus532\:\\}/',
				531 => '/\\{\:tus531\:\\}/',
				547 => '/\\{\:tus547\:\\}/',
				548 => '/\\{\:tus548\:\\}/',
				549 => '/\\{\:tus549\:\\}/',
				565 => '/\\{\:tus565\:\\}/',
				564 => '/\\{\:tus564\:\\}/',
				563 => '/\\{\:tus563\:\\}/',
				562 => '/\\{\:tus562\:\\}/',
				561 => '/\\{\:tus561\:\\}/',
				560 => '/\\{\:tus560\:\\}/',
				559 => '/\\{\:tus559\:\\}/',
				558 => '/\\{\:tus558\:\\}/',
				557 => '/\\{\:tus557\:\\}/',
				556 => '/\\{\:tus556\:\\}/',
				555 => '/\\{\:tus555\:\\}/',
				554 => '/\\{\:tus554\:\\}/',
				553 => '/\\{\:tus553\:\\}/',
				552 => '/\\{\:tus552\:\\}/',
				551 => '/\\{\:tus551\:\\}/',
				550 => '/\\{\:tus550\:\\}/',
				530 => '/\\{\:tus530\:\\}/',
				529 => '/\\{\:tus529\:\\}/',
				528 => '/\\{\:tus528\:\\}/',
				567 => '/\\{\:tus567\:\\}/',
				568 => '/\\{\:tus568\:\\}/',
				294 => '/\\{\:11_106\:\}/',
				295 => '/\\{\:11_163\:\}/',
				296 => '/\\{\:11_115\:\}/',
				297 => '/\\{\:11_140\:\}/',
				298 => '/\\{\:11_126\:\}/',
				299 => '/\\{\:11_147\:\}/',
				300 => '/\\{\:11_134\:\}/',
				301 => '/\\{\:11_187\:\}/',
				302 => '/\\{\:11_180\:\}/',
				303 => '/\\{\:11_144\:\}/',
				304 => '/\\{\:11_174\:\}/',
				305 => '/\\{\:11_161\:\}/',
				273 => '/\\{\:11_162\:\}/',
				293 => '/\\{\:11_125\:\}/',
				284 => '/\\{\:11_136\:\}/',
				285 => '/\\{\:11_138\:\}/',
				269 => '/\\{\:11_166\:\}/',
				268 => '/\\{\:11_137\:\}/',
				267 => '/\\{\:11_153\:\}/',
				266 => '/\\{\:11_164\:\}/',
				265 => '/\\{\:11_156\:\}/',
				264 => '/\\{\:11_182\:\}/',
				262 => '/\\{\:11_150\:\}/',
				261 => '/\\{\:11_167\:\}/',
				271 => '/\\{\:11_168\:\}/',
				272 => '/\\{\:11_120\:\}/',
				274 => '/\\{\:11_105\:\}/',
				283 => '/\\{\:11_103\:\}/',
				282 => '/\\{\:11_128\:\}/',
				281 => '/\\{\:11_176\:\}/',
				280 => '/\\{\:11_151\:\}/',
				279 => '/\\{\:11_160\:\}/',
				278 => '/\\{\:11_159\:\}/',
				277 => '/\\{\:11_110\:\}/',
				276 => '/\\{\:11_107\:\}/',
				275 => '/\\{\:11_112\:\}/',
				260 => '/\\{\:11_145\:\}/',
				259 => '/\\{\:11_139\:\}/',
				246 => '/\\{\:11_141\:\}/',
				245 => '/\\{\:11_149\:\}/',
				244 => '/\\{\:11_186\:\}/',
				286 => '/\\{\:11_117\:\}/',
				287 => '/\\{\:11_104\:\}/',
				288 => '/\\{\:11_171\:\}/',
				289 => '/\\{\:11_113\:\}/',
				290 => '/\\{\:11_116\:\}/',
				291 => '/\\{\:11_133\:\}/',
				247 => '/\\{\:11_173\:\}/',
				248 => '/\\{\:11_175\:\}/',
				249 => '/\\{\:11_142\:\}/',
				258 => '/\\{\:11_184\:\}/',
				257 => '/\\{\:11_132\:\}/',
				256 => '/\\{\:11_143\:\}/',
				255 => '/\\{\:11_181\:\}/',
				254 => '/\\{\:11_155\:\}/',
				253 => '/\\{\:11_111\:\}/',
				252 => '/\\{\:11_172\:\}/',
				251 => '/\\{\:11_179\:\}/',
				250 => '/\\{\:11_130\:\}/',
				292 => '/\\{\:11_154\:\}/',
				263 => '/\\{\:11_129\:\}/',
				319 => '/\\{\:11_157\:\}/',
				318 => '/\\{\:11_169\:\}/',
				317 => '/\\{\:11_178\:\}/',
				316 => '/\\{\:11_170\:\}/',
				315 => '/\\{\:11_119\:\}/',
				270 => '/\\{\:11_158\:\}/',
				313 => '/\\{\:11_124\:\}/',
				314 => '/\\{\:11_102\:\}/',
				307 => '/\\{\:11_109\:\}/',
				312 => '/\\{\:11_121\:\}/',
				308 => '/\\{\:11_118\:\}/',
				309 => '/\\{\:11_135\:\}/',
				320 => '/\\{\:11_185\:\}/',
				306 => '/\\{\:11_165\:\}/',
				330 => '/\\{\:11_127\:\}/',
				329 => '/\\{\:11_146\:\}/',
				328 => '/\\{\:11_101\:\}/',
				311 => '/\\{\:11_152\:\}/',
				327 => '/\\{\:11_131\:\}/',
				326 => '/\\{\:11_183\:\}/',
				325 => '/\\{\:11_177\:\}/',
				324 => '/\\{\:11_148\:\}/',
				322 => '/\\{\:11_114\:\}/',
				323 => '/\\{\:11_123\:\}/',
				321 => '/\\{\:11_108\:\}/',
				310 => '/\\{\:11_122\:\}/',
				698 => '/\\{\:10_11\:\}/',
				704 => '/\\{\:10_24\:\}/',
				703 => '/\\{\:10_25\:\}/',
				702 => '/\\{\:10_16\:\}/',
				701 => '/\\{\:10_19\:\}/',
				707 => '/\\{\:10_20\:\}/',
				708 => '/\\{\:10_17\:\}/',
				710 => '/\\{\:10_29\:\}/',
				713 => '/\\{\:10_32\:\}/',
				712 => '/\\{\:10_15\:\}/',
				697 => '/\\{\:10_13\:\}/',
				696 => '/\\{\:10_10\:\}/',
				695 => '/\\{\:10_18\:\}/',
				694 => '/\\{\:10_26\:\}/',
				693 => '/\\{\:10_28\:\}/',
				692 => '/\\{\:10_31\:\}/',
				691 => '/\\{\:10_30\:\}/',
				690 => '/\\{\:10_12\:\}/',
				689 => '/\\{\:10_14\:\}/',
				688 => '/\\{\:10_22\:\}/',
				685 => '/\\{\:10_21\:\}/',
				684 => '/\\{\:10_23\:\}/',
				683 => '/\\{\:10_27\:\}/',
				686 => '/\\{\:10_1\:\}/',
				714 => '/\\{\:10_3\:\}/',
				711 => '/\\{\:10_7\:\}/',
				709 => '/\\{\:10_2\:\}/',
				706 => '/\\{\:10_6\:\}/',
				700 => '/\\{\:10_8\:\}/',
				705 => '/\\{\:10_9\:\}/',
				699 => '/\\{\:10_5\:\}/',
				687 => '/\\{\:10_4\:\}/',
				729 => '/\\{\:d29\:\}/',
				728 => '/\\{\:d22\:\}/',
				727 => '/\\{\:d35\:\}/',
				726 => '/\\{\:d25\:\}/',
				725 => '/\\{\:d33\:\}/',
				724 => '/\\{\:d27\:\}/',
				723 => '/\\{\:d34\:\}/',
				722 => '/\\{\:d28\:\}/',
				721 => '/\\{\:d31\:\}/',
				720 => '/\\{\:d30\:\}/',
				719 => '/\\{\:d24\:\}/',
				718 => '/\\{\:d26\:\}/',
				717 => '/\\{\:d32\:\}/',
				716 => '/\\{\:d36\:\}/',
				715 => '/\\{\:d23\:\}/',
				731 => '/\\{\:d21\:\}/',
				730 => '/\\{\:d20\:\}/',
				671 => '/\\[Z\:24\\]/',
				681 => '/\\[Z\:32\\]/',
				680 => '/\\[Z\:44\\]/',
				679 => '/\\[Z\:15\\]/',
				677 => '/\\[Z\:29\\]/',
				674 => '/\\[Z\:20\\]/',
				675 => '/\\[Z\:17\\]/',
				670 => '/\\[Z\:25\\]/',
				669 => '/\\[Z\:38\\]/',
				655 => '/\\[Z\:28\\]/',
				654 => '/\\[Z\:36\\]/',
				653 => '/\\[Z\:31\\]/',
				652 => '/\\[Z\:43\\]/',
				651 => '/\\[Z\:30\\]/',
				650 => '/\\[Z\:33\\]/',
				649 => '/\\[Z\:12\\]/',
				648 => '/\\[Z\:14\\]/',
				656 => '/\\[Z\:26\\]/',
				657 => '/\\[Z\:40\\]/',
				667 => '/\\[Z\:19\\]/',
				659 => '/\\[Z\:10\\]/',
				666 => '/\\[Z\:37\\]/',
				663 => '/\\[Z\:11\\]/',
				662 => '/\\[Z\:41\\]/',
				661 => '/\\[Z\:13\\]/',
				660 => '/\\[Z\:39\\]/',
				658 => '/\\[Z\:18\\]/',
				647 => '/\\[Z\:22\\]/',
				668 => '/\\[Z\:16\\]/',
				533 => '/\\[s\:17\\]/',
				534 => '/\\[s\:25\\]/',
				611 => '/\\[L\:27\\]/',
				612 => '/\\[L\:23\\]/',
				613 => '/\\[L\:21\\]/',
				530 => '/\\[s\:13\\]/',
				529 => '/\\[s\:30\\]/',
				505 => '/\\[s\:28\\]/',
				507 => '/\\[s\:27\\]/',
				509 => '/\\[s\:29\\]/',
				511 => '/\\[s\:14\\]/',
				513 => '/\\[s\:26\\]/',
				515 => '/\\[s\:20\\]/',
				516 => '/\\[s\:19\\]/',
				517 => '/\\[s\:23\\]/',
				519 => '/\\[s\:16\\]/',
				520 => '/\\[s\:18\\]/',
				521 => '/\\[s\:15\\]/',
				523 => '/\\[s\:21\\]/',
				524 => '/\\[s\:12\\]/',
				525 => '/\\[s\:10\\]/',
				526 => '/\\[s\:24\\]/',
				528 => '/\\[s\:22\\]/',
				616 => '/\\[L\:22\\]/',
				617 => '/\\[L\:14\\]/',
				514 => '/\\[s\:11\\]/',
				642 => '/\\[Z\:42\\]/',
				627 => '/\\[L\:19\\]/',
				629 => '/\\[L\:25\\]/',
				641 => '/\\[Z\:23\\]/',
				640 => '/\\[Z\:35\\]/',
				639 => '/\\[Z\:27\\]/',
				630 => '/\\[L\:24\\]/',
				637 => '/\\[L\:15\\]/',
				633 => '/\\[L\:20\\]/',
				634 => '/\\[L\:17\\]/',
				624 => '/\\[L\:11\\]/',
				643 => '/\\[Z\:21\\]/',
				628 => '/\\[L\:16\\]/',
				620 => '/\\[L\:26\\]/',
				621 => '/\\[L\:18\\]/',
				618 => '/\\[L\:12\\]/',
				622 => '/\\[L\:10\\]/',
				623 => '/\\[L\:13\\]/',
				645 => '/\\[Z\:34\\]/',
				619 => '/\\[L\:28\\]/',
				506 => '/\\[s\:6\\]/',
				518 => '/\\[s\:2\\]/',
				638 => '/\\[L\:3\\]/',
				508 => '/\\[s\:3\\]/',
				636 => '/\\[L\:7\\]/',
				644 => '/\\[Z\:1\\]/',
				512 => '/\\[s\:5\\]/',
				678 => '/\\[Z\:7\\]/',
				510 => '/\\[s\:8\\]/',
				635 => '/\\[L\:2\\]/',
				522 => '/\\[s\:4\\]/',
				615 => '/\\[L\:4\\]/',
				614 => '/\\[L\:1\\]/',
				676 => '/\\[Z\:2\\]/',
				673 => '/\\[Z\:6\\]/',
				672 => '/\\[Z\:9\\]/',
				625 => '/\\[L\:5\\]/',
				626 => '/\\[L\:8\\]/',
				646 => '/\\[Z\:4\\]/',
				532 => '/\\[s\:7\\]/',
				531 => '/\\[s\:1\\]/',
				665 => '/\\[Z\:8\\]/',
				664 => '/\\[Z\:5\\]/',
				527 => '/\\[s\:9\\]/',
				631 => '/\\[L\:9\\]/',
				632 => '/\\[L\:6\\]/',
				682 => '/\\[Z\:3\\]/',
			),

			'replacearray' => array
			(
				548 => '4a46b55d456a94d99afd5&000.gif',
				562 => '4a46b55d456a94d6b9733&000.gif',
				566 => '4a46b55d45b1853a6e966&000.gif',
				540 => '4a46b55d45b1853a70e8e&000.gif',
				541 => '4a46b55d456a94d7b1b6e&000.gif',
				560 => '4a46b55dt54410f1c355c&000.gif',
				568 => '4a46b55d45b7bf75f0548&000.gif',
				567 => '4a46b55dafe31352a0532.gif',
				557 => '4a46b55dd8ba751c30cdd.gif',
				546 => '4a46b55d1e5a330526197.gif',
				537 => '4a46b55d45494f21bd926.gif',
				544 => '4a46b55deb0972b26d166.gif',
				543 => '4a46b55dc06cd3919fc1d.gif',
				542 => '4a46b55d5007920bafc4d.gif',
				539 => '4a46b55da385c7fd83ac9.gif',
				538 => '4a46b55dfc1bc0944ba7d.gif',
				554 => '4a46b55d976953e6cc93f.gif',
				564 => '4a46b55dcab854a58022e.gif',
				563 => '4a46b55d31e8dc4532e1f.gif',
				549 => '4a46b55de24190bad96ca.gif',
				550 => '4a46b55d211ec54549b69.gif',
				551 => '4a46b55d48cc3d73ebedf.gif',
				552 => '4a46b55d6e9ee7a960ad4.gif',
				553 => '4a46b55daaecf3c0ae0a7.gif',
				565 => '4a46b55d8202386be8bbe.gif',
				555 => '4a46b55d8a6437501b745.gif',
				556 => '4a46b55de1e36a61a8bbe.gif',
				547 => '4a46b55dd740392c54af3.gif',
				558 => '4a46b55df9ae3f13948a1.gif',
				545 => '4a46b55d45b060956ecd8.gif',
				535 => '4a46b55d63ff227add841.gif',
				561 => '4a46b55d0d2b1b9e669c9.gif',
				536 => '4a46b55d7558abc958959.gif',
				559 => 'show_fpic.php.gif',
				294 => '106.gif',
				295 => '163.gif',
				296 => '115.gif',
				297 => '140.gif',
				298 => '126.gif',
				299 => '147.gif',
				300 => '134.gif',
				301 => '187.gif',
				302 => '180.gif',
				303 => '144.gif',
				304 => '174.gif',
				305 => '161.gif',
				273 => '162.gif',
				293 => '125.gif',
				284 => '136.gif',
				285 => '138.gif',
				269 => '166.gif',
				268 => '137.gif',
				267 => '153.gif',
				266 => '164.gif',
				265 => '156.gif',
				264 => '182.gif',
				262 => '150.gif',
				261 => '167.gif',
				271 => '168.gif',
				272 => '120.gif',
				274 => '105.gif',
				283 => '103.gif',
				282 => '128.gif',
				281 => '176.gif',
				280 => '151.gif',
				279 => '160.gif',
				278 => '159.gif',
				277 => '110.gif',
				276 => '107.gif',
				275 => '112.gif',
				260 => '145.gif',
				259 => '139.gif',
				246 => '141.gif',
				245 => '149.gif',
				244 => '186.gif',
				286 => '117.gif',
				287 => '104.gif',
				288 => '171.gif',
				289 => '113.gif',
				290 => '116.gif',
				291 => '133.gif',
				247 => '173.gif',
				248 => '175.gif',
				249 => '142.gif',
				258 => '184.gif',
				257 => '132.gif',
				256 => '143.gif',
				255 => '181.gif',
				254 => '155.gif',
				253 => '111.gif',
				252 => '172.gif',
				251 => '179.gif',
				250 => '130.gif',
				292 => '154.gif',
				263 => '129.gif',
				319 => '157.gif',
				318 => '169.gif',
				317 => '178.gif',
				316 => '170.gif',
				315 => '119.gif',
				270 => '158.gif',
				313 => '124.gif',
				314 => '102.gif',
				307 => '109.gif',
				312 => '121.gif',
				308 => '118.gif',
				309 => '135.gif',
				320 => '185.gif',
				306 => '165.gif',
				330 => '127.gif',
				329 => '146.gif',
				328 => '101.gif',
				311 => '152.gif',
				327 => '131.gif',
				326 => '183.gif',
				325 => '177.gif',
				324 => '148.gif',
				322 => '114.gif',
				323 => '123.gif',
				321 => '108.gif',
				310 => '122.gif',
				698 => '11.gif',
				704 => '24.gif',
				703 => '25.gif',
				702 => '16.gif',
				701 => '19.gif',
				707 => '20.gif',
				708 => '17.gif',
				710 => '29.gif',
				713 => '32.gif',
				712 => '15.gif',
				697 => '13.gif',
				696 => '10.gif',
				695 => '18.gif',
				694 => '26.gif',
				693 => '28.gif',
				692 => '31.gif',
				691 => '30.gif',
				690 => '12.gif',
				689 => '14.gif',
				688 => '22.gif',
				685 => '21.gif',
				684 => '23.gif',
				683 => '27.gif',
				686 => '1.gif',
				714 => '3.gif',
				711 => '7.gif',
				709 => '2.gif',
				706 => '6.gif',
				700 => '8.gif',
				705 => '9.gif',
				699 => '5.gif',
				687 => '4.gif',
				729 => 'd29.gif',
				728 => 'd22.jpg',
				727 => 'd35.gif',
				726 => 'd25.gif',
				725 => 'd33.gif',
				724 => 'd27.gif',
				723 => 'd34.gif',
				722 => 'd28.gif',
				721 => 'd31.gif',
				720 => 'd30.gif',
				719 => 'd24.gif',
				718 => 'd26.gif',
				717 => 'd32.gif',
				716 => 'd36.gif',
				715 => 'd23.gif',
				731 => 'd21.jpg',
				730 => 'd20.jpg',
				671 => '24.gif',
				681 => '32.gif',
				680 => '44.gif',
				679 => '15.gif',
				677 => '29.gif',
				674 => '20.gif',
				675 => '17.gif',
				670 => '25.gif',
				669 => '38.gif',
				655 => '28.gif',
				654 => '36.gif',
				653 => '31.gif',
				652 => '43.gif',
				651 => '30.gif',
				650 => '33.gif',
				649 => '12.gif',
				648 => '14.gif',
				656 => '26.gif',
				657 => '40.gif',
				667 => '19.gif',
				659 => '10.gif',
				666 => '37.gif',
				663 => '11.gif',
				662 => '41.gif',
				661 => '13.gif',
				660 => '39.gif',
				658 => '18.gif',
				647 => '22.gif',
				668 => '16.gif',
				533 => '17.gif',
				534 => '25.gif',
				611 => '27.gif',
				612 => '23.gif',
				613 => '21.gif',
				530 => '13.gif',
				529 => '30.gif',
				505 => '28.gif',
				507 => '27.gif',
				509 => '29.gif',
				511 => '14.gif',
				513 => '26.gif',
				515 => '20.gif',
				516 => '19.gif',
				517 => '23.gif',
				519 => '16.gif',
				520 => '18.gif',
				521 => '15.gif',
				523 => '21.gif',
				524 => '12.gif',
				525 => '10.gif',
				526 => '24.gif',
				528 => '22.gif',
				616 => '22.gif',
				617 => '14.gif',
				514 => '11.gif',
				642 => '42.gif',
				627 => '19.gif',
				629 => '25.gif',
				641 => '23.gif',
				640 => '35.gif',
				639 => '27.gif',
				630 => '24.gif',
				637 => '15.gif',
				633 => '20.gif',
				634 => '17.gif',
				624 => '11.gif',
				643 => '21.gif',
				628 => '16.gif',
				620 => '26.gif',
				621 => '18.gif',
				618 => '12.gif',
				622 => '10.gif',
				623 => '13.gif',
				645 => '34.gif',
				619 => '28.gif',
				506 => '6.gif',
				518 => '2.gif',
				638 => '3.gif',
				508 => '3.gif',
				636 => '7.gif',
				644 => '1.gif',
				512 => '5.gif',
				678 => '7.gif',
				510 => '8.gif',
				635 => '2.gif',
				522 => '4.gif',
				615 => '4.gif',
				614 => '1.gif',
				676 => '2.gif',
				673 => '6.gif',
				672 => '9.gif',
				625 => '5.gif',
				626 => '8.gif',
				646 => '4.gif',
				532 => '7.gif',
				531 => '1.gif',
				665 => '8.gif',
				664 => '5.gif',
				527 => '9.gif',
				631 => '9.gif',
				632 => '6.gif',
				682 => '3.gif',
			),

			'typearray' => array
			(
				548 => 3,
				562 => 3,
				566 => 3,
				540 => 3,
				541 => 3,
				560 => 3,
				568 => 3,
				567 => 3,
				557 => 3,
				546 => 3,
				537 => 3,
				544 => 3,
				543 => 3,
				542 => 3,
				539 => 3,
				538 => 3,
				554 => 3,
				564 => 3,
				563 => 3,
				549 => 3,
				550 => 3,
				551 => 3,
				552 => 3,
				553 => 3,
				565 => 3,
				555 => 3,
				556 => 3,
				547 => 3,
				558 => 3,
				545 => 3,
				535 => 3,
				561 => 3,
				536 => 3,
				559 => 3,
				294 => 4,
				295 => 4,
				296 => 4,
				297 => 4,
				298 => 4,
				299 => 4,
				300 => 4,
				301 => 4,
				302 => 4,
				303 => 4,
				304 => 4,
				305 => 4,
				273 => 4,
				293 => 4,
				284 => 4,
				285 => 4,
				269 => 4,
				268 => 4,
				267 => 4,
				266 => 4,
				265 => 4,
				264 => 4,
				262 => 4,
				261 => 4,
				271 => 4,
				272 => 4,
				274 => 4,
				283 => 4,
				282 => 4,
				281 => 4,
				280 => 4,
				279 => 4,
				278 => 4,
				277 => 4,
				276 => 4,
				275 => 4,
				260 => 4,
				259 => 4,
				246 => 4,
				245 => 4,
				244 => 4,
				286 => 4,
				287 => 4,
				288 => 4,
				289 => 4,
				290 => 4,
				291 => 4,
				247 => 4,
				248 => 4,
				249 => 4,
				258 => 4,
				257 => 4,
				256 => 4,
				255 => 4,
				254 => 4,
				253 => 4,
				252 => 4,
				251 => 4,
				250 => 4,
				292 => 4,
				263 => 4,
				319 => 4,
				318 => 4,
				317 => 4,
				316 => 4,
				315 => 4,
				270 => 4,
				313 => 4,
				314 => 4,
				307 => 4,
				312 => 4,
				308 => 4,
				309 => 4,
				320 => 4,
				306 => 4,
				330 => 4,
				329 => 4,
				328 => 4,
				311 => 4,
				327 => 4,
				326 => 4,
				325 => 4,
				324 => 4,
				322 => 4,
				323 => 4,
				321 => 4,
				310 => 4,
				698 => 10,
				704 => 10,
				703 => 10,
				702 => 10,
				701 => 10,
				707 => 10,
				708 => 10,
				710 => 10,
				713 => 10,
				712 => 10,
				697 => 10,
				696 => 10,
				695 => 10,
				694 => 10,
				693 => 10,
				692 => 10,
				691 => 10,
				690 => 10,
				689 => 10,
				688 => 10,
				685 => 10,
				684 => 10,
				683 => 10,
				686 => 10,
				714 => 10,
				711 => 10,
				709 => 10,
				706 => 10,
				700 => 10,
				705 => 10,
				699 => 10,
				687 => 10,
				729 => 11,
				728 => 11,
				727 => 11,
				726 => 11,
				725 => 11,
				724 => 11,
				723 => 11,
				722 => 11,
				721 => 11,
				720 => 11,
				719 => 11,
				718 => 11,
				717 => 11,
				716 => 11,
				715 => 11,
				731 => 11,
				730 => 11,
				671 => 9,
				681 => 9,
				680 => 9,
				679 => 9,
				677 => 9,
				674 => 9,
				675 => 9,
				670 => 9,
				669 => 9,
				655 => 9,
				654 => 9,
				653 => 9,
				652 => 9,
				651 => 9,
				650 => 9,
				649 => 9,
				648 => 9,
				656 => 9,
				657 => 9,
				667 => 9,
				659 => 9,
				666 => 9,
				663 => 9,
				662 => 9,
				661 => 9,
				660 => 9,
				658 => 9,
				647 => 9,
				668 => 9,
				533 => 3,
				534 => 3,
				611 => 8,
				612 => 8,
				613 => 8,
				530 => 3,
				529 => 3,
				505 => 3,
				507 => 3,
				509 => 3,
				511 => 3,
				513 => 3,
				515 => 3,
				516 => 3,
				517 => 3,
				519 => 3,
				520 => 3,
				521 => 3,
				523 => 3,
				524 => 3,
				525 => 3,
				526 => 3,
				528 => 3,
				616 => 8,
				617 => 8,
				514 => 3,
				642 => 9,
				627 => 8,
				629 => 8,
				641 => 9,
				640 => 9,
				639 => 9,
				630 => 8,
				637 => 8,
				633 => 8,
				634 => 8,
				624 => 8,
				643 => 9,
				628 => 8,
				620 => 8,
				621 => 8,
				618 => 8,
				622 => 8,
				623 => 8,
				645 => 9,
				619 => 8,
				506 => 3,
				518 => 3,
				638 => 8,
				508 => 3,
				636 => 8,
				644 => 9,
				512 => 3,
				678 => 9,
				510 => 3,
				635 => 8,
				522 => 3,
				615 => 8,
				614 => 8,
				676 => 9,
				673 => 9,
				672 => 9,
				625 => 8,
				626 => 8,
				646 => 9,
				532 => 3,
				531 => 3,
				665 => 9,
				664 => 9,
				527 => 3,
				631 => 8,
				632 => 8,
				682 => 9,
			)

		);


		$smileytypes = array (
			4 =>
				array (
					'name' => '嘻哈猴',
					'directory' => 'xhh',
				),
			11 =>
				array (
					'name' => '暴走漫画',
					'directory' => 'baozou',
				),
			3 =>
				array (
					'name' => '兔斯基',
					'directory' => 'tus',
				),
			8 =>
				array (
					'name' => '变变龙',
					'directory' => 'long',
				),
			9 =>
				array (
					'name' => '猪猪侠',
					'directory' => 'pig',
				),
			10 =>
				array (
					'name' => '小幺鸡',
					'directory' => 'chicken',
				),
		);
		if(!empty($smiles) && is_array($smiles)) {
			foreach($smiles['replacearray'] AS $key => $smiley) {
				$smiles['replacearray'][$key] = '<img src="http://www.yeeyi.com/bbs/static/image/smiley/'.$smileytypes[$smiles['typearray'][$key]]['directory'].'/'.$smiley.'" smilieid="'.$key.'" border="0" alt="" />';

			}
		}
		ksort($smiles['replacearray']);
		ksort($smiles['searcharray']);
		$message = preg_replace($smiles['searcharray'], $smiles['replacearray'], $message);
		return $message;
	}

//changeAryToObj
function array2obj($array){
	$return = array();
	foreach($array as $list){
		$return[$list[0]] = $list[1];
	}
	return $return;
}

function getattachtableid($tid)
{
	$tid = (string)$tid;
	return intval($tid{strlen($tid) - 1});
}

// 参数解释
// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期
function authcode($string, $operation = 'DECODE', $expiry = 0,$key = '%_dm%$s&e2yeeyifo') {
	// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
	// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
	// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
	// 当此值为 0 时，则不产生随机密钥
	if($expiry<1){
		$expiry = 86400*30;
	}
	$ckey_length = 16;
	// 密匙
	$key = md5($key);
	// 密匙a会参与加解密
	$keya = md5(substr($key, 0, 16));
	// 密匙b会用来做数据完整性验证
	$keyb = md5(substr($key, 16, 16));
	// 密匙c用于变化生成的密文
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	// 参与运算的密匙
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
	// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	// 产生密匙簿
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上并不会增加密文的强度
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	// 核心加解密部分
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		// 从密匙簿得出密匙进行异或，再转成字符
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		// substr($result, 0, 10) == 0 验证数据有效性
		// substr($result, 0, 10) - time() > 0 验证数据有效性
		// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
		// 验证数据有效性，请看未加密明文的格式
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
		// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function sendMail($email,$subject,$message,$from='baoliao@yeeyi.com'){
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
	$headers .= 'Content-Transfer-Encoding: base64'. "\r\n";
	$headers .= 'From: ' . $from . "\r\n";
	$message = chunk_split(base64_encode(str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $message)))))));
	$send= @mail($email,$subject, $message, $headers)?true : false;
	return $send;
}

