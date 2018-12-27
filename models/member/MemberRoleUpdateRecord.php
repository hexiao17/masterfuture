<?php

namespace app\models\member;

use Yii;

/**
 * This is the model class for table "member_role_update_record".
 *
 * @property string $id
 * @property integer $member_id
 * @property integer $update_role_id
 * @property integer $before_role_id
 * @property string $before_expired_time
 * @property string $update_expired_time
 * @property integer $pay_order_id
 * @property string $created_time
 */
class MemberRoleUpdateRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_role_update_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'update_role_id', 'before_role_id', 'pay_order_id'], 'required'],
            [['member_id', 'update_role_id', 'before_role_id', 'pay_order_id'], 'integer'],
            [['before_expired_time', 'update_expired_time', 'created_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'update_role_id' => 'Update Role ID',
            'before_role_id' => 'Before Role ID',
            'before_expired_time' => 'Before Expired Time',
            'update_expired_time' => 'Update Expired Time',
            'pay_order_id' => 'Pay Order ID',
            'created_time' => 'Created Time',
        ];
    }
}
