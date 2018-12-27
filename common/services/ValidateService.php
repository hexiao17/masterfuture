<?php

 namespace app\common\services;
/**
 * 校验工具类
 * echo ValidateService::isMobile('1510189000');
 * @author hhs
 *
 */
 class ValidateService {
    
     public static  $mobile = "/^(13|15|18|17|16)[0-9]{9}$/";
     
     public static $codeAndMobile = "/^\\+[0-9]{2}\\-(13|15|18|17|16)[0-9]{9}$/";
     
     /**整数*/
     public  static $intege="/^-?[1-9]\\d*$/";
     /** 正整数*/
     public static $intege1="/^[1-9]\\d*$/";
     /** 负整数*/
     public static $intege2="/^-[1-9]\\d*$/";
     /** 数字*/
     public static $num="/^([+-]?)\\d*\\.?\\d+$/";
     /** 正数（正整数 + 0）*/
     public static $num1="/^[1-9]\\d*|0$/";
     /** 负数（负整数 + 0）*/
     public static $num2="/^-[1-9]\\d*|0$/";
     /** 浮点数*/
     public static $decmal="/^([+-]?)\\d*\\.\\d+$/";
     /** 正浮点数*/
     public static $decmal1="/^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*$/";
     /** 负浮点数*/
     public static $decmal2="/^-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*)$/";
     /** 浮点数*/
     public static $decmal3="/^-?([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0)$/";
     /** 非负浮点数（正浮点数 + 0）*/
     public static $decmal4="/^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0$/";
     /**非正浮点数（负浮点数 + 0） */
     public static $decmal5="/^(-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*))|0?.0+|0$/";
     /** 邮件*/
     public static $email="/^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$/";
     /** 颜色*/
     public static $color="/^[a-fA-F0-9]{6}$/";
     /** url*/
     public static $url="/^http[s]?=\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&=]*)?$/";
     /** 仅中文*/
     public static $chinese="/^[\\u4E00-\\u9FA5\\uF900-\\uFA2D]+$/";
     /** 仅ACSII字符*/
     public static $ascii="/^[\\x00-\\xFF]+$/";
     /**邮编 */
     public static $zipcode="/^\\d{6}$/";
     /** ip地址*/
     public static $ip4="/^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$/";
     /** 非空*/
     public static $notempty="/^\\S+$/";
     /**图片 */
     public static $picture="(.*)\\.(jpg|bmp|gif|ico|pcx|jpeg|tif|png|raw|tga)$/";
     /** 压缩文件*/
     public static $rar="(.*)\\.(rar|zip|7zip|tgz)$/";
     /** 日期*/
     public static $date="/^\\d{4}(\\-|\\/|\\.)\\d{1,2}\\1\\d{1,2}$/";
     /** QQ号码*/
     public static $qq="/^[1-9]*[1-9][0-9]*$/";
     /** 电话号码的函数(包括验证国内区号;国际区号;分机号)*/
     public static $tel="/^(([0\\+]\\d{2,3}-)?(0\\d{2,3})-)?(\\d{7,8})(-(\\d{1,}))?$/";
     /** 用来用户注册。匹配由数字、26个英文字母或者下划线组成的字符串*/
     public static $username="/^\\w+$/";
     /** 字母*/
     public static $letter="/^[A-Za-z]+$/";
     public static $letterAndSpace="/^[A-Za-z ]+$/";
     /** 大写字母*/
     public static $letter_u="/^[A-Z]+$/";
     /** 小写字母*/
     public static $letter_l="/^[a-z]+$/";
     /** 身份证*/
     public static $idcard="/^[1-9]([0-9]{14}|[0-9]{17})$/";
     /**判断字符串是否为浮点数*/
     public static $isFloat="/^[-]?\\d+(\\.\\d+)?$/";
     /**判断字符串是否为正浮点数*/
     public static $isUFloat="/^\\d+(\\.\\d+)?$/";
     /**判断是否是整数*/
     public static $isInteger="/^[-]?\\d+$/";
     /**判断是否是正整数*/
     public static $isUInteger="/^\\d+$/";
     /**判断车辆Vin码*/
     public static $isCarVin="/^[1234567890WERTYUPASDFGHJKLZXCVBNM]{13}[0-9]{4}$/";
     /** 手机号 */
     public static function isMobile($input){
         return preg_match(self::$mobile, $input);
     }
     public static function isCodeAndMobile($input){
         return preg_match(self::$codeAndMobile , $input);
     }
     /** 整数 */
     public static function isIntege($input){
         return preg_match(self::$intege, $input);
     }
     /** 正整数 */
     public static function isintege1($input){
         return preg_match(self::$intege1, $input);
     }
     /** 负整数*/
     public static function isIntege2($input){
         return preg_match(self::$intege2, $input);
     }
     /** 数字 */
     public static function isNum($input){
         return preg_match(self::$num, $input);
     }
     /** 正数（正整数 + 0） */
     public static function isNum1($input){
         return preg_match(self::$num1,$input);
     }
     /** 负数（负整数 + 0）*/
     public static function isNum2($input){
         return preg_match(self::$num2,$input);
     }
     /** 浮点数*/
     public static function isDecmal($input){
         return preg_match(self::$decmal, $input);
     }
     /** 正浮点数*/
     public static function isDecmal1($input){
         return preg_match(self::$decmal1, $input);
     }
     /** 负浮点数*/
     public static function isDecmal2($input){
         return preg_match(self::$decmal2, $input);
     }
     /**浮点数 */
     public static function isDecmal3($input){
         return preg_match(self::$decmal3, $input);
     }
     /** 非负浮点数（正浮点数 + 0）*/
     public static function isDecmal4($input){
         return preg_match(self::$decmal4, $input);
     }
     /** 非正浮点数（负浮点数 + 0）*/
     public static function isDecmal5($input){
         return preg_match(self::$decmal5, $input);
     }
     /** 邮件*/
     public static function isEmail($input){
         return preg_match(self::$email,$input);
     }
     /** 颜色*/
     public static function isColor($input){
         return preg_match(self::$color, $input);
     }
     /** url*/
     public static function isUrl($input){
         return preg_match(self::$url,$input);
     }
     /** 中文*/
     public static function isChinese($input){
         return preg_match(self::$chinese,$input);
     }
     /** ascii码*/
     public static function isAscii($input){
         return preg_match(self::$ascii, $input);
     }
     /** 邮编*/
     public static function isZipcode($input){
         return preg_match(self::$zipcode, $input);
     }
     /** IP地址*/
     public static function isIP4($input){
         return preg_match(self::$ip4, $input);
     }
     /** 非空*/
     public static function isNotEmpty($input){
         return preg_match(self::$notempty,$input);
     }
     /** 图片*/
     public static function isPicture($input){
         return preg_match(self::$picture, $input);
     }
     /** 压缩文件*/
     public static function isRar($input){
         return preg_match(self::$rar, $input);
     }
     /** 日期*/
     public static function isDate($input){
         return preg_match(self::$date, $input);
     }
     /** qq*/
     public static function isQQ($input){
         return preg_match(self::$qq, $input);
     }
     /** 电话号码的函数(包括验证国内区号;国际区号;分机号)*/
     public static function isTel($input){
         return preg_match(self::$tel, $input);
     }
     /** 用来用户注册。匹配由数字、26个英文字母或者下划线组成的字符串*/
     public static function isUserName($input){
         return preg_match(self::$username,$input);
     }
     /**字母*/
     public static function isLetter($input){
         return preg_match(self::$letter, $input);
     }
     public static function isLetterAndSpace($input){
         return preg_match(self::$letterAndSpace, $input);
     }
     /** 小写字母*/
     public static function isLowLetter($input){
         return preg_match(self::$letter_l,$input);
     }
     /** 大写字母*/
     public static function isUpperLetter($input){
         return preg_match(self::$letter_u,$input);
     }
     /** 身份证*/
     public static function isIDCard($input){
         return preg_match(self::$idcard,$input);
     }
     public static function isFloat($input){
         return preg_match(self::$isFloat,$input);
     }
     public static function isUFloat($input){
         return preg_match(self::$isUFloat,$input);
     }
     public static function isInteger($input){
         return preg_match(self::$isInteger,$input);
     }
     public static function isUInteger($input){
         return preg_match(self::$isUInteger,$input);
     }
     
     public static function isCarVin($carVin){
         return preg_match(self::$isCarVin,$carVin);
     }
     /** 字符串长度      */
     public static function strLength($input,$max,$min) {
        return mb_strlen($input,"utf-8")>=$min &&  mb_strlen($input,"utf-8")<=$max;
     }
     
     public static function inIntArr($input,$intArr) {
         return  in_array($input, $intArr);
     }
     /**
                * 自定义规则    
      */
     public static function preg_match($regex,$input){
         if(StringUtils.isBlank($input)) return false;
         if(input.preg_match($regex))return true;
         return false;
     }
 
 }
 
 //echo ValidateService::isMobile('1510189000');