<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use mistim\kernel\models\Language;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\modules\setting\models\Setting */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin([
        'id' => 'setting-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label'   => 'col-sm-3',
                'offset'  => 'col-sm-offset-3',
                'wrapper' => 'col-sm-6',
                'error'   => 'help-block',
                'hint'    => 'help-block',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'varKey')->textInput(['maxlength' => true, 'readonly' => (!$model->isNewRecord || !in_array(Yii::$app->user->identity->getRole(), ['Администратор', 'Administrator', 'app'], true))]) ?>

    <?php if ($model->varKey === 'isNeedUrgentRequest'): ?>
        <div class="form-group field-setting-varvalue required">
            <label class="control-label col-sm-3" for="setting-varkey"><?= Yii::t('app', 'Value') ?></label>
            <div class="col-md-6">
                <?= Html::tag('div', $model->varValue ? Yii::t('app', 'yes') : Yii::t('app', 'no'), ['class' => 'text-as-input']) ?>
            </div>
        </div>
    <?php elseif($model->varKey === 'languageAdminPanel'): ?>
        <?= $form->field($model, 'varValue')->dropDownList(ArrayHelper::map(Language::getAllActive(), 'varCode', 'varCode')) ?>
    <?php elseif($model->varKey === 'extensionUploadFile'): ?>
        <?= $form->field(
            $model, 'varValue',
            ['template' => "{label}<div class='col-sm-6'>\n{input}\n{error}\n{hint}</div>"])->textInput(['maxlength' => true]
        )
        ->hint(
            Yii::t('app', 'enter the necessary extensions, separated by commas',
            ['class' => 'help-block col-sm-6 col-sm-offset-3'])
        ) ?>
    <?php else: ?>
        <?= $form->field($model, 'varValue')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'isActive')->checkbox() ?>

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
