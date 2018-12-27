<?php
namespace app\models\flow;

use app\models\flow\FlowStep;
use app\models\member\MemberExtra;

class FlowStepExtra extends FlowStep
{
    public function getCreater() {
        return $this->hasOne(MemberExtra::className(), ['id'=>'user_id']);
    }
    
    public function getFlow() {
        return $this->hasOne(FlowExtra::className(), ['flow_id'=>'id']);
    }
}

