<?php

namespace app\models\role;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property integer $valid_days
 * @property integer $pos
 * @property string $updated_time
 * @property string $created_time
 * @property integer $cate
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'valid_days', 'pos', 'cate'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['name'], 'string', 'max' => 50],
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
            'status' => 'Status',
            'valid_days' => 'Valid Days',
            'pos' => 'Pos',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
            'cate' => 'Cate',
        ];
    }
}
