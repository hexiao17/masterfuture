<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_use_log".
 *
 * @property integer $id
 * @property integer $equip_detail_id
 * @property string $use_name
 * @property string $receiver
 * @property integer $user_id
 * @property string $created_time
 * @property integer $relate_userid
 * @property string $beizhu
 */
class EquipmentUseLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_use_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equip_detail_id', 'use_name', 'receiver', 'user_id', 'beizhu'], 'required'],
            [['equip_detail_id', 'user_id', 'relate_userid'], 'integer'],
            [['created_time'], 'safe'],
            [['use_name', 'receiver'], 'string', 'max' => 10],
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
            'equip_detail_id' => 'Equip Detail ID',
            'use_name' => 'Use Name',
            'receiver' => 'Receiver',
            'user_id' => 'User ID',
            'created_time' => 'Created Time',
            'relate_userid' => 'Relate Userid',
            'beizhu' => 'Beizhu',
        ];
    }
}
