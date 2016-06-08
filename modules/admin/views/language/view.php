<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\models\Language */

$this->title = $model->intLanguageID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-view">

    <p>
        <?= Html::a(Yii::t('admin', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('admin', 'Update'), ['update', 'id' => $model->intLanguageID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('admin', 'Delete'), ['delete', 'id' => $model->intLanguageID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('admin', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'options'     => ['class' => 'box-success'],
                    'bodyOptions' => [
                        'class' => 'table-responsive'
                    ],
                ]
            ); ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                                'intLanguageID',
                    'varCode',
                    'varName',
                    'isDefault',
                    'isActive',
                ],
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
