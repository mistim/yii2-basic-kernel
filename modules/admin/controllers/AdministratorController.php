<?php

namespace mistim\kernel\modules\admin\controllers;

use mistim\kernel\modules\admin\models\AdminAuth;
use mistim\kernel\modules\admin\models\search\AdminSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * AdministratorController implements the CRUD actions for Admin model.
 */
class AdministratorController extends BaseController
{
	/**
	 * Lists all Admin models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new AdminSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Admin model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Admin model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new AdminAuth();
		$model->scenario = 'create';
		//$this->ajaxValidate($model);

		if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			Yii::$app->getSession()->setFlash('success', Yii::t('admin', 'Entry has been saved successfully'));
			return $this->redirect(['view', 'id' => $model->intAdminID]);
		}
		else
		{
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Admin model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->scenario = 'update';

		if ($model->load(Yii::$app->request->post()) && $model->save())
		{
			Yii::$app->getSession()->setFlash('success', Yii::t('admin', 'Entry has been saved successfully'));
			return $this->redirect(['view', 'id' => $model->intAdminID]);
		}
		else
		{
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Admin model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		/*$model = $this->findModel($id);
		$model->intStatus = 0;
		$model->save();*/
		$this->findModel($id)->delete();
		Yii::$app->getSession()->setFlash('success', Yii::t('admin', 'Entry has been deleted successfully'));

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Admin model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return AdminAuth the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = AdminAuth::findOne($id)) !== null)
		{
			$model->setListRoles();

			return $model;
		}
		else
		{
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/**
	 * @param $model
	 * @return array
	 */
	protected function ajaxValidate(AdminAuth $model)
	{
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
		{
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}

		return false;
	}
}
