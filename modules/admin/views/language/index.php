<?php

use yii\helpers\Html;
use mistim\theme\adminlte\widgets\Box;
use mistim\theme\adminlte\widgets\grid\ActionColumn;
use yii\grid\GridView;
use mistim\kernel\models\Language;

/* @var $this yii\web\View */
/* @var $searchModel mistim\kernel\models\search\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Languages');
$this->params['breadcrumbs'][] = $this->title;

$gridId = 'language-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'intLanguageID',
        'varCode',
        'varName',
        [
            'attribute' => 'isDefault',
            'format' => 'raw',
            'value' => function ($data) {
                return (
                $data->isDefault === Language::STATUS_ACTIVE
                    ? '<span class="glyphicon glyphicon-ok-circle text-green"></span>'
                    : '<span class="glyphicon glyphicon-ban-circle text-red"></span>'
                );
            },
            'filter' => [
                Language::STATUS_ACTIVE => Yii::t('admin', 'enabled'),
                Language::STATUS_INACTIVE => Yii::t('admin', 'disabled')
            ],
            'headerOptions' => [
                'width' => '120px'
            ],
            'contentOptions' => [
                'align' => 'center',
            ]
        ],
        [
            'attribute' => 'isActive',
            'format' => 'raw',
            'value' => function ($data) {
                return (
                $data->isActive === Language::STATUS_ACTIVE
                    ? '<span class="glyphicon glyphicon-ok-circle text-green"></span>'
                    : '<span class="glyphicon glyphicon-ban-circle text-red"></span>'
                );
            },
            'filter' => [
                Language::STATUS_ACTIVE => Yii::t('admin', 'enabled'),
                Language::STATUS_INACTIVE => Yii::t('admin', 'disabled')
            ],
            'headerOptions' => [
                'width' => '120px'
            ],
            'contentOptions' => [
                'align' => 'center',
            ]
        ],
    ],
];

$showActions = false;
$actions = [];

if (Yii::$app->user->can('/admin/language/view')) {
    $actions[] = '{view}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/language/update')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/language/delete')) {
    $actions[] = '{delete}';
    $showActions = $showActions || true;
}

if ($showActions === true) {
    $gridConfig['columns'][] = [
        'class'    => ActionColumn::className(),
        'template' => implode(' ', $actions),
        'contentOptions' => [
            'align' => 'center',
            'width' => '100px'
        ]
    ];
}
?>

<div class="language-index">

    <p>
        <?= Html::a(Yii::t('admin', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'bodyOptions' => [
                        'class' => 'table-responsive'
                    ],
                    'grid' => $gridId
                ]
            ); ?>
            <?= GridView::widget($gridConfig); ?>
            <?php Box::end(); ?>
        </div>
    </div>


</div>
