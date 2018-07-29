<?php
define('ROOT_PATH',dirname(__FILE__) . '/');
define('RELATIVE_ROOT_PATH','./');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
//版本控制
$version = trim($_POST['app_ver']); //version = '1_0_0_ios'; version = '1_0_0_android'; 最后一位小版本控制
$verDir = 'app_1_0';
if($version){
	$verAry = explode('_',$version);
	if(count($verAry) == 4){
		//$verDir = 'app_'.$verAry[0].'_'.$verAry[1]; // app_1_0; editby neekli
		$verDir = $verAry[2]>1 ?  'app_'.$verAry[0].'_'.$verAry[1].'_'.$verAry[2] : 'app_'.$verAry[0].'_'.$verAry[1]; // app_1_0;
	}
}
if(!is_dir(ROOT_PATH.$verDir)){
	$verDir = 'app_1_0';
}
define('VERSION',$verDir.'/');

class initialize
{
	function init()
	{
		$config=array();
		require(ROOT_PATH . VERSION . '/config/config.php');

//		if(VERSION != 'app_1_9/' && VERSION != 'app_1_9_2/' && VERSION != 'app_1_9_3/') {
//            require(ROOT_PATH . '/setting.php');
//        }
		if(intval(substr(VERSION,4,1).substr(VERSION,6,1))<19) {
			require(ROOT_PATH . '/setting.php');
		}
		require(ROOT_PATH . '/default_ad.php');  
		@header('Content-Type: text/html; charset=utf-8');
		@header('P3P: CP="CAO PSA OUR"');
		require_once(ROOT_PATH . VERSION . '/include/function/global.func.php');
		require_once(ROOT_PATH . VERSION . '/include/golbal.php');
		require_once(ROOT_PATH . VERSION . '/app/app.mod.php');
		require_once(ROOT_PATH . VERSION . '/app/' . $this->SetEvent($config['default_app']) . '.mod.php');
		if($_GET)
		{
			$_GET = jaddslashes($_GET, 1, FALSE);
		}
		if($_POST)
		{
			$_POST = jaddslashes($_POST, 1, FALSE);
		}
		$moduleobject = new ModuleObject($config);
	}

	function SetEvent($default='index')
	{
		$modss = array(
				'article'=>1,
				'thread'=>1,
				'index'=>1,
				'tools'=>1,
				'member'=>1,
				'topic'=>1,
		);
		$mod = (isset($_POST['app']) ? $_POST['app'] : $_GET['app']);
		if(!isset($modss[$mod]))
		{
			if($mod)
			{
				$_POST['mod_original'] = $_GET['mod_original'] = $mod;
			}
				
			$mod = ($default ? $default : 'index');
		}
		$_POST['app'] = $_GET['app'] = $mod;
		Return $mod;
	}
}
$init=new initialize;
$init->init();
unset($init);