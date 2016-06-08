<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;


/* @var $this yii\web\View */
/* @var $model mistim\kernel\modules\admin\models\Admin */

$this->title = Yii::t('admin', 'Add record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Admins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

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