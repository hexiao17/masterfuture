<?php

namespace app\models\masterfuture;

use Yii;

/**
 * This is the model class for table "masterfuture_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $num
 */
class MasterfutureCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masterfuture_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'num' => 'Num',
        ];
    }
}
