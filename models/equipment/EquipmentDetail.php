<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_detail".
 *
 * @property integer $id
 * @property string $qrcode
 * @property string $qr_code_url
 * @property integer $classinfo_id
 * @property integer $org_id
 * @property integer $statu
 * @property string $beizhu
 * @property string $equip_params
 * @property string $image
 * @property integer $invent_record_id
 * @property string $updated_time
 * @property integer $user_id
 * @property string $created_time
 */
class EquipmentDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qrcode', 'qr_code_url', 'classinfo_id', 'org_id', 'image', 'invent_record_id', 'user_id'], 'required'],
            [['classinfo_id', 'org_id', 'statu', 'invent_record_id', 'user_id'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['qrcode'], 'string', 'max' => 50],
            [['qr_code_url', 'image'], 'string', 'max' => 200],
            [['beizhu'], 'string', 'max' => 20],
            [['equip_params'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qrcode' => 'Qrcode',
            'qr_code_url' => 'Qr Code Url',
            'classinfo_id' => 'Classinfo ID',
            'org_id' => 'Org ID',
            'statu' => 'Statu',
            'beizhu' => 'Beizhu',
            'equip_params' => 'Equip Params',
            'image' => 'Image',
            'invent_record_id' => 'Invent Record ID',
            'updated_time' => 'Updated Time',
            'user_id' => 'User ID',
            'created_time' => 'Created Time',
        ];
    }
}
