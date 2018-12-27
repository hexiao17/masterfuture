<?php
namespace app\models\member;

 
/**
 * 生成密码 的工具类
 * @author Administrator
 *
 */
class PasswordUtils  {
     
    
    public static function getSalt($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        $salt = '';
        for ($i = 0; $i < $length; $i ++) {
            $salt .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $salt;
    }
    
    public static function getMd5SaltPassword($password,$salt)
    {
        return md5($password . md5($salt));
    }
    
    public static function verifyPassword($password,$oldPassword,$salt)
    {
        return $oldPassword === self::getMd5SaltPassword($password,$salt);
    }
    
    
    
    
}