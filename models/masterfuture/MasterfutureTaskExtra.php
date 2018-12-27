<?php
namespace app\models\masterfuture;

use app\models\masterfuture\MasterfutureTask;
use app\models\member\MemberExtra;

class MasterfutureTaskExtra extends MasterfutureTask
{
    
    //
    //cate
    public function getCate() {
        return $this->hasOne(MasterfutureCategoryExtra::className() , ['id'=>'cate_id']);
    }
    
    //user
    public function getUser() {
        return $this->hasOne(MemberExtra::className(), ['id'=>'user_id'])->select(['nickname','avatar']);
    }
    
   
    
    
}

