<?php
namespace app\modules\front\controllers;

 
use app\modules\front\controllers\common\BaseFrontController;

class DefaultController extends BaseFrontController
{
    public function actionIndex() {
        
        
        return $this->render("index");
    }
    
    
}

