<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\models\Message */
/* @var $sourceMessage mistim\kernel\models\sourceMessage */

/*$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('admin', 'Message'),
]) . ' ' . $model->id;*/
$this->title = Yii::t('admin', 'Update record') . ' № ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="message-update">
	<p>
        <?= Html::a(Yii::t('admin', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
    </p>

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'bodyOptions' => [
                        'class' => 'table-responsive'
                    ],
                ]
            ); ?>
            <?= $this->render('_form', [
                'model' => $model,
                'sourceMessage' => $sourceMessage,
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>

