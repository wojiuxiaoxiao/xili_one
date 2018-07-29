<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 16:47
 */
$passphrase = '8J8LcjgRwSyo';
$cert_file = 'ck.pem';//推送的证书地址，环境不要错了
$feedback_server = 'ssl://feedback.push.apple.com:2196';//feedback服务器地址
//沙盒环境地址是 ssl://feedback.sandbox.push.apple.com:2196
$feedback_server = 'ssl://feedback.sandbox.push.apple.com:2196';
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $cert_file);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
$fp = stream_socket_client($feedback_server, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $ctx);
if(!$fp){
    print "Failed to connect feedback server: $error $errorString\n";
    return false;
}else{
    print "Connection to feedback server OK\n";
}

while ($devcon = fread($fp, 38)){
    $count1 ++ ;
    $arr = unpack("H*", $devcon);//解包传过来的二进制数据
    echo $arr;
    $rawhex = trim(implode("", $arr));
    $feedbackTime = hexdec(substr($rawhex, 0, 8));
    $feedbackDate = date('Y-m-d H:i:s', $feedbackTime);
    $feedbackDeviceToken = substr($rawhex, 12, 64);
//记录被删除的token
    //$redis->hSet($iostokenremoved,$feedbackDeviceToken,$feedbackDate);
//记录每天的卸载数量
    //$redis->hIncrBy($iostokenremoved_num,date('Y-m-d',$feedbackTime),1);
}
echo 'FeedBack:'. $count1 . PHP_EOL;