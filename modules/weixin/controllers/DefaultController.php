<?php
namespace app\modules\weixin\controllers;

use app\common\components\BaseWebController;

/**
 * Default controller for the `weixin` module
 */
class DefaultController extends BaseWebController
{

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
