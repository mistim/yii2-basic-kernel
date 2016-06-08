<?php

use yii\helpers\Url;
use yii\grid\GridView;
use mistim\theme\adminlte\widgets\Box;
use mistim\theme\adminlte\widgets\grid\ActionColumn;
use mistim\models\Language;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel mistim\models\Search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Url::remember(Url::current());

$this->title = Yii::t('admin', 'Translations');
$this->params['breadcrumbs'][] = $this->title;

$langs = Language::getAllActive();
$columnLangs = [];

foreach ($langs as $lang) {
    $columnLangs[] = [
        'attribute' => 'translation',
        'label'     => Yii::t('admin', strtoupper($lang->varCode)),
        'value'     => function ($data) use ($lang) {
            foreach ($data->messages as $item) {
                if ($item->language === $lang->varCode) return $item->translation;
            }
        }
    ];
}

$gridId = 'translate-grid';
$gridConfig = [
    'id' => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' =>  ArrayHelper::merge([
        ['class' => 'yii\grid\SerialColumn'],
        'message',
    ], $columnLangs),
];

$showActions = false;

if (Yii::$app->user->can('/admin/translation-public/view')) {
    $actions[] = '{view}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/translation-public/update')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/translation-public/delete')) {
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