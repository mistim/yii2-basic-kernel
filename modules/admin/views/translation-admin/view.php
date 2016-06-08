<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\models\Message */

$this->title = Yii::t('admin', 'Record') . ' № ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view">

    <p>
	    <?= Html::a(Yii::t('admin', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
		<?= Yii::$app->user->can('/admin/translation-admin/update')
            ? Html::a(Yii::t('admin', 'Update'), ['update', 'id' => $model->id, 'language' => $model->language], ['class' => 'btn btn-primary'])
            : null ?>
        <?= Yii::$app->user->can('/admin/translation-admin/delete')
            ? Html::a(Yii::t('admin', 'Delete'), ['delete', 'id' => $model->id, 'language' => $model->language], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('admin', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) : null ?>
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
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'sourceMessage.message',
                    'language',
                    'translation:ntext',
                ],
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
