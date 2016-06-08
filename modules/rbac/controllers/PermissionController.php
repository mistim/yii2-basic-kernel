<?php

namespace mistim\modules\rbac\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use mistim\modules\rbac\models\AuthItemModel;
use mistim\modules\rbac\models\search\AuthItemSearch;
use mistim\modules\admin\controllers\BaseController;

/**
 * Class PermissionController
 * @package mistim\modules\rbac\controllers
 */
class PermissionController extends BaseController
{
    /**
     * Lists all permissions.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch(['type' => Item::TYPE_PERMISSION]);
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $authManager = Yii::$app->getAuthManager();
        $available = $assigned = [
            'Permission' => [],
            'Routes' => [],
        ];
        $children = array_keys($authManager->getChildren($id));
        $children[] = $id;
        foreach ($authManager->getPermissions() as $name => $role) {
            if (in_array($name, $children)) {
                continue;
            }
            $available[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
        }
        foreach ($authManager->getChildren($id) as $name => $child) {
            $assigned[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
        }

        $available = array_filter($available);
        $assigned = array_filter($assigned);

        return $this->render('view', [
            'model' => $model,
            'available' => $available,
            'assigned' => $assigned
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItemModel(null);
        $model->type = Item::TYPE_PERMISSION;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Permission has been saved.');
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Permission has been saved.');
            return $this->redirect(['view', 'id' => $model->name]);
        }
        return $this->render('update', ['model' => $model,]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->getAuthManager()->remove($model->item);
        Yii::$app->session->setFlash('success', 'Permission has been removed.');
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $action
     *
     * @return string[]
     */
    public function actionAssign($id, $action)
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;
        $post = Yii::$app->getRequest()->post();
        $roles = ArrayHelper::getValue($post, 'roles', []);
        $manager = Yii::$app->getAuthManager();
        $parent = $manager->getPermission($id);
        if ($action == 'assign') {
            foreach ($roles as $role) {
                $child = $manager->getPermission($role);
                $manager->addChild($parent, $child);
            }
        } else {
            foreach ($roles as $role) {
                $child = $manager->getPermission($role);
                $manager->removeChild($parent, $child);
            }
        }
        return [
            $this->actionRoleSearch($id, 'available', $post['search_av']),
            $this->actionRoleSearch($id, 'assigned', $post['search_asgn'])
        ];
    }

    /**
     * @param $id
     * @param string $target
     * @param string $term
     *
     * @return string
     */
    public function actionRoleSearch($id, $target, $term = '')
    {
        $result = [
            'Permission' => [],
            'Routes' => [],
        ];
        $authManager = Yii::$app->getAuthManager();
        if ($target == 'available') {
            $children = array_keys($authManager->getChildren($id));
            $children[] = $id;
            foreach ($authManager->getPermissions() as $name => $role) {
                if (in_array($name, $children)) {
                    continue;
                }
                if (empty($term) or strpos($name, $term) !== false) {
                    $result[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
                }
            }
        } else {
            foreach ($authManager->getChildren($id) as $name => $child) {
                if (empty($term) or strpos($name, $term) !== false) {
                    $result[$name[0] === '/' ? 'Routes' : 'Permission'][$name] = $name;
                }
            }
        }
        return Html::renderSelectOptions('', array_filter($result));
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @throws \yii\web\NotFoundHttpException
     * @return AuthItemModel the loaded model
     */
    protected function findModel($id)
    {
        $item = Yii::$app->getAuthManager()->getPermission($id);
        if ($item) {
            return new AuthItemModel($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}