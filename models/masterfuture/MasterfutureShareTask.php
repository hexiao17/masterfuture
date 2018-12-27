<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_share_task".
 *
 * @property string $uuid
 * @property integer $task_id
 * @property string $access_pwd
 * @property integer $created_user
 * @property string $created_time
 * @property string $expired_time
 * @property integer $view_num
 * @property integer $reply_num
 * @property integer $agree_num
 * @property integer $share_level
 * @property integer $statu
 * @property integer $id
 * @property integer $cate_id
 * @property string $snapshot
 * @property string $updated_time
 * @property string $title
 * @property string $image
 * @property integer $fav_num
 */
class MasterfutureShareTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_share_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'created_user', 'snapshot'], 'required'],
            [['task_id', 'created_user', 'view_num', 'reply_num', 'agree_num', 'share_level', 'statu', 'cate_id', 'fav_num'], 'integer'],
            [['created_time', 'expired_time', 'updated_time'], 'safe'],
            [['snapshot'], 'string'],
            [['uuid'], 'string', 'max' => 32],
            [['access_pwd'], 'string', 'max' => 10],
            [['title', 'image'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uuid' => 'Uuid',
            'task_id' => 'Task ID',
            'access_pwd' => 'Access Pwd',
            'created_user' => 'Created User',
            'created_time' => 'Created Time',
            'expired_time' => 'Expired Time',
            'view_num' => 'View Num',
            'reply_num' => 'Reply Num',
            'agree_num' => 'Agree Num',
            'share_level' => 'Share Level',
            'statu' => 'Statu',
            'id' => 'ID',
            'cate_id' => 'Cate ID',
            'snapshot' => 'Snapshot',
            'updated_time' => 'Updated Time',
            'title' => 'Title',
            'image' => 'Image',
            'fav_num' => 'Fav Num',
        ];
    }
}
