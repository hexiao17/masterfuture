<?php

namespace app\models\market;

use Yii;

/**
 * This is the model class for table "market_qrcode".
 *
 * @property string $id
 * @property integer $member_id
 * @property string $name
 * @property string $qrcode
 * @property string $extra
 * @property string $expired_time
 * @property integer $total_scan_count
 * @property integer $total_reg_count
  * @property integer $total_view_count
 * @property string $updated_time
 * @property string $created_time
 * @property integer $type
 */
class MarketQrcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'market_qrcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'total_scan_count',total_view_count, 'total_reg_count', 'type'], 'integer'],
            [['expired_time', 'updated_time', 'created_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
            [['qrcode'], 'string', 'max' => 62],
            [['extra'], 'string', 'max' => 2000],
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
            'name' => 'Name',
            'qrcode' => 'Qrcode',
            'extra' => 'Extra',
            'expired_time' => 'Expired Time',
            'total_scan_count' => 'Total Scan Count',
            'total_reg_count' => 'Total Reg Count',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
            'type' => 'Type',
        ];
    }
}
