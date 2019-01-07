<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_user_counter".
 *
 * @property integer $id
 * @property string $name
 * @property integer $num
 * @property string $unit
 * @property integer $user_id
 * @property integer $statu
 * @property integer $updated_time
 * @property string $node_icon
 */
class MasterfutureUserCounter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_user_counter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'num', 'unit', 'user_id', 'statu', 'updated_time', 'node_icon'], 'required'],
            [['num', 'user_id', 'statu', 'updated_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['unit'], 'string', 'max' => 20],
            [['node_icon'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'num' => 'Num',
            'unit' => 'Unit',
            'user_id' => 'User ID',
            'statu' => 'Statu',
            'updated_time' => 'Updated Time',
            'node_icon' => 'Node Icon',
        ];
    }
}
