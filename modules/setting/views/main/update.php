<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\models\Setting */

$this->title = Yii::t('app', 'Update record') . ' № ' .  $model->intSettingID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->varKey), 'url' => ['view', 'id' => $model->intSettingID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="setting-update">

    <p>
        <?= Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
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
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
