<?php

namespace app\models\masterfuture;
 
class MasterfutureUserCounterExtra extends MasterfutureUserCounter
{
     
    ///一对多
    public function getLogs() {
        return $this->hasMany(MasterfutureCounterLogExtra::className(), ['counter_id'=>'id'])->all();
    }
    
}
