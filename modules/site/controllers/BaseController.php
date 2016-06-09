<?php
namespace mistim\modules\site\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;

/**
 * Class BaseController
 * @package mistim\modules\site\controllers
 */
class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->findViewDir($action);

        return parent::beforeAction($action);
    }

    /**
     * @param $action
     */
    protected function findViewDir($action)
    {
        $templateVendorViewPath = '@vendor/mistim/{vendor}/modules/admin/views/' . $action->controller->id;

        if (file_exists(FileHelper::normalizePath(Yii::getAlias('@app/modules/admin/views/' . $action->controller->id)))) {
            $this->setViewPath('@app/modules/admin/views/' . $action->controller->id);
        } elseif (file_exists(FileHelper::normalizePath(Yii::getAlias('@app/views/' . $action->controller->id)))) {
            $this->setViewPath('@app/views/' . $action->controller->id);
        } else {
            foreach (Yii::$app->extensions as $key => $item) {
                if (substr_count($key, 'mistim/') > 0) {
                    $vendorName = explode('/', $item['name'])[1];
                    $viewPath = FileHelper::normalizePath(Yii::getAlias(str_replace('{vendor}', $vendorName,$templateVendorViewPath)));

                    if (file_exists($viewPath)) {
                        $this->setViewPath($viewPath);
                        break;
                    }
                }
            }
        }
    }
}