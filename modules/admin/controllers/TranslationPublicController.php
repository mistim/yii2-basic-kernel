<?php

namespace mistim\kernel\modules\admin\controllers;

use mistim\kernel\models\Message;
use mistim\kernel\models\Search\SourceMessageSearch;
use mistim\kernel\models\SourceMessage;
use Yii;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class TranslationPublicController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws InvalidParamException if the view file or the layout file does not exist.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws InvalidParamException if the view file or the layout file does not exist.
     */
    public function actionUpdate($id)
    {
        /** @var SourceMessage $model */
        $model = $this->findModel($id);
        $model->prepareTranslation();

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->addTranslation())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('admin', 'Entry has been saved successfully'));
            return $this->redirect(Url::previous());
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Message::deleteAll(['id' => $id]);
        Yii::$app->getSession()->setFlash('success', Yii::t('admin', 'Entry has been deleted successfully'));

        return $this->redirect(Url::previous());
    }

    /**
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SourceMessage::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}