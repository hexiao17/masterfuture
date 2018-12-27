<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_attachment".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $task_id
 * @property string $link
 */
class MasterfutureAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'task_id'], 'integer'],
            [['link'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'task_id' => 'Task ID',
            'link' => 'Link',
        ];
    }
}
