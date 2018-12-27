<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_share_task_reply".
 *
 * @property integer $id
 * @property integer $share_id
 * @property integer $user_id
 * @property string $content
 * @property string $created_time
 * @property integer $agreeNum
 * @property integer $isAccept
 * @property integer $floor
 */
class MasterfutureShareTaskReply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_share_task_reply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['share_id', 'user_id', 'agreeNum', 'isAccept', 'floor'], 'integer'],
            [['content'], 'required'],
            [['content'], 'string'],
            [['created_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'share_id' => 'Share ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_time' => 'Created Time',
            'agreeNum' => 'Agree Num',
            'isAccept' => 'Is Accept',
            'floor' => 'Floor',
        ];
    }
}
