<?php

namespace app\models\equipment;

use Yii;

/**
 * This is the model class for table "equipment_order".
 *
 * @property integer $id
 * @property string $content
 * @property string $tel
 * @property integer $user_id
 * @property integer $org_id
 * @property integer $equip_detail_id
 * @property string $book_time
 * @property string $created_time
 * @property integer $statu
 * @property string $updated_time
 * @property string $leader
 * @property integer $flow_id
 * @property integer $flow_step
 * @property string $image
 */
class EquipmentOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipment_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'user_id', 'org_id', 'equip_detail_id', 'flow_id', 'flow_step', 'image'], 'required'],
            [['user_id', 'org_id', 'equip_detail_id', 'statu', 'flow_id', 'flow_step'], 'integer'],
            [['book_time', 'created_time', 'updated_time'], 'safe'],
            [['content'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 13],
            [['leader'], 'string', 'max' => 20],
            [['image'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'tel' => 'Tel',
            'user_id' => 'User ID',
            'org_id' => 'Org ID',
            'equip_detail_id' => 'Equip Detail ID',
            'book_time' => 'Book Time',
            'created_time' => 'Created Time',
            'statu' => 'Statu',
            'updated_time' => 'Updated Time',
            'leader' => 'Leader',
            'flow_id' => 'Flow ID',
            'flow_step' => 'Flow Step',
            'image' => 'Image',
        ];
    }
}
