<?php
namespace app\models\equipment;

use app\models\equipment\EquipmentOrderReply;
use app\models\member\MemberExtra;

class EquipmentOrderReplyExtra extends EquipmentOrderReply
{
    
    
    
    
    //关联关系
    public function getCreater() {
       return $this->hasOne(MemberExtra::className(), ['id'=>'user_id']) ;
    }
    
    public function getOrder(){
        return $this->hasOne(EquipmentOrderExtra::className(), ['order_id'=>'id']);
    }
    
}

