<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_inventory".
 *
 * @property integer $id
 * @property integer $classinfo_id
 * @property integer $total
 * @property string $inventory_addr
 * @property integer $user_id
 * @property string $created_time
 * @property string $beizhu
 */
class EquipmentInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classinfo_id', 'user_id'], 'required'],
            [['classinfo_id', 'total', 'user_id'], 'integer'],
            [['created_time'], 'safe'],
            [['inventory_addr'], 'string', 'max' => 50],
            [['beizhu'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'classinfo_id' => 'Classinfo ID',
            'total' => 'Total',
            'inventory_addr' => 'Inventory Addr',
            'user_id' => 'User ID',
            'created_time' => 'Created Time',
            'beizhu' => 'Beizhu',
        ];
    }
}
