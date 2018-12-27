<?php

namespace app\models\member;

use Yii;

/**
 * This is the model class for table "member_trial".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $created_time
 * @property string $expired_time
 * @property string $adder
 * @property string $beizhu  备注
 */
class MemberTrial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member_trial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id'], 'integer'],
            [['created_time','beizhu'], 'safe'],
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
            'created_time' => 'Created Time',
        ];
    }
}
