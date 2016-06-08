<?php

use yii\helpers\Url;
use yii\grid\GridView;
use mistim\theme\adminlte\widgets\Box;
use mistim\theme\adminlte\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel mistim\kernel\models\Search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Url::remember(Url::current());

$this->title = Yii::t('admin', 'Translations');
$this->params['breadcrumbs'][] = $this->title;

$gridId = 'translate-grid';
$gridConfig = [
    'id'           => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],

        'sourceMessage.message',
        [
            'attribute'     => 'language',
            'filter'        => false,
            'enableSorting' => false,
        ],
        'translation:ntext',
    ],
];

$showActions = false;

if (Yii::$app->user->can('/admin/translation-admin/view')) {
    $actions[] = '{view}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/translation-admin/update')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/translation-admin/delete')) {
    $actions[] = '{delete}';
    $showActions = $showActions || true;
}

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

<?php //Pjax::begin(['enablePushState' => false, 'timeout' => 10000]); ?>

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

<?php //Pjax::end(); ?>