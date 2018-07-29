<?php

/**
 * @param $uid
 * @param $dataAry
 * @return bool
 * 添加进入数据库
t：类型   1新闻 2分类信息 3话题 4话题内容 5评论 6站内消息
d: 数据id
m:文字信息
f:特别强调，此参数只有在t是5的时候独有 1表示新闻评论 2生活信息评论 3话题评论
 *
 */
function addDb($uid,$dataAry)
{
    $uid = intval($uid);
    if($uid<1){
        return false;
    }
    if(!is_array($dataAry)){
        return false;
    }
    $db = Mysql::newMysql();
    $data = serialize($dataAry);
    $dataStr = addslashes($data);
    $db->query("insert into app_ws_data(uid,`data`) values('".$uid."','".$dataStr."')");
    //判断是否为ios
    $checkIosInfo = $db->once_fetch_assoc("select token from app_user_authcode where uid=".$uid);
    if(isset($checkIosInfo['token']) && strlen($checkIosInfo['token'])){
        $token = trim($checkIosInfo['token']);
        $body = array(
            "aps" => array(
                "alert" => $dataAry['m'],
                "badge" => 1,
                'sound' => 'bingbong.aiff',

            ),
            'i'=>time(),
            't'=>$dataAry['t'],
            'id'=>$dataAry['d'],
            'm'=>$dataAry['m']
        );
        if($dataAry['t'] == 5){
            $body['f'] = $dataAry['f'];
        }
        $content = serialize($body);
        $db->query('set names utf8');
        $db->query("insert into app_ios_push(token,content) values('".$token."','".addslashes($content)."')");
        $db->query('set names gbk');
    }
}

function pushReply($uid,$from,$message){
    $uid = intval($uid);
    if($uid<1){
        return false;
    }
    $message = changeCode($message,'utf-8','gbk');
    $dataAry = array();
    $dataAry['t'] = 5;
    $dataAry['d'] = 0;
    $dataAry['m'] = $message;
    $dataAry['f'] = intval($from);
    addDb($uid,$dataAry);
}

function pushNewsReply($uid){
    $from = 1;
    $message = '您收到一条新闻评论';
    pushReply($uid,$from,$message);
}

function pushTopicReply($uid){
    $from = 3;
    $message = '您收到一条话题评论';
    pushReply($uid,$from,$message);
}

function pushThreadReply($uid,$message){
    $from = 2;
    $message = '您收到一条分类信息评论';
    pushReply($uid,$from,$message);
}

function pushNotice($uid){
    $message = '您收到一条站内消息';
    $message = changeCode($message,'utf-8','gbk');
    $dataAry = array();
    $dataAry['t'] = 6;
    $dataAry['d'] = 0;
    $dataAry['m'] = $message;
    addDb($uid,$dataAry);
}


function pushIOS($token){

}