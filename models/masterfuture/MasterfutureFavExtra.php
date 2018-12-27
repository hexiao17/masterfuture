<?php
namespace app\models\masterfuture;

use app\models\masterfuture\MasterfutureFav;

class MasterfutureFavExtra extends MasterfutureFav
{
    
    public function getShare( ) {     
        return $this->hasOne(MasterfutureShareTaskExtra::className(), ['id'=>'share_id']);
    }
}

