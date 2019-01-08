<?php

namespace app\models\masterfuture;
 
 
class MasterfutureCounterLogExtra extends MasterfutureCounterLog
{
    public function getCounter(){
        return $this->hasOne(MasterfutureCategoryExtra::className(), ['counter_id'=>'id'])->one();
    }
}
