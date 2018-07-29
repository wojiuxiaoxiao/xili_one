<?php
use Sms\Request\V20160927 as Sms; 

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
    if($resultcode == '0000'){
        return 1;
        setVar($keyTime,time(),60);
    }
    else{
        return 0;
    }
}
function SendSMSChina($tel,$code,$key,$ischeck=1)
{
    if($ischeck){
        $keyTime = 'sms_time_'.$tel;
        $lastTime = getVar($keyTime);
        if($lastTime>0){
            return -1;
        }
    }
    $keypair = md5($tel."_e2_msgkey");
    if($key!=$keypair){
        return 0;
    }
    require_once(ROOT_PATH . VERSION . '/include/lib/aliyun-php-sdk-core/Config.php');
               
    $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", "LTAIoJ7cJSR09j4q", "uyofC9vg9C9hWhyo2FKxkzLAnZNoUa");        
    $client = new DefaultAcsClient($iClientProfile);    
    $request = new Sms\SingleSendSmsRequest();
    $request->setSignName("亿忆网");/*签名名称*/
    $request->setTemplateCode("SMS_40070001");/*模板code*/
    $request->setRecNum($tel);/*目标手机号*/
    $request->setParamString("{\"code\":\"".$code."\"}");/*模板变量，数字一定要转换为字符串*/
    try {
        $response = $client->getAcsResponse($request);
        setVar($keyTime,time(),60);
        return 1;
    }
    catch (ClientException  $e) {
        print_r($e->getErrorCode());   
        print_r($e->getErrorMessage());   
    }
    catch (ServerException  $e) {        
        print_r($e->getErrorCode());   
        print_r($e->getErrorMessage());
    }
    

}

/**
 * @param $mobile 手机号码
 * @return boolean
 */
function loginSMS($mobile,$country_code){
    $scode = mt_rand(100000,999999);
    $keyCode = 'sms_'.$mobile;
    $message = "来自亿忆网的校验短信 ".$scode." 有效时间为5分钟";
    if($country_code=='61'){
        $return = SendSMS($mobile,$message);
    }elseif($country_code=='86'){
        $key = md5($mobile."_e2_msgkey");
        $return = SendSMSChina($mobile,$scode,$key);
    }
    
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

function sendPwd($mobile,$pwd, $countryCode = '61'){
    $message = "来自亿忆网的短信：您在亿忆网使用手机注册帐号的随机密码是 ".$pwd." ";

    if ($countryCode == '86') {

        $key = md5($mobile."_e2_msgkey");

        $return = SendSMSChina($mobile,$message,$key, 0);

    }else {

        $return = SendSMS($mobile,$message,0);
    }

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

