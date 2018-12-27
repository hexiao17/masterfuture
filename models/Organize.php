<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organize".
 *
 * @property integer $id
 * @property integer $name
 * @property integer $pid
 * @property integer $pos
 */
class Organize extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organize';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pid', 'pos'], 'required'],
            [['name', 'pid', 'pos'], 'integer']
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
            'pid' => 'Pid',
            'pos' => 'Pos',
        ];
    }
}
