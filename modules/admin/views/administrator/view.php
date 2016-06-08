<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mistim\modules\admin\models\Admin;
use mistim\theme\adminlte\widgets\Box;

/* @var $this yii\web\View */
/* @var $model mistim\modules\admin\models\Admin */

$this->title = Yii::t('admin', 'Record') . ' № ' . $model->intAdminID;
$this->params['breadcrumbs'][] = ['label' => 'Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
	    <?= Html::a(Yii::t('admin', 'Back to list'), ['index'], ['class' => 'btn btn-info']) ?>
        <?= Yii::$app->user->can('/admin/administrator/update') ? Html::a(Yii::t('admin', 'Update'), ['update', 'id' => $model->intAdminID], ['class' => 'btn btn-primary']) : null ?>
        <?= Yii::$app->user->can('/admin/administrator/delete') ? Html::a(Yii::t('admin', 'Delete'), ['delete', 'id' => $model->intAdminID], [
		        'class' => 'btn btn-danger',
		        'data' => [
			        'confirm' => 'Are you sure you want to delete this item?',
			        'method' => 'post',
		        ],
	        ]) : null; ?>
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
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'varName',
                    'varEmail:email',
                    [
                        'attribute' => 'intStatus',
                        'value' => Yii::t('admin', Admin::$listStatus[$model->intStatus])
                    ],
                    [
                        'attribute' => 'listRoles',
                        'value' => implode(', ', $model->listRoles)
                    ],
                    'dateCreated:datetime',
                    'dateLastEnter:datetime',
                ],
            ]) ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
