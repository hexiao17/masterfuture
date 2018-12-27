<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_summary".
 *
 * @property integer $id
 * @property string $created_time
 * @property integer $user_id
 * @property string $year_month
 * @property string $title
 * @property string $summary_content
 */
class MasterfutureSummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time'], 'safe'],
            [['user_id', 'title', 'summary_content'], 'required'],
            [['user_id'], 'integer'],
            [['summary_content'], 'string'],
            [['year_month'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_time' => 'Created Time',
            'user_id' => 'User ID',
            'year_month' => 'Year Month',
            'title' => 'Title',
            'summary_content' => 'Summary Content',
        ];
    }
}
