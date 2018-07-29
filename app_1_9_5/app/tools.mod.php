<?php

class ModuleObject extends AppObject
{
    function ModuleObject($config)
    {
        $this->AppObject($config);
        $this->Execute();
    }

    function Execute()
    {
        if ($this->Act == 'getCarModel') {
            $this->getCarModel();
        } else if ($this->Act == 'getTelCache') {
            $this->getTelCache();
        } else if ($this->Act == 'getStr') {
            $this->getStr();
        } else if ($this->Act == 'getMem') {
            $this->getMem();
        } else if ($this->Act == 'getSuburb') {
            $this->getSuburb();
        } else if ($this->Act == 'pushSingle') {
            $this->pushSingle();
        } else if ($this->Act == 'pushList') {
            $this->pushList();
        } else if ($this->Act == 'pushAll') {
            $this->pushAll();
        }
    }

    function index()
    {
        die('Error');
    }

    /**
     * 消息推送单推接口
     * create by chen
     * @return string
     */
    function pushSingletoo()
    {
        $push['template']           = 'transmission';
        $push['cid']                = $this->Post['cid'];
        $push['message']['title']   = $this->Post['title'];
        $push['message']['body']    = $this->Post['body'];
        $content['action']          = $this->Post['action'];
        $content['title']           = $this->Post['title'];
        $content['id']              = intval($this->Post['id']);
        $push['message']['content'] = json_encode($content);
        Load::functions('getui');
        $result         = pushMessageToSingle($push);
        $result['data'] = $push;
        $this->outjson($result);
    }

    function pushSingle()
    {
        Load::functions('getui');
        $push['template']           = "transmission";
        $push['message']['title']   = $this->Post['title'];
        $cont['action']             = $this->Post['action'];
        $cont['id']                 = $this->Post['id'];
        $cont['title']              = $this->Post['title'];
        $push['cid']                = $this->Post['cid'];
        $push['message']['content'] = json_encode($cont);
        $push['message']['body']    = $this->Post['body'];
        pushMessageToSingle($push);
    }


    /**
     * 消息推送多推接口
     * create by chen
     */
//    function pushList()
//    {
//        $push['template']           = $this->Post['template'];
//        $push['cidlist'][]          = $this->Post['cid'];
//        $push['message']['title']   = $this->Post['title'];
//        $push['message']['text']    = $this->Post['text'];
//        $push['message']['content'] = $this->Post['content'];
//        Load::functions('getui');
//        $result = pushMessageToList($push);
//        $this->outjson($result);
//    }

    /**
     * 消息群推接口
     * create by chen
     * @param $type 消息类型
     * 15=个人中心 14=我的消息 1=站内信 2=新闻消息 3=分类消息 4=论坛消息 5=系统消息  10=站内信列表
     */
    function pushAll()
    {
        $push['template']        = 'transmission';
        $push['message']['body'] = $this->Post['body'];
        $type                    = $this->Post['type'];
        $content['id']           = $this->Post['id'];
        $content['title']        = $this->Post['body'];
        if ($type == 11) {
            $push['message']['title']   = '亿忆论坛';
            $content['action']          = "category";
            $push['message']['content'] = json_encode($content);
        } else if ($type == 12) {
            $push['message']['title']   = '亿忆话题';
            $content['action']          = "topic";
            $push['message']['content'] = json_encode($content);
        } else if ($type == 13) {
            $push['message']['title']   = '亿忆新闻';
            $content['action']          = "news";
            $push['message']['content'] = json_encode($content);
        }
        Load::functions('getui');
        $res = pushMessageToApp($push);
        $this->outjson($res);

    }

    function getCarModel()
    {
        header("Content-type: application/json");
        $returnAry                   = array();
        $returnAry['value']          = array();
        $returnAry['child']          = array();
        $returnAry['child']['label'] = '车辆型号';
        $returnAry['child']['name']  = 'model';
        $returnAry['child']['value'] = array();
        $carMakeAry                  = $this->Db->fetch_all_assoc("select make from professional_car_model group by make");
        foreach ($carMakeAry as $make) {
            $tmp                  = array();
            $returnAry['value'][] = array($make['make'], $make['make']);
            $modelAry             = $this->Db->fetch_all_assoc("select model from  professional_car_model where make='" . $make['make'] . "'");
            foreach ($modelAry as $model) {
                if (strstr($model['model'], '(')) {
                    continue;
                }
                $tmp[] = array($model['model'], $model['model']);
            }
            $returnAry['child']['value'][] = $tmp;
        }
        $str = json_encode($returnAry);
        echo $str;
        exit;
    }

    function getTelCache()
    {
        $tel        = $this->Post['tel'];
        $keyCode    = 'sms_' . $tel;
        $successKey = 'sms_check_' . $tel;
        echo getVar($keyCode);
        echo "==========================";
        echo getVar($successKey);
    }

    function getStr()
    {
        $authcode = $this->Post['authcode'];
        echo authcode($authcode, 'DECODE');
    }

    function getMem()
    {
        $memKey = $this->Post['memKey'];
        echo getVar($memKey);
    }

    function getSuburb()
    {
        $suburb        = $this->Db->fetch_all_row("select suburb,suburb from api_common_city_suburb where city='NSW'");
        $return        = array();
        $return['NSW'] = $suburb;
        echo json_encode($return);
        exit;
    }

}