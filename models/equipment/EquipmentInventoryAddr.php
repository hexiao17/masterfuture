<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_inventory_addr".
 *
 * @property integer $id
 * @property string $factory
 */
class EquipmentInventoryAddr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_inventory_addr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['factory'], 'required'],
            [['factory'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'factory' => 'Factory',
        ];
    }
}
