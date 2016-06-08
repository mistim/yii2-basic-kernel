<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var mistim\kernel\modules\rbac\models\AuthItemModel $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin([
        'layout'      => 'horizontal',
        //'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'hint' => 'col-sm-6 col-sm-offset-3',
            ],
        ],
    ]); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>

    <?php echo $form->field($model, 'className')->textInput(); ?>

    <?php echo $form->field($model, 'expression')->textarea([
        'rows'     => 2,
        'disabled' => $model->className != '' && $model->className != 'mistim\kernel\modules\rbac\components\BizRule'
    ])->hint('Simple PHP expression. Example: return Yii::$app->user->isGuest;');
    ?>

    <div class="box-footer with-border">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if ($model->isNewRecord): ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-warning']) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

