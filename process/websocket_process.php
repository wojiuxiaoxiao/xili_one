<?php
date_default_timezone_set('America/Mexico_City');
include(dirname(__FILE__)."/include/fun.php");
class E2WsServer{
    var $server;
    function run(){
        $this->server = new swoole_websocket_server("168.1.79.41", 8089);
        //$this->server->set(['worker_num' => 4, 'user'=>'www', 'group'=>'www', 'daemonize'=>0]);
        $this->server->on('open',array($this,'srvOpen'));//另外一种回调的写法
        $this->server->on('message',array($this,'srvMessage'));
        $this->server->on('request',array($this,'srvRequest'));
        $this->server->on('close',array($this,'srvClose'));
        $server = &$this->server;
        $this->server->addProcess(new swoole_process(function($process) {
            $timer = swoole_timer_tick(2000, function ($timer_id) {

                foreach($this->server->connections as $fd1)
                {
                    echo '||||'.$fd1."||||\r\n";
                    $this->server->push($fd1,$fd1."=====".time());
                }


            });
        }));
        /**/
        $this->server->start();
    }

    /**
     * @param $request
     * @param $response
     * 正常的网页访问
     */
    function srvRequest($request, $response) {
    }

    /**
     * @param swoole_websocket_server $server
     * @param swoole_http_request $request
     * 当握手连接的时候
     */
    function srvOpen(swoole_websocket_server $server, swoole_http_request $request){
        //swoole_set_process_name("e2wsserver"); //进程名称
        $fd = $request->fd;
        $authcodeclient = trim($request->get['id']);

    }

    /**
     * @param $server
     * @param $frame
     * 当收到消息的时候
     */
    function srvMessage($server, $frame){
        $fd = $frame->fd;
        $data = $frame->data;
        $this->sendmsg($fd,$data);

    }

    /**
     * @param $fd
     * @param $msg
     * @return bool
     * 发送消息
     */
    function sendmsg($fd,$msg){
        try{
            return $this->server->push($fd,$msg); //成功则真，失败则假
        }
        catch(Exception $e){
            return false;//发送失败
        }
    }

    /**
     * @param $server
     * @param $fd
     * 关闭连接
     */
    function srvClose($server,$fd){

    }

    function getNewMsg($uid){

    }



}
$ws = new E2WsServer();
$ws->run();
?>