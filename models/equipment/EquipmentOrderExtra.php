<?php
namespace app\models\equipment; 
use app\models\member\MemberExtra;
use app\models\Organize;
use app\models\flow\FlowExtra;
use app\models\flow\FlowStepExtra;

class EquipmentOrderExtra extends EquipmentOrder
{
    //关联关系
    public function getCreater() {
        return $this->hasOne(MemberExtra::className(), ['id'=>'user_id']);
    }
    
    public function getOrg() {
        return $this->hasOne(Organize::className(), ['id'=>'org_id']);
    }
    
    public function getEquipdetail() {
        return $this->hasOne(EquipmentDetailExtra::className(), ['id'=>'equip_detail_id']);
    }
    
    //取得所有回复
    public function getReplys($statu) {
        return $this->hasMany(EquipmentOrderReplyExtra::className(), ['order_id'=>'id'])
        ->where('statu = :statu', [':statu' => $statu]);
    }
    
    //取得状态列表
    public function getFlowList() {
        
        $flow = $this->hasOne(FlowExtra::className(), ['id'=>'flow_id'])->one();
        $flow_steps = $this->hasMany(FlowStepExtra::className(), ['flow_id'=>'flow_id'])
                        ->orderBy(['step'=>SORT_ASC])->all();
        $ul_str = "<div>[<strong>".$flow->title."</strong>]";
        $li_str="";
        foreach ($flow_steps as $step){            
            $mark = ($this->flow_step == $step->step) ? 'now_step':'';
            $li_str =$li_str. "-><a href='#' class='".$mark."'>".$step->name."</a>";
        }
        
        $ul_str .=$li_str."</div>";
        
        return $ul_str;
    }
    
    
    public function getFlowBeauty() {
        
        $flow = $this->hasOne(FlowExtra::className(), ['id'=>'flow_id'])->one();
        $flow_steps = $this->hasMany(FlowStepExtra::className(), ['flow_id'=>'flow_id'])
        ->orderBy(['step'=>SORT_ASC])->all();
        $ul_str = " ";
        $li_str='<div class="weui-flex"> ';
        foreach ($flow_steps as $step){
            $mark = ($this->flow_step == $step->step) ? 'now_step':'';
            $li_str =$li_str. '<div class="weui-flex__item"><div class="placeholder '.$mark.'  ">'.$step->name.'</div></div>';
        }
        
        $ul_str .=$li_str.' </div>';
        
        return $ul_str;
        
        
      
    }
    public function getFlow() {
        return $this->hasOne(FlowExtra::className(), ['id'=>flow_id]);
    }
    
    public function getNextStep($step) {
        return $this->hasMany(FlowStepExtra::className(), ['flow_id'=>'flow_id'])
        ->where('step>:step',[':step'=>$step])
        ->orderBy(['step'=>SORT_ASC])->one();
    }
    
}

