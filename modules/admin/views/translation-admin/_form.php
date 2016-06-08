<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mistim\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <label class="control-label" for="message-translation"><?=Yii::t('admin','Message')?></label>
	    <textarea cols="50" rows="5" readonly="readonly" class="form-control"><?php echo $sourceMessage->message ?></textarea>
    </div>

    <?= $form->field($model, 'translation')->textarea(['rows' => 5]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
