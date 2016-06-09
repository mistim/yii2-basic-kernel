<?php
namespace mistim\modules\admin\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use mistim\modules\rbac\components\AccessControl;

/**
 * Class BaseController
 * @package mistim\modules\admin\controllers
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

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::$app->getView()->params['sidebar-collapse'] = $this->sidebarCollapse;
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