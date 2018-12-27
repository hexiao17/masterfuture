<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_order_reply".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property string $content
 * @property string $do_user_list
 * @property string $image
 * @property string $created_time
 * @property integer $statu
 * @property integer $flow_step
 * @property integer $score
 */
class EquipmentOrderReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_order_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'content', 'flow_step'], 'required'],
            [['order_id', 'user_id', 'statu', 'flow_step', 'score'], 'integer'],
            [['content'], 'string'],
            [['created_time'], 'safe'],
            [['do_user_list', 'image'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'do_user_list' => 'Do User List',
            'image' => 'Image',
            'created_time' => 'Created Time',
            'statu' => 'Statu',
            'flow_step' => 'Flow Step',
            'score' => 'Score',
        ];
    }
}
