<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mistim\models\Language */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="language-form">

    <?php $form = ActiveForm::begin([
        'id' => 'language-form',
        'layout' => 'horizontal',
    ]); ?>

    <?= $form->field($model, 'varCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'varName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isDefault')->checkbox() ?>

    <?= $form->field($model, 'isActive')->checkbox() ?>


    <div class="col-sm-6 col-sm-offset-3">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
        <?php if ($model->isNewRecord): ?>
            <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
