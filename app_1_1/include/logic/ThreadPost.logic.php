<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/2
 * Time: 7:20
 */
class ThreadPost
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
    //车版291
    function post291(){
        $paramAry = $this->param['291'];
        $city = intval($this->Post['city']);
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $subject = $this->Post['subject'];
        $carfrom = $this->Post['carfrom'];
        $carmake = $this->Post['carmake'];
        $model = $this->Post['model'];
        $bodytype = $this->Post['bodytype'];
        $transmission = $this->Post['transmission'];
        $colour = $this->Post['colour'];
        $drives = $this->Post['drives'];
        $seats = $this->Post['seats'];
        $doors = $this->Post['doors'];
        $fueltype = $this->Post['fueltype'];
        $displace = $this->Post['displace'];
        $kilometres = $this->Post['kilometres'];
        $havemaintenance = $this->Post['havemaintenance'];
        $marktime = $this->Post['marktime'];
        $price = $this->Post['car_price'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        $message = $this->Post['message'];
        $nomalMessage = stripslashes($message);
        $dateline = time();

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


        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>车辆信息</caption>';
        $tmp .='<tr><td class="tit">所在地区:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">来源:</td><td class="con2">'.$carFromStr.'</td></tr>';
        $tmp .='<tr><td class="tit">品牌系列:</td><td class="con">'.$carmake." ".$model.'</td><td class="tit">车型:</td><td class="con2">'.$bodytypeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">变速箱:</td><td class="con">'.$transmissionStr.'</td><td class="tit">颜色:</td><td class="con2">'.$colourStr.'</td></tr>';
        $tmp .='<tr><td class="tit">驱动:</td><td class="con2">'.$drivesStr.'</td><td class="tit">座位数:</td><td class="con">'.$seatsStr.'座</td></tr>';
        $tmp .='<tr><td class="tit">门数:</td><td class="con2">'.$doorsStr.'</td><td class="tit">燃油类型:</td><td class="con">'. $fueltypeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">排量:</td><td class="con2">'.$displace.'升</td><td class="tit">行驶里程:</td><td class="con">'.$kilometres.'公里</td></tr>';
        $tmp .='<tr><td class="tit">保养记录:</td><td class="con">'.$havemaintenanceStr.'</td><td class="tit">价格:</td><td class="con2">$'.$price.'</td></tr>';
        $tmp .='<tr><td class="tit" colspan="4">首次上牌日期:<span style="font-weight: normal;">'.$marktime.'</span></td></tr>';
        $tmp .='<tr><td colspan="4" style="height: 28px;background: #E5EDF2;margin-left:20px;">&nbsp;</td></tr>';
        $tmp .='<tr><td class="tit">联系人:</td><td class="con">'.$poster.'</td><td class="tit">电话:</td><td class="con2">'.$tel.'</td></tr>';
        $tmp .='<tr><td class="tit">微信:</td><td class="con">'.$weixin.'</td><td class="tit">QQ:</td><td class="con2">'.$qq.'</td></tr>';
        $tmp .='<tr><td class="tit">邮箱:</td><td colspan="3" class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";
        $fid = 291;

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];
        $carpic = $postThreadInfo['pic'];

        //写入专项数据库
        list($marktime,$tt) = explode(" ",$marktime);
        list($myear,$mmonth,$mday) = explode("-",$marktime);
        $marktime = mktime(0,0,0,$mmonth,$mday,$myear);
        //编码转换
        $city = changeCode($city,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $carfrom = changeCode($carfrom,'utf-8','gb2312');
        $carmake = changeCode($carmake,'utf-8','gb2312');
        $model = changeCode($model,'utf-8','gb2312');
        $bodytype = changeCode($bodytype,'utf-8','gb2312');
        $transmission = changeCode($transmission,'utf-8','gb2312');
        $colour = changeCode($colour,'utf-8','gb2312');
        $drives = changeCode($drives,'utf-8','gb2312');
        $seats = changeCode($seats,'utf-8','gb2312');
        $doors = changeCode($doors,'utf-8','gb2312');
        $fueltype = changeCode($fueltype,'utf-8','gb2312');
        $displace = changeCode($displace,'utf-8','gb2312');
        $kilometres = changeCode($kilometres,'utf-8','gb2312');
        $havemaintenance = changeCode($havemaintenance,'utf-8','gb2312');
        $marktime = changeCode($marktime,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');


        $sql = "insert into professional_car_sale_detail(tid,city,suburb,postcode,carfrom,carmake,model,bodytype,transmission,colour,kilometres,drives,seats,doors,fueltype,displace,marktime,price,tel,weixin,qq,email,carpic,message,havemaintenance,poster) values('".$tid."','".$city."','".$suburb."','".$postcode."','".$carfrom."','".$carmake."','".$model."','".$bodytype."','".$transmission."','".$colour."','".$kilometres."','".$drives."','".$seats."','".$doors."','".$fueltype."','".$displace."','".$marktime."','".$price."','".$tel."','".$weixin."','".$qq."','".$email."','".$carpic."','".$message."','".$havemaintenance."','".$poster."')";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    /*
     * 车辆求购
     * */
    function post715(){
        $fid = 715;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $carfrom = $this->Post['carfrom'];
        $model = $this->Post['model'];
        $carmake = $this->Post['carmake'];
        $carprice = $this->Post['carprice'];
        $carage = $this->Post['carage'];
        $bodytype = $this->Post['bodytype'];
        $kilometres = $this->Post['kilometres'];
        $transmission = $this->Post['transmission'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        //必备
        $paramAry = $this->param['715'];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $carFromStr = $paramAry['carfrom'][$carfrom];
        $carPriceStr = $paramAry['carprice'][$carprice];
        $carageStr = $paramAry['carage'][$carage];
        $bodytypeStr = $paramAry['bodytype'][$bodytype];
        $kilometresStr = $paramAry['kilometres'][$kilometres];
        $transmissionStr = $paramAry['transmission'][$transmission];


        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>二手车求购</caption>';
        $tmp .='<tr><td class="tit">所在地区:</td><td class="con">'.$cityStr." ".$suburb.' '.$postcode.'</td><td class="tit">车辆来源:</td><td class="con2">'.$carFromStr.'</td></tr>';
        $tmp .='<tr><td class="tit">品牌系列:</td><td class="con">'.$carmake." ".$model.'</td><td class="tit">期望车型:</td><td class="con2">'.$bodytypeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">期望价格:</td><td class="con">'.$carPriceStr.'</td><td class="tit">期望车龄:</td><td class="con2">'.$carageStr.'</td></tr>';
        $tmp .='<tr><td class="tit">里程:</td><td class="con">'.$kilometresStr.'</td><td class="tit">变速箱:</td><td class="con2">'.$transmissionStr.'</td></tr>';
        $tmp .='<tr><td class="tit">联系人:</td><td class="con">'.$poster.'</td><td class="tit">电话:</td><td class="con2">'.$tel.'</td></tr>';
        $tmp .='<tr><td class="tit">微信:</td><td class="con">'.$weixin.'</td><td class="tit">QQ:</td><td class="con2">'.$qq.'</td></tr>';
        $tmp .='<tr><td class="tit">邮箱:</td><td colspan=3 class="con">'.$email.'</td></tr>';
        $tmp .='</table></div>';
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];
        $carpic = $postThreadInfo['pic'];

        //写入专项数据库

        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $carfrom = changeCode($carfrom,'utf-8','gb2312');
        $model = changeCode($model,'utf-8','gb2312');
        $carmake = changeCode($carmake,'utf-8','gb2312');
        $carprice = changeCode($carprice,'utf-8','gb2312');
        $carage = changeCode($carage,'utf-8','gb2312');
        $bodytype = changeCode($bodytype,'utf-8','gb2312');
        $kilometres = changeCode($kilometres,'utf-8','gb2312');
        $transmission = changeCode($transmission,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into professional_car_buy_detail(tid,city,suburb,postcode,carfrom,carmake,model,transmission,carage,kilometres,carprice,tel,weixin,qq,email,message,poster,bodytype) values('".$tid."','".$city."','".$suburb."','".$postcode."','".$carfrom."','".$carmake."','".$model."','".$transmission."','".$carage."','".$kilometres."','".$carprice."','".$tel."','".$weixin."','".$qq."','".$email."','".$message."','".$poster."','".$bodytype."')";

        $result = $this->Db->query($sql);
        return $postThreadInfo;

    }


    /**
     * 个人求职
     */
    function post714(){
        $fid = 714;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $position = $this->Post['position'];
        $salary_form = $this->Post['salary_form'];
        $salary = $this->Post['salary'];
        $ages = $this->Post['ages'];
        $education = $this->Post['education'];
        $property = $this->Post['property'];
        $visa = $this->Post['visa'];
        $worktime = $this->Post['worktime'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        //必备
        $paramAry = $this->param['714'];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();


        //转换字符串
        $cityStr = $this->inPutCity[$city];
        $positionStr = $paramAry['position'][$position];
        $salary_formStr = $paramAry['salary_form'][$salary_form];
        $salaryStr = $paramAry['salary'][$salary];
        $educationStr = $paramAry['education'][$education];
        $visaStr = $paramAry['visa'][$visa];



        //旧版发帖
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>求职信息</caption>';
        $tmp .='<tr><td class="tit">城市:</td><td class="con">'.$cityStr." ".$suburb.' '.$postcode.'</td><td class="tit">姓名:</td><td class="con2">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">最高学历:</td><td class="con">'.$educationStr.'</td><td class="tit">年龄:</td><td class="con2">'.$ages.'</td></tr>';
        $tmp .='<tr><td class="tit">工作性质:</td><td class="con">'.$property.'</td><td class="tit">签证状态:</td><td class="con2">'.$visaStr.'</td></tr>';
        $tmp .='<tr><td class="tit">期望职位:</td><td class="con">'.$positionStr.'</td><td class="tit">具体职位:</td><td class="con2">&nbsp;</td></tr>';
        $tmp .='<tr><td class="tit">期望薪资:</td><td class="con">'.$salary_formStr."/".$salaryStr.'</td><td class="tit">联系电话:</td><td class="con2">'.$tel.'</td></tr>';
        $tmp .='<tr><td class="tit">可工作时间:</td><td class="con">'.$worktime.'</td><td class="tit">微信:</td><td class="con2">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con">'.$qq.'</td><td class="tit">邮箱:</td><td class="con2">'.$email.'</td></tr>';
        $tmp .='</table></div>';
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];
        $carpic = $postThreadInfo['pic'];


        //写入专项数据库
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $position = changeCode($position,'utf-8','gb2312');
        $salary_form = changeCode($salary_form,'utf-8','gb2312');
        $salary = changeCode($salary,'utf-8','gb2312');
        $ages = changeCode($ages,'utf-8','gb2312');
        $education = changeCode($education,'utf-8','gb2312');
        $property = changeCode($property,'utf-8','gb2312');
        $visa = changeCode($visa,'utf-8','gb2312');
        $worktime = changeCode($worktime,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into professional_job_apply_detail(tid,city,suburb,postcode,ages,salary_form,property,visa,`position`,po_specific,salary,username,education,worktime,tels,weixin,qqnum,emails,message) values('".$tid."','".$city."','".$suburb."','".$postcode."','".$ages."','".$salary_form."','".$property."','".$visa."','".$position."','','".$salary."','".$poster."','".$education."','".$worktime."','".$tel."','".$weixin."','".$qq."','".$email."','".$message."')";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update714(){
        $paramAry = $this->param['714'];
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $position = $this->Post['position'];
        $salary_form = $this->Post['salary_form'];
        $salary = $this->Post['salary'];
        $ages = $this->Post['ages'];
        $education = $this->Post['education'];
        $property = $this->Post['property'];
        $visa = $this->Post['visa'];
        $worktime = $this->Post['worktime'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        //单独处理
        $nomalMessage = stripslashes($message);
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);
        //转换
        $cityInfo = $this->Db->once_fetch_assoc("select city from professional_job_apply_detail where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];
        $positionStr = $paramAry['position'][$position];
        $salary_formStr = $paramAry['salary_form'][$salary_form];
        $salaryStr = $paramAry['salary'][$salary];
        $educationStr = $paramAry['education'][$education];
        $visaStr = $paramAry['visa'][$visa];

        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>求职信息</caption>';
        $tmp .='<tr><td class="tit">城市:</td><td class="con">'.$cityStr." ".$suburb.' '.$postcode.'</td><td class="tit">姓名:</td><td class="con2">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">最高学历:</td><td class="con">'.$educationStr.'</td><td class="tit">年龄:</td><td class="con2">'.$ages.'</td></tr>';
        $tmp .='<tr><td class="tit">工作性质:</td><td class="con">'.$property.'</td><td class="tit">签证状态:</td><td class="con2">'.$visaStr.'</td></tr>';
        $tmp .='<tr><td class="tit">期望职位:</td><td class="con">'.$positionStr.'</td><td class="tit">具体职位:</td><td class="con2">&nbsp;</td></tr>';
        $tmp .='<tr><td class="tit">期望薪资:</td><td class="con">'.$salary_formStr."/".$salaryStr.'</td><td class="tit">联系电话:</td><td class="con2">'.$tel.'</td></tr>';
        $tmp .='<tr><td class="tit">可工作时间:</td><td class="con">'.$worktime.'</td><td class="tit">微信:</td><td class="con2">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con">'.$qq.'</td><td class="tit">邮箱:</td><td class="con2">'.$email.'</td></tr>';
        $tmp .='</table></div>';
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        //写入专项数据库
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $position = changeCode($position,'utf-8','gb2312');
        $salary_form = changeCode($salary_form,'utf-8','gb2312');
        $salary = changeCode($salary,'utf-8','gb2312');
        $ages = changeCode($ages,'utf-8','gb2312');
        $education = changeCode($education,'utf-8','gb2312');
        $property = changeCode($property,'utf-8','gb2312');
        $visa = changeCode($visa,'utf-8','gb2312');
        $worktime = changeCode($worktime,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update professional_job_apply_detail set city='".$city."',suburb='".$suburb."',postcode='".$postcode."',ages='".$ages."',salary_form='".$salary_form."',property='".$property."',visa='".$visa."',position='".$position."',salary='".$salary."',username='".$poster."',education='".$education."',worktime='".$worktime."',tels='".$tel."',weixin='".$weixin."',qqnum='".$qq."',emails='".$email."',message='".$message."'  where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    /**
     * 岗位招聘
     */
    function post161(){
        $fid = 161;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $company = $this->Post['company'];
        $position = $this->Post['position'];
        $property = $this->Post['property'];
        $visa = $this->Post['visa'];
        $experience = $this->Post['experience'];
        $education = $this->Post['education'];
        $p_num = $this->Post['p_num'];
        $salary_form = $this->Post['salary_form'];
        $salary = $this->Post['salary'];
        $annualleave = $this->Post['annualleave'];
        $superannua = $this->Post['superannua'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        //必备
        $paramAry = $this->param['161'];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $positionStr = $paramAry['position'][$position];
        $experienceStr = $paramAry['experience'][$experience];
        $educationStr = $paramAry['education'][$education];
        $salary_formStr = $paramAry['salary_form'][$salary_form];
        $salaryStr = $paramAry['salary'][$salary];
        $annualleaveStr = $paramAry['annualleave'][$annualleave];
        $superannuaStr = $paramAry['superannua'][$superannua];

        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>招聘信息</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.' '.$postcode.'</td><td class="tit">具体职位:</td><td class="con2">'.$positionStr.'</td></tr>';
        $tmp .='<tr><td class="tit">公司名称:</td><td class="con">'.$company.'</td><td class="tit">工作性质:</td><td class="con2">'.$property.'</td></tr>';
        $tmp .='<tr><td class="tit">签证状态:</td><td class="con">'.$visa.'</td><td class="tit">经验要求:</td><td class="con2">'.$experience.'</td></tr>';
        $tmp .='<tr><td class="tit">学历要求:</td><td class="con2">'.$educationStr.'</td><td class="tit">招聘人数:</td><td class="con">'.$p_num.'人</td></tr>';
        $tmp .='<tr><td class="tit">Superannuation:</td><td class="con2">'.$superannua.'</td><td class="tit">Annual leave:</td><td class="con">'.$annualleave.'</td></tr>';
        $tmp .='<tr><td class="tit">工资待遇:</td><td class="con2">'.$salary_formStr.'/'.$salaryStr.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];



        //写入专项数据库
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $company = changeCode($company,'utf-8','gb2312');
        $position = changeCode($position,'utf-8','gb2312');
        $property = changeCode($property,'utf-8','gb2312');
        $visa = changeCode($visa,'utf-8','gb2312');
        $experience = changeCode($experience,'utf-8','gb2312');
        $education = changeCode($education,'utf-8','gb2312');
        $p_num = changeCode($p_num,'utf-8','gb2312');
        $salary_form = changeCode($salary_form,'utf-8','gb2312');
        $salary = changeCode($salary,'utf-8','gb2312');
        $annualleave = changeCode($annualleave,'utf-8','gb2312');
        $superannua = changeCode($superannua,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into professional_job_fire_detail(tid,city,suburb,postcode,company,position,po_specific,property,visa,experience,education,salary_form,salary,annualleave,superannua,p_num,linkman,tels,weixin,qqnum,emails,message) values('".$tid."','".$city."','".$suburb."','".$postcode."','".$company."','".$position."','','".$property."','".$visa."','".$experience."','".$education."','".$salary_form."','".$salary."','".$annualleave."','".$superannua."','".$p_num."','".$poster."','".$tel."','".$weixin."','".$qq."','".$email."','".$message."')";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update161(){
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $company = $this->Post['company'];
        $position = $this->Post['position'];
        $property = $this->Post['property'];
        $visa = $this->Post['visa'];
        $experience = $this->Post['experience'];
        $education = $this->Post['education'];
        $p_num = $this->Post['p_num'];
        $salary_form = $this->Post['salary_form'];
        $salary = $this->Post['salary'];
        $annualleave = $this->Post['annualleave'];
        $superannua = $this->Post['superannua'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        //单独处理
        $nomalMessage = stripslashes($message);
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);
        //转换
        $cityInfo = $this->Db->once_fetch_assoc("select city from professional_job_fire_detail where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];

        //必备
        $paramAry = $this->param['161'];
        $nomalMessage = stripslashes($message);

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $positionStr = $paramAry['position'][$position];
        $experienceStr = $paramAry['experience'][$experience];
        $educationStr = $paramAry['education'][$education];
        $salary_formStr = $paramAry['salary_form'][$salary_form];
        $salaryStr = $paramAry['salary'][$salary];
        $annualleaveStr = $paramAry['annualleave'][$annualleave];
        $superannuaStr = $paramAry['superannua'][$superannua];

        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>招聘信息</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.' '.$postcode.'</td><td class="tit">具体职位:</td><td class="con2">'.$positionStr.'</td></tr>';
        $tmp .='<tr><td class="tit">公司名称:</td><td class="con">'.$company.'</td><td class="tit">工作性质:</td><td class="con2">'.$property.'</td></tr>';
        $tmp .='<tr><td class="tit">签证状态:</td><td class="con">'.$visa.'</td><td class="tit">经验要求:</td><td class="con2">'.$experience.'</td></tr>';
        $tmp .='<tr><td class="tit">学历要求:</td><td class="con2">'.$educationStr.'</td><td class="tit">招聘人数:</td><td class="con">'.$p_num.'人</td></tr>';
        $tmp .='<tr><td class="tit">Superannuation:</td><td class="con2">'.$superannua.'</td><td class="tit">Annual leave:</td><td class="con">'.$annualleave.'</td></tr>';
        $tmp .='<tr><td class="tit">工资待遇:</td><td class="con2">'.$salary_formStr.'/'.$salaryStr.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        //写入专项数据库
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $company = changeCode($company,'utf-8','gb2312');
        $position = changeCode($position,'utf-8','gb2312');
        $property = changeCode($property,'utf-8','gb2312');
        $visa = changeCode($visa,'utf-8','gb2312');
        $experience = changeCode($experience,'utf-8','gb2312');
        $education = changeCode($education,'utf-8','gb2312');
        $p_num = changeCode($p_num,'utf-8','gb2312');
        $salary_form = changeCode($salary_form,'utf-8','gb2312');
        $salary = changeCode($salary,'utf-8','gb2312');
        $annualleave = changeCode($annualleave,'utf-8','gb2312');
        $superannua = changeCode($superannua,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update professional_job_fire_detail set city='".$city."',suburb='".$suburb."',postcode='".$postcode."',company='".$company."',position='".$position."',po_specific='',property='".$property."',visa='".$visa."',experience='".$experience."',education='".$education."',salary_form='".$salary_form."',salary='".$salary."',annualleave='".$annualleave."',superannua='".$superannua."',p_num='".$p_num."',linkman='".$poster."',tels='".$tel."',qqnum='".$qq."',emails='".$email."',weixin='".$weixin."',message='".$message."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    /**
     * 142//房屋租赁
     */
    function post142(){
        $fid = 142;
        $subject = $this->Post['subject'];
        $validity = $this->Post['validity'];
        $suburb = $this->Post['suburb'];
        $address = $this->Post['address'];
        $house_from = $this->Post['house_from'];
        $iscity = $this->Post['iscity'];
        $house_type = $this->Post['house_type'];
        $house_room = $this->Post['house_room'];
        $house_hall = $this->Post['house_hall'];
        $house_toilet = $this->Post['house_toilet'];
        $house_balcony = $this->Post['house_balcony'];
        $house_ku = $this->Post['house_ku'];
        $house_rents = $this->Post['house_rents'];
        $rent_type = $this->Post['rent_type'];
        $in_date = $this->Post['in_date'];
        $house_sex = $this->Post['house_sex'];
        $house_equipment = $this->Post['house_equipment'];
        $bus_info = $this->Post['bus_info'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        //必备
        $paramAry = $this->param[$fid];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $validityStr = $paramAry['validity'][$validity];
        $house_fromStr = $paramAry['house_from'][$house_from];
        $iscityStr = $paramAry['iscity'][$iscity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $house_roomStr = $paramAry['house_room'][$house_room];
        $house_hallStr = $paramAry['house_hall'][$house_hall];
        $house_toiletStr = $paramAry['house_toilet'][$house_toilet];
        $house_balconyStr = $paramAry['house_balcony'][$house_balcony];
        $house_kuStr = $paramAry['house_ku'][$house_ku];
        $rent_typeStr = $paramAry['rent_type'][$rent_type];
        $house_sexStr = $paramAry['house_sex'][$house_sex];

        //$house_equipment
        $house_equipmentStr = '';
        $house_equipmentAryTmp = $paramAry['house_equipment'];
        if(is_array($house_equipment)){
            foreach($house_equipment as $v){
                $house_equipmentStr .= ' '.$house_equipmentAryTmp[$v];
            }
        }

        //$bus_info
        $bus_infoStr = '';
        $bus_infoAryTmp = $paramAry['bus_info'];
        if(is_array($bus_info)){
            foreach($bus_info as $v){
                $bus_infoStr .= ' '.$bus_infoAryTmp[$v];
            }
        }

        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋租赁</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">地址:</td><td class="con">'.$address.'</td><td class="tit">来源:</td><td class="con2">'.$house_fromStr.'</td></tr>';
        $tmp .='<tr><td class="tit">是否在City:</td><td class="con">'.$iscityStr.'</td><td class="tit">类型:</td><td class="con2">'.$house_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">配置:</td><td class="con2">'.$house_roomStr.'室'.$house_hallStr.'厅'.$house_toiletStr.'卫'.$house_balconyStr.'阳台'.$house_kuStr.'车库</td><td class="tit">租金:</td><td class="con">'.$house_rents.'人</td></tr>';
        $tmp .='<tr><td class="tit">出租方式:</td><td class="con2">'.$rent_typeStr.'</td><td class="tit">Annual 可入住时间:</td><td class="con">'.$in_date.'</td></tr>';
        $tmp .='<tr><td class="tit">性别要求:</td><td class="con2">'.$house_sexStr.'</td><td class="tit">配套设施:</td><td class="con">'.$house_equipmentStr.'</td></tr>';
        $tmp .='<tr><td class="tit">周边配套:</td><td class="con2">'.$bus_infoStr.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $address = changeCode($address,'utf-8','gb2312');
        $house_from = changeCode($house_from,'utf-8','gb2312');
        $iscity = changeCode($iscity,'utf-8','gb2312');
        $house_type = changeCode($house_type,'utf-8','gb2312');
        $house_room = changeCode($house_room,'utf-8','gb2312');
        $house_hall = changeCode($house_hall,'utf-8','gb2312');
        $house_toilet = changeCode($house_toilet,'utf-8','gb2312');
        $house_balcony = changeCode($house_balcony,'utf-8','gb2312');
        $house_ku = changeCode($house_ku,'utf-8','gb2312');
        $house_rents = changeCode($house_rents,'utf-8','gb2312');
        $rent_type = changeCode($rent_type,'utf-8','gb2312');
        $in_date = changeCode($in_date,'utf-8','gb2312');
        $house_sex = changeCode($house_sex,'utf-8','gb2312');
        $house_equipment = changeCode($house_equipment,'utf-8','gb2312');
        $bus_info = changeCode($bus_info,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into pre_forum_field_house_for_rent set city='".$city."',tid='".$tid."', validity='".$validity."', suburb='".$suburb."', address='".$address."', house_from='".$house_from."', iscity='".$iscity."', house_type='".$house_type."', house_room='".$house_room."', house_hall='".$house_hall."', house_toilet='".$house_toilet."', house_balcony='".$house_balcony."', house_ku='".$house_ku."', house_rents='".$house_rents."', rent_type='".$rent_type."', in_date='".$in_date."', house_sex='".$house_sex."', house_equipment='".addslashes(serialize($house_equipment))."', bus_info='".addslashes(serialize($bus_info))."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }


    function update142(){
        $fid = 142;
        $paramAry = $this->param[$fid];
        $subject = $this->Post['subject'];
        $validity = $this->Post['validity'];
        $suburb = $this->Post['suburb'];
        $address = $this->Post['address'];
        $house_from = $this->Post['house_from'];
        $iscity = $this->Post['iscity'];
        $house_type = $this->Post['house_type'];
        $house_room = $this->Post['house_room'];
        $house_hall = $this->Post['house_hall'];
        $house_toilet = $this->Post['house_toilet'];
        $house_balcony = $this->Post['house_balcony'];
        $house_ku = $this->Post['house_ku'];
        $house_rents = $this->Post['house_rents'];
        $rent_type = $this->Post['rent_type'];
        $in_date = $this->Post['in_date'];
        $house_sex = $this->Post['house_sex'];
        $house_equipment = $this->Post['house_equipment'];
        $bus_info = $this->Post['bus_info'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        //修改需要加的
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        //必备
        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_house_for_rent where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $validityStr = $paramAry['validity'][$validity];
        $house_fromStr = $paramAry['house_from'][$house_from];
        $iscityStr = $paramAry['iscity'][$iscity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $house_roomStr = $paramAry['house_room'][$house_room];
        $house_hallStr = $paramAry['house_hall'][$house_hall];
        $house_toiletStr = $paramAry['house_toilet'][$house_toilet];
        $house_balconyStr = $paramAry['house_balcony'][$house_balcony];
        $house_kuStr = $paramAry['house_ku'][$house_ku];
        $rent_typeStr = $paramAry['rent_type'][$rent_type];
        $house_sexStr = $paramAry['house_sex'][$house_sex];

        //$house_equipment
        $house_equipmentStr = '';
        $house_equipmentAryTmp = $paramAry['house_equipment'];
        if(is_array($house_equipment)){
            foreach($house_equipment as $v){
                $house_equipmentStr .= ' '.$house_equipmentAryTmp[$v];
            }
        }

        //$bus_info
        $bus_infoStr = '';
        $bus_infoAryTmp = $paramAry['bus_info'];
        if(is_array($bus_info)){
            foreach($bus_info as $v){
                $bus_infoStr .= ' '.$bus_infoAryTmp[$v];
            }
        }




        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋租赁</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">地址:</td><td class="con">'.$address.'</td><td class="tit">来源:</td><td class="con2">'.$house_fromStr.'</td></tr>';
        $tmp .='<tr><td class="tit">是否在City:</td><td class="con">'.$iscityStr.'</td><td class="tit">类型:</td><td class="con2">'.$house_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">配置:</td><td class="con2">'.$house_roomStr.'室'.$house_hallStr.'厅'.$house_toiletStr.'卫'.$house_balconyStr.'阳台'.$house_kuStr.'车库</td><td class="tit">租金:</td><td class="con">'.$house_rents.'人</td></tr>';
        $tmp .='<tr><td class="tit">出租方式:</td><td class="con2">'.$rent_typeStr.'</td><td class="tit">Annual 可入住时间:</td><td class="con">'.$in_date.'</td></tr>';
        $tmp .='<tr><td class="tit">性别要求:</td><td class="con2">'.$house_sexStr.'</td><td class="tit">配套设施:</td><td class="con">'.$house_equipmentStr.'</td></tr>';
        $tmp .='<tr><td class="tit">周边配套:</td><td class="con2">'.$bus_infoStr.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        //修改
        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        $subject = changeCode($subject,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $address = changeCode($address,'utf-8','gb2312');
        $house_from = changeCode($house_from,'utf-8','gb2312');
        $iscity = changeCode($iscity,'utf-8','gb2312');
        $house_type = changeCode($house_type,'utf-8','gb2312');
        $house_room = changeCode($house_room,'utf-8','gb2312');
        $house_hall = changeCode($house_hall,'utf-8','gb2312');
        $house_toilet = changeCode($house_toilet,'utf-8','gb2312');
        $house_balcony = changeCode($house_balcony,'utf-8','gb2312');
        $house_ku = changeCode($house_ku,'utf-8','gb2312');
        $house_rents = changeCode($house_rents,'utf-8','gb2312');
        $rent_type = changeCode($rent_type,'utf-8','gb2312');
        $in_date = changeCode($in_date,'utf-8','gb2312');
        $house_sex = changeCode($house_sex,'utf-8','gb2312');
        $house_equipment = changeCode($house_equipment,'utf-8','gb2312');
        $bus_info = changeCode($bus_info,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_house_for_rent set city='".$city."',  validity='".$validity."', suburb='".$suburb."', address='".$address."', house_from='".$house_from."', iscity='".$iscity."', house_type='".$house_type."', house_room='".$house_room."', house_hall='".$house_hall."', house_toilet='".$house_toilet."', house_balcony='".$house_balcony."', house_ku='".$house_ku."', house_rents='".$house_rents."', rent_type='".$rent_type."', in_date='".$in_date."', house_sex='".$house_sex."', house_equipment='".addslashes(serialize($house_equipment))."', bus_info='".addslashes(serialize($bus_info))."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    /**
     * 房屋求租
     */
    function post680(){
        $fid = 680;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $validity = $this->Post['validity'];
        $address = $this->Post['address'];
        $rent_type = $this->Post['rent_type'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];



        //必备
        $paramAry = $this->param[$fid];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $validityStr = $paramAry['validity'][$validity];
        $rent_typeStr = $paramAry['rent_type'][$rent_type];

        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋求租</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">地址:</td><td class="con">'.$address.'</td><td class="tit">求租方式:</td><td class="con2">'.$rent_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">&nbsp;</td><td class="con2">&nbsp;</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $address = changeCode($address,'utf-8','gb2312');
        $rent_type = changeCode($rent_type,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into pre_forum_field_house_want_rent set city='".$city."',tid='".$tid."', suburb='".$suburb."', validity='".$validity."', address='".$address."', rent_type='".$rent_type."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update680(){
        $fid = 680;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $validity = $this->Post['validity'];
        $address = $this->Post['address'];
        $rent_type = $this->Post['rent_type'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_house_want_rent where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        $validityStr = $paramAry['validity'][$validity];
        $rent_typeStr = $paramAry['rent_type'][$rent_type];

        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋求租</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">地址:</td><td class="con">'.$address.'</td><td class="tit">求租方式:</td><td class="con2">'.$rent_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">&nbsp;</td><td class="con2">&nbsp;</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $address = changeCode($address,'utf-8','gb2312');
        $rent_type = changeCode($rent_type,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_house_want_rent set city='".$city."', suburb='".$suburb."', validity='".$validity."', address='".$address."', rent_type='".$rent_type."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    //房屋出售
    function post305(){
        $fid = 305;
        $subject = $this->Post['subject'];
        $validity = $this->Post['validity'];
        $description = $this->Post['description'];
        $house_type = $this->Post['house_type'];
        $suburb = $this->Post['suburb'];
        $address = $this->Post['address'];
        $iscity = $this->Post['iscity'];
        $price = $this->Post['price'];
        $showtime = $this->Post['showtime'];
        $readyhouse = $this->Post['readyhouse'];
        $house_room = $this->Post['house_room'];
        $house_hall = $this->Post['house_hall'];
        $house_toilet = $this->Post['house_toilet'];
        $house_balcony = $this->Post['house_balcony'];
        $house_ku = $this->Post['house_ku'];
        $allowforeigner = $this->Post['allowforeigner'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];


        //必备
        $paramAry = $this->param[$fid];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
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


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋出售</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">地址:</td><td class="con">'.$address.'</td><td class="tit">是否在City:</td><td class="con2">'.$iscityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">房屋特色:</td><td colspan="3">'.$description.'</td></tr>';
        $tmp .='<tr><td class="tit">出售价格:</td><td class="con">'.$price.'</td><td class="tit">类型:</td><td class="con2">'.$house_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">配置:</td><td class="con2">'.$house_roomStr.'室'.$house_hallStr.'厅'.$house_toiletStr.'卫'.$house_balconyStr.'阳台'.$house_kuStr.'车库</td><td class="tit">看房时间:</td><td class="con">'.$showtime.'人</td></tr>';
        $tmp .='<tr><td class="tit">是否现房:</td><td class="con2">'.$readyhouseStr.'</td><td class="tit">海外人士购买:</td><td class="con">'.$allowforeignerStr.'</td></tr>';
        $tmp .='<tr><td class="tit">&nbsp;</td><td class="con2">&nbsp;</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $description = changeCode($description,'utf-8','gb2312');
        $house_type = changeCode($house_type,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $address = changeCode($address,'utf-8','gb2312');
        $iscity = changeCode($iscity,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $showtime = changeCode($showtime,'utf-8','gb2312');
        $readyhouse = changeCode($readyhouse,'utf-8','gb2312');
        $house_room = changeCode($house_room,'utf-8','gb2312');
        $house_hall = changeCode($house_hall,'utf-8','gb2312');
        $house_toilet = changeCode($house_toilet,'utf-8','gb2312');
        $house_balcony = changeCode($house_balcony,'utf-8','gb2312');
        $house_ku = changeCode($house_ku,'utf-8','gb2312');
        $allowforeigner = changeCode($allowforeigner,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into pre_forum_field_house_for_sale set city='".$city."',tid='".$tid."', validity='".$validity."', description='".$description."', house_type='".$house_type."', suburb='".$suburb."', address='".$address."', iscity='".$iscity."', price='".$price."', showtime='".$showtime."', readyhouse='".$readyhouse."', house_room='".$house_room."', house_hall='".$house_hall."', house_toilet='".$house_toilet."', house_balcony='".$house_balcony."', house_ku='".$house_ku."', allowforeigner='".$allowforeigner."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;

    }


    function update305(){
        $fid = 305;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);
        $subject = $this->Post['subject'];
        $validity = $this->Post['validity'];
        $description = $this->Post['description'];
        $house_type = $this->Post['house_type'];
        $suburb = $this->Post['suburb'];
        $address = $this->Post['address'];
        $iscity = $this->Post['iscity'];
        $price = $this->Post['price'];
        $showtime = $this->Post['showtime'];
        $readyhouse = $this->Post['readyhouse'];
        $house_room = $this->Post['house_room'];
        $house_hall = $this->Post['house_hall'];
        $house_toilet = $this->Post['house_toilet'];
        $house_balcony = $this->Post['house_balcony'];
        $house_ku = $this->Post['house_ku'];
        $allowforeigner = $this->Post['allowforeigner'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];


        //必备
        $paramAry = $this->param[$fid];
        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_house_for_sale where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
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


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋出售</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">地址:</td><td class="con">'.$address.'</td><td class="tit">是否在City:</td><td class="con2">'.$iscityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">房屋特色:</td><td colspan="3">'.$description.'</td></tr>';
        $tmp .='<tr><td class="tit">出售价格:</td><td class="con">'.$price.'</td><td class="tit">类型:</td><td class="con2">'.$house_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">配置:</td><td class="con2">'.$house_roomStr.'室'.$house_hallStr.'厅'.$house_toiletStr.'卫'.$house_balconyStr.'阳台'.$house_kuStr.'车库</td><td class="tit">看房时间:</td><td class="con">'.$showtime.'人</td></tr>';
        $tmp .='<tr><td class="tit">是否现房:</td><td class="con2">'.$readyhouseStr.'</td><td class="tit">海外人士购买:</td><td class="con">'.$allowforeignerStr.'</td></tr>';
        $tmp .='<tr><td class="tit">&nbsp;</td><td class="con2">&nbsp;</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $description = changeCode($description,'utf-8','gb2312');
        $house_type = changeCode($house_type,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $address = changeCode($address,'utf-8','gb2312');
        $iscity = changeCode($iscity,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $showtime = changeCode($showtime,'utf-8','gb2312');
        $readyhouse = changeCode($readyhouse,'utf-8','gb2312');
        $house_room = changeCode($house_room,'utf-8','gb2312');
        $house_hall = changeCode($house_hall,'utf-8','gb2312');
        $house_toilet = changeCode($house_toilet,'utf-8','gb2312');
        $house_balcony = changeCode($house_balcony,'utf-8','gb2312');
        $house_ku = changeCode($house_ku,'utf-8','gb2312');
        $allowforeigner = changeCode($allowforeigner,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_house_for_sale set city='".$city."', validity='".$validity."', description='".$description."', house_type='".$house_type."', suburb='".$suburb."', address='".$address."', iscity='".$iscity."', price='".$price."', showtime='".$showtime."', readyhouse='".$readyhouse."', house_room='".$house_room."', house_hall='".$house_hall."', house_toilet='".$house_toilet."', house_balcony='".$house_balcony."', house_ku='".$house_ku."', allowforeigner='".$allowforeigner."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }


    //房屋求购
    function post681(){
        $fid = 681;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $validity = $this->Post['validity'];
        $house_position = $this->Post['house_position'];
        $house_type = $this->Post['house_type'];
        $iscity = $this->Post['iscity'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];




        //必备
        $paramAry = $this->param[$fid];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $validityStr = $paramAry['validity'][$validity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $iscityStr = $paramAry['iscity'][$iscity];


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋求购</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr.' '.$cityStr.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">是否City:</td><td class="con">'.$iscityStr.'</td><td class="tit">房屋类型:</td><td class="con2">'.$house_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">目标区域</td><td class="con2">'.$house_position.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $house_type = changeCode($house_type,'utf-8','gb2312');
        $iscity = changeCode($iscity,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');
        $house_position = changeCode($house_position,'utf-8','gb2312');



        $sql = "insert into pre_forum_field_house_want_buy set city='".$city."',suburb='".$suburb."',tid='".$tid."',  validity='".$validity."', house_position='".$house_position."',house_type='".$house_type."', iscity='".$iscity."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update681(){
        $fid = 681;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $validity = $this->Post['validity'];
        $house_type = $this->Post['house_type'];
        $iscity = $this->Post['iscity'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        $house_position = $this->Post['house_position'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_house_want_buy where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        $validityStr = $paramAry['validity'][$validity];
        $house_typeStr = $paramAry['house_type'][$house_type];
        $iscityStr = $paramAry['iscity'][$iscity];

        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>房屋求购</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr.' '.$cityStr.'</td><td class="tit">有效期:</td><td class="con2">'.$validityStr.'</td></tr>';
        $tmp .='<tr><td class="tit">是否City:</td><td class="con">'.$iscityStr.'</td><td class="tit">房屋类型:</td><td class="con2">'.$house_typeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">目标区域</td><td class="con2">'.$house_position.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        $subject = changeCode($subject,'utf-8','gb2312');
        $validity = changeCode($validity,'utf-8','gb2312');
        $house_type = changeCode($house_type,'utf-8','gb2312');
        $iscity = changeCode($iscity,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');

        $sql = "update pre_forum_field_house_want_buy set city='".$city."',suburb='".$suburb."', validity='".$validity."', house_position='".$house_position."', house_type='".$house_type."', iscity='".$iscity."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    //二手市场
    function post304(){
        $fid = 304;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $typeid = $this->Post['typeid'];
        $delivery = $this->Post['delivery'];
        $fromtype = $this->Post['fromtype'];
        $markettype = $this->Post['markettype'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];


        //必备
        $paramAry = $this->param[$fid];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $typeidStr = $paramAry['typeid'][$typeid];
        $deliveryStr = $paramAry['delivery'][$delivery];
        $fromtypeStr = $paramAry['fromtype'][$fromtype];
        $markettypeStr = $paramAry['markettype'][$markettype];



        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>二手市场</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">求购/出售:</td><td class="con">'.$markettypeStr.'</td><td class="tit">送货:</td><td class="con2">'.$deliveryStr.'</td></tr>';
        $tmp .='<tr><td class="tit">来源</td><td class="con2">'.$fromtypeStr.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $delivery = changeCode($delivery,'utf-8','gb2312');
        $fromtype = changeCode($fromtype,'utf-8','gb2312');
        $markettype = changeCode($markettype,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');


        $sql = "insert into pre_forum_field_market set city='".$city."',tid='".$tid."',  suburb='".$suburb."', postcode='".$postcode."', typeid='".$typeid."', delivery='".$delivery."', fromtype='".$fromtype."', markettype='".$markettype."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update304(){
        $fid = 304;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $typeid = $this->Post['typeid'];
        $delivery = $this->Post['delivery'];
        $fromtype = $this->Post['fromtype'];
        $markettype = $this->Post['markettype'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_market where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        $typeidStr = $paramAry['typeid'][$typeid];
        $deliveryStr = $paramAry['delivery'][$delivery];
        $fromtypeStr = $paramAry['fromtype'][$fromtype];
        $markettypeStr = $paramAry['markettype'][$markettype];

        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>二手市场</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">求购/出售:</td><td class="con">'.$markettypeStr.'</td><td class="tit">送货:</td><td class="con2">'.$deliveryStr.'</td></tr>';
        $tmp .='<tr><td class="tit">来源</td><td class="con2">'.$fromtypeStr.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $delivery = changeCode($delivery,'utf-8','gb2312');
        $fromtype = changeCode($fromtype,'utf-8','gb2312');
        $markettype = changeCode($markettype,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_market set city='".$city."', suburb='".$suburb."', postcode='".$postcode."', typeid='".$typeid."', delivery='".$delivery."', fromtype='".$fromtype."', markettype='".$markettype."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    //超级市场
    function post89(){
        $fid = 89;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $typeid = $this->Post['typeid'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        //必备
        $paramAry = $this->param[$fid];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $typeidStr = $paramAry['typeid'][$typeid];



        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>超级市场</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">价格</td><td class="con2">'.$price.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');



        $sql = "insert into pre_forum_field_super_market set city='".$city."',tid='".$tid."',  suburb='".$suburb."', typeid='".$typeid."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update89(){
        $fid = 89;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $typeid = $this->Post['typeid'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_super_market where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        $typeidStr = $paramAry['typeid'][$typeid];

        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>超级市场</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">价格</td><td class="con2">'.$price.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_super_market set city='".$city."', suburb='".$suburb."', typeid='".$typeid."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    //生意买卖
    function post716(){
        $fid = 716;
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $hangye = $this->Post['hangye'];
        $company_name = $this->Post['company_name'];
        $company_address = $this->Post['company_address'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];


        //必备
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>生意买卖</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">所属行业:</td><td class="con2">'.$hangye.'</td></tr>';
        $tmp .='<tr><td class="tit">公司名称:</td><td class="con">'.$company_name.'</td><td class="tit">公司地址:</td><td class="con2">'.$company_address.'</td></tr>';
        $tmp .='<tr><td class="tit">价格</td><td class="con2">'.$price.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $hangye = changeCode($hangye,'utf-8','gb2312');
        $company_name = changeCode($company_name,'utf-8','gb2312');
        $company_address = changeCode($company_address,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into pre_forum_field_business set city='".$city."',tid='".$tid."',  suburb='".$suburb."', hangye='".$hangye."', company_name='".$company_name."', company_address='".$company_address."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update716(){
        $fid = 716;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $hangye = $this->Post['hangye'];
        $company_name = $this->Post['company_name'];
        $company_address = $this->Post['company_address'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_business where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>生意买卖</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">所属行业:</td><td class="con2">'.$hangye.'</td></tr>';
        $tmp .='<tr><td class="tit">公司名称:</td><td class="con">'.$company_name.'</td><td class="tit">公司地址:</td><td class="con2">'.$company_address.'</td></tr>';
        $tmp .='<tr><td class="tit">价格</td><td class="con2">'.$price.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $hangye = changeCode($hangye,'utf-8','gb2312');
        $company_name = changeCode($company_name,'utf-8','gb2312');
        $company_address = changeCode($company_address,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_business set city='".$city."', suburb='".$suburb."', hangye='".$hangye."', company_name='".$company_name."', company_address='".$company_address."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    //二手教材
    function post679(){
        $fid = 679;
        $paramAry = $this->param[$fid];
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $school = $this->Post['school'];
        $xuqiu = $this->Post['xuqiu'];
        $typeid = $this->Post['typeid'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];


        //必备
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $schoolStr = $paramAry['school'][$school];
        $xuqiuStr = $paramAry['xuqiu'][$xuqiu];
        $typeidStr = $paramAry['typeid'][$typeid];



        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>二手教材</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">学校:</td><td class="con2">'.$schoolStr.'</td></tr>';
        $tmp .='<tr><td class="tit">出售/求购:</td><td class="con">'.$xuqiuStr.'</td><td class="tit">类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">价格</td><td class="con2">'.$price.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $school = changeCode($school,'utf-8','gb2312');
        $xuqiu = changeCode($xuqiu,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into pre_forum_field_book set city='".$city."',tid='".$tid."',  suburb='".$suburb."', school='".$school."', xuqiu='".$xuqiu."', typeid='".$typeid."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update679(){
        $fid = 679;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $school = $this->Post['school'];
        $xuqiu = $this->Post['xuqiu'];
        $typeid = $this->Post['typeid'];
        $price = $this->Post['price'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_book where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        $schoolStr = $paramAry['school'][$school];
        $xuqiuStr = $paramAry['xuqiu'][$xuqiu];
        $typeidStr = $paramAry['typeid'][$typeid];


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>二手教材</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">学校:</td><td class="con2">'.$schoolStr.'</td></tr>';
        $tmp .='<tr><td class="tit">出售/求购:</td><td class="con">'.$xuqiuStr.'</td><td class="tit">类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">价格</td><td class="con2">'.$price.'</td><td class="tit">联系人:</td><td class="con">'.$poster.'</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $school = changeCode($school,'utf-8','gb2312');
        $xuqiu = changeCode($xuqiu,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_book set city='".$city."', suburb='".$suburb."', school='".$school."', xuqiu='".$xuqiu."', typeid='".$typeid."', price='".$price."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    //二手教材
    function post651(){
        $fid = 651;
        $paramAry = $this->param[$fid];
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $typeid = $this->Post['typeid'];
        $company_name = $this->Post['company_name'];
        $company_address = $this->Post['company_address'];
        $company_website = $this->Post['company_website'];
        $company_info = $this->Post['company_info'];
        $company_service = $this->Post['company_service'];
        $company_area = $this->Post['company_area'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];


        //必备
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $dateline = time();

        //下来转换
        $cityStr = $this->inPutCity[$city];
        $typeidStr = $paramAry['typeid'][$typeid];




        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>生活服务</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">服务类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">公司名字:</td><td class="con">'.$company_name.'</td><td class="tit">公司地址:</td><td class="con2">'.$company_address.'</td></tr>';
        $tmp .='<tr><td class="tit">公司网站:</td><td class="con2">'.$company_website.'</td><td class="tit">公司介绍:</td><td class="con">'.$company_info.'</td></tr>';
        $tmp .='<tr><td class="tit">服务内容:</td><td class="con2">'.$company_service.'</td><td class="tit">服务区域:</td><td class="con">'.$company_area.'</td></tr>';
        $tmp .='<tr><td class="tit">联系人:</td><td class="con2">'.$poster.'</td><td class="tit">&nbsp;</td><td class="con">&nbsp;</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->postThread($fid,$subject,$tmp,$dateline,0);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $tid = $postThreadInfo['tid'];
        $pid = $postThreadInfo['pid'];

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $company_name = changeCode($company_name,'utf-8','gb2312');
        $company_address = changeCode($company_address,'utf-8','gb2312');
        $company_website = changeCode($company_website,'utf-8','gb2312');
        $company_info = changeCode($company_info,'utf-8','gb2312');
        $company_service = changeCode($company_service,'utf-8','gb2312');
        $company_area = changeCode($company_area,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');


        $sql = "insert into pre_forum_field_service set city='".$city."',tid='".$tid."',  suburb='".$suburb."', typeid='".$typeid."', company_name='".$company_name."', company_address='".$company_address."', company_website='".$company_website."', company_info='".$company_info."', company_service='".$company_service."', company_area='".$company_area."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."'";
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update651(){
        $fid = 651;
        $paramAry = $this->param[$fid];
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $typeid = $this->Post['typeid'];
        $company_name = $this->Post['company_name'];
        $company_address = $this->Post['company_address'];
        $company_website = $this->Post['company_website'];
        $company_info = $this->Post['company_info'];
        $company_service = $this->Post['company_service'];
        $company_area = $this->Post['company_area'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];

        $cityInfo = $this->Db->once_fetch_assoc("select city from pre_forum_field_service where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];

        $nomalMessage = stripslashes($message);
        $dateline = time();

        $typeidStr = $paramAry['typeid'][$typeid];


        //构建内容
        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>生活服务</caption>';
        $tmp .='<tr><td class="tit">所在城市:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">服务类别:</td><td class="con2">'.$typeidStr.'</td></tr>';
        $tmp .='<tr><td class="tit">公司名字:</td><td class="con">'.$company_name.'</td><td class="tit">公司地址:</td><td class="con2">'.$company_address.'</td></tr>';
        $tmp .='<tr><td class="tit">公司网站:</td><td class="con2">'.$company_website.'</td><td class="tit">公司介绍:</td><td class="con">'.$company_info.'</td></tr>';
        $tmp .='<tr><td class="tit">服务内容:</td><td class="con2">'.$company_service.'</td><td class="tit">服务区域:</td><td class="con">'.$company_area.'</td></tr>';
        $tmp .='<tr><td class="tit">联系人:</td><td class="con2">'.$poster.'</td><td class="tit">&nbsp;</td><td class="con">&nbsp;</td></tr>';
        $tmp .='<tr><td class="tit">电话:</td><td class="con2">'.$tel.'</td><td class="tit">微信:</td><td class="con">'.$weixin.'</td></tr>';
        $tmp .='<tr><td class="tit">QQ:</td><td class="con2">'.$qq.'</td><td class="tit">邮箱:</td><td class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }

        //写入专门的
        $subject = changeCode($subject,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $typeid = changeCode($typeid,'utf-8','gb2312');
        $company_name = changeCode($company_name,'utf-8','gb2312');
        $company_address = changeCode($company_address,'utf-8','gb2312');
        $company_website = changeCode($company_website,'utf-8','gb2312');
        $company_info = changeCode($company_info,'utf-8','gb2312');
        $company_service = changeCode($company_service,'utf-8','gb2312');
        $company_area = changeCode($company_area,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "update pre_forum_field_service set city='".$city."', suburb='".$suburb."', typeid='".$typeid."', company_name='".$company_name."', company_address='".$company_address."', company_website='".$company_website."', company_info='".$company_info."', company_service='".$company_service."', company_area='".$company_area."', message='".$message."', poster='".$poster."', tel='".$tel."', weixin='".$weixin."', qq='".$qq."', email='".$email."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update291(){
        $paramAry = $this->param['291'];
       // $city = intval($this->Post['city']);
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $subject = $this->Post['subject'];
        $carfrom = $this->Post['carfrom'];
        $carmake = $this->Post['carmake'];
        $model = $this->Post['model'];
        $bodytype = $this->Post['bodytype'];
        $transmission = $this->Post['transmission'];
        $colour = $this->Post['colour'];
        $drives = $this->Post['drives'];
        $seats = $this->Post['seats'];
        $doors = $this->Post['doors'];
        $fueltype = $this->Post['fueltype'];
        $displace = $this->Post['displace'];
        $kilometres = $this->Post['kilometres'];
        $havemaintenance = $this->Post['havemaintenance'];
        $marktime = $this->Post['marktime'];
        $price = $this->Post['car_price'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        $message = $this->Post['message'];
        $nomalMessage = stripslashes($message);
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        //转换字符串
        $cityInfo = $this->Db->once_fetch_assoc("select city from professional_car_sale_detail where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];
        $carFromStr = $paramAry['carfrom'][$carfrom];
        $bodytypeStr = $paramAry['bodytypefrom'][$bodytype];
        $transmissionStr = $paramAry['transmission'][$transmission];
        $colourStr = $paramAry['colour'][$colour];
        $drivesStr = $paramAry['drives'][$drives];
        $seatsStr = $paramAry['seats'][$seats];
        $doorsStr = $paramAry['doors'][$doors];
        $fueltypeStr = $paramAry['fueltype'][$fueltype];
        $havemaintenanceStr = $paramAry['havemaintenance'][$havemaintenance];


        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>车辆信息</caption>';
        $tmp .='<tr><td class="tit">所在地区:</td><td class="con">'.$cityStr." ".$suburb.'</td><td class="tit">来源:</td><td class="con2">'.$carFromStr.'</td></tr>';
        $tmp .='<tr><td class="tit">品牌系列:</td><td class="con">'.$carmake." ".$model.'</td><td class="tit">车型:</td><td class="con2">'.$bodytypeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">变速箱:</td><td class="con">'.$transmissionStr.'</td><td class="tit">颜色:</td><td class="con2">'.$colourStr.'</td></tr>';
        $tmp .='<tr><td class="tit">驱动:</td><td class="con2">'.$drivesStr.'</td><td class="tit">座位数:</td><td class="con">'.$seatsStr.'座</td></tr>';
        $tmp .='<tr><td class="tit">门数:</td><td class="con2">'.$doorsStr.'</td><td class="tit">燃油类型:</td><td class="con">'. $fueltypeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">排量:</td><td class="con2">'.$displace.'升</td><td class="tit">行驶里程:</td><td class="con">'.$kilometres.'公里</td></tr>';
        $tmp .='<tr><td class="tit">保养记录:</td><td class="con">'.$havemaintenanceStr.'</td><td class="tit">价格:</td><td class="con2">$'.$price.'</td></tr>';
        $tmp .='<tr><td class="tit" colspan="4">首次上牌日期:<span style="font-weight: normal;">'.$marktime.'</span></td></tr>';
        $tmp .='<tr><td colspan="4" style="height: 28px;background: #E5EDF2;margin-left:20px;">&nbsp;</td></tr>';
        $tmp .='<tr><td class="tit">联系人:</td><td class="con">'.$poster.'</td><td class="tit">电话:</td><td class="con2">'.$tel.'</td></tr>';
        $tmp .='<tr><td class="tit">微信:</td><td class="con">'.$weixin.'</td><td class="tit">QQ:</td><td class="con2">'.$qq.'</td></tr>';
        $tmp .='<tr><td class="tit">邮箱:</td><td colspan="3" class="con">'.$email.'</td></tr>';
        $tmp .="</table></div>";
        $tmp .="<p>".$nomalMessage."</p>";
        $fid = 291;
        //变更板块
        if($city == 2){
            $fid = 653;
        }
        else if($city == 1){
            if($carfrom == 1){
                $fid = 635;
            }
            else if($carfrom == 2){
                $fid = 634;
            }
            else if($carfrom == 3){
                $fid = 633;
            }
            else{
                $fid = 635;
            }
        }
        else{
            $fid = 660;
        }

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $carpic = $postThreadInfo['pic'];

        //写入专项数据库
        list($marktime,$tt) = explode(" ",$marktime);
        list($myear,$mmonth,$mday) = explode("-",$marktime);
        $marktime = mktime(0,0,0,$mmonth,$mday,$myear);
        //编码转换
        $city = changeCode($city,'utf-8','gb2312');
        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $carfrom = changeCode($carfrom,'utf-8','gb2312');
        $carmake = changeCode($carmake,'utf-8','gb2312');
        $model = changeCode($model,'utf-8','gb2312');
        $bodytype = changeCode($bodytype,'utf-8','gb2312');
        $transmission = changeCode($transmission,'utf-8','gb2312');
        $colour = changeCode($colour,'utf-8','gb2312');
        $drives = changeCode($drives,'utf-8','gb2312');
        $seats = changeCode($seats,'utf-8','gb2312');
        $doors = changeCode($doors,'utf-8','gb2312');
        $fueltype = changeCode($fueltype,'utf-8','gb2312');
        $displace = changeCode($displace,'utf-8','gb2312');
        $kilometres = changeCode($kilometres,'utf-8','gb2312');
        $havemaintenance = changeCode($havemaintenance,'utf-8','gb2312');
        $marktime = changeCode($marktime,'utf-8','gb2312');
        $price = changeCode($price,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');


        //$sql = "insert into professional_car_sale_detail(tid,city,suburb,postcode,carfrom,carmake,model,bodytype,transmission,colour,kilometres,drives,seats,doors,fueltype,displace,marktime,price,tel,weixin,qq,email,carpic,message,havemaintenance,poster) values('".$tid."','".$city."','".$suburb."','".$postcode."','".$carfrom."','".$carmake."','".$model."','".$bodytype."','".$transmission."','".$colour."','".$kilometres."','".$drives."','".$seats."','".$doors."','".$fueltype."','".$displace."','".$marktime."','".$price."','".$tel."','".$weixin."','".$qq."','".$email."','".$carpic."','".$message."','".$havemaintenance."','".$poster."')";
        $sql = "update professional_car_sale_detail set city='".$city."',suburb='".$suburb."',postcode='".$postcode."',carfrom='".$carfrom."',carmake='".$carmake."',model='".$model."',bodytype='".$bodytype."',transmission='".$transmission."',colour='".$colour."',kilometres='".$kilometres."',drives='".$drives."',seats='".$seats."',doors='".$doors."',fueltype='".$fueltype."',displace='".$displace."',marktime='".$marktime."',price='".$price."',tel='".$tel."',weixin='".$weixin."',qq='".$qq."',email='".$email."',carpic='".$carpic."',message='".$message."', havemaintenance='".$havemaintenance."', poster='".$poster."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }

    function update715(){
        $subject = $this->Post['subject'];
        $suburb = $this->Post['suburb'];
        $postcode = $this->Post['postcode'];
        $carfrom = $this->Post['carfrom'];
        $model = $this->Post['model'];
        $carmake = $this->Post['carmake'];
        $carprice = $this->Post['carprice'];
        $carage = $this->Post['carage'];
        $bodytype = $this->Post['bodytype'];
        $kilometres = $this->Post['kilometres'];
        $transmission = $this->Post['transmission'];
        $message = $this->Post['message'];
        $poster = $this->Post['poster'];
        $tel = $this->Post['tel'];
        $weixin = $this->Post['weixin'];
        $qq = $this->Post['qq'];
        $email = $this->Post['email'];
        //必备
        $paramAry = $this->param['715'];
        $city = intval($this->Post['city']);
        $nomalMessage = stripslashes($message);
        $tid = intval($this->Post['tid']);
        $pid = intval($this->Post['pid']);

        //转换字符串
        //$cityStr = $this->inPutCity[$city];
        $cityInfo = $this->Db->once_fetch_assoc("select city from professional_car_buy_detail where tid=".$tid);//城市不能修改
        $city = $cityInfo['city'];
        $cityStr = $this->inPutCity[$city];
        $carFromStr = $paramAry['carfrom'][$carfrom];
        $carPriceStr = $paramAry['carprice'][$carprice];
        $carageStr = $paramAry['carage'][$carage];
        $bodytypeStr = $paramAry['bodytype'][$bodytype];
        $kilometresStr = $paramAry['kilometres'][$kilometres];
        $transmissionStr = $paramAry['transmission'][$transmission];


        $tmp = '<div class="carmessage"><table cellspacing="0" class="carcontent">';
        $tmp .= '<caption>二手车求购</caption>';
        $tmp .='<tr><td class="tit">所在地区:</td><td class="con">'.$cityStr." ".$suburb.' '.$postcode.'</td><td class="tit">车辆来源:</td><td class="con2">'.$carFromStr.'</td></tr>';
        $tmp .='<tr><td class="tit">品牌系列:</td><td class="con">'.$carmake." ".$model.'</td><td class="tit">期望车型:</td><td class="con2">'.$bodytypeStr.'</td></tr>';
        $tmp .='<tr><td class="tit">期望价格:</td><td class="con">'.$carPriceStr.'</td><td class="tit">期望车龄:</td><td class="con2">'.$carageStr.'</td></tr>';
        $tmp .='<tr><td class="tit">里程:</td><td class="con">'.$kilometresStr.'</td><td class="tit">变速箱:</td><td class="con2">'.$transmissionStr.'</td></tr>';
        $tmp .='<tr><td class="tit">联系人:</td><td class="con">'.$poster.'</td><td class="tit">电话:</td><td class="con2">'.$tel.'</td></tr>';
        $tmp .='<tr><td class="tit">微信:</td><td class="con">'.$weixin.'</td><td class="tit">QQ:</td><td class="con2">'.$qq.'</td></tr>';
        $tmp .='<tr><td class="tit">邮箱:</td><td colspan=3 class="con">'.$email.'</td></tr>';
        $tmp .='</table></div>';
        $tmp .="<p>".$nomalMessage."</p>";

        $postThreadInfo = $this->updateThread($tid,$pid,$subject,$tmp);
        if($postThreadInfo['status'] == 5400){
            return $postThreadInfo;
        }
        $carpic = $postThreadInfo['pic'];

        //写入专项数据库

        $suburb = changeCode($suburb,'utf-8','gb2312');
        $postcode = changeCode($postcode,'utf-8','gb2312');
        $carfrom = changeCode($carfrom,'utf-8','gb2312');
        $model = changeCode($model,'utf-8','gb2312');
        $carmake = changeCode($carmake,'utf-8','gb2312');
        $carprice = changeCode($carprice,'utf-8','gb2312');
        $carage = changeCode($carage,'utf-8','gb2312');
        $bodytype = changeCode($bodytype,'utf-8','gb2312');
        $kilometres = changeCode($kilometres,'utf-8','gb2312');
        $transmission = changeCode($transmission,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');
        $poster = changeCode($poster,'utf-8','gb2312');
        $tel = changeCode($tel,'utf-8','gb2312');
        $weixin = changeCode($weixin,'utf-8','gb2312');
        $qq = changeCode($qq,'utf-8','gb2312');
        $email = changeCode($email,'utf-8','gb2312');

        $sql = "insert into professional_car_buy_detail(tid,city,suburb,postcode,carfrom,carmake,model,transmission,carage,kilometres,carprice,tel,weixin,qq,email,message,poster,bodytype) values('".$tid."','".$city."','".$suburb."','".$postcode."','".$carfrom."','".$carmake."','".$model."','".$transmission."','".$carage."','".$kilometres."','".$carprice."','".$tel."','".$weixin."','".$qq."','".$email."','".$message."','".$poster."','".$bodytype."')";

        $sql = "update professional_car_buy_detail set city='".$city."',suburb='".$suburb."',postcode='".$postcode."',carfrom='".$carfrom."',carmake='".$carmake."',model='".$model."',bodytype='".$bodytype."',transmission='".$transmission."',kilometres='".$kilometres."',carprice='".$carprice."',carage='".$carage."',tel='".$tel."',weixin='".$weixin."',qq='".$qq."',email='".$email."',message='".$message."', poster='".$poster."' where tid=".$tid;
        $result = $this->Db->query($sql);
        return $postThreadInfo;
    }


    function updateThread($tid,$pid,$subject,$message){
        $subject = strip_tags($subject);
        $message = strip_tags($message);
        $subject = stripslashes($subject);
        $subject = addslashes($subject);
        $messageNoSlashes = stripslashes($message);
        $message = addslashes($messageNoSlashes);
        $subject = changeCode($subject,'utf-8','gb2312');
        $message = changeCode($message,'utf-8','gb2312');

        preg_match_all("/\[attach\](.*)\[\/attach\]/isU",$messageNoSlashes,$attAryTmp);
        $attAry = $attAryTmp[1];
        $attNums = count($attAry);
        $firstPic = '';
        if($attNums>0){
            //有附件的情况下
            $picAry = array();
            //判断tabid
            $tableid = getattachtableid($tid);
            $attTableName = "pre_forum_attachment_".$tableid;
            //首先删除不在这里的
            $haveAttAry = $this->Db->fetch_all_assoc("select aid from pre_forum_attachment where tid='".$tid."' and pid='".$pid."'");
            foreach($haveAttAry as $att){
                if(!in_array($att['aid'],$attAry)){
                    $this->Db->query("delete from pre_forum_attachment where aid=".$att['aid']);
                    $this->Db->query("delete from ".$attTableName." where aid=".$att['aid']);
                }
            }


            $attachAry = $this->Db->fetch_all_assoc("SELECT * FROM pre_forum_attachment_unused WHERE `aid` IN(".implode(',',$attAry).")");
            $attachment = '';
            foreach($attachAry as $atta){
                $this->Db->query("REPLACE INTO ".$attTableName." SET `readperm`='' , `price`='0' , `tid`='".$tid."' , `pid`='".$pid."' , `uid`='".MEMBER_ID."' , `description`='' , `aid`='".$atta['aid']."' , `dateline`='".$atta['dateline']."' , `filename`='".$atta['filename']."' , `filesize`='".$atta['filesize']."' , `attachment`='".$atta['attachment']."' , `remote`='0' , `isimage`='1' , `width`='".$atta['width']."' , `thumb`='0'");
                $this->Db->query("UPDATE  pre_forum_attachment SET `tid`='".$tid."' , `pid`='".$tid."' , `tableid`='".$tableid."' WHERE `aid`='".$atta['aid']."'");
                $this->Db->query("DELETE FROM pre_forum_attachment_unused WHERE `aid`='".$atta['aid']."'");
            }

            $picAryResult = $this->Db->query("select attachment from ".$attTableName." where pid='".$pid."'");
            while($atta = $this->Db->fetch_assoc($picAryResult)){
                $picAry[] = "/home/yeeyico/bbs/data/attachment/forum/".$atta['attachment']."_thread.jpg";
                $attachment = $atta['attachment'];
            }

            //判断那些缩略图存在
            $picAryStatus = myFileExists($picAry);
            $picAry = array();
            foreach($picAryStatus as $k=>$picInfo){
                if($picInfo['exist']){
                    $truePath = str_replace("/home/yeeyico/","http://www.yeeyi.com/",$picInfo['filepath']);
                    $picAry[] = $truePath;
                }
            }
            if(count($picAry)>0){
                $firstPic = $picAry[0]; //获取第一张图片
                $picStr = serialize($picAry);
                $this->Db->query("replace into pre_forum_thread_pic set pic='".addslashes($picStr)."',tid=".$tid);
            }
            $this->Db->query("INSERT INTO pre_forum_threadimage SET `tid`='".$tid."' , `attachment`='".$attachment."' , `remote`='0'");
        }
        $this->Db->query("update pre_forum_thread set subject='".$subject."' where tid=".$tid);
        $this->Db->query("update pre_forum_post set subject='".$subject."',message='".$message."' where pid=".$pid);
        $return['status'] = 2521;
        $return['tid'] = $tid;
        $return['pid'] = $pid;
        $return['pic'] = $firstPic;
        return $return;
    }


    function postThread($fid,$subject,$message,$dateline,$typeid=0){
        //判断用户
        if(MEMBER_ID>0){
            //禁言,禁止访问,游客，待验证,禁止ip 不能发帖
            $userInfo = $this->Db->once_fetch_assoc("select * from `pre_common_member` where uid='".MEMBER_ID."'");
            if($userInfo['status']<0 || in_array($userInfo['groupid'],array(4,5,6,7,8))){
                $return['status'] = 5400;
                return $return;
            }
        }
        else if($fid !=234){
            $return['status'] = 5100;
            $this->outjson($return);
        }
        //手机验证
        if(in_array($fid,array(291,715,714,161,142,680,305,681,304,89,716,679,651,93,294))){
            $phoneArr = $this->Db->once_fetch_assoc("select phone from `pre_phone_verify` where uid='".MEMBER_ID."' and status=1");
            $phone = $phoneArr['phone'];
            if(empty($phone)){
                $return['status'] = 5100;
                $this->outjson($return);
            }
        }

        $subject = strip_tags($subject);
        $subject = stripslashes($subject);
        $subject = addslashes($subject);
        $messageNoSlashes = stripslashes($message);
        $messageNoSlashes = strip_tags($messageNoSlashes,"<p><br><div><table><tr><td><span><font><img>");
        $message = addslashes($messageNoSlashes);
        $message .= '<p style="color:blue;margin-top:30px;font-weight:bolder;text-align:right;">发自<a href="https://m.yeeyi.com/mobile/client/index.php">亿忆APP</a></p>';
        $subject = changeCode($subject,'utf-8','gbk');
        $message = changeCode($message,'utf-8','gbk');
        $username = changeCode(MEMBER_NAME,'utf-8','gbk');

        $ip = client_ip();
        //写入了
        $result = $this->Db->query("insert into `pre_forum_thread` (`fid`,`typeid`,`author`,`authorid`,`subject`,`attachment`,`dateline`,`lastpost`,`lastposter`,`views`,`status`) values ('".$fid."','".$typeid."','".$username."','".MEMBER_ID."','".$subject."','','".$dateline."','".$dateline."','".$username."',0,'32')");
        if($result == false){
            $return['status'] = 5400;
            return $return;
        }
        $tid = $this->Db->insert_id();
        //监控发帖
        $this->Db->query("insert into a_thread_log(tid,uid,dateline,subject,ipaddress,agent) values('".$tid."','".MEMBER_ID."','".time()."','".$subject."','".$ip."','app_".addslashes($_SERVER['HTTP_USER_AGENT'])."')");
        //if(in_array($this->G['usergroup'],array(8,9,10,11))){
            $this->Db->query("insert into `pre_new_user_check` values('','".MEMBER_ID."','thread','[app]{$subject}','{$dateline}','{$tid}')");
        //}
        //帖子内容
        $this->Db->query("insert into pre_forum_post_tableid values ('')");
        $pid = $this->Db->insert_id();
        if($pid<1){
            $this->Db->query("delete from pre_forum_thread where tid=".$tid);
            $return['status'] = 5400;
            return $return;
        }
        $postSql = "insert into pre_forum_post (`pid`,`fid`,`tid`,`first`,`subject`,`author`,`authorid`,`dateline`,`message`,`useip`,`usesig`,`attachment`,`smileyoff`) values ('{$pid}','".$fid."','".$tid."',1,'".$subject."','".$username."','".MEMBER_ID."','".$dateline."','".$message."','".client_ip()."',1,'','-1')";
        $postResult = $this->Db->query($postSql);
        if($postResult == false){
            $this->Db->query("delete from pre_forum_thread where tid=".$tid);
            $return['status'] = 5400;
            return $return;
        }
        //更新板块
        $this->Db->query("update `pre_forum_forum` set `threads` = `threads` + 1,`posts` = `posts` + 1,`todayposts` = `todayposts` + 1,`lastpost` = '".$tid."\t".$subject."\t".$dateline."\t".$username."' where `fid` = '".$fid."'");
        $this->Db->query("update pre_common_member_count set `posts` = `posts` + 1,`threads` = `threads` + 1 where `uid` = '".MEMBER_ID."'");
        //处理附件
        preg_match_all("/\[attach\](.*)\[\/attach\]/isU",$messageNoSlashes,$attAryTmp);
        $attAry = $attAryTmp[1];
        $attNums = count($attAry);
        $firstPic = '';
        if($attNums>0){
            //有附件的情况下
            $picAry = array();
            //判断tabid
            $tableid = getattachtableid($tid);
            $attTableName = "pre_forum_attachment_".$tableid;
            $attachAry = $this->Db->fetch_all_assoc("SELECT * FROM pre_forum_attachment_unused WHERE `aid` IN(".implode(',',$attAry).")");
            $attachment = '';
            foreach($attachAry as $atta){
                $this->Db->query("REPLACE INTO ".$attTableName." SET `readperm`='' , `price`='0' , `tid`='".$tid."' , `pid`='".$pid."' , `uid`='".MEMBER_ID."' , `description`='' , `aid`='".$atta['aid']."' , `dateline`='".$atta['dateline']."' , `filename`='".$atta['filename']."' , `filesize`='".$atta['filesize']."' , `attachment`='".$atta['attachment']."' , `remote`='0' , `isimage`='1' , `width`='".$atta['width']."' , `thumb`='0'");
                $this->Db->query("UPDATE  pre_forum_attachment SET `tid`='".$tid."' , `pid`='".$pid."' , `tableid`='".$tableid."' WHERE `aid`='".$atta['aid']."'");
                $this->Db->query("DELETE FROM pre_forum_attachment_unused WHERE `aid`='".$atta['aid']."'");
                $picAry[] = "/home/yeeyico/bbs/data/attachment/forum/".$atta['attachment']."_thread.jpg";
                $attachment = $atta['attachment'];
            }
            //判断那些缩略图存在
            $picAryStatus = myFileExists($picAry);
            $picAry = array();
            foreach($picAryStatus as $k=>$picInfo){
                if($picInfo['exist']){
                    $truePath = str_replace("/home/yeeyico/","http://www.yeeyi.com/",$picInfo['filepath']);
                    $picAry[] = $truePath;
                }
            }
            if(count($picAry)>0){
                $firstPic = $picAry[0]; //获取第一张图片
                $picStr = serialize($picAry);
                $this->Db->query("replace into pre_forum_thread_pic set pic='".addslashes($picStr)."',tid=".$tid);
            }
            $this->Db->query("UPDATE  pre_forum_thread SET `attachment`=2 WHERE `tid`='".$tid."'");
            $this->Db->query("UPDATE  pre_forum_post SET `attachment`=2 WHERE `pid`='".$pid."'");
            $this->Db->query("INSERT INTO pre_forum_threadimage SET `tid`='".$tid."' , `attachment`='".$attachment."' , `remote`='0'");
        }
        $return['status'] = 2400;
        $return['tid'] = $tid;
        $return['pid'] = $pid;
        $return['pic'] = $firstPic;
        return $return;
    }
}