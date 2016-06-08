<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use mistim\theme\adminlte\widgets\Box;
use mistim\theme\adminlte\widgets\grid\ActionColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var mistim\modules\rbac\models\search\AuthItemSearch $searchModel
 */
$this->title = 'BizRules';
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');


$gridId = 'rule-grid';
$gridConfig = [
    'id'           => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'expression:ntext',
    ],
];

$showActions = true;
$actions = ['{view}', '{update}', '{delete}'];

if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class'          => ActionColumn::className(),
        'template'       => implode(' ', $actions),
        'contentOptions' => [
            'align' => 'center',
            'width' => '100px'
        ]
    ];
}
?>
<div class="role-index">

    <p>
        <?php echo Html::a('Create Rule', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000]); ?>

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'bodyOptions' => [
                        'class' => 'table-responsive'
                    ],
                    'grid'        => $gridId
                ]
            ); ?>
            <?= GridView::widget($gridConfig); ?>
            <?php Box::end(); ?>
        </div>
    </div>

    <?php Pjax::end(); ?>
</div>
