<?php

namespace mistim\modules\admin\controllers;

use mistim\models\Message;
use mistim\models\SourceMessage;
use mistim\models\Search\MessageSearch;
use Yii;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

/**
 * Class TranslationAdminController
 * @package mistim\modules\admin\controllers
 */
class TranslationAdminController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @param string $language
     * @return mixed
     * @throws InvalidParamException if the view file or the layout file does not exist.
     */
    public function actionView($id, $language)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $language),
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $language
     * @return mixed
     * @throws InvalidParamException if the view file or the layout file does not exist.
     */
    public function actionUpdate($id, $language)
    {
        $model = $this->findModel($id, $language);
        $sourceMessage = SourceMessage::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->getSession()->setFlash('success', Yii::t('admin', 'Entry has been saved successfully'));
            return $this->redirect(Url::previous());
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
                'sourceMessage' => $sourceMessage,
            ]);
        }
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function actionDelete($id, $language)
    {
        $this->findModel($id, $language)->delete();
        SourceMessage::findOne($id)->delete();

        return $this->redirect(Url::previous());
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $language
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $language)
    {
        if (($model = Message::findOne(['id' => $id, 'language' => $language])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}