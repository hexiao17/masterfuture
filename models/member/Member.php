<?php

namespace app\models\member;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $expired_time
 * @property string $nickname
 * @property string $mobile
 * @property string $login_pwd
 * @property string $email
 * @property integer $sex
 * @property string $avatar
 * @property string $salt
 * @property string $reg_ip
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'sex', 'status'], 'integer'],
            [['expired_time', 'updated_time', 'created_time'], 'safe'],
            [['nickname', 'email', 'reg_ip'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 11],
            [['login_pwd', 'salt'], 'string', 'max' => 32],
            [['avatar'], 'string', 'max' => 200],
            [['mobile'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'expired_time' => 'Expired Time',
            'nickname' => 'Nickname',
            'mobile' => 'Mobile',
            'login_pwd' => 'Login Pwd',
            'email' => 'Email',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'salt' => 'Salt',
            'reg_ip' => 'Reg Ip',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
