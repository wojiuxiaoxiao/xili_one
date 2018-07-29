<?php
date_default_timezone_set('Australia/Melbourne');
include(dirname(__FILE__)."/include/fun.php");
include(dirname(__FILE__)."/include/lib.php");
class E2WsServer{
    var $server;
    function run(){
        $this->server = new swoole_websocket_server("144.217.219.68", 8088);
        $this->server->set(array('worker_num' => 64, 'max_request' => 1000,'user'=>'www', 'group'=>'www', 'daemonize'=>0,'heartbeat_idle_time' => 600,'heartbeat_check_interval' => 60,));
        //$this->server->setGlobal(HTTP_GLOBAL_GET);//开放get
        $this->server->on('open',array($this,'srvOpen'));//另外一种回调的写法
        $this->server->on('message',array($this,'srvMessage'));
        $this->server->on('request',array($this,'srvRequest'));
        $this->server->on('close',array($this,'srvClose'));
        $this->server->start();
    }

    function srvRequest($request, $response) {

    }
    function srvOpen(swoole_websocket_server $server, swoole_http_request $request){
        echo count($this->server->connections)."\r\n";
        swoole_set_process_name("e2wsserver");
        $fd = $request->fd;
        $devId = trim($request->get['dev']);
        $link = getVar('ws_connect_'.$devId);
        if(is_array($link)){
            if(count($link)>1){
                $server->close($fd);
                return false;
            }
        }
        else{
            $link = array();
        }
        $link[] = $fd;
        setVar('ws_connect_'.$devId,$link,3600);
        
        $authcodeclient = trim($request->get['id']);
        $authcodeclient = trim(str_replace("e2app","/",$authcodeclient));
        $authcodeclient = trim(str_replace(" ","+",$authcodeclient));
        if(strlen($authcodeclient)>=10){
            $str = authcode($authcodeclient,'DECODE');
            list($uid,$username,$groupid) = explode("::::",$str);
            $authType = 'client';
        }
        else{
            $authType = 'guest';
        }
        $redis = MyRedis::newRedis();
        if($uid>0){
            //保存authcode 和 uid的关系
            $redisKey = 'user_redis_'.$fd;
            $redis->setval($redisKey,$uid);
            $olKey = 'ol_'.$uid;
            setVar($olKey,time(),60);
        }
        $this->logInfo($uid."----".$fd."----is comming \r\n");
        $msgAry = $this->getNewmsg($uid);
        foreach($msgAry as $data){
            $str = json_encode($data);
            $this->sendmsg($fd,$str);
        }
    }
    function srvMessage($server, $frame){
        $fd = $frame->fd;
        $data = $frame->data;
        $message = $data;//收到的信息
        $redis = MyRedis::newRedis();
        $redisKey = 'user_redis_'.$fd;
        $uid = $redis->getval($redisKey);
        $uid = intval($uid);
        $this->logInfo($uid."----".$fd."----get---".$data." \r\n");
		//更新用户在线
		$olKey = 'ol_'.$uid;
        setVar($olKey,time(),60);
        if($message == 2){
            $this->sendmsg($fd,2);
        }
        else if(strstr($message,'w|')){
            list($tt,$wsid) = explode('|',$message);
            $this->syncMsg(0,$wsid);
        }
        if($uid>0){
            $msgAry = $this->getNewmsg($uid);
            foreach($msgAry as $data){
                $str = json_encode($data);
                $this->sendmsg($fd,$str);
            }
        }

        $this->sendPush();
    }



    function sendmsg($fd,$msg){
        try{
            $this->logInfo($fd."----send---".$msg." \r\n");
            return $this->server->push($fd,$msg); //成功则真，失败则假
        }
        catch(Exception $e){
            return false;//发送失败
        }
    }
    function srvClose($server,$fd){
        $redisKey = 'user_redis_'.$fd;
        $redis = MyRedis::newRedis();
        $redis->delKey($redisKey);
    }
    //获取最新的消息

    /**
     * @param $uid
     *
     */
    function getNewmsg($uid){
        $uid = intval($uid);
        $db =Mysql::newMysql();
        $msgAry = $db->fetch_all_assoc("select * from app_ws_data where uid=".$uid);
        $msg = array();
        if(is_array($msgAry)){
            foreach($msgAry as $tmp){
                $msgTmp = array();
                $msgTmp['i'] = intval($tmp['wsid']);
                $dataAry = unserialize($tmp['data']);
                $dataAry = changeCode($dataAry);
                $msgTmp['t'] = intval($dataAry['t']);
                $msgTmp['id'] = intval($dataAry['id']);
                $msgTmp['m'] = trim($dataAry['m']);
                if(isset($dataAry['f'])){
                    $msgTmp['f'] = trim($dataAry['f']);
                }
                $msg[] = $msgTmp;
            }
        }
        return $msg;
    }


    function sendPush(){
        $key = 'e2_push_list';
        $redis = MyRedis::newRedis();
        $data = $redis->listPop($key);
        $dataAry = unserialize($data);
        if(is_array($dataAry) && $dataAry['i']>0){
            $dataAry = changeCode($dataAry);
            $str = json_encode($dataAry);

            foreach($this->server->connections as $fd)
            {
                try{
                    $this->logInfo($fd."----push---".$str);
                    $this->server->push($fd,$str);
                }
                catch(Exception $e){
                    $this->logInfo($fd." send false\r\n");
                }
            }
        }
    }

    function syncMsg($uid,$wsid){
        $wsid = intval($wsid);
        $db =Mysql::newMysql();
        $db->query("delete from app_ws_data where wsid=".$wsid);
    }

    function logInfo($str){
        /*$file = 'log_'.date("Y_m_d")."_.txt";
        $fp = fopen($file,'a+');
        fwrite($fp,date("m-d G:i:s")."   ".$str."\r\n");
        fclose($fp);
        */
    }
}
$ws = new E2WsServer();
$ws->run();
?>