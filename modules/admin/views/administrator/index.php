<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mistim\modules\admin\models\Admin;
use mistim\theme\adminlte\widgets\Box;
use mistim\theme\adminlte\widgets\grid\ActionColumn;
use mistim\theme\adminlte\widgets\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel mistim\modules\admin\models\search\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Administrators');
$this->params['breadcrumbs'][] = $this->title;

$gridId = 'admin-grid';
$gridConfig = [
    'id'           => $gridId,
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'rowOptions'   => function ($model, $index, $widget, $grid) {

        if ($model->intStatus == 0) {
            return ['class' => 'danger'];
        } else {
            return [];
        }
    },
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],

        'varName',
        'varEmail:email',
        [
            'attribute' => 'role',
            'value'     => function (Admin $data) {
                $result = [];
                /** @var mistim\modules\rbac\models\AuthAssignmentModel $role */
                foreach ($data->roles as $role) {
                    $result[] = $role->item_name;
                }
                return implode(', ', $result);
            }
        ],
        [
            'attribute'      => 'dateCreated',
            'format'         => ['date', 'php:Y-m-d H:i'],
            'contentOptions' => [
                'width' => '190px'
            ],
            'filter'         => DatePicker::widget([
                'model'         => $searchModel,
                'attribute'     => 'dateCreated',
                'template'      => '{addon}{input}',
                'clientOptions' => [
                    'autoclose' => true,
                    'format'    => 'yyyy-mm-dd'
                ]
            ])
        ],
        [
            'attribute'      => 'dateLastEnter',
            'format'         => ['date', 'php:Y-m-d H:i'],
            'contentOptions' => [
                'width' => '190px'
            ],
            'filter'         => DatePicker::widget([
                'model'         => $searchModel,
                'attribute'     => 'dateLastEnter',
                'template'      => '{addon}{input}',
                'clientOptions' => [
                    'autoclose' => true,
                    'format'    => 'yyyy-mm-dd'
                ]
            ])
        ],
    ],
];

$showActions = false;

if (Yii::$app->user->can('/admin/administrator/view')) {
    $actions[] = '{view}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/administrator/update')) {
    $actions[] = '{update}';
    $showActions = $showActions || true;
}

if (Yii::$app->user->can('/admin/administrator/delete')) {
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
    <?php if (Yii::$app->user->can('/admin/administrator/create')): ?>
    <p>
        <?= Html::a(Yii::t('admin', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

<?php Pjax::begin(['enablePushState' => false, 'timeout' => 10000]); ?>

    <div class="row">
        <div class="col-xs-12">
            <?php Box::begin(
                [
                    'options'     => [
                        'class' => 'box-success'
                    ],
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