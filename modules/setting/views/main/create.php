<?php

use mistim\theme\adminlte\widgets\Box;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\models\News */

$this->title = Yii::t('app', 'Create record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

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
