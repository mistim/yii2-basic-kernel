<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\models\Language */

$this->title = Yii::t('admin', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">

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
