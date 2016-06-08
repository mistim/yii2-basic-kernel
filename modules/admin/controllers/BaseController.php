<?php
namespace mistim\kernel\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use mistim\kernel\modules\rbac\components\AccessControl;

/**
 * Class BaseController
 * @package mistim\kernel\modules\admin\controllers
 */
class BaseController extends Controller
{
    public $sidebarCollapse = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'fileapi-delete' => ['delete'],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        Yii::$app->getView()->params['sidebar-collapse'] = $this->sidebarCollapse;
    }
}