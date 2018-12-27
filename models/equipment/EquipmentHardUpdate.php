<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_hard_update".
 *
 * @property integer $id
 * @property integer $equip_detail_id
 * @property integer $repair_record_id
 * @property integer $content
 * @property integer $created_time
 */
class EquipmentHardUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_hard_update';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equip_detail_id', 'repair_record_id', 'content', 'created_time'], 'required'],
            [['equip_detail_id', 'repair_record_id', 'content', 'created_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equip_detail_id' => 'Equip Detail ID',
            'repair_record_id' => 'Repair Record ID',
            'content' => 'Content',
            'created_time' => 'Created Time',
        ];
    }
}
