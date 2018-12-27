<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_inventory_record".
 *
 * @property integer $id
 * @property integer $inventory_id
 * @property integer $updateNum
 * @property string $ops_user
 * @property string $ops_time
 * @property integer $user_id
 * @property string $created_time
 * @property string $beizhu
 */
class EquipmentInventoryRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_inventory_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_id', 'updateNum', 'ops_user', 'user_id', 'beizhu'], 'required'],
            [['inventory_id', 'updateNum', 'user_id'], 'integer'],
            [['ops_time', 'created_time'], 'safe'],
            [['ops_user'], 'string', 'max' => 20],
            [['beizhu'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inventory_id' => 'Inventory ID',
            'updateNum' => 'Update Num',
            'ops_user' => 'Ops User',
            'ops_time' => 'Ops Time',
            'user_id' => 'User ID',
            'created_time' => 'Created Time',
            'beizhu' => 'Beizhu',
        ];
    }
}
