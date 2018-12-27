<?php
namespace app\models\flow;

use app\models\flow\Flow;
use app\models\member\MemberExtra;

class FlowExtra extends Flow
{
    public function getCreater() {
        return $this->hasOne(MemberExtra::className(), ['id'=>'user_id']);
    }
    
    public function getSteps($statu) {
        return $this->hasMany(FlowStepExtra::className(), ['flow_id'=>'id'])
                    ->where('statu=:statu',[':statu'=>$statu])
                    ->orderBy(['step'=>SORT_ASC]);
    }
    
    
    
    public function getNextStep($step) {
       return $this->hasMany(FlowStepExtra::className(), ['flow_id'=>'id'])
               ->where('step>:step',[':step'=>$step])
               ->orderBy(['step'=>SORT_ASC])->one();
    }
    
    
    public function getFirstStep() {
        return $this->hasMany(FlowStepExtra::className(), ['flow_id'=>'id'])
                    ->orderBy(['step'=>SORT_ASC])->one();
    }
    
    
}

