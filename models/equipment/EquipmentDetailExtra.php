<?php
namespace app\models\equipment;

use app\models\Organize;
use app\models\member\MemberExtra;
use app\models\OrganizeExtra;
 

class EquipmentDetailExtra extends EquipmentDetail
{
    
    //关联关系
    //classinfo
    public function getClassinfo() {
        return $this->hasOne(EquipmentClassInfoExtra::className(), ['id'=>'classinfo_id']);
    }
    
    //org
    public function getOrg() {
        return $this->hasOne(OrganizeExtra::className() , ['id'=>'org_id']);
    }
    
    //user
    public function getCreater() {
        return $this->hasOne(MemberExtra::className(), ['id'=>'user_id']);
    }
    /**
     * 所有的使用记录
     * @return \yii\db\ActiveQuery
     */
    public function getUses() {
        return $this->hasMany(EquipmentUseLogExtra::className(), ['equip_detail_id'=>'id']);
    }
    /**
     * 最后的使用记录
     * @return \yii\db\ActiveQuery
     */
    public function getLastUse() {
        return $this->hasMany(EquipmentUseLogExtra::className(), ['equip_detail_id'=>'id'])
                     ->orderBy(['id'=>SORT_DESC])->one();
    }
    
    /**
                   *  返回设备的所有工单
     * @param   $statu
     * @return \yii\db\ActiveQuery
     */
    public function getOrders($statu) {
        return $this->hasMany(EquipmentOrderExtra::className(), ['equip_detail_id'=>'id'])
                    ->where('statu = :statu',[':statu'=>$statu])
                    ->orderBy(['id'=>SORT_DESC]);
    }
    
    
  
}

