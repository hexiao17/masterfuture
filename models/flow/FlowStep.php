<?php

namespace app\models\flow;

use Yii;

/**
 * This is the model class for table "flow_step".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $step
 * @property integer $flow_id
 * @property integer $user_id
 * @property string $created_time
 * @property integer $statu
 */
class FlowStep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flow_step';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content', 'step', 'flow_id', 'user_id'], 'required'],
            [['content'], 'string'],
            [['step', 'flow_id', 'user_id', 'statu'], 'integer'],
            [['created_time'], 'safe'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'step' => 'Step',
            'flow_id' => 'Flow ID',
            'user_id' => 'User ID',
            'created_time' => 'Created Time',
            'statu' => 'Statu',
        ];
    }
}
