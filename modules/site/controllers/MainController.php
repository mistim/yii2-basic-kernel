<?php
namespace mistim\kernel\modules\site\controllers;

/**
 * Class MainController
 * @package mistim\kernel\modules\site\controllers
 */
class MainController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}