<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mistim\theme\adminlte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var mistim\kernel\modules\rbac\models\RouteModel $model
 * @var yii\bootstrap\ActiveForm $form
 */

$this->title = Yii::t('app', 'Create record');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Routes'),
    'url'   => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>

<div class="create">

    <p>
        <?php echo Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-info']); ?>
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

            <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
            ]); ?>

            <?php echo $form->field($model, 'route')->label(Yii::t('app', 'Route')); ?>

            <div class="box-footer with-border">
                <div class="col-sm-6 col-sm-offset-3">
                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <?php Box::end(); ?>
        </div>
    </div>

</div><!-- create -->
