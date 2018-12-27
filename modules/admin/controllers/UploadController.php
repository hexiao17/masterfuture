<?php
namespace app\modules\admin\controllers;

use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\UploadService;

class UploadController extends BaseAdminController
{
    private $allow_file_type = ["jpg","gif","jpeg","png"];
    /**
     * 上传接口
     * bucket:avatar/brand/book
     */
    public function actionPic(){
        $bucket = trim($this->post("bucket",""));
        //这里使用子页面的父页面来弹出提示消息（error,success）
        $callback = "window.parent.upload";
        if(!$_FILES || !isset($_FILES['pic'])){
            return "<script>{$callback}.error('请选择文件之后再提交~~')</script>";
        }
        
        //文件类型
        $file_name = $_FILES['pic']['name'];
        $tmp_file_extend = explode(".", $file_name);        
        if(!in_array(strtolower(end($tmp_file_extend)), $this->allow_file_type)){
            return "<script>{$callback}.error('请上传指定类型的图片，类型运行png,gif,jpg,jpeg~~')</script>";
        }
        //上传图片业务逻辑 todo
        $ret = UploadService::uploadByFile($file_name, $_FILES['pic']['tmp_name'],$bucket);
        if(!$ret){
            return "<script>{$callback}.error('".UploadService::getLastErrorMsg()."')</script>";
        }
        
        return "<script>{$callback}.success('{$ret['path']}')</script>";
    }
    
}

