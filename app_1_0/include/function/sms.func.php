<?php
/*
 * 短信发布集合
 *
 * */

/**
+----------------------------------------------------------
 * 短信发布函数
+----------------------------------------------------------
 * @param $Mobile_Number 手机号码
 * @param  $msg 短信内容 Utf-8编码
 * @param $ischeck 是否需要校验时间
+----------------------------------------------------------
 * @return 0 1 -1
 * 0 发送失败
 * 1 发送成功
 * -1 未超过1分钟
+----------------------------------------------------------
 */


function SendSMS($Mobile_Number,$msg,$ischeck=1)
{
    if($ischeck){
        $keyTime = 'sms_time_'.$Mobile_Number;
        $lastTime = getVar($keyTime);
        if($lastTime>0){
            return -1;
        }
    }
    $Username = 'yeeyi';
    $Key = '3F6AED01-6B1A-3BBA-77BF-5DFBC3B284C0';
    $content =  'method=http'.'&username='.rawurlencode($Username).'&key='.rawurlencode($Key);
    $content .=  '&to='.rawurlencode($Mobile_Number).'&message='.rawurlencode($msg).'&messagetype=Unicode';
    $url = "https://api.clicksend.com/http/v2/send.php";
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $content);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt( $ch, CURLOPT_TIMEOUT, 60);

    $Result = curl_exec($ch);
    $xml = simplexml_load_string($Result);
    $resultcode = (string)$xml->messages->message->result;
    /**
     * 0000成功
     * 2开头的都是失败
     */
    setVar($keyTime,time(),60);
    if($resultcode == '0000'){
        return 1;
    }
    else{
        return 0;
    }
}


/**
 * @param $mobile 手机号码
 * @return boolean
 */
function loginSMS($mobile){
    $scode = mt_rand(100000,999999);
    $keyCode = 'sms_'.$mobile;
    $message = "来自亿忆网的校验短信 ".$scode." 有效时间为5分钟";
    $return = SendSMS($mobile,$message);
    if($return == -1){
        return -1;
    }
    else if($return == 1){
        setVar($keyCode,$scode,300);
        return 1;
    }
    else {
        return 0;
    }
}

function sendPwd($mobile,$pwd){
    $message = "来自亿忆网的短信：您在亿忆网使用手机注册帐号的随机密码是 ".$pwd." ";
    $return = SendSMS($mobile,$message,0);
}


function checkSms($mobile,$smscode){
    $keyCode = 'sms_'.$mobile;
    $successKey = 'sms_check_'.$mobile;
    $cacheCode = getVar($keyCode);
    if($smscode == $cacheCode){
        $checkNum = mt_rand(1000,9999);
        setVar($successKey,$checkNum,300);
        return $checkNum;
    }
    else{
        return false;
    }
}

