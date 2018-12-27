<?php
namespace app\models\masterfuture;

use app\models\masterfuture\MasterfutureShareTaskReply;

class MasterfutureShareTaskReplyExtra extends MasterfutureShareTaskReply
{
    
    
    public function getShare() {
        return $this->hasOne(MasterfutureShareTaskExtra::className(), ['id'=>'share_id']);
    }
    
}

