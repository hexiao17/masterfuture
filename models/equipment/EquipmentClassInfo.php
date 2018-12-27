<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_class_info".
 *
 * @property integer $id
 * @property string $investment_plan
 * @property string $name
 * @property string $equipment_model
 * @property string $unit
 * @property string $material_code
 * @property double $price
 * @property string $produce_company
 * @property string $produce_date
 * @property string $procure_company
 * @property string $procure_tel
 * @property string $created_time
 * @property integer $user_id
 * @property string $cpu
 * @property string $harddisk
 * @property string $memory
 * @property string $screen
 * @property string $keyboard
 * @property string $mouse
 * @property string $beizhu
 */
class EquipmentClassInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_class_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['produce_date', 'created_time'], 'safe'],
            [['user_id', 'cpu'], 'required'],
            [['user_id'], 'integer'],
            [['investment_plan', 'material_code', 'cpu', 'harddisk', 'memory', 'screen', 'keyboard', 'mouse'], 'string', 'max' => 20],
            [['name', 'beizhu'], 'string', 'max' => 200],
            [['equipment_model', 'produce_company', 'procure_company'], 'string', 'max' => 100],
            [['unit'], 'string', 'max' => 10],
            [['procure_tel'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'investment_plan' => 'Investment Plan',
            'name' => 'Name',
            'equipment_model' => 'Equipment Model',
            'unit' => 'Unit',
            'material_code' => 'Material Code',
            'price' => 'Price',
            'produce_company' => 'Produce Company',
            'produce_date' => 'Produce Date',
            'procure_company' => 'Procure Company',
            'procure_tel' => 'Procure Tel',
            'created_time' => 'Created Time',
            'user_id' => 'User ID',
            'cpu' => 'Cpu',
            'harddisk' => 'Harddisk',
            'memory' => 'Memory',
            'screen' => 'Screen',
            'keyboard' => 'Keyboard',
            'mouse' => 'Mouse',
            'beizhu' => 'Beizhu',
        ];
    }
}
