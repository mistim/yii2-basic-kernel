<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use mistim\kernel\modules\admin\models\Admin;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model mistim\kernel\modules\admin\models\Admin */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="administrator-form">

	<?php $form = ActiveForm::begin([
		'id' => 'administrator-form',
		'layout' => 'horizontal',
	]); ?>

	<?php //if (Admin::isAdmin()): ?>

		<?= $form->field($model, 'varName')->textInput(['maxlength' => 32]) ?>

		<?= $form->field($model, 'varEmail')->input('email') ?>

	<?php //endif; ?>

	<?= $form->field($model, 'varPassword')->passwordInput(['value'=>'', 'maxlength' => 64]) ?>

	<?php if (!$model->isNewRecord): ?>

		<?= $form->field($model, 'varConfirmPassword')->passwordInput(['maxlength' => 64]) ?>

	<?php endif; ?>

	<?php //if (Admin::isAdmin()): ?>

		<?= $form->field($model, 'intStatus')->dropDownList(Admin::$listStatus) ?>

		<?= $form->field($model, 'listRoles')->dropDownList(
			ArrayHelper::map(Admin::getAllRoles(), 'name', 'name'),
			['multiple' => true]
		) ?>

	<?php //endif; ?>

	<div class="col-sm-6 col-sm-offset-3">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<?php if ($model->isNewRecord): ?>
		<?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-warning']) ?>
		<?php endif; ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
