<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mistim\theme\adminlte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var mistim\modules\rbac\models\AuthItemModel $model
 */
$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'BizRules'),
    'url'   => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="auth-item-view">

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'bodyOptions' => [
                        'class' => 'table-responsive'
                    ],
                ]
            ); ?>

            <p>
                <?php echo Html::a(Yii::t('app', 'Back to list'), ['index'], ['class' => 'btn btn-info']); ?>
                <?php echo Html::a('Update', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
                <?php echo Html::a('Delete', ['delete', 'id' => $model->name], [
                    'class'        => 'btn btn-danger',
                    'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                    'data-method'  => 'post',
                ]);
                ?>
                <?php echo Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']); ?>
            </p>

            <?php echo DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'name',
                    'className',
                    'expression:ntext',
                ],
            ]);
            ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>

