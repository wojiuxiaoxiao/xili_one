<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2017/6/26
 * Time: 下午5:04
 */
class Search
{
    var $shpinx;
    function __construct(){
        $this->sphinx = new SphinxClient();
        $this->sphinx->setServer('localhost','9312');
        $this->sphinx->SetSortMode(SPH_SORT_ATTR_DESC,"fid");
        $this->sphinx->setArrayResult(true);
        $this->sphinx->setSelect();
        $this->sphinx->setMatchMode(SPH_MATCH_ALL);
    }

    function searchNews($keyWord){
        $result = array();
//        $this->shpinx->setLimits(0,10);
        $result['data'] = $this->sphinx->query($keyWord);
//        $result['error'] = $this->sphinx->getLastError();
        return $this->doSearchResult($result['data']);
//        return $result;
    }

    function searchAll($keyWord,$lastaid=0,$limit=30){
        if($lastaid>0){
            $this->sphinx->setFilterRange('aid',0,$lastaid);
        }
        $this->shpinx->setLimits(0,$limit);
        $result = $this->shpinx->query($keyWord,'news');
        return $this->doSearchResult($result);
    }

    function searchFid($fidAry,$keyword,$lasttid=0,$limit=30){
        if(!is_array($fidAry)){
            $fidAry = array(0);
        }
        if($lasttid>0){
            $this->sphinx->setFilterRange('aid',0,$lasttid);
        }
        $this->sphinx->SetFilter("fid",$fidAry);
        $this->shpinx->setLimits(0,$limit);
        $result  = $this->sphinx->query($keyword,'news');
        return $this->doSearchResult($result);
    }

    function doSearchResult($result){
        $return = array();
        if($result['total_found'] == 0){
            $return['total'] = 0;
        }
        else{
            $return['total'] = $result['total_found'];
            $list = array();
            foreach($result['matches'] as $match){
                $list[] = $match['attrs'];
            }
            $return['list'] = $list;
        }
        return $return;
    }
}