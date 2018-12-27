<?php

namespace app\models\flow;

use Yii;

/**
 * This is the model class for table "flow".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $user_id
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $forder
 * @property integer $statu
 */
class Flow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'create_time', 'statu'], 'required'],
            [['content'], 'string'],
            [['user_id', 'create_time', 'update_time', 'forder', 'statu'], 'integer'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'user_id' => 'User ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'forder' => 'Forder',
            'statu' => 'Statu',
        ];
    }
}
