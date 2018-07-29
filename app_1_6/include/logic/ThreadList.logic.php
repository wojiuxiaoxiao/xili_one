<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/2
 * Time: 7:20
 */
class ThreadList
{
    var $Db;
    var $fid;
    var $city;
    var $typeid;
    var $where;
    function __construct($fid,$typeid){
        $this->Post = &$_POST;
        require(ROOT_PATH . VERSION.'config/config.php');
        $this->param = $config['param']; //参数转换
        load::lib("Db");
        $this->Db = Mysql::newMysql();
        $this->fid = $fid;
        $this->typeid = $typeid;
        $city = trim($this->Post['cityFilter']);
        if(strstr($city,'|')){
            $cityAry = explode('|',$city);
            $this->where = 'where city in('.implode(',',$cityAry).') ';
        }
        else if(intval($city) == 0){
            $this->where = 'where 1=1 ';
        }
        else{
            $this->where = 'where city='.$city.' ';
        }
        if($this->Post['suburb']){
            $this->where .= "and suburb='".trim($this->Post['suburb'])."' ";
        }
    }
    function getList($start,$amount){
        if($this->fid == 715){
            return $this->list_715($start,$amount);
        }
        else if($this->fid == 291){
            return $this->list_291($start,$amount);
        }
        else if($this->fid == 714){
            return $this->list_714($start,$amount);
        }
        else if($this->fid == 161){
            return $this->list_161($start,$amount);
        }
        else if($this->fid == 142){
            return $this->list_142($start,$amount);
        }
        else if($this->fid == 680){
            return $this->list_680($start,$amount);
        }
        else if($this->fid == 305){
            return $this->list_305($start,$amount);
        }
        else if($this->fid == 681){
            return $this->list_681($start,$amount);
        }
        else if($this->fid == 304){
            return $this->list_304($start,$amount);
        }
        else if($this->fid == 89){
            return $this->list_89($start,$amount);
        }
        else if($this->fid == 716){
            return $this->list_716($start,$amount);
        }
        else if($this->fid == 679){
            return $this->list_679($start,$amount);
        }
        else if($this->fid == 651){
            return $this->list_651($start,$amount);
        }
        else if($this->fid == 604){ //宠物交易
            return $this->list_604($start, $amount);
        }
        else if($this->fid == 325){ //团购打折
            return $this->list_325($start, $amount);
        }

        else return array();
    }

    function getList_search($start,$amount){
        ini_set("display_errors","off");
        if($this->fid == 715){
            return $this->list_715_s($start,$amount);
        }
        else if($this->fid == 291){
            return $this->list_291_s($start,$amount);
        }
        else if($this->fid == 714){
            return $this->list_714_s($start,$amount);
        }
        else if($this->fid == 161){
            return $this->list_161_s($start,$amount);
        }
        else if($this->fid == 142){
            return $this->list_142_s($start,$amount);
        }
        else if($this->fid == 680){
            return $this->list_680_s($start,$amount);
        }
        else if($this->fid == 305){
            return $this->list_305_s($start,$amount);
        }
        else if($this->fid == 681){
            return $this->list_681_s($start,$amount);
        }
        else if($this->fid == 304){
            return $this->list_304_s($start,$amount);
        }
        else if($this->fid == 89){
            return $this->list_89_s($start,$amount);
        }
        else if($this->fid == 716){
            return $this->list_716_s($start,$amount);
        }
        else if($this->fid == 679){
            return $this->list_679_s($start,$amount);
        }
        else if($this->fid == 651){
            return $this->list_651_s($start,$amount);
        }
        else if($this->fid == 604){ //宠物之家
            return $this->list_604_s($start, $amount);
        }
        else if($this->fid == 325){ //团购打折
            return $this->list_325_s($start, $amount);
        }
        /*
        else if($this->fid == 0){ //全部
            return $this->list_all_s($start, $amount);
        }
        */
        else return array();
    }

    /* edit by allen qu 2017.04.11 全局搜索*/

    function list_all_s($start, $amount)
    {
        $keyword = trim($this->Post['search']);
        //$fidAry = array(604);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        //$postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }

        foreach ($slistAry as $k=>$v)
        {

        }
        return $slistAry;
    }


    /* edit by allen qu   2017.04.06 */

    //宠物交易 608
    function list_604($start, $amount)
    {
        $filterCounter = 0;
        //过滤
        $typeid   = changeCode(trim($this->Post['typeid']),"utf-8","gbk");
        $ic       = changeCode(trim($this->Post['ic']),"utf-8","gbk");
        $dateline = changeCode(trim($this->Post['dateline']),"utf-8","gbk");

        if($typeid){
            $filterCounter++;
            $this->where .= " and pre_forum_field_pet.typeid='".$typeid."' ";
        }

        if ($ic){
            $filterCounter++;
            $this->where .= " and pre_forum_field_pet.ic='".$ic."' ";
        }

        if($dateline){
            $filterCounter++;
            if($dateline == '1'){
                $timestart = time();
                $endtime = $timestart - 86400;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($dateline == '2'){
                $timestart = time();
                $endtime = $timestart - 86400*3;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($dateline == '3'){
                $timestart = time();
                $endtime = $timestart - 86400*7;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }

            else if($dateline == '4'){
                $timestart = time();
                $endtime = $timestart - 86400*14;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }

            else if($dateline == '5'){
                $timestart = time();
                $endtime = $timestart - 86400*30;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";

        if($start<1){
            $sql = "select '604' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_pet.typeid,pre_forum_field_pet.message,pre_forum_field_pet.ic from pre_forum_field_pet left join pre_forum_thread ".$use_index." on pre_forum_field_pet.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '604' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_pet.typeid,pre_forum_field_pet.message,pre_forum_field_pet.ic from pre_forum_field_pet left join pre_forum_thread ".$use_index." on pre_forum_field_pet.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }


        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;

    }

    function list_604_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(604);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '604' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_pet.typeid,pre_forum_field_pet.message,pre_forum_field_pet.ic from pre_forum_field_pet left join pre_forum_thread on pre_forum_field_pet.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    //打折团购 325
    function list_325($start, $amount)
    {
        $filterCounter = 0;
        //过滤
        $typeid   = changeCode(trim($this->Post['typeid']),"utf-8","gbk");
        $dateline = changeCode(trim($this->Post['dateline']),"utf-8","gbk");

        if($typeid){
            $filterCounter++;
            $this->where .= " and pre_forum_field_groupbuy.typeid='".$typeid."' ";
        }

        if($dateline){
            $filterCounter++;
            if($dateline == '1'){
                $timestart = time();
                $endtime = $timestart - 86400;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($dateline == '2'){
                $timestart = time();
                $endtime = $timestart - 86400*3;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($dateline == '3'){
                $timestart = time();
                $endtime = $timestart - 86400*7;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }

            else if($dateline == '4'){
                $timestart = time();
                $endtime = $timestart - 86400*14;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }

            else if($dateline == '5'){
                $timestart = time();
                $endtime = $timestart - 86400*30;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";

        if($start<1){
            $sql = "select '325' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_groupbuy.typeid,pre_forum_field_groupbuy.message from pre_forum_field_groupbuy left join pre_forum_thread ".$use_index." on pre_forum_field_groupbuy.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '325' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_groupbuy.typeid,pre_forum_field_groupbuy.message from pre_forum_field_groupbuy left join pre_forum_thread ".$use_index." on pre_forum_field_groupbuy.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }


        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;

    }

    function list_325_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(325);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '325' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_groupbuy.typeid,pre_forum_field_groupbuy.message from pre_forum_field_groupbuy left join pre_forum_thread on pre_forum_field_groupbuy.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    /* edit end  */
    //汽车出售 291
    function list_291($start,$amount){
        $filterCounter = 0;
        //过滤
        $carfrom = trim($this->Post['carfrom']);
        $carmake = trim($this->Post['carmake']);
        $model = trim($this->Post['model']);
        $bodytype = trim($this->Post['bodytype']);
        $transmission = trim($this->Post['transmission']);
        $fueltype = trim($this->Post['fueltype']);
        $kilometres = trim($this->Post['kilometres']);
        $carprice = trim($this->Post['carprice']);
        if($carfrom){
            $filterCounter++;
            $this->where .= " and carfrom='".$carfrom."' ";
        }
        if($carmake){
            $filterCounter++;
            $this->where .= " and carmake='".$carmake."' ";
        }
        if($model){
            $filterCounter++;
            $this->where .= " and model='".$model."' ";
        }
        if($bodytype){
            $filterCounter++;
            $this->where .= " and bodytype='".$bodytype."' ";
        }
        if($transmission){
            $filterCounter++;
            $this->where .= " and transmission='".$transmission."' ";
        }
        if($fueltype){
            $filterCounter++;
            $this->where .= " and fueltype='".$fueltype."' ";
        }
        if($kilometres != '0'){
            $filterCounter++;
            if($kilometres == '1'){
                $this->where .= " and kilometres<10000 ";
            }
            if($kilometres == '2'){
                $this->where .= " and kilometres between 10000 and 30000 ";
            }
            if($kilometres == '3'){
                $this->where .= " and kilometres between 30000 and 60000 ";
            }
            if($kilometres == '4'){
                $this->where .= " and kilometres between 60000 and 100000 ";
            }
            if($kilometres == '5'){
                $this->where .= " and kilometres>100000 ";
            }
        }

        if($carprice != '0'){
            $filterCounter++;
            if($carprice == '1'){
                $this->where .= " and professional_car_sale_detail.price<5000 ";
            }
            if($carprice == '2'){
                $this->where .= " and professional_car_sale_detail.price between 5000 and 10000 ";
            }
            if($carprice == '3'){
                $this->where .= " and professional_car_sale_detail.price between 10000 and 20000 ";
            }
            if($carprice == '4'){
                $this->where .= " and professional_car_sale_detail.price between 20000 and 30000 ";
            }
            if($carprice == '5'){
                $this->where .= " and professional_car_sale_detail.price between 30000 and 40000 ";
            }
            if($carprice == '6'){
                $this->where .= " and professional_car_sale_detail.price>400000 ";
            }
        }
        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';
        //carmake,price
        if($start<1){
            $sql = "select '291' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_car_sale_detail.carmake,professional_car_sale_detail.price from professional_car_sale_detail left join pre_forum_thread ".$use_index." on professional_car_sale_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '291' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_car_sale_detail.carmake,professional_car_sale_detail.price from professional_car_sale_detail left join pre_forum_thread  ".$use_index."  on professional_car_sale_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_291_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(291,653,635,291,633,660,634);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '291' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,professional_car_sale_detail.carmake,professional_car_sale_detail.price from professional_car_sale_detail left join pre_forum_thread on professional_car_sale_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }



    //汽车出售 291
    function list_715($start,$amount){
        $filterCounter = 0;
        $carfrom = trim($this->Post['carfrom']);
        $carmake = trim($this->Post['carmake']);
        $model = trim($this->Post['model']);
        $bodytype = trim($this->Post['bodytype']);
        $transmission = trim($this->Post['transmission']);
        $kilometres = trim($this->Post['kilometres']);
        $carprice = trim($this->Post['carprice']);
        if($carfrom){
            $filterCounter++;
            $this->where .= " and carfrom='".$carfrom."' ";
        }
        if($carmake){
            $filterCounter++;
            $this->where .= " and carmake='".$carmake."' ";
        }
        if($model){
            $filterCounter++;
            $this->where .= " and model='".$model."' ";
        }
        if($bodytype){
            $filterCounter++;
            $this->where .= " and bodytype='".$bodytype."' ";
        }
        if($transmission){
            $filterCounter++;
            $this->where .= " and transmission='".$transmission."' ";
        }
        if($kilometres != '0'){
            $filterCounter++;
            if($kilometres == '1'){
                $this->where .= " and kilometres<10000 ";
            }
            if($kilometres == '2'){
                $this->where .= " and kilometres between 10000 and 30000 ";
            }
            if($kilometres == '3'){
                $this->where .= " and kilometres between 30000 and 60000 ";
            }
            if($kilometres == '4'){
                $this->where .= " and kilometres between 60000 and 100000 ";
            }
            if($kilometres == '5'){
                $this->where .= " and kilometres>100000 ";
            }
        }

        if($carprice != '0'){
            $filterCounter++;
            if($carprice == '1'){
                $this->where .= " and professional_car_buy_detail.price<5000 ";
            }
            if($carprice == '2'){
                $this->where .= " and professional_car_buy_detail.price between 5000 and 10000 ";
            }
            if($carprice == '3'){
                $this->where .= " and professional_car_buy_detail.price between 10000 and 20000 ";
            }
            if($carprice == '4'){
                $this->where .= " and professional_car_buy_detail.price between 20000 and 30000 ";
            }
            if($carprice == '5'){
                $this->where .= " and professional_car_buy_detail.price between 30000 and 40000 ";
            }
            if($carprice == '6'){
                $this->where .= " and professional_car_buy_detail.price>400000 ";
            }
        }
//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';
        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //carmake carprice
        if($start<1){
            $sql = "select '715' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_car_buy_detail.carmake,professional_car_buy_detail.carprice from professional_car_buy_detail left join pre_forum_thread  ".$use_index."  on professional_car_buy_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '715' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_car_buy_detail.carmake,professional_car_buy_detail.carprice from professional_car_buy_detail left join pre_forum_thread  ".$use_index."  on professional_car_buy_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_715_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(715);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }

        $sql = "select '715' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,professional_car_buy_detail.carmake,professional_car_buy_detail.carprice from professional_car_buy_detail left join pre_forum_thread on professional_car_buy_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_714($start,$amount){
        $filterCounter = 0;
        $visa = changeCode(trim($this->Post['visa']),"utf-8","gbk");
        $property = changeCode(trim($this->Post['property']),"utf-8","gbk");
        $position = changeCode(trim($this->Post['position']),"utf-8","gbk");

        if($visa){
            $filterCounter++;
            $this->where .= " and visa='".$visa."' ";
        }
        if($property){
            $filterCounter++;
            $this->where .= " and property='".$property."' ";
        }
        if($position){
            $filterCounter++;
            $this->where .= " and position='".$position."' ";
        }
//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';
        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //suburb visa
        if($start<1){
            $sql = "select '714' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_job_apply_detail.suburb,professional_job_apply_detail.visa from professional_job_apply_detail left join pre_forum_thread  ".$use_index." on professional_job_apply_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '714' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_job_apply_detail.suburb,professional_job_apply_detail.visa from professional_job_apply_detail left join pre_forum_thread  ".$use_index." on professional_job_apply_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_714_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(714);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '714' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,professional_job_apply_detail.suburb,professional_job_apply_detail.visa from professional_job_apply_detail left join pre_forum_thread on professional_job_apply_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_161($start,$amount){
        $filterCounter = 0;
        $visa = changeCode(trim($this->Post['visa']),"utf-8","gbk");
        $property = changeCode(trim($this->Post['property']),"utf-8","gbk");
        $position = changeCode(trim($this->Post['position']),"utf-8","gbk");
        if($visa){
            $filterCounter++;
            $this->where .= " and visa='".$visa."' ";
        }
        if($property){
            $filterCounter++;
            $this->where .= " and property='".$property."' ";
        }
        if($position){
            $filterCounter++;
            $this->where .= " and position='".$position."' ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";

        //suburb,salary
        if($start<1){
            $sql = "select '161' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_job_fire_detail.suburb,professional_job_fire_detail.salary_form,professional_job_fire_detail.salary from professional_job_fire_detail left join pre_forum_thread  ".$use_index." on professional_job_fire_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '161' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,professional_job_fire_detail.suburb,professional_job_fire_detail.salary_form,professional_job_fire_detail.salary from professional_job_fire_detail left join pre_forum_thread  ".$use_index." on professional_job_fire_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_161_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(161,630,631,632);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '161' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,professional_job_fire_detail.suburb,professional_job_fire_detail.salary_form,professional_job_fire_detail.salary from professional_job_fire_detail left join pre_forum_thread on professional_job_fire_detail.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_142($start,$amount){
        $filterCounter = 0;
        $house_type = changeCode(trim($this->Post['house_type']),"utf-8","gbk");
        $house_from = changeCode(trim($this->Post['house_from']),"utf-8","gbk");
        $rent_type = changeCode(trim($this->Post['rent_type']),"utf-8","gbk");
        $rent_price = changeCode(trim($this->Post['rent_price']),"utf-8","gbk");
        $postdate = changeCode(trim($this->Post['postdate']),"utf-8","gbk");

        if($house_type){
            $filterCounter++;
            $this->where .= " and house_type='".$house_type."' ";
        }
        if($house_from){
            $filterCounter++;
            $this->where .= " and house_from='".$house_from."' ";
        }
        if($rent_type){
            $filterCounter++;
            $this->where .= " and rent_type='".$rent_type."' ";
        }
        if($rent_price){
            $filterCounter++;
            list($startPrice,$endPrice) = explode('|',$rent_price);
            $startPrice = floatval($startPrice);
            $endPrice = floatval($endPrice);
            $this->where .= " and house_rents between $startPrice and $endPrice ";
        }
        if($postdate){
            $filterCounter++;
            if($postdate == '1'){
                $timestart = time();
                $endtime = $timestart - 86400;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($postdate == '2'){
                $timestart = time();
                $endtime = $timestart - 86400*3;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($postdate == '3'){
                $timestart = time();
                $endtime = $timestart - 86400*7;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($postdate == '4'){
                $timestart = time();
                $endtime = $timestart - 86400*30;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
        }
//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //house_rents house_type
        if($start<1){
            $sql = "select '142' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_house_for_rent.house_rents,pre_forum_field_house_for_rent.house_type from pre_forum_field_house_for_rent left join pre_forum_thread  ".$use_index." on pre_forum_field_house_for_rent.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '142' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_house_for_rent.house_rents,pre_forum_field_house_for_rent.house_type from pre_forum_field_house_for_rent left join pre_forum_thread  ".$use_index." on pre_forum_field_house_for_rent.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid  ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_142_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(142,622,623,624,625,626,627);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '142' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_house_for_rent.house_rents,pre_forum_field_house_for_rent.house_type from pre_forum_field_house_for_rent left join pre_forum_thread on pre_forum_field_house_for_rent.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }



    function list_680($start,$amount){
        $filterCounter = 0;
        $rent_type = changeCode(trim($this->Post['rent_type']),"utf-8","gbk");
        $validity = changeCode(trim($this->Post['validity']),"utf-8","gbk");


        if($rent_type){
            $filterCounter++;
            $this->where .= " and rent_type='".$rent_type."' ";
        }
        if($validity){
            $filterCounter++;
            $this->where .= " and validity='".$validity."' ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';


        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        if($start<1){
            $sql = "select '680' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost from pre_forum_field_house_want_rent left join pre_forum_thread  ".$use_index." on pre_forum_field_house_want_rent.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '680' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost from pre_forum_field_house_want_rent left join pre_forum_thread  ".$use_index." on pre_forum_field_house_want_rent.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_680_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(680);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }

        $sql = "select '680' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost from pre_forum_field_house_want_rent left join pre_forum_thread on pre_forum_field_house_want_rent.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_305($start,$amount){
        $filterCounter = 0;
        $house_type = changeCode(trim($this->Post['house_type']),"utf-8","gbk");
        $house_price = changeCode(trim($this->Post['house_price']),"utf-8","gbk");
        $readyhouse = changeCode(trim($this->Post['readyhouse']),"utf-8","gbk");

        if($house_type){
            $filterCounter++;
            $this->where .= " and house_type='".$house_type."' ";
        }
        if($readyhouse){
            $filterCounter++;
            $this->where .= " and readyhouse='".$readyhouse."' ";
        }

        if($house_price){
            $filterCounter++;
            list($startPrice,$endPrice) = explode('|',$house_price);
            $startPrice = floatval($startPrice);
            $endPrice = floatval($endPrice);
            $this->where .= " and pre_forum_field_house_for_sale.price between $startPrice and $endPrice ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //price house_type
        if($start<1){
            $sql = "select '305' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_house_for_sale.price,pre_forum_field_house_for_sale.house_type from pre_forum_field_house_for_sale left join pre_forum_thread  ".$use_index." on pre_forum_field_house_for_sale.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '305' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_house_for_sale.price,pre_forum_field_house_for_sale.house_type  from pre_forum_field_house_for_sale left join pre_forum_thread  ".$use_index." on pre_forum_field_house_for_sale.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_305_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(305);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '305' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_house_for_sale.price,pre_forum_field_house_for_sale.house_type from pre_forum_field_house_for_sale left join pre_forum_thread on pre_forum_field_house_for_sale.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_681($start,$amount){
        $filterCounter = 0;
        $validity = changeCode(trim($this->Post['validity']),"utf-8","gbk");
        $house_type = changeCode(trim($this->Post['house_type']),"utf-8","gbk");
        $iscity = changeCode(trim($this->Post['iscity']),"utf-8","gbk");
        if($validity){
            $filterCounter++;
            $this->where .= " and validity='".$validity."' ";
        }
        if($house_type){
            $filterCounter++;
            $this->where .= " and house_type='".$house_type."' ";
        }
        if($iscity){
            $filterCounter++;
            $this->where .= " and iscity='".$iscity."' ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //house_position,house_type
        if($start<1){
            $sql = "select '681' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_house_want_buy.house_position,pre_forum_field_house_want_buy.house_type from pre_forum_field_house_want_buy left join pre_forum_thread  ".$use_index." on pre_forum_field_house_want_buy.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '681' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_house_want_buy.house_position,pre_forum_field_house_want_buy.house_type from pre_forum_field_house_want_buy left join pre_forum_thread  ".$use_index." on pre_forum_field_house_want_buy.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_681_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(681);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '681' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_house_want_buy.house_position,pre_forum_field_house_want_buy.house_type from pre_forum_field_house_want_buy left join pre_forum_thread on pre_forum_field_house_want_buy.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_304($start,$amount){
        $filterCounter = 0;

        $typeid = changeCode(trim($this->Post['typeid']),"utf-8","gbk");
        $delivery = changeCode(trim($this->Post['delivery']),"utf-8","gbk");
        $fromtype = changeCode(trim($this->Post['fromtype']),"utf-8","gbk");
        $markettype = changeCode(trim($this->Post['markettype']),"utf-8","gbk");
        $postdate = changeCode(trim($this->Post['postdate']),"utf-8","gbk");

        if($typeid){
            $filterCounter++;
            $this->where .= " and pre_forum_field_market.typeid='".$typeid."' ";
        }
        if($delivery){
            $filterCounter++;
            $this->where .= " and delivery='".$delivery."' ";
        }
        if($fromtype){
            $filterCounter++;
            $this->where .= " and fromtype='".$fromtype."' ";
        }
        if($markettype){
            $filterCounter++;
            $this->where .= " and markettype='".$markettype."' ";
        }

        if($postdate){
            $filterCounter++;
            if($postdate == '1'){
                $timestart = time();
                $endtime = $timestart - 86400;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($postdate == '2'){
                $timestart = time();
                $endtime = $timestart - 86400*3;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($postdate == '3'){
                $timestart = time();
                $endtime = $timestart - 86400*7;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
            else if($postdate == '4'){
                $timestart = time();
                $endtime = $timestart - 86400*30;
                $this->where .= " and pre_forum_thread.dateline between $endtime and $timestart ";
            }
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';


        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //suburb price
        if($start<1){
            $sql = "select '304' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_market.suburb,pre_forum_field_market.price from pre_forum_field_market left join pre_forum_thread  ".$use_index." on pre_forum_field_market.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '304' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_market.suburb,pre_forum_field_market.price  from pre_forum_field_market left join pre_forum_thread  ".$use_index." on pre_forum_field_market.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and  pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_304_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(304,641,642,643);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }


        $sql = "select '304' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_market.suburb,pre_forum_field_market.price  from pre_forum_field_market left join pre_forum_thread on pre_forum_field_market.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_89($start,$amount){
        $filterCounter = 0;
        //$this->where = 'where 1=1 ';
        $typeid = changeCode(trim($this->Post['typeid']),"utf-8","gbk");
        if($typeid){
            $filterCounter++;
            $this->where .= " and pre_forum_field_super_market.typeid='".$typeid."' ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        //suburb,price
        if($start<1){
            $sql = "select '89' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_super_market.suburb,pre_forum_field_super_market.price from pre_forum_field_super_market left join pre_forum_thread  ".$use_index." on pre_forum_field_super_market.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '89' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_super_market.suburb,pre_forum_field_super_market.price from pre_forum_field_super_market left join pre_forum_thread  ".$use_index." on pre_forum_field_super_market.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and  pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_89_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(89);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }

        $sql = "select '89' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_super_market.suburb,pre_forum_field_super_market.price from pre_forum_field_super_market left join pre_forum_thread on pre_forum_field_super_market.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_716($start,$amount){
        $filterCounter = 0;
//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';
        //suburb hangye
        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        if($start<1){
            $sql = "select '716' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_business.suburb,pre_forum_field_business.hangye from pre_forum_field_business left join pre_forum_thread  ".$use_index." on pre_forum_field_business.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '716' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_business.suburb,pre_forum_field_business.hangye from pre_forum_field_business left join pre_forum_thread  ".$use_index." on pre_forum_field_business.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_716_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(716);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }

        $sql = "select '716' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_business.suburb,pre_forum_field_business.hangye from pre_forum_field_business left join pre_forum_thread on pre_forum_field_business.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";


        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }



    function list_679($start,$amount){
        $filterCounter = 0;
        $school = changeCode(trim($this->Post['school']),"utf-8","gbk");
        $typeid = changeCode(trim($this->Post['typeid']),"utf-8","gbk");
        $xuqiu = changeCode(trim($this->Post['xuqiu']),"utf-8","gbk");

        if($typeid){
            $filterCounter++;
            $this->where .= " and pre_forum_field_book.typeid='".$typeid."' ";
        }
        if($school){
            $filterCounter++;
            $this->where .= " and school='".$school."' ";
        }
        if($xuqiu){
            $filterCounter++;
            $this->where .= " and xuqiu='".$xuqiu."' ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';

        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        if($start<1){
            $sql = "select '679' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_book.suburb,pre_forum_field_book.price from pre_forum_field_book left join pre_forum_thread  ".$use_index." on pre_forum_field_book.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '679' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_book.suburb,pre_forum_field_book.price from pre_forum_field_book left join pre_forum_thread  ".$use_index." on pre_forum_field_book.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }

    function list_679_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(679);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }

        $sql = "select '679' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_book.suburb,pre_forum_field_book.price from pre_forum_field_book left join pre_forum_thread on pre_forum_field_book.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_651($start,$amount){
        $filterCounter = 0;
        $typeid = changeCode(trim($this->Post['typeid']),"utf-8","gbk");
        if($typeid){
            $filterCounter++;
            $this->where .= " and pre_forum_field_service.typeid='".$typeid."' ";
        }

//        if($filterCounter == 0){
//            $use_index = " use index(lastpost) ";
//        }
//        else{
//            $use_index = '';
//        }
        $use_index = '';
        
        $this->where .= " and pre_forum_thread.`displayorder`>=0 ";
        if($start<1){
            $sql = "select '651' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_service.typeid,pre_forum_field_service.company_area from pre_forum_field_service left join pre_forum_thread  ".$use_index." on pre_forum_field_service.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        else{
            $sql = "select '651' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,lastpost,pre_forum_field_service.typeid,pre_forum_field_service.company_area from pre_forum_field_service left join pre_forum_thread  ".$use_index." on pre_forum_field_service.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid ".$this->where." and  pre_forum_thread.lastpost<$start order by pre_forum_thread.lastpost desc limit 0,$amount";
        }
        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function list_651_s($start,$amount){
        $keyword = trim($this->Post['search']);
        $fidAry = array(651,652,316,662);
        $postAry = array();
        $postAry['maxtid'] = $start;
        $postAry['keyword'] = $keyword;
        $postAry['limit'] = $amount;
        $postAry['fidStr'] = json_encode($fidAry);
        $slistAry = $this->postSearch($postAry);
        if($slistAry['total'] == 0 || !is_array($slistAry['list'])){
            return array();
        }
        $tidAry = array(0);
        foreach($slistAry['list'] as $sthread){
            $tidAry[] = $sthread['tid'];
        }

        $sql = "select '651' as fid,pre_forum_thread.tid,author,authorid,subject,pre_forum_thread_pic.description,dateline,pre_forum_thread_pic.pic,views,replies,'0' as likes,pre_forum_thread.tid as lastpost,pre_forum_field_service.typeid,pre_forum_field_service.company_area from pre_forum_field_service left join pre_forum_thread on pre_forum_field_service.tid=pre_forum_thread.tid left join pre_forum_thread_pic on pre_forum_thread.tid = pre_forum_thread_pic.tid where pre_forum_thread.tid in(".implode(',',$tidAry).") order by pre_forum_thread.tid desc";

        $threadlistTmp = $this->Db->fetch_all_assoc($sql);
        $threadlist = $this->dothreadlist($threadlistTmp);
        return $threadlist;
    }


    function dothreadlist($threadlistTmp){
        $threadlist = array();
        foreach($threadlistTmp as $k=>$thread){
            if($thread['tid']<1 || $thread['dateline']<1){
                continue;
            }
            //处理选项的问题
            $fid = intval($thread['fid']);
            $thread['list_option'] = $this->getListOption($fid,$thread);
            $picStr = $thread['pic'];
            $picAry = unserialize($picStr);
            $picAry2 = json_decode($picStr,true);
            if(is_array($picAry2)){
                $picAry = $picAry2;
            }
            if(!is_array($picAry)){
                $picAry = array();
                $nomalPic = array();
            }
            else{
                $nomalPic = array();
                foreach($picAry as $kk=>$pic){
                    $nomalPic[$kk] = str_replace('_thread.jpg','',$pic);
                }
            }
            $threadlistTmp[$k]['pic'] = $picAry;
            $threadlistTmp[$k]['bigpic'] = $nomalPic;
            $threadlistTmp[$k]['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$thread['authorid']."&size=middle";

            $thread['pic'] = $picAry;
            $thread['bigpic'] = $nomalPic;
            $thread['userface'] = "http://center.yeeyi.com/avatar.php?uid=".$thread['authorid']."&size=middle";
            $threadlist[] = $thread;

        }
        return $threadlist;
    }

    function getListOption($fid,$thread){
        $param = changeCode($this->param,'utf-8','gbk');
        $optionAry = array();
        if($fid == 715){
            $optionAry[] = $thread['carmake'];
            $optionAry[] = '$'.$thread['carprice'];
        }
        else if($fid == 291){
            $optionAry[] = $thread['carmake'];
            $optionAry[] = '$'.$thread['price'];
        }
        else if($fid == 714){
            //suburb visa
            $optionAry[] = $thread['suburb'];
            $optionAry[] = $thread['visa'];
        }
        else if($fid == 161){
            //suburb,salary
            $optionAry[] = $thread['suburb'];
            $paramAry = $param['161'];
            /* 2017.06.19 edit by allen qu 如果salary_form为0返回为空字符串 */
            if ($thread['salary_form'] == 0) {

                $salary_formStr = '';
            }else {
                $salary_formStr = $paramAry['salary_form'][$thread['salary_form']];
            }

            $salaryStr = $paramAry['salary'][$thread['salary']];
            $optionAry[] = $salary_formStr.' '.$salaryStr;
        }
        else if($fid == 142){
            //house_rents house_type
            $optionAry[] = '$'.$thread['house_rents'].'/week';
            $paramAry = $param['142'];
            $house_typeStr = $paramAry['house_type'][$thread['house_type']];
            $optionAry[] = $house_typeStr;

        }
        else if($fid == 680){

        }
        else if($fid == 305){
            //price house_type
            $optionAry[] = '$'.$thread['price'];
            $paramAry = $param['305'];
            $house_typeStr = $paramAry['house_type'][$thread['house_type']];
            $optionAry[] = $house_typeStr;
        }
        else if($fid == 681){
            //house_position,house_type
            $optionAry[] = $thread['house_position'];
            $paramAry = $param['681'];
            $house_typeStr = $paramAry['house_type'][$thread['house_type']];
            $optionAry[] = $house_typeStr;
        }
        else if($fid == 304){
            $optionAry[] = $thread['suburb'];
            $optionAry[] = '$'.$thread['price'];
        }
        else if($fid == 89){
            $optionAry[] = $thread['suburb'];
            $optionAry[] = '$'.$thread['price'];
        }
        else if($fid == 716){
            $optionAry[] = $thread['suburb'];
            $optionAry[] = $thread['hangye'];
        }
        else if($fid == 679){
            $optionAry[] = $thread['suburb'];
            $optionAry[] = $thread['hangye'];
        }
        else if($fid == 651){
            $paramAry = $param['651'];
            //$typeidStr = $paramAry['typeid'][$thread['typeid']];
            /* 2017.06.07 edit by allen qu */
            $optionAry[] = $thread['author'];
            //$optionAry[] = $typeidStr;
            $optionAry[] = $thread['company_area'];

        }
        /* 2017.06.07 edit by allen qu 604, 325为新添加 */
        else if($fid == 604){

            $optionAry[] = $thread['author'];
        }
        else if($fid == 325){

            $optionAry[] = $thread['author'];
        }

        return $optionAry;
    }

    function postSearch($array){
        $url = "http://s.yeeyi.com/index.php?act=search";
        $result = postData($url,$array);
        $threalist = json_decode($result,true);
        return $threalist;
    }
}