<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/2
 * Time: 7:20
 */
class ThreadView
{
    var $Db;
    var $Config;
    function __construct(){
        $this->Post = &$_POST;
        load::lib("Db");
        $this->Db = Mysql::newMysql();
        require(ROOT_PATH . VERSION.'config/config.php');
        $this->inPutCity = array2obj($config['inPutCity']);
        $this->forumList = $config['forumList'];
        $this->inputParam = $config['inputParam'];
        $this->param = $config['param']; //参数转换

    }


    /* 2017.05.17 edit by allen qu 新添加604,325 */

    //团购打折325
    function viewThread325($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_groupbuy where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['325'];
        $city  = $professionInfo['city'];
        $suburb  = $professionInfo['suburb'];
        $postcode  = $professionInfo['postcode'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];
        $message = $professionInfo['message'];
        $typeid  = $professionInfo['typeid'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $typeidStr = $paramAry['typeid'][$typeid];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb." ".$postcode);
        $s3[] = array('类型',$typeidStr);

        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    //宠物交易604
    function viewThread604($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_pet where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['604'];
        $city  = $professionInfo['city'];
        $suburb  = $professionInfo['suburb'];
        $postcode  = $professionInfo['postcode'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];
        $message = $professionInfo['message'];
        $typeid  = $professionInfo['typeid'];
        $ic      = $professionInfo['ic'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $typeidStr = $paramAry['typeid'][$typeid];
        $icStr = $paramAry['ic'][$ic];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb." ".$postcode);
        $s3[] = array('类型',$typeidStr);
        $s3[] = array('芯片', $icStr);

        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }


    //车版291
    function viewThread291($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_car_sale_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['291'];
        $city  = $professionInfo['city'];
        $suburb  = $professionInfo['suburb'];
        $postcode  = $professionInfo['postcode'];
        $carfrom = $professionInfo['carfrom'];
        $carmake  = $professionInfo['carmake'];
        $model = $professionInfo['model'];
        $bodytype = $professionInfo['bodytype'];
        $transmission = $professionInfo['transmission'];
        $kilometres = $professionInfo['kilometres'];
        $colour = $professionInfo['colour'];
        $drives = $professionInfo['drives'];
        $seats = $professionInfo['seats'];
        $doors = $professionInfo['doors'];
        $fueltype = $professionInfo['fueltype'];
        $displace = $professionInfo['displace'];

        $havemaintenance = $professionInfo['havemaintenance'];
        $marktime = $professionInfo['marktime'];
        $price = $professionInfo['price'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];
        $message = $professionInfo['message'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $carFromStr = $paramAry['carfrom'][$carfrom];
        $bodytypeStr = $paramAry['bodytype'][$bodytype];
        $transmissionStr = $paramAry['transmission'][$transmission];
        $colourStr = $paramAry['colour'][$colour];
        $drivesStr = $paramAry['drives'][$drives];
        $seatsStr = $paramAry['seats'][$seats];
        $doorsStr = $paramAry['doors'][$doors];
        $fueltypeStr = $paramAry['fueltype'][$fueltype];
        $havemaintenanceStr = $paramAry['havemaintenance'][$havemaintenance];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb." ".$postcode);
        $s3[] = array('来源',$carFromStr);
        $s3[] = array('品牌系列',$carmake." ".$model);
        $s3[] = array('车型', $bodytypeStr);
        $s3[] = array('变速箱',$transmissionStr);
        $s3[] = array('颜色',$colourStr);
        $s3[] = array('驱动',$drivesStr);
        $s3[] = array('燃油类型',$fueltypeStr);
        $s3[] = array('座位数',$seatsStr);
        $s3[] = array('门数',$doorsStr);
        $s3[] = array('排量',$displace."升");
        $s3[] = array('行驶里程',$kilometres.'公里');
        $s3[] = array('保养记录',$havemaintenanceStr);
        $s3[] = array('价格','$'.$price);
        $s3[] = array('首次上牌日期',date('Y-m-d',$marktime));
        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function getModify291($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_car_sale_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo['car_price'] = $professionInfo['price'];
        unset($professionInfo['car_id']);
        unset($professionInfo['tid']);
        unset($professionInfo['carpic']);
        unset($professionInfo['price']);
        foreach($professionInfo as $key=>$value){
            if($key == 'message'){
                //$value = preg_replace("/\[attach\].*\[\/attach\]/isU","",$value);
            }
            if($key == 'marktime'){
                $value = date("Y-m-d G:i:s",$value);
            }
            $return[$key] = $value;
        }
        return $return;
    }

    function viewThread715($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_car_sale_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['715'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $postcode = $professionInfo['postcode'];
        $carfrom = $professionInfo['carfrom'];
        $model = $professionInfo['model'];
        $carmake = $professionInfo['carmake'];
        $carprice = $professionInfo['carprice'];
        $carage = $professionInfo['carage'];
        $bodytype = $professionInfo['bodytype'];
        $kilometres = $professionInfo['kilometres'];
        $transmission = $professionInfo['transmission'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $carFromStr = $paramAry['carfrom'][$carfrom];
        $carPriceStr = $paramAry['carprice'][$carprice];
        $carageStr = $paramAry['carage'][$carage];
        $bodytypeStr = $paramAry['bodytype'][$bodytype];
        $kilometresStr = $paramAry['kilometres'][$kilometres];
        $transmissionStr = $paramAry['transmission'][$transmission];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb." ".$postcode);
        $s3[] = array('来源',$carFromStr);
        $s3[] = array('品牌系列',$carmake." ".$model);
        $s3[] = array('期望车型', $bodytypeStr);
        $s3[] = array('变速箱',$transmissionStr);
        $s3[] = array('行驶里程',$kilometresStr.'公里');
        $s3[] = array('期望价格',$carPriceStr);
        $s3[] = array('期望车龄',$carageStr);

        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread714($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_job_apply_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['714'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $postcode = $professionInfo['postcode'];
        $position = $professionInfo['position'];
        $salary_form = $professionInfo['salary_form'];
        $salary = $professionInfo['salary'];
        $ages = $professionInfo['ages'];
        $education = $professionInfo['education'];
        $property = $professionInfo['property'];
        $visa = $professionInfo['visa'];
        $worktime = $professionInfo['worktime'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['username'];
        $tel = $professionInfo['tels'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qqnum'];
        $email = $professionInfo['emails'];



        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $positionStr = $paramAry['position'][$position];
        $educationStr = $paramAry['education'][$education];
        $visaStr = $paramAry['visa'][$visa];
        $salary_formStr = $paramAry['salary_form'][$salary_form];
        $salaryStr = $paramAry['salary'][$salary];


        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb." ".$postcode);
        $s3[] = array('期望职位',$positionStr);
        $s3[] = array('期望薪资',$salary_formStr.' '.$salaryStr);
        $s3[] = array('年龄',$ages);
        $s3[] = array('最高学历',$educationStr);
        $s3[] = array('工作性质(可多选)',$property);
        $s3[] = array('签证状态',$visaStr);
        $s3[] = array('可工作时间',$worktime);


        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread161($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_job_fire_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['161'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $company = $professionInfo['company'];
        $position = $professionInfo['position'];
        $property = $professionInfo['property'];
        $visa = $professionInfo['visa'];
        $experience = $professionInfo['experience'];
        $education = $professionInfo['education'];
        $p_num = $professionInfo['p_num'];
        $salary_form = $professionInfo['salary_form'];
        $salary = $professionInfo['salary'];
        $annualleave = $professionInfo['annualleave'];
        $superannua = $professionInfo['superannua'];
        $message = $professionInfo['message'];
        //$poster = $professionInfo['poster'];
        //$tel = $professionInfo['tel'];
        /* edit by allen qu 2017.04.24  原来读取的字段不对  */
        $poster = $professionInfo['linkman'];
        $tel = $professionInfo['tels'];

        $weixin = $professionInfo['weixin'];

        /* 2017.06.14 edit by allen qu 原读取字段和数据库字段不符 */
        $qq = $professionInfo['qqnum'];
        $email = $professionInfo['emails'];





        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $positionStr = $paramAry['position'][$position];
        $experienceStr = $paramAry['experience'][$experience];
        $educationStr = $paramAry['education'][$education];
        $annualleaveStr = $paramAry['annualleave'][$annualleave];
        $superannuaStr = $paramAry['superannua'][$superannua];

        $salary_formStr = $paramAry['salary_form'][$salary_form];
        $salaryStr = $paramAry['salary'][$salary];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);
        $s3[] = array('公司名称',$company);
        $s3[] = array('招聘职位',$positionStr);
        $s3[] = array('工作性质',$property);
        $s3[] = array('签证状态',$visa);
        $s3[] = array('经验要求',$experienceStr);
        $s3[] = array('学历要求',$educationStr);
        $s3[] = array('招聘人数',$p_num);
        /* 2017.06.19 edit by allen qu 如果salary_form为0返回为空字符串 */
        $s3[] = array('工资待遇', $salary_form == 0 ?  '' : $salary_formStr.' '.$salaryStr);
        $s3[] = array('Annual leave',$annualleaveStr);
        $s3[] = array('Superannuation',$superannuaStr);


        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread142($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_for_rent where tid=".$tid);

        //pre_forum_thread
        $postTime = $this->Db->once_fetch_assoc("select lastpost from pre_forum_thread where tid=".$tid);

        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['142'];

        $city  = $professionInfo['city'];

        $validity = $professionInfo['validity'];
        $suburb = $professionInfo['suburb'];
        $address = $professionInfo['address'];

        $house_from = $professionInfo['house_from'];
        $iscity = $professionInfo['iscity'];
        $house_type = $professionInfo['house_type'];

        $house_room = $professionInfo['house_room'];
        $house_hall = $professionInfo['house_hall'];
        $house_toilet = $professionInfo['house_toilet'];
        $house_balcony = $professionInfo['house_balcony'];
        $house_ku = $professionInfo['house_ku'];

        $house_rents = $professionInfo['house_rents'];
        $rent_type = $professionInfo['rent_type'];
        $in_date = $professionInfo['in_date'];
        $house_sex = $professionInfo['house_sex'];
        $house_equipment = $professionInfo['house_equipment'];
        $bus_info = $professionInfo['bus_info'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];
        $dateline = $professionInfo['dateline'];






        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $validityStr = $paramAry['validity'][$validity];
        $house_fromStr = $paramAry['house_from'][$house_from];
        $iscityStr = $paramAry['iscity'][$iscity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $house_roomStr = $paramAry['house_room'][$house_room];
        $house_hallStr = $paramAry['house_hall'][$house_hall];
        $house_toiletStr = $paramAry['house_toilet'][$house_toilet];
        $house_balconyStr = $paramAry['house_balcony'][$house_balcony];
        /* 2017.06.12 edit by allen qu $house_ku有返回0的情况 */
        $house_kuStr = $house_ku == 0 ? $house_ku : $paramAry['house_ku'][$house_ku];
        $rent_typeStr = $paramAry['rent_type'][$rent_type];
        $house_sexStr = $paramAry['house_sex'][$house_sex];
        $house_equipment = unserialize($house_equipment);

        //$house_equipment
        $house_equipmentStr = '';
        $house_equipmentAryTmp = $paramAry['house_equipment'];
        if(is_array($house_equipment)){
            foreach($house_equipment as $v){
                $house_equipmentStr .= ' '.$house_equipmentAryTmp[$v];
            }
        }

        //$bus_info
        $bus_info = unserialize($bus_info);
        $bus_infoStr = '';
        $bus_infoAryTmp = $paramAry['bus_info'];
        if(is_array($bus_info)){
            foreach($bus_info as $v){
                $bus_infoStr .= ' '.$bus_infoAryTmp[$v];
            }
        }

        $house_equipmentStr = $house_equipmentStr;
        $bus_infoStr = $bus_infoStr;




        $s3 = array();
        $s3[] = array('更新时间',date('Y-m-d',$postTime['lastpost']));
        $s3[] = array('所在地区',$cityStr." ".$suburb);
        //$s3[] = array('有效期',$validityStr);
        //$s3[] = array('地址',$address);
        $s3[] = array('来源',$house_fromStr);
        $s3[] = array('房源是否在City',$iscityStr);
        $s3[] = array('类型',$house_typeStr);
        //$s3[] = array('室',$house_roomStr);
        //$s3[] = array('厅',$house_hallStr);
        //$s3[] = array('卫',$house_toiletStr);
        //$s3[] = array('阳台',$house_balconyStr);
        //$s3[] = array('车库',$house_kuStr);
        //$s3[] = array('租金',$house_rents);
        $s3[] = array('出租方式',$rent_typeStr);
        $s3[] = array('可入住时间',$in_date);
        $s3[] = array('性别要求',$house_sexStr);
        $s3[] = array('配套设施',$house_equipmentStr);
        $s3[] = array('周边设施',$bus_infoStr);

        $houseParam = array();
        $houseParam['house_rents'] = '$'.$professionInfo['house_rents'].'/week';
        $houseParam['address'] = $professionInfo['address'];
        $houseParam['house_room'] = $professionInfo['house_room'];
        $houseParam['house_hall'] = $professionInfo['house_hall'];
        $houseParam['house_toilet'] = $professionInfo['house_toilet'];
        $houseParam['house_balcony'] = $professionInfo['house_balcony'];

        /* 2017.05.27 edit by allen qu  house_ku值不对,特此更正*/
        $houseParam['house_ku'] = $professionInfo['house_ku'];
        $houseParam['house_ku'] = $house_kuStr;

        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        $return['houseParam'] = $houseParam;
        return $return;
    }

    function viewThread680($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_want_rent where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['680'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $validity = $professionInfo['validity'];
        $address = $professionInfo['address'];
        $rent_type = $professionInfo['rent_type'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $validityStr = $paramAry['validity'][$validity];
        $rent_typeStr = $paramAry['rent_type'][$rent_type];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);
        $s3[] = array('有效期|validity',$validityStr);
        $s3[] = array('地址',$address);
        $s3[] = array('求租方式',$rent_typeStr);




        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread305($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_for_sale where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['305'];

        $city  = $professionInfo['city'];
        $validity = $professionInfo['validity'];
        $description = $professionInfo['description'];
        $house_type = $professionInfo['house_type'];
        $suburb = $professionInfo['suburb'];
        $address = $professionInfo['address'];
        $iscity = $professionInfo['iscity'];
        $price = $professionInfo['price'];
        $showtime = $professionInfo['showtime'];
        $readyhouse = $professionInfo['readyhouse'];
        $house_room = $professionInfo['house_room'];
        $house_hall = $professionInfo['house_hall'];
        $house_toilet = $professionInfo['house_toilet'];
        $house_balcony = $professionInfo['house_balcony'];
        $house_ku = $professionInfo['house_ku'];
        $allowforeigner = $professionInfo['allowforeigner'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];



        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $validityStr = $paramAry['validity'][$validity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $iscityStr = $paramAry['iscity'][$iscity];
        $readyhouseStr = $paramAry['readyhouse'][$readyhouse];
        $house_roomStr = $paramAry['house_room'][$house_room];
        $house_hallStr = $paramAry['house_hall'][$house_hall];
        $house_toiletStr = $paramAry['house_toilet'][$house_toilet];
        $house_balconyStr = $paramAry['house_balcony'][$house_balcony];
        $house_kuStr = $paramAry['house_ku'][$house_ku];
        $allowforeignerStr = $paramAry['allowforeigner'][$allowforeigner];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);
        //$s3[] = array('有效期|validity',$validityStr);
        $s3[] = array('房屋特色',$description);
        $s3[] = array('房屋类型|House Type',$house_typeStr);
        //$s3[] = array('Suburb',$suburb);
        //$s3[] = array('地址|Address',$address);
        $s3[] = array('房源是否在City',$iscityStr);
        $s3[] = array('出售售价|Price',$price."万元");
        $s3[] = array('看房时间|Inspection',$showtime);
        $s3[] = array('现房/期房',$readyhouseStr);
        //$s3[] = array('室',$house_roomStr);
        //$s3[] = array('厅',$house_hallStr);
        //$s3[] = array('卫',$house_toiletStr);
        //$s3[] = array('阳台',$house_balconyStr);
        //$s3[] = array('车库',$house_kuStr);
        $s3[] = array('海外人士购买',mb_substr($allowforeignerStr, 0, 1, 'utf-8'));
        $houseParam = array();
        $houseParam['price'] = $professionInfo['price']."万元";
        $houseParam['address'] = $professionInfo['address'];
        $houseParam['house_room'] = $professionInfo['house_room'];
        $houseParam['house_hall'] = $professionInfo['house_hall'];
        $houseParam['house_toilet'] = $professionInfo['house_toilet'];
        $houseParam['house_balcony'] = $professionInfo['house_balcony'];

        /* 2017.05.27 edit by allen qu 车库数值不对, 特此更正 */
        $houseParam['house_ku'] = $house_kuStr;


        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        $return['houseParam'] = $houseParam;
        return $return;
    }

    function viewThread681($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_want_buy where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['681'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $validity = $professionInfo['validity'];
        $house_type = $professionInfo['house_type'];
        $house_position = $professionInfo['house_position'];
        $iscity = $professionInfo['iscity'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];

        $validityStr = $paramAry['validity'][$validity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $iscityStr = $paramAry['iscity'][$iscity];


        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);
        $s3[] = array('目标区域',$house_position);
        $s3[] = array('有效期|validity',$validityStr);
        $s3[] = array('求购类型',$house_typeStr);
        $s3[] = array('房源是否在City',$iscityStr);


        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread304($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_market where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['304'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $postcode = $professionInfo['postcode'];
        $typeid = $professionInfo['typeid'];
        $delivery = $professionInfo['delivery'];
        $fromtype = $professionInfo['fromtype'];
        $markettype = $professionInfo['markettype'];
        $price = $professionInfo['price'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];



        //转换字符串
        $cityStr = $this->inPutCity[$city];

        $typeidStr = $paramAry['typeid'][$typeid];
        $deliveryStr = $paramAry['delivery'][$delivery];
        $fromtypeStr = $paramAry['fromtype'][$fromtype];
        $markettypeStr = $paramAry['markettype'][$markettype];


        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);


        $s3[] = array('类别',$typeidStr);
        $s3[] = array('是否送货',$deliveryStr);
        $s3[] = array('来源',$fromtypeStr);
        $s3[] = array('需求',$markettypeStr);
        $s3[] = array('价格',$price);



        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread89($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_super_market where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['89'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $typeid = $professionInfo['typeid'];
        $price = $professionInfo['price'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];




        //转换字符串
        $cityStr = $this->inPutCity[$city];

        $typeidStr = $paramAry['typeid'][$typeid];



        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);


        $s3[] = array('类别',$typeidStr);
        $s3[] = array('价格',$price);




        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread716($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_business where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['716'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $hangye = $professionInfo['hangye'];
        $company_name = $professionInfo['company_name'];
        $company_address = $professionInfo['company_address'];
        $price = $professionInfo['price'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];

        //转换字符串
        $cityStr = $this->inPutCity[$city];

        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);

        $s3[] = array('行业类型',$hangye);
        $s3[] = array('行业类型',$company_name);
        $s3[] = array('公司地址',$company_address);
        $s3[] = array('价格',$price);

        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread679($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_book where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['679'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $school = $professionInfo['school'];
        $xuqiu = $professionInfo['xuqiu'];
        $typeid = $professionInfo['typeid'];
        $price = $professionInfo['price'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];


        //转换字符串
        $cityStr = $this->inPutCity[$city];

        $schoolStr = $paramAry['school'][$school];
        $xuqiuStr = $paramAry['xuqiu'][$xuqiu];
        $typeidStr = $paramAry['typeid'][$typeid];


        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);

        $s3[] = array('学校',$schoolStr);
        $s3[] = array('需求',$xuqiuStr);
        $s3[] = array('类型',$typeidStr);
        $s3[] = array('价格',$price);


        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }

    function viewThread651($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_service where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        $professionInfo = changeCode($professionInfo);
        $paramAry = $this->param['651'];

        $city  = $professionInfo['city'];
        $suburb = $professionInfo['suburb'];
        $typeid = $professionInfo['typeid'];
        $company_name = $professionInfo['company_name'];
        $company_address = $professionInfo['company_address'];
        $company_website = $professionInfo['company_website'];
        $company_info = $professionInfo['company_info'];
        $company_service = $professionInfo['company_service'];
        $company_area = $professionInfo['company_area'];
        $message = $professionInfo['message'];
        $poster = $professionInfo['poster'];
        $tel = $professionInfo['tel'];
        $weixin = $professionInfo['weixin'];
        $qq = $professionInfo['qq'];
        $email = $professionInfo['email'];



        //转换字符串
        $cityStr = $this->inPutCity[$city];

        $typeidStr = $paramAry['typeid'][$typeid];



        $s3 = array();
        $s3[] = array('所在地区',$cityStr." ".$suburb);

        $s3[] = array('服务分类',$typeidStr);
        $s3[] = array('公司名称',$company_name);
        $s3[] = array('公司地址',$company_address);
        $s3[] = array('公司网址',$company_website);
        $s3[] = array('公司简介',$company_info);
        $s3[] = array('服务项目',$company_service);
        $s3[] = array('服务区域',$company_area);



        $return['s3'] = $s3;
        $s4 = array();
        $s4['message'] = $message;
        $return['s4'] = $s4;
        $s5 = array();
        $s5[] = array('姓名',$poster);
        $s5[] = array('电话',$tel);
        $s5[] = array('微信',$weixin);
        $s5[] = array('QQ',$qq);
        $s5[] = array('邮箱',$email);
        $return['s5'] = $s5;
        return $return;
    }




    function getModify715($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_car_buy_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['car_id']);
        unset($professionInfo['tid']);
        unset($professionInfo['carpic']);



        foreach($professionInfo as $key=>$value){
            if($key == 'message'){
                //$value = preg_replace("/\[attach\].*\[\/attach\]/isU","",$value);
            }
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 个人求职
     */
    function getModify714($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_job_apply_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        $professionInfo['poster'] = $professionInfo['username'];
        $professionInfo['tel'] = $professionInfo['tels'];
        $professionInfo['qq'] = $professionInfo['qqnum'];
        $professionInfo['email'] = $professionInfo['emails'];

        unset($professionInfo['username']);
        unset($professionInfo['tels']);
        unset($professionInfo['qqnum']);
        unset($professionInfo['emails']);
        foreach($professionInfo as $key=>$value){
            $tmp = @unserialize($value);
            if(is_array($tmp)){
                $value = $tmp;
            }
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 岗位招聘
     */
    function getModify161($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from professional_job_fire_detail where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $tmp = @unserialize($value);
            if(is_array($tmp)){
                $value = $tmp;
            }
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 房屋租赁
     */
    function getModify142($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_for_rent where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        $professionInfo['bus_info'] = unserialize($professionInfo['bus_info']);
        $professionInfo['house_equipment'] = unserialize($professionInfo['house_equipment']);
        foreach($professionInfo as $key=>$value){
            $tmp = @unserialize($value);
            if(is_array($tmp)){
                $value = $tmp;
            }
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 房屋求租
     *
     */
    function getModify680($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_want_rent where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        $professionInfo['bus_info'] = unserialize($professionInfo['bus_info']);
        $professionInfo['house_equipment'] = unserialize($professionInfo['house_equipment']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 房屋出售
     */
    function getModify305($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_for_sale where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        $professionInfo['bus_info'] = unserialize($professionInfo['bus_info']);
        $professionInfo['house_equipment'] = unserialize($professionInfo['house_equipment']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 房屋求购
     */
    function getModify681($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_house_want_buy where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     *  //二手市场
     */
    function getModify304($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_market where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * //超级市场
     */
    function getModify89($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_super_market where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 生意买卖
     */
    function getModify716($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_business where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 二手教材
     */
    function getModify679($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_book where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 生活服务
     */
    function getModify651($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_service where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 团购打折
     */
    function getModify325($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_groupbuy where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }

    /**
     * @param $tid
     * @return array|bool
     * 宠物交易
     */
    function getModify604($tid){
        $return = array();
        $professionInfo = $this->Db->once_fetch_assoc("select * from pre_forum_field_pet where tid=".$tid);
        if(!isset($professionInfo['tid'])){
            return false;
        }
        unset($professionInfo['id']);
        foreach($professionInfo as $key=>$value){
            $return[$key] = $value;
        }
        return $return;
    }
}