<?php

namespace app\models\role;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property string $id
 * @property integer $uid
 * @property integer $role_id
 * @property string $created_time
  * @property integer $cate
 */
class UserRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'role_id'], 'integer'],
            [['created_time','cate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'role_id' => 'Role ID',
            'created_time' => 'Created Time',
        ];
    }
}
