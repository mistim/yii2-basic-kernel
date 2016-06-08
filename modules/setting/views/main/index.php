<?php

use yii\grid\GridView;
use mistim\theme\adminlte\widgets\Box;
use mistim\theme\adminlte\widgets\grid\ActionColumn;
use yii\helpers\Html;
use mistim\modules\setting\models\Setting;

/* @var $this yii\web\View */
/* @var $searchModel mistim\modules\setting\models\search\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;

$gridId = 'product-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'intSettingID',
            'headerOptions' => [
                'width' => '50px'
            ],
        ],
		'varKey',
        [
            'attribute' => 'parameterName',
            'label' => Yii::t('app', 'Parameter name'),
            'value' => function($data) {
                return Yii::t('app', $data->varKey);
            },
            'filter' => false
        ],
        [
            'attribute' => 'varValue',
            'value' => function($data) {
                if ($data->varKey === 'isNeedUrgentRequest')
                {
                    return $data->varValue ? Yii::t('app', 'yes') : Yii::t('app', 'no');
                }

                return $data->varValue;
            }
        ],
        [
            'attribute' => 'isActive',
            'format' => 'raw',
            'value' => function ($data) {
                return (
                $data->isActive === Setting::STATUS_ACTIVE
                    ? '<span class="glyphicon glyphicon-ok-circle text-green"></span>'
                    : '<span class="glyphicon glyphicon-ban-circle text-red"></span>'
                );
            },
            'filter' => [
                Setting::STATUS_ACTIVE => Yii::t('admin', 'enabled'),
                Setting::STATUS_INACTIVE => Yii::t('admin', 'disabled')
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

$showActions = true;
$actions = ['{update}'];

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
<div class="setting-index">

    <!--<p>
        <?php /* Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

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
