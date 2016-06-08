<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var mistim\modules\rbac\models\AuthItemModel $model
 */
$this->title = Yii::t('app', 'Update record') . ': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'BizRules'),
    'url'   => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url'   => [
        'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = 'Update';
$this->render('/layouts/_sidebar');
?>
<div class="auth-item-update">

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
            <?php echo $this->render('_form', [
                'model' => $model,
            ]);
            ?>
            <?php Box::end(); ?>
        </div>
    </div>

</div>
