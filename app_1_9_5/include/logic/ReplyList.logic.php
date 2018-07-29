<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/2
 * Time: 7:20
 */
class ReplyList
{
    var $Db;
    var $uid;
    var $type;
    function __construct($uid,$type){
        load::lib("Db");
        $this->Db = Mysql::newMysql();
        $this->G['uid'] = $uid;
        $this->type = $type;
    }
    function getList($start,$amount){
        if($this->type == 1){
            return $this->getNewsReply($start,$amount);
        }
        else if($this->type == 2){
            return $this->getThreadReply($start,$amount);
        }
        else if($this->type == 3){
            return $this->getThreadReply($start,$amount,3);
        }
        else {
            return array();
        }
    }

    /**
     * 新闻评论
     * @param $start
     * @param $amount
     */
    function getNewsReply($start,$amount){
        if($start>0){
            $sql = "SELECT a.id,a.aid,title,pubdate,pic,a.userid,a.username,a.content,a.addtime,a.replyid,b.id as upid,b.userid as upuserid,b.username as upusername,b.content as upcontent,b.addtime as upaddtime FROM `news_comment` a left join news_article on a.aid=news_article.aid left join `news_comment` b on a.replyid=b.id where a.userid=".$this->G['uid']." and a.id<".$start." order by a.id desc";
        }
        else{
            $sql = "SELECT a.id,a.aid,title,pubdate,pic,a.userid,a.username,a.content,a.addtime,a.replyid,b.id as upid,b.userid as upuserid,b.username as upusername,b.content as upcontent,b.addtime as upaddtime FROM `news_comment` a left join news_article on a.aid=news_article.aid left join `news_comment` b on a.replyid=b.id where a.userid=".$this->G['uid']." order by a.id desc limit $amount";
        }
        $listTmp = $this->Db->fetch_all_assoc($sql);
        $newsReply = array();
        foreach($listTmp as $list){
            $tmp = array();
            $tmp['id'] = $list['id'];
            $tmp['userid'] = $list['userid'];
            $tmp['face'] = "http://center.yeeyi.com/avatar.php?uid=".$list['userid']."&size=middle";
            $tmp['username'] = $list['username'];
            $tmp['content'] = $list['content'];
            $tmp['addtime'] = $list['addtime'];
            $tmp['newsInfo'] = array(
                'aid' => $list['aid'],
                'title' => $list['title'],
                'pic' => $list['pic'],
                'pubdate' => $list['pubdate']
            );
            if($list['replyid']>0){
                $tmp['upReply'] = array(
                    'id' => $list['upid'],
                    'uid' => $list['upuserid'],
                    'face' => "http://center.yeeyi.com/avatar.php?uid=".$list['upuserid']."&size=middle",
                    'username' => $list['upusername'],
                    'addtime' => $list['upaddtime'],
                    'content' => $list['upcontent'],
                );
            }
            $newsReply[] = $tmp;
        }
        $newsReply = changeCode($newsReply);
        return $newsReply;
    }

    /**
     * 新闻评论我的
     * @param $start
     * @param $amount
     * @return array|string
     */
    function getNewsReplyMe($start,$amount){
        if($start>0){
            $sql = "SELECT a.id,a.aid,title,pubdate,pic,froms,a.userid,a.username,a.content,a.addtime,a.replyid,a.up,a.commnum,b.up as uplike,b.commnum as upreplies,b.id as upid,b.userid as upuserid,b.username as upusername,b.content as upcontent,b.addtime as upaddtime FROM `news_comment` a left join news_article on a.aid=news_article.aid left join `news_comment` b on a.replyid=b.id where b.userid=".$this->G['uid']." and a.id<".$start." order by a.id desc";
        }
        else{
            $sql = "SELECT a.id,a.aid,title,pubdate,pic,froms,a.userid,a.username,a.content,a.addtime,a.replyid,a.up,a.commnum,b.up as uplike,b.commnum as upreplies,b.id as upid,b.userid as upuserid,b.username as upusername,b.content as upcontent,b.addtime as upaddtime FROM `news_comment` a left join news_article on a.aid=news_article.aid left join `news_comment` b on a.replyid=b.id where b.userid=".$this->G['uid']." order by a.id desc limit $amount";
        }
        $listTmp = $this->Db->fetch_all_assoc($sql);
        $newsReply = array();
        foreach($listTmp as $list){
            $tmp = array();
            $tmp['id'] = $list['id'];
            $tmp['userid'] = $list['userid'];
            $tmp['face'] = "http://center.yeeyi.com/avatar.php?uid=".$list['userid']."&size=middle";
            $tmp['username'] = $list['username'];
            $tmp['content'] = $list['content'];
            $tmp['addtime'] = $list['addtime'];
            $tmp['likes'] = $list['up'];
            $tmp['replies'] = $list['commnum'];
            $tmp['newsInfo'] = array(
                'aid' => $list['aid'],
                'title' => $list['title'],
                'pic' => $list['pic'],
                'froms' => $list['froms'],
                'pubdate' => $list['pubdate']
            );
            if($list['replyid']>0){
                $tmp['upReply'] = array(
                    'id' => $list['upid'],
                    'uid' => $list['upuserid'],
                    'face' => "http://center.yeeyi.com/avatar.php?uid=".$list['upuserid']."&size=middle",
                    'username' => $list['upusername'],
                    'addtime' => $list['upaddtime'],
                    'content' => $list['upcontent'],
                    'likes'=>$list['uplike'],
                    'replies'=>$list['upreplies'],
                );
            }
            $newsReply[] = $tmp;
        }
        $newsReply = changeCode($newsReply);
        return $newsReply;
    }

    /**
     * 我的评论，评论的发布者是我
     * @param $start
     * @param $amount
     * @return array|string
     */
    function getThreadReply($start,$amount,$type=2){
        if($type == 2){
            if($start>0){
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_post.authorid=".$this->G['uid']." and first=0 and pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and invisible>=0 and pid<$start order by pid desc limit 0,$amount";
            }
            else{
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_post.authorid=".$this->G['uid']." and first=0 and pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and invisible>=0 order by pid desc limit $amount";
            }
        }
        else{
            if($start>0){
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_post.authorid=".$this->G['uid']." and first=0 and pre_forum_thread.fid not in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and invisible>=0 and pid<$start order by pid desc limit 0,$amount";
            }
            else{
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_post.authorid=".$this->G['uid']." and first=0 and pre_forum_thread.fid not in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and invisible>=0 order by pid desc limit $amount";
            }
        }



        $result = $this->Db->query($replySql);
        $tmpAry = array();
        while($listTmp = $this->Db->fetch_assoc($result)){
            $tmp = array();
            $tmp['pid'] = $listTmp['pid'];
            $tmp['author'] = $listTmp['author'];
            $tmp['authorid'] = $listTmp['authorid'];
            $tmp['face'] = "http://center.yeeyi.com/avatar.php?uid=".$listTmp['authorid']."&size=middle";
            $tmp['dateline'] = $listTmp['dateline'];
            $tmp['message'] = $listTmp['message'];
            $message = stripslashes($tmp['message']);
            $postmessage = $this->getImgAttachment($tmp['pid'],$message);
            //$postmessage = parseQuote($postmessage); //获取上级评论的
            $postmessage = getImg($postmessage);
            $postmessage = parsesmiles2($postmessage);
            $postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
            //$postmessage = getMp3($postmessage); [mp3]音乐地址[/mp3]
            $postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
            $postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
            $postmessage = nl2br($postmessage);
            $postmessage = stripslashes($postmessage);
            $tmp['message'] = $postmessage;


            $tmp['threadInfo'] = array(
                'tid'=>$listTmp['tid'],
                'subject'=>$listTmp['subject'],
                'addtime'=>$listTmp['tdateline'],
                'pic'=>'',
            );
            $message = stripslashes($tmp['message']);
            //获取上级的
            preg_match("/\[quote\].*pid=([0-9]+)&ptid.*\[\/quote\]/isU",$message,$uppidAry);
            if($uppidAry[1]>0){
                $upPid[$tmp['pid']] = intval($uppidAry[1]);
            }
            $tmpAry[$tmp['pid']] = $tmp;
        }

        if(count($upPid)>0){
            $upInfoAry = $this->Db->fetch_all_assoc("select pid,message,author,authorid,dateline from pre_forum_post where pid in(".implode(',',$upPid).")");
            foreach($upInfoAry as $reply){
                $message = stripslashes($reply['message']);
                $postmessage = $this->getImgAttachment($reply['pid'],$message);
                //$postmessage = parseQuote($postmessage); //获取上级评论的
                $postmessage = getImg($postmessage);
                $postmessage = parsesmiles2($postmessage);
                $postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
                //$postmessage = getMp3($postmessage); [mp3]音乐地址[/mp3]
                $postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
                $postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
                $postmessage = nl2br($postmessage);
                $postmessage = stripslashes($postmessage);
                $reply['message'] = $postmessage;
                $reply['face'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['authorid']."&size=middle";

                foreach($upPid as $k=>$v){
                    if($v == $reply['pid']){
                        $tmpAry[$k]['upReply'] = $reply;
                        break;
                    }
                }
            }
        }
        $threadReply = array();
        foreach($tmpAry as $reply){
            $threadReply[] = $reply;
        }
        $threadReply = changeCode($threadReply);
        return $threadReply;
    }


    /**
     * 分类信息回复我的
     * @param $start
     * @param $amount
     * @param $type 2分类信息 3 话题
     * @return array|string
     */
    function getThreadReplyMe($start,$amount,$type=2){
        if($type == 2){
            if($start>0){
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_thread.authorid=".$this->G['uid']." and first=0 and invisible>=0 and pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and pid<$start order by pid desc limit 0,$amount";
            }
            else{
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_thread.authorid=".$this->G['uid']." and first=0 and invisible>=0 and pre_forum_thread.fid in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) order by pid desc limit $amount";
            }

        }
        else{
            if($start>0){
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_thread.authorid=".$this->G['uid']." and first=0 and pre_forum_thread.fid not in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and  invisible>=0 and pid<$start order by pid desc limit 0,$amount";
            }
            else{
                $replySql = "SELECT pre_forum_thread.subject,pre_forum_thread.dateline as tdateline, pre_forum_post.pid,pre_forum_post.tid,pre_forum_post.author,pre_forum_post.authorid,pre_forum_post.dateline,pre_forum_post.message FROM `pre_forum_post` left join pre_forum_thread on pre_forum_post.tid=pre_forum_thread.tid where pre_forum_thread.authorid=".$this->G['uid']." and first=0 and pre_forum_thread.fid not in(89,651,161,632,631,630,714,304,643,642,641,142,627,626,625,624,623,622,680,305,677,681,291,653,635,634,633,660,715,716,656,657) and  invisible>=0 order by pid desc limit $amount";
            }

        }

        $result = $this->Db->query($replySql);
        $tmpAry = array();
        while($listTmp = $this->Db->fetch_assoc($result)){
            $tmp = array();
            $tmp['pid'] = $listTmp['pid'];
            $tmp['author'] = $listTmp['author'];
            $tmp['authorid'] = $listTmp['authorid'];
            $tmp['face'] = "http://center.yeeyi.com/avatar.php?uid=".$listTmp['authorid']."&size=middle";
            $tmp['dateline'] = $listTmp['dateline'];
            $tmp['message'] = $listTmp['message'];
            $message = stripslashes($tmp['message']);
            $postmessage = $this->getImgAttachment($tmp['pid'],$message);
            //$postmessage = parseQuote($postmessage); //获取上级评论的
            $postmessage = getImg($postmessage);
            $postmessage = parsesmiles2($postmessage);
            $postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
            //$postmessage = getMp3($postmessage); [mp3]音乐地址[/mp3]
            $postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
            $postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
            $postmessage = nl2br($postmessage);
            $postmessage = stripslashes($postmessage);
            $tmp['message'] = $postmessage;


            $tmp['threadInfo'] = array(
                'tid'=>$listTmp['tid'],
                'subject'=>$listTmp['subject'],
                'pubdate'=>$listTmp['tdateline'],
                'pic'=>'',
            );
            $message = stripslashes($tmp['message']);
            //获取上级的
            preg_match("/\[quote\].*pid=([0-9]+)&ptid.*\[\/quote\]/isU",$message,$uppidAry);
            if($uppidAry[1]>0){
                $upPid[$tmp['pid']] = intval($uppidAry[1]);
            }
            $tmpAry[$tmp['pid']] = $tmp;
        }

        /*if(count($upPid)>0){
            $upInfoAry = $this->Db->fetch_all_assoc("select pid,message,author,authorid,dateline from pre_forum_post where pid in(".implode(',',$upPid).")");
            foreach($upInfoAry as $reply){
                $message = stripslashes($reply['message']);
                $postmessage = $this->getImgAttachment($reply['pid'],$message);
                //$postmessage = parseQuote($postmessage); //获取上级评论的
                $postmessage = getImg($postmessage);
                $postmessage = parsesmiles2($postmessage);
                $postmessage = preg_replace("/\[attach\]\d+\[\/attach\]/i", '', $postmessage);
                //$postmessage = getMp3($postmessage); [mp3]音乐地址[/mp3]
                $postmessage = preg_replace("/\[quote\].*\[\/quote\]/isU",'',$postmessage);
                $postmessage = preg_replace("/\[.*\]/isU",'',$postmessage);
                $postmessage = nl2br($postmessage);
                $postmessage = stripslashes($postmessage);
                $reply['message'] = $postmessage;
                $reply['face'] = "http://center.yeeyi.com/avatar.php?uid=".$reply['authorid']."&size=middle";

                foreach($upPid as $k=>$v){
                    if($v == $reply['pid']){
                        $tmpAry[$k]['upReply'] = $reply;
                        break;
                    }
                }
            }
        }
        */
        $threadReply = array();
        foreach($tmpAry as $reply){
            $threadReply[] = $reply;
        }
        $threadReply = changeCode($threadReply);
        return $threadReply;
    }


    /**
     * @param $start
     * @param $amount
     * @return array|string
     */
    function getTopicReply($start,$amount){
        return array();
    }

    function getImgAttachment($pid,$message){
        if(!empty($pid)){
            $query = $this->Db->query("select aid,tableid from `pre_forum_attachment` where pid=".$pid);
            while($img = $this->Db->fetch_assoc($query)){
                if($img['aid']){
                    $ro = $this->Db->once_fetch_assoc("select attachment from pre_forum_attachment_".$img['tableid']." where aid=".$img['aid']);
                    if($ro){
                        $attachmentUrl = 'http://www.yeeyi.com/bbs/data/attachment/forum/'.$ro['attachment'];
                        $imgStr = "<p style='text-align:center;width:100%;'><img style='width:98%' src='".$attachmentUrl."'></p>";
                        $message = str_replace('[attach]'.$img['aid'].'[/attach]',$imgStr,$message);
                        $message = str_replace('[attachimg]'.$img['aid'].'[/attachimg]',$imgStr,$message);
                    }

                }

            }
        }
        return $message;
    }


}