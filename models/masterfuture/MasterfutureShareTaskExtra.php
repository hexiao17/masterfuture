<?php
namespace app\models\masterfuture;

use app\models\masterfuture\MasterfutureShareTask;
use app\models\member\MemberExtra;

class MasterfutureShareTaskExtra extends MasterfutureShareTask
{
    
    //user
    public function getUser() {
        return $this->hasOne(MemberExtra::className(), ['id'=>'created_user'])->select(['nickname','avatar']);
    }
}

