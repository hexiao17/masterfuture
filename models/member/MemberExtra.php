<?php
namespace app\models\member;

use app\models\member\Member;
use app\models\role\Role;
use app\models\role\RoleExtra;
use app\models\masterfuture\MasterfutureCategoryExtra;
 

class MemberExtra extends Member
{
    
    
    public function setSalt( $length = 16 ){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        $salt = '';
        for ( $i = 0; $i < $length; $i++ ){
            $salt .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $this->salt = $salt;
    }
    
    public function setPassword( $password ) {
        
        $this->login_pwd = $this->getSaltPassword($password);
    }
    public function getSaltPassword($password) {
        return md5( $password.md5( $this->salt ) );
    }
    
    
    public function verifyPassword($password) {
        return $this->login_pwd === $this->getSaltPassword($password);
    }
    
    //关联关系
    public function getRole() {
       return $this->hasOne(RoleExtra::className(), ['id'=>'role_id']) ;
    }
    
    //
    public function getDefaultCate() {
        $cate =$this->hasMany(MasterfutureCategoryExtra::className(), ['user_id'=>'id'])
        ->orderBy(['id'=>SORT_ASC])->one()      ; 
        return $cate;
    }
    
    
    
   
    
}

