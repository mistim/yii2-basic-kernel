<?php
namespace mistim\modules\site\controllers;

/**
 * Class MainController
 * @package mistim\modules\site\controllers
 */
class MainController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}