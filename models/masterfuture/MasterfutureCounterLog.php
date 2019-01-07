<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_counter_log".
 *
 * @property integer $id
 * @property integer $counter_id
 * @property string $log_text
 * @property string $created_time
 */
class MasterfutureCounterLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_counter_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['counter_id', 'log_text'], 'required'],
            [['counter_id'], 'integer'],
            [['created_time'], 'safe'],
            [['log_text'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'counter_id' => 'Counter ID',
            'log_text' => 'Log Text',
            'created_time' => 'Created Time',
        ];
    }
}
