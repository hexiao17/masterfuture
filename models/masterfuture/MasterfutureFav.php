<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_fav".
 *
 * @property integer $id
 * @property integer $share_id
 * @property integer $user_id
 * @property string $tags
 * @property integer $statu
 * @property string $created_time
 */
class MasterfutureFav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_fav';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'share_id', 'user_id', 'statu'], 'required'],
            [['id', 'share_id', 'user_id', 'statu'], 'integer'],
            [['created_time'], 'safe'],
            [['tags'], 'string', 'max' => 20],
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
            'tags' => 'Tags',
            'statu' => 'Statu',
            'created_time' => 'Created Time',
        ];
    }
}
