<?php

namespace app\modules\admin\controllers;
 
use app\common\services\UrlService;
use app\modules\admin\controllers\common\BaseAdminController;
 
use app\models\member\MemberExtra;

class UserController extends BaseAdminController
{
 

    //登录界面
     public function actionLogin(){
        //如果是get请求，直接展示登录页面
         if(\Yii::$app->request->isGet){
             $this->layout = 'user';
             return $this->render('login');
         }
         //如果是post请求，进行逻辑处理
         $login_name =trim( $this->post('login_name',"") );
         $login_pwd =trim( $this->post('login_pwd',"") );

         if(!$login_name || !$login_pwd){
             return $this->renderJs('请输入正确的用户名和密码~~',UrlService::buildAdminUrl('/user/login'));

         }

         
         //从用户表获取 login_name = $login_name 信息是否存在
         $user_info = MemberExtra::find()->where(['mobile'=>$login_name,'status'=>1])->one();
         if(!$user_info){
             return $this->renderJs('请输入正确的用户名和密码~~',UrlService::buildAdminUrl('/user/login'));
         }

         //校验密码
         //密码加密算法 = md5(login_pwd + md5(login_salt)) 
         if(!$user_info->verifyPassword($login_pwd)){
             return $this->renderJs('请输入正确的用户名和密码~~',UrlService::buildAdminUrl('/user/login'));

         }
         //保持用户的登录状态
         //cookie保存
         //加密字符串 + "#" + uid,加密字符串= md5(login_name +login_pwd + login_salt)         
         $this->setLoginStatus($user_info);

         return $this->redirect(UrlService::buildAdminUrl('/dashboard/index'));
     }
    //编辑当前登录人信息
    public function actionEdit(){
 
        if(\Yii::$app->request->isGet){
            //获取当前登录人的信息           
            return $this->render('edit',['user_info'=>$this->current_user]);
        }
        $nickname = trim( $this->post("nickname",""));
        $email = trim($this->post("email",""));
        if(mb_strlen($nickname,"utf-8")<1){
            return $this->renderJson([],"请输入合法的姓名~~",-1);
        }
        if(mb_strlen($email,"utf-8")<1){
            return $this->renderJson([],"请输入合法的邮箱~~",-1);
        }
        
        $user_info = $this->current_user;
        $user_info->nickname= $nickname;
        $user_info->email = $email;
        $user_info->updated_time = date("Y-m-d H:i:s");
        
        $user_info->update(0);
        return $this->renderJson([],"编辑成功~~");       
    }

    //修改当前登录人的密码
    //这里的访问地址是：reset-pwd
    public function actionResetPwd(){
 
        if(\Yii::$app->request->isGet){
            return $this->render('reset_pwd',['user_info'=>$this->current_user]);
        }
        
        $old_password = trim( $this->post("old_password"));
        $new_password = trim( $this->post("new_password"));
        
        if(mb_strlen($old_password,"utf-8") < 1){
            return $this->renderJson([],"请输入原密码~~",-1);
        }
        if(mb_strlen($new_password,"utf-8") < 6){
            return $this->renderJson([],"请输入不少于6位的新密码~~",-1);
        }
        
        if($old_password == $new_password ){
            return $this->renderJson([],"请重新输入一个吧，新密码和原密码不能一样哦~~",-1);            
        }
        //判断原密码是否正确
        $user_info = $this->current_user;    
        if(!$user_info->verifyPassword($old_password)){
            return $this->renderJson([],"请检查密码是否正确~~",-1);
        }
        
        $user_info->setPassword($new_password);
        $user_info->updated_time = date("Y-m-d H:i:s");
        $user_info->update(0);
        
        //重置登录态
        $this->setLoginStatus($user_info);
        
       return $this->renderJson([],"重置密码成功~~");
    }


    //退出
    public function actionLogout(){
        
        $this->removeLoginStatus();
        return $this->redirect(UrlService::buildAdminUrl("/user/login"));
    }

}
