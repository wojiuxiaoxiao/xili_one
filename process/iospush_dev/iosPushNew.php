<?php
/**
 * ApplePush 苹果消息推送公共类
\\
 */
class ApplePush
{

    const STATUS_CODE_INTERNAL_ERROR = 999;
    const ERROR_RESPONSE_SIZE = 6;
    const ERROR_RESPONSE_COMMAND = 8;

    protected $_errorResponseMessages = array(
        0 => 'No errors encountered',
        1 => 'Processing error',
        2 => 'Missing device token',
        3 => 'Missing topic',
        4 => 'Missing payload',
        5 => 'Invalid token size',
        6 => 'Invalid topic size',
        7 => 'Invalid payload size',
        8 => 'Invalid token',
        self::STATUS_CODE_INTERNAL_ERROR => 'Internal error'
    );

    /**
     * APNS server url
     *
     * @var string
     */
    //protected $apns_url = 'ssl://gateway.push.apple.com:2195'; //沙盒地址：ssl://gateway.sandbox.push.apple.com:2195
    protected $apns_url = 'ssl://gateway.sandbox.push.apple.com:2195';
    /**
     * 推送数据
     *
     * @var string
     */
    private $payload_json;

    /**
     * 数据流对象
     *
     * @var mixed
     */
    private $fp;

    /**
     * 设置APNS地址
     *
     * @param string $url
     */

    public function setApnsUrl($url)
    {
        if (empty($url)) {
            return false;
        } else {
            $this->apns_url = $url;
        }
        return true;
    }

    /**
     * 设置推送的消息
     *
     * @param string $body
     */
    public function setBody($body)
    {
        if (empty($body)) {
            return false;
        } else {
            $this->payload_json = json_encode($body);
        }
        return true;
    }

    /**
     * Open 打开APNS服务器连接
     *
     * @param string $pem 证书
     * @param string $passphrase 证书密钥
     */
    public function open($pem, $passphrase)
    {
        if (empty($pem)) {
            return false;
        }
        if (empty($passphrase)) {
            return false;
        }
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $pem);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $fp = stream_socket_client($this->apns_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) {
            return false;
        }
        $this->fp = $fp;
        return true;
    }

    /**
     * Send 推送
     *
     * @param string $token
     */
    public function send($token, $id)
    {
        $msg = pack('CNNnH*', 1, $id, 864000, 32, $token) . pack('n', strlen($this->payload_json)) . $this->payload_json;
// Send it to the server
        $result = fwrite($this->fp, $msg, strlen($msg));
        return $result;
    }

    public function readErrMsg()
    {
        $errInfo = @fread($this->fp, self::ERROR_RESPONSE_SIZE);
        if ($errInfo === false || strlen($errInfo) != self::ERROR_RESPONSE_SIZE) {
            return true;
        }
        $errInfo = $this->parseErrMsg($errInfo);
        if (!is_array($errInfo) || empty($errInfo)) {
            return true;
        }
        if (!isset($errInfo['command'], $errInfo['statusCode'], $errInfo['identifier'])) {
            return true;
        }
        if ($errInfo['command'] != self::ERROR_RESPONSE_COMMAND) {
            return true;
        }
        $errInfo['timeline'] = time();
        $errInfo['statusMessage'] = 'None (unknown)';
        $errInfo['errorIdentifier'] = $errInfo['identifier'];
        if (isset($this->_aErrorResponseMessages[$errInfo['statusCode']])) {
            $errInfo['statusMessage'] = $this->_errorResponseMessages[$errInfo['statusCode']];
        }
        return $errInfo;
    }

    protected function parseErrMsg($errorMessage)
    {
        return unpack('Ccommand/CstatusCode/Nidentifier', $errorMessage);
    }

    /**
     * Close APNS server 关闭APNS服务器连接
     *
     */
    public function close()
    {
        fclose($this->fp);
        return true;
    }

}

$push = new ApplePush();
$open = $push->open('ck.pem','8J8LcjgRwSyo');
if($open == false){
    echo $push->readErrMsg();
}
else{
    $push = $push->send('9b6a4f2c667f7aeccfc6409699b68031503b216a0489fb2afcccb9fdb29aedc4','new message');
    echo $push->readErrMsg();
}


?>