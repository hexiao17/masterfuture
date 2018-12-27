<?php
namespace app\common\services;

use yii\helpers\Html;

//只封装通用方法
class UtilService
{
    //取得真是IP地址
    public static function getIP(){
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }
    /**
     *  对用户输入的信息编码
     *  防止XSS攻击
     *  使用HMTL/helpers
     * @param  $display
     */
    public static function encode($display){
        
        return Html::encode($display);
    }
    
    public static function encodeModel($model){
        foreach ($model as $name=>$value){
            $model->$name = self::encode($value);
        }
        
        return $model;
    }
    
    
    /**
     * html过滤
     *
     * @param array|object $_date
     * @return string
     *
     */
    static public function htmlString($_date)
    {
        if (is_array($_date)) {
            foreach ($_date as $_key => $_value) {
                $_string[$_key] = self::htmlString($_value); // 递归
            }
        } elseif (is_object($_date)) {
            foreach ($_date as $_key => $_value) {
                $_string->$_key = self::htmlString($_value); // 递归
            }
        } else {
            $_string = htmlspecialchars($_date);
        }
        return $_string;
    }
    /**
     * 数据库输入过滤
     *
     * @param string $_data
     * @return string
     *
     */
    static public function mysqlString($_data)
    {
        $_data = trim($_data);
        return ! GPC ? addcslashes($_data) : $_data;
    }
    
    /**
     * 字符截取
     *
     * @param $string
     * @param $length
     * @param $dot  
     */
    public static function cutstr( $string, $length, $dot = '...', $charset = 'utf-8' ) {
        if ( strlen( $string ) <= $length )
            return $string;
             
            //防止出现中文乱码
            $pre = chr( 1 );
            $end = chr( 1 );
            //替换字符串中的 &,",<,>
            $string = str_replace( array ( '&amp;' , '&quot;' , '&lt;' , '&gt;' ), array ( $pre . '&' . $end , $pre . '"' . $end , $pre . '<' . $end , $pre . '>' . $end ), $string );
    
            $strcut = '';
            if ( strtolower( $charset ) == 'utf-8' ) {
    
                $n = $tn = $noc = 0;
                while ( $n < strlen( $string ) ) {
    
                    $t = ord( $string[$n] );
                    if ( $t == 9 || $t == 10 || ( 32 <= $t && $t <= 126 ) ) {
                        $tn = 1;
                        $n ++;
                        $noc ++;
                    } elseif ( 194 <= $t && $t <= 223 ) {
                        $tn = 2;
                        $n += 2;
                        $noc += 2;
                    } elseif ( 224 <= $t && $t <= 239 ) {
                        $tn = 3;
                        $n += 3;
                        $noc += 2;
                    } elseif ( 240 <= $t && $t <= 247 ) {
                        $tn = 4;
                        $n += 4;
                        $noc += 2;
                    } elseif ( 248 <= $t && $t <= 251 ) {
                        $tn = 5;
                        $n += 5;
                        $noc += 2;
                    } elseif ( $t == 252 || $t == 253 ) {
                        $tn = 6;
                        $n += 6;
                        $noc += 2;
                    } else {
                        $n ++;
                    }
    
                    if ( $noc >= $length ) {
                        break;
                    }
    
                }
                if ( $noc > $length ) {
                    $n -= $tn;
                }
    
                $strcut = substr( $string, 0, $n );
    
            } else {
                for ( $i = 0; $i < $length; $i ++ ) {
                    $strcut .= ord( $string[$i] ) > 127 ? $string[$i] . $string[++ $i] : $string[$i];
                }
            }
            //再把字符串中的符号替换回来
            $strcut = str_replace( array ( $pre . '&' . $end , $pre . '"' . $end , $pre . '<' . $end , $pre . '>' . $end ), array ( '&amp;' , '&quot;' , '&lt;' , '&gt;' ), $strcut );
    
            $pos = strrpos( $strcut, chr( 1 ) );
            if ( $pos !== false ) {
                $strcut = substr( $strcut, 0, $pos );
            }
             
            return $strcut . $dot;
    }
    
     
    /*
     * 返回 系统跟路径
     * 带盘符
     */
    public static function getRootPath(){
        return  dirname(\yii::$app->vendorPath);
    }
     
    /**
     * 是否微信
     */
    public static  function isWechat(){
        $ug= isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
        if( stripos($ug,'micromessenger') !== false ){
            return true;
        }
        return false;
    }
    
    
    /**
     * 把时间字符串转换成指定的格式
     * @param  $str  
     * @param  $format 转换成的格式()
     * @return string
     */
    public static function str2DateFormate($str,$format){
        $time = strtotime($str);
        return date($format,$time);
    }
    
    
    /**
     * 当前微秒数
     *
     * @return number
     *
     */
    public static function microtime_float()
    {
        list ($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }
    
    
    /**
     * 判断字符串是utf-8 还是gb2312
     *
     * @param  $str
     * @param string $default
     * @return string
     *
     */
    public static function utf8_gb2312($str, $default = 'gb2312')
    {
        $str = preg_replace("/[\x01-\x7F]+/", "", $str);
        if (empty($str))
            return $default;
    
            $preg = array(
                "gb2312" => "/^([\xA1-\xF7][\xA0-\xFE])+$/", // 正则判断是否是gb2312
                "utf-8" => "/^[\x{4E00}-\x{9FA5}]+$/u"
            ) // 正则判断是否是汉字(utf8编码的条件了)，这个范围实际上已经包含了繁体中文字了
            ;
    
            if ($default == 'gb2312') {
                $option = 'utf-8';
            } else {
                $option = 'gb2312';
            }
    
            if (! preg_match($preg[$default], $str)) {
                return $option;
            }
            $str = @iconv($default, $option, $str);
    
            // 不能转成 $option, 说明原来的不是 $default
            if (empty($str)) {
                return $option;
            }
            return $default;
    }
    
    
    /**
     * utf-8和gb2312自动转化
     *
     * @param  $string
     * @param string $outEncoding
     * @return |string
     *
     */
    public static function safeEncoding($string, $outEncoding = 'UTF-8')
    {
        $encoding = "UTF-8";
        for ($i = 0; $i < strlen($string); $i ++) {
            if (ord($string{$i}) < 128)
                continue;
    
                if ((ord($string{$i}) & 224) == 224) {
                    // 第一个字节判断通过
                    $char = $string{++ $i};
                    if ((ord($char) & 128) == 128) {
                        // 第二个字节判断通过
                        $char = $string{++ $i};
                        if ((ord($char) & 128) == 128) {
                            $encoding = "UTF-8";
                            break;
                        }
                    }
                }
                if ((ord($string{$i}) & 192) == 192) {
                    // 第一个字节判断通过
                    $char = $string{++ $i};
                    if ((ord($char) & 128) == 128) {
                        // 第二个字节判断通过
                        $encoding = "GB2312";
                        break;
                    }
                }
        }
    
        if (strtoupper($encoding) == strtoupper($outEncoding))
            return $string;
            else
                return @iconv($encoding, $outEncoding, $string);
    }
    
    /**
     * 判断 文件/目录 是否可写（取代系统自带的 is_writeable 函数）
     *
     * @param string $file
     *            文件/目录
     * @return boolean
     *
     */
    public static function is_writeable($file)
    {
        if (is_dir($file)) {
            $dir = $file;
            if ($fp = @fopen("$dir/test.txt", 'w')) {
                @fclose($fp);
                @unlink("$dir/test.txt");
                $writeable = 1;
            } else {
                $writeable = 0;
            }
        } else {
            if ($fp = @fopen($file, 'a+')) {
                @fclose($fp);
                $writeable = 1;
            } else {
                $writeable = 0;
            }
        }
    
        return $writeable;
    }
    
    /**
     * 对字符串 加密或者解密
     * @param string $string
     *            原文或者密文
     * @param string $operation
     *            操作(ENCODE | DECODE), 默认为 DECODE
     * @param string $key
     *            密钥
     * @param int $expiry
     *            密文有效期, 加密时候有效， 单位 秒，0 为永久有效
     * @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
     *
     * @example $a = authcode('abc', 'ENCODE', 'key');
     *          $b = authcode($a, 'DECODE', 'key'); // $b(abc)
     *
     *          $a = authcode('abc', 'ENCODE', 'key', 3600);
     *          $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
     *
     */
    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 3600)
    {
        $ckey_length = 4;
        // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大po,jie难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥
    
        $key = md5($key ? $key : 'key'); // 这里可以填写默认key值
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), - $ckey_length)) : '';
    
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);
    
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);
    
        $result = '';
        $box = range(0, 255);
    
        $rndkey = array();
        for ($i = 0; $i <= 255; $i ++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
    
        for ($j = $i = 0; $i < 256; $i ++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
    
        for ($a = $j = $i = 0; $i < $string_length; $i ++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
    
        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
    /**
     * 删除文件
     *
     * @param string $filename
     *
     */
    static public function delFile($filename)
    {
        if (file_exists($filename))
            unlink($filename);
    }
    /**
     * 删除目录
     *
     * @param string $path
     *
     */
    public static function delDir($path)
    {
        if (is_dir($path))
            rmdir($path);
    }
    
    /**
     * 删除目录及地下的全部文件
     *
     * @param string $dir
     * @return bool
     *
     */
    static public function delDirOfAll($dir)
    {
        // 先删除目录下的文件：
        if (is_dir($dir)) {
            $dh = opendir($dir);
            while (! ! $file = readdir($dh)) {
                if ($file != "." && $file != "..") {
                    $fullpath = $dir . "/" . $file;
                    if (! is_dir($fullpath)) {
                        unlink($fullpath);
                    } else {
                        self::delDirOfAll($fullpath);
                    }
                }
            }
            closedir($dh);
            // 删除当前文件夹：
            if (rmdir($dir)) {
                return true;
            } else {
                return false;
            }
        }
    }
    /**
     * 给已经存在的图片添加水印
     *
     * @param string $file_path
     * @return bool
     *
     */
    static public function addMark($file_path)
    {
        if (file_exists($file_path) && file_exists(MARK)) {
            // 求出上传图片的名称后缀
            $ext_name = strtolower(substr($file_path, strrpos($file_path, '.'), strlen($file_path)));
            // $new_name='jzy_' . time() . rand(1000,9999) . $ext_name ;
            $store_path = ROOT_PATH . UPDIR;
            // 求上传图片高宽
            $imginfo = getimagesize($file_path);
            $width = $imginfo[0];
            $height = $imginfo[1];
            // 添加图片水印
            switch ($ext_name) {
                case '.gif':
                    $dst_im = imagecreatefromgif($file_path);
                    break;
                case '.jpg':
                    $dst_im = imagecreatefromjpeg($file_path);
                    break;
                case '.png':
                    $dst_im = imagecreatefrompng($file_path);
                    break;
            }
            $src_im = imagecreatefrompng(MARK);
            // 求水印图片高宽
            $src_imginfo = getimagesize(MARK);
            $src_width = $src_imginfo[0];
            $src_height = $src_imginfo[1];
            // 求出水印图片的实际生成位置
            $src_x = $width - $src_width - 10;
            $src_y = $height - $src_height - 10;
            // 新建一个真彩色图像
            $nimage = imagecreatetruecolor($width, $height);
            // 拷贝上传图片到真彩图像
            imagecopy($nimage, $dst_im, 0, 0, 0, 0, $width, $height);
            // 按坐标位置拷贝水印图片到真彩图像上
            imagecopy($nimage, $src_im, $src_x, $src_y, 0, 0, $src_width, $src_height);
            // 分情况输出生成后的水印图片
            switch ($ext_name) {
                case '.gif':
                    imagegif($nimage, $file_path);
                    break;
                case '.jpg':
                    imagejpeg($nimage, $file_path);
                    break;
                case '.png':
                    imagepng($nimage, $file_path);
                    break;
            }
            // 释放资源
            imagedestroy($dst_im);
            imagedestroy($src_im);
            unset($imginfo);
            unset($src_imginfo);
            // 移动生成后的图片
            @move_uploaded_file($file_path, ROOT_PATH . UPDIR . $file_path);
        }
    }
    /**
     * 图片等比例缩放
     *
     * @param resource $im
     *            新建图片资源(imagecreatefromjpeg/imagecreatefrompng/imagecreatefromgif)
     * @param int $maxwidth
     *            生成图像宽
     * @param int $maxheight
     *            生成图像高
     * @param string $name
     *            生成图像名称
     * @param string $filetype文件类型(.jpg/.gif/.png)
     *
     */
    static public function resizeImage($im, $maxwidth, $maxheight, $name, $filetype)
    {
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);
        if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
            if ($maxwidth && $pic_width > $maxwidth) {
                $widthratio = $maxwidth / $pic_width;
                $resizewidth_tag = true;
            }
            if ($maxheight && $pic_height > $maxheight) {
                $heightratio = $maxheight / $pic_height;
                $resizeheight_tag = true;
            }
            if ($resizewidth_tag && $resizeheight_tag) {
                if ($widthratio < $heightratio)
                    $ratio = $widthratio;
                    else
                        $ratio = $heightratio;
            }
            if ($resizewidth_tag && ! $resizeheight_tag)
                $ratio = $widthratio;
                if ($resizeheight_tag && ! $resizewidth_tag)
                    $ratio = $heightratio;
                    $newwidth = $pic_width * $ratio;
                    $newheight = $pic_height * $ratio;
                    if (function_exists("imagecopyresampled")) {
                        $newim = imagecreatetruecolor($newwidth, $newheight);
                        imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
                    } else {
                        $newim = imagecreate($newwidth, $newheight);
                        imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
                    }
                    $name = $name . $filetype;
                    imagejpeg($newim, $name);
                    imagedestroy($newim);
        } else {
            $name = $name . $filetype;
            imagejpeg($im, $name);
        }
    }
    
    /**
     * 下载文件
     *
     * @param string $file_path
     *            绝对路径
     *
     */
    static public function downFile($file_path)
    {
        // 判断文件是否存在
        $file_path = iconv('utf-8', 'gb2312', $file_path); // 对可能出现的中文名称进行转码
        if (! file_exists($file_path)) {
            exit('文件不存在！');
        }
        $file_name = basename($file_path); // 获取文件名称
        $file_size = filesize($file_path); // 获取文件大小
        $fp = fopen($file_path, 'r'); // 以只读的方式打开文件
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: {$file_size}");
        header("Content-Disposition: attachment;filename={$file_name}");
        $buffer = 1024;
        $file_count = 0;
        // 判断文件是否结束
        while (! feof($fp) && ($file_size - $file_count > 0)) {
            $file_data = fread($fp, $buffer);
            $file_count += $buffer;
            echo $file_data;
        }
        fclose($fp); // 关闭文件
    }
    
    /**
     * 邮件发送
     *
     * @param string $toemail
     * @param string $subject
     * @param string $message
     * @return boolean
     *
     */
    public static function sendMail($toemail = '', $subject = '', $message = '')
    {
//         $mailer = \Yii::createComponent('application.extensions.mailer.EMailer');
    
//         // 邮件配置
//         $mailer->SetLanguage('zh_cn');
//         $mailer->Host = \Yii::app()->params['emailHost']; // 发送邮件服务器
//         $mailer->Port = \Yii::app()->params['emailPort']; // 邮件端口
//         $mailer->Timeout = \Yii::app()->params['emailTimeout']; // 邮件发送超时时间
//         $mailer->ContentType = 'text/html'; // 设置html格式
//         $mailer->SMTPAuth = true;
//         $mailer->Username = Yii::app()->params['emailUserName'];
//         $mailer->Password = Yii::app()->params['emailPassword'];
//         $mailer->IsSMTP();
//         $mailer->From = $mailer->Username; // 发件人邮箱
//         $mailer->FromName = Yii::app()->params['emailFormName']; // 发件人姓名
//         $mailer->AddReplyTo($mailer->Username);
//         $mailer->CharSet = 'UTF-8';
    
//         // 添加邮件日志
//         $modelMail = new MailLog();
//         $modelMail->accept = $toemail;
//         $modelMail->subject = $subject;
//         $modelMail->message = $message;
//         $modelMail->send_status = 'waiting';
//         $modelMail->save();
//         // 发送邮件
//         $mailer->AddAddress($toemail);
//         $mailer->Subject = $subject;
//         $mailer->Body = $message;
    
//         if ($mailer->Send() === true) {
//             $modelMail->times = $modelMail->times + 1;
//             $modelMail->send_status = 'success';
//             $modelMail->save();
//             return true;
//         } else {
//             $error = $mailer->ErrorInfo;
//             $modelMail->times = $modelMail->times + 1;
//             $modelMail->send_status = 'failed';
//             $modelMail->error = $error;
//             $modelMail->save();
//             return false;
//         }
    }
    
    /**
     * 对象转换成map
     */
    public static function Objects2Map($objs,$key,$value){
        $arr ;
        foreach ($objs as $obj){
            
            $arr[$obj->$key] = $obj->$value;
             
        }
        
        return $arr;
    }
    /**
     * 计算开始和结束之间差多少天
     * @param string $start
     * @param string $end
     
     * @return number
     */
    public static function DateMath($start="",$end="",$type){
        
        $tmp1 = $start ?strtotime($start): time();
        
        $tmp2 = $end?strtotime($start):time();
        
        if($type = 'year'){
            return intval(($tmp2-$tmp1)/(3600*24*360));
        }
        if($type == 'day'){
            return intval(($tmp2-$tmp1)/(3600*24));
        }
        
        
    }
    
    /**
     * 友好的时间显示
     *
     * @param int    $sTime 待显示的时间
     * @param string $type  类型. normal | mohu | full | ymd | other
     * @param string $alt   已失效
     * @return string
     */
    static function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
        if (!$sTime)
            return '';
            //sTime=源时间，cTime=当前时间，dTime=时间差
            $cTime      =   time();
            $dTime      =   $cTime - $sTime;
            $dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
            
            //$dDay     =   intval($dTime/3600/24);
            $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
            //normal：n秒前，n分钟前，n小时前，日期
            if($type=='normal'){
                if( $dTime < 60 ){
                    if($dTime < 10){
                        return '刚刚';    //by yangjs
                    }else{
                        return intval(floor($dTime / 10) * 10)."秒前";
                    }
                }elseif( $dTime < 3600 ){
                    return intval($dTime/60)."分钟前";
                    //今天的数据.年份相同.日期相同.
                }elseif( $dYear==0 && $dDay == 0  ){
                    //return intval($dTime/3600)."小时前";
                    return '今天'.date('H:i',$sTime);
                }elseif($dYear==0){
                    return date("m月d日 H:i",$sTime);
                }else{
                    return date("Y-m-d H:i",$sTime);
                }
            }elseif($type=='mohu'){
                if( $dTime < 60 ){
                    return $dTime."秒前";
                }elseif( $dTime < 3600 ){
                    return intval($dTime/60)."分钟前";
                }elseif( $dTime >= 3600 && $dDay == 0  ){
                    return intval($dTime/3600)."小时前";
                }elseif( $dDay > 0 && $dDay<=7 ){
                    return intval($dDay)."天前";
                }elseif( $dDay > 7 &&  $dDay <= 30 ){
                    return intval($dDay/7) . '周前';
                }elseif( $dDay > 30 ){
                    return intval($dDay/30) . '个月前';
                }
                //full: Y-m-d , H:i:s
            }elseif($type=='full'){
                return date("Y-m-d , H:i:s",$sTime);
            }elseif($type=='ymd'){
                return date("Y-m-d",$sTime);
            }else{
                if( $dTime < 60 ){
                    return $dTime."秒前";
                }elseif( $dTime < 3600 ){
                    return intval($dTime/60)."分钟前";
                }elseif( $dTime >= 3600 && $dDay == 0  ){
                    return intval($dTime/3600)."小时前";
                }elseif($dYear==0){
                    return date("Y-m-d H:i:s",$sTime);
                }else{
                    return date("Y-m-d H:i:s",$sTime);
                }
            }
    }
}

