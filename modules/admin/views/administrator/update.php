<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\modules\admin\models\Admin */

$this->title = Yii::t('admin', 'Update record') . ' № ' . $model->intAdminID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->varName, 'url' => ['view', 'id' => $model->intAdminID]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>

<p>
    <?= Html::a(Yii::t('admin', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
</p>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'options'     => ['class' => 'box-success'],
                'bodyOptions' => ['class' => 'table-responsive'],
            ]
        ); ?>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
        <?php Box::end(); ?>
    </div>
</div>

