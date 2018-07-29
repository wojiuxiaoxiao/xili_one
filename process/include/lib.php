<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 16:38
 */
class MyRedis{
    var $redis;
    static $redisobj = null;
    private function MyRedis(){
        $this->redis = new Redis();
        $this->redis->pconnect('127.0.0.1',6379);
        $this->redis->auth("rryz,aqfh");
    }
    //单件模式
    static function newRedis() {
        if(self::$redisobj == null) {
            self::$redisobj = new MyRedis();
        }
        return self::$redisobj;
    }

    function setval($key,$val){
        try{
            $this->redis->ping();//判断是否存在
            $this->redis->setex($key,86400,$val);
        }
        catch(Exception $e){
            //echo 'false'.$e->getMessage();
            self::$redisobj = new MyRedis();
            $this->redis->setex($key,86400,$val);
        }

    }

    function getval($key){
        try{
            $this->redis->ping();//判断是否存在
            return $this->redis->get($key);
        }
        catch(Exception $e){
            self::$redisobj = new MyRedis();
            return $this->redis->get($key);
        }
    }

    function delKey($key){
        try{
            $this->redis->ping();//判断是否存在
            return $this->redis->delete($key);
        }
        catch(Exception $e){
            self::$redisobj = new MyRedis();
            return $this->redis->delete($key);
        }
    }

    function sadd($key,$val){
        return $this->redis->sAdd($key,$val);//添加一个集合数据
    }

    function sremove($key,$val){
        return $this->redis->sRem($key,$val);//添加一个集合数据
    }

    /*返回集合中的数据*/
    function gets($key){
        return $this->redis->sMembers($key);
    }

    /**
     * @param $key
     * 删除并取出列表中的第一个元素
     */
    function listPop($key){
        return $this->redis->lpop($key);
    }

}

class MySql{
    var $queryCount = 0;
    var $conn;
    var $result;
    static $mysqlobj = null;
    /*初始化*/
    private function MySql(){
        $this->conn = mysql_connect("10.118.30.217:8066","yeeyico_yicoeei","85nsxcNTpqatjcfQ") or die("连接数据库失败,可能是数据库用户名或密码错误");
        mysql_query("SET NAMES 'gbk'");
        mysql_select_db("yeeyico_new", $this->conn) OR die("未找到指定数据库");
    }
    //单件模式
    static function newMysql() {
        if(self::$mysqlobj == null) {
            self::$mysqlobj = new Mysql();
        }
        return self::$mysqlobj;
    }

    function __destruct() {
        $this->close();
    }

    function close(){
        return mysql_close($this->conn);
    }

    function query($sql){
        mysql_real_escape_string($sql, $this->conn); //过滤转义符号
        $this->result = false;
        $this->result = mysql_query($sql,$this->conn) or $this->showerror();
        if ($this->result === false){
            if (mysql_errno($this->conn) == 2006 or mysql_errno($this->conn) == 2013){
                $r = $this->checkConnection();
                if ($r === true){
                    $this->result = mysql_query($sql,$this->conn);
                }
            }

        }
        return $this->result;
    }

    function showerror(){
        echo mysql_error($this->conn)."\r\n";
    }


    function checkConnection()
    {
        if(!mysql_ping($this->conn)){
            mysql_close($this->conn);
            $this->MySql();
            echo 're'."\r\n";
        }
        return true;
    }


    function fetch_all_array($sql){
        $query = $this->query($sql);
        while($list_item = $this->fetch_array($query)){
            $all_array[] = $list_item;
        }
        return $all_array;
    }
    function fetch_all_row($sql){
        $query = $this->query($sql);
        while($list_item = $this -> fetch_row($query)){
            $all_row[] = $list_item;
        }
        return $all_row;
    }

    function fetch_array($query){
        return mysql_fetch_array($query);
    }

    function once_fetch_array($sql){
        $this->result = $this->query($sql);
        return $this->fetch_array($this->result);
    }

    function fetch_row($query){
        return mysql_fetch_row($query);
    }


    function fetch_all_assoc($sql,$max=0){
        $query = $this->query($sql);
        $current_index = 0;
        while($list_item = $this->fetch_assoc($query,$sql)){
            $current_index ++;
            if($current_index > $max && $max != 0){
                break;
            }
            $all_array[] = $list_item;
        }
        return $all_array;
    }

    function fetch_assoc($query,$sql=''){
        $return = mysql_fetch_assoc($query);
        if($return){
            return $return;
        }
        else{
            return false;
        }
    }

    function once_fetch_assoc($sql){
        $list 	= $this->query($sql);
        $list_array = $this->fetch_assoc($list);
        return $list_array;
    }

    function num_rows($query){
        return mysql_num_rows($query);
    }

    function once_num_rows($sql){
        $query=$this->query($sql);
        return mysql_num_rows($query);
    }

    function num_fields($query){
        return mysql_num_fields($query);
    }

    function insert_id(){
        return mysql_insert_id($this->conn);
    }

    function insertArr($arrData,$table,$where=''){
        $Item = array();
        foreach($arrData as $key=>$data){
            $Item[] = "$key='$data'";
        }
        $intStr = implode(',',$Item);
        $this->query("insert into $table  SET $intStr $where");
        return mysql_insert_id($this->conn);
    }

    function updateArr($arrData,$table,$where=''){
        $Item = array();
        foreach($arrData as $key => $date)
        {
            $Item[] = "$key='$date'";
        }
        $upStr = implode(',',$Item);
        $this->query("UPDATE $table  SET  $upStr $where");
        return true;
    }

    function geterror(){
        return mysql_error();
    }


    function affected_rows(){
        return mysql_affected_rows();
    }


    function getMysqlVersion(){
        return @mysql_get_server_info();
    }

}