<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_task".
 *
 * @property integer $id
 * @property string $title
 * @property string $task_desc
 * @property string $start_date
 * @property string $end_date
 * @property string $finish_time
 * @property integer $weight
 * @property integer $task_group
 * @property integer $user_id
 * @property integer $statu
 * @property string $created_time
 * @property string $updated_time
 * @property integer $viewNum
 * @property integer $cate_id
 * @property integer $isShare
 * @property string $share_id
 */
class MasterfutureTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_desc'], 'string'],
            [['start_date', 'end_date', 'finish_time', 'created_time', 'updated_time'], 'safe'],
            [['weight', 'task_group', 'user_id', 'statu', 'viewNum', 'cate_id', 'isShare'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['share_id'], 'string', 'max' => 32],
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
            'task_desc' => 'Task Desc',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'finish_time' => 'Finish Time',
            'weight' => 'Weight',
            'task_group' => 'Task Group',
            'user_id' => 'User ID',
            'statu' => 'Statu',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'viewNum' => 'View Num',
            'cate_id' => 'Cate ID',
            'isShare' => 'Is Share',
            'share_id' => 'Share ID',
        ];
    }
}
