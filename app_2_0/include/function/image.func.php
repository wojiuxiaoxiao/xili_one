<?php
/**
 * Created by PhpStorm.
 * User: bluebat
 * Date: 2016/5/11
 * Time: 14:47
 */
/*
 * 图片缩放函数 thumbImg
 * @param $picPath 图片的物理路径
 * @param $newWidth 新图片的宽度
 * @param $newHeight 新图片的高度
 * @aram @extName 为图片后面追加的比如 _m.jpg _l.jpg
 * 图片输出全部为 jpg格式
 * 图片缩放采用上下或者左右剪切放方式等比缩放
 * */
function thumbImg($picPath,$newWidth,$newHeight,$extName){
    if(!file_exists($picPath)){
        return -2;
    }
    $image = new Imagick($picPath);
    //文件大小，以及中图尺寸
    $width = $image->getimagewidth();
    $height = $image->getimageheight();
    if($width == 0 || $height == 0){
        return -1;//类型不是图片
    }
    $compression_type = Imagick::COMPRESSION_JPEG;
    $image->setImageFormat('jpeg');
    $image->setImageCompression($compression_type);
    //原始比例
    $oldRatio = $width/$height;
    $newRatio = $newWidth/$newHeight;
    if($oldRatio>$newRatio){
        //宽了 以高为准
        $changeRatio = $newHeight/$height;
        $newWidthTmp = $width*$changeRatio;

        $image->thumbnailImage ($newWidthTmp,$newHeight,false); // 不变形新的宽度
        $marginLeft = ($newWidthTmp-$newWidth)/2;//有取消的边缘
        $image->cropImage($newWidth,$newHeight,$marginLeft,0);
    }
    else{
        //高了以宽为准
        $changeRatio = $newWidth/$width;
        $newHeightTmp = $height*$changeRatio;
        $image->thumbnailImage ($newWidth,$newHeightTmp,false); // 不变形新的宽度
        $marginTop = ($newHeightTmp-$newHeight)/2;//有取消的边缘
        $image->cropImage($newWidth,$newHeight,0,$marginTop);
    }
    $write = $image->writeImage($picPath.$extName);
    if($write){
        return '1';
    }
    else {
        return 0;
    }
}

//新闻头条缩略图 _t.jpg 750*380
function thumbTopImg($file,$newPath){
    $dir = date("Y_m_d");
    $dirPath = $newPath."/".$dir;
    if(!is_dir($dirPath)){
        mkdir($dirPath);
        chmod($dirPath,0777);
    }
    $filename = 'newsHot_'.time().'_'.mt_rand(1000,9999);
    $filePath = $dirPath."/".$filename;
    $tmp_name = $file['tmp_name'];
    if(move_uploaded_file($tmp_name,$filePath)){
        $newWidth = 750;
        $newHeight = 380;
        $extName = '_t.jpg';
        $newPath = $filePath.$extName;
        if(thumbImg($filePath,$newWidth,$newHeight,$extName)){
            if(file_exists($newPath)){
                return $newPath;
            }
        }
    }
    return false;
}

//新闻列表图片newslist _nl.jpg 372*280
function thumbNewsListImg($picPath){
    $newWidth = 372;
    $newHeight = 280;
    $extName = '_nl.jpg';
    if(thumbImg($picPath,$newWidth,$newHeight,$extName)){
        return $picPath.$extName;
    }
    return false;
}

//话题图片 _tag.jpg 230*146
function uploadTopic($file,$newPath){
    $dir = date("Y_m_d");
    $dirPath = $newPath."/".$dir;
    if(!is_dir($dirPath)){
        mkdir($dirPath);
        chmod($dirPath,0777);
    }
    $filename = 'topic_'.time().'_'.mt_rand(1000,9999);
    $filePath = $dirPath."/".$filename;
    $tmp_name = $file['tmp_name'];
    if(move_uploaded_file($tmp_name,$filePath)){
        $newWidth = 230;
        $newHeight = 146;
        $extName = '_tag.jpg';
        $newPath = $filePath.$extName;
        if(thumbImg($filePath,$newWidth,$newHeight,$extName)){
            if(file_exists($newPath)){
                return $newPath;
            }
        }
    }
    return false;
}

function uploadHotTopic($file,$newPath){
    $dir = date("Y_m_d");
    $dirPath = $newPath."/".$dir;
    if(!is_dir($dirPath)){
        mkdir($dirPath);
        chmod($dirPath,0777);
    }
    $filename = 'topic_'.time().'_'.mt_rand(1000,9999);
    $filePath = $dirPath."/".$filename;
    $tmp_name = $file['tmp_name'];
    if(move_uploaded_file($tmp_name,$filePath)){
        $newWidth = 300;
        $newHeight = 300;
        $extName = '_tagHot.jpg';
        $newPath = $filePath.$extName;
        if(thumbImg($filePath,$newWidth,$newHeight,$extName)){
            if(file_exists($newPath)){
                return $newPath;
            }
        }
    }
    return false;
}


//本地生活信息 _life  500*500
function thumbThreadListImg($picPath){
    $newWidth = 500;
    $newHeight = 500;
    $extName = '_thread.jpg';
    if(thumbImg($picPath,$newWidth,$newHeight,$extName)){
        return $picPath.$extName;
    }
    return false;
}







