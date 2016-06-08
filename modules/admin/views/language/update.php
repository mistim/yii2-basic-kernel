<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\models\Language */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Language',
]) . $model->intLanguageID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->intLanguageID, 'url' => ['view', 'id' => $model->intLanguageID]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="language-update">

    <p>
        <?= Html::a(Yii::t('admin', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
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
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
