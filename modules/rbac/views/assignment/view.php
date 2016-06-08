<?php

use yii\helpers\Html;
use yii\helpers\Url;
use mistim\theme\adminlte\widgets\Box;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var mistim\kernel\modules\rbac\models\search\AssignmentSearch $searchModel
 */
$this->title = Yii::t('app', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
    <div class="assignment-index">

        <div class="row">
            <div class="col-xs-12">
                <?php Box::begin(
                    [
                        'title'       => Yii::t('app', 'User') . ': ' . $model->{$usernameField},
                        'bodyOptions' => [
                            'class' => 'table-responsive'
                        ],
                    ]
                ); ?>

                <div class="col-lg-5">
                    <?php
                    echo Html::textInput('search_av', '', [
                            'class'       => 'role-search form-control',
                            'data-target' => 'available',
                            'placeholder' => 'Search:'
                        ]) . '<br>';
                    echo Html::listBox('roles', '', $available, [
                        'id'       => 'available',
                        'multiple' => true,
                        'size'     => 20,
                        'style'    => 'width:100%',
                        'class'    => 'form-control'
                    ]);
                    ?>
                </div>
                <div class="col-lg-2">
                    <div class="move-buttons">
                        <?php
                        echo Html::a('<i class="glyphicon glyphicon-chevron-left"></i>', '#', [
                            'class'       => 'btn btn-success',
                            'data-action' => 'delete'
                        ]);
                        ?>
                        <?php
                        echo Html::a('<i class="glyphicon glyphicon-chevron-right"></i>', '#', [
                            'class'       => 'btn btn-success',
                            'data-action' => 'assign'
                        ]);
                        ?>
                    </div>
                </div>
                <div class="col-lg-5">
                    <?php
                    echo Html::textInput('search_asgn', '', [
                            'class'       => 'role-search form-control',
                            'data-target' => 'assigned',
                            'placeholder' => 'Search:'
                        ]) . '<br>';
                    echo Html::listBox('roles', '', $assigned, [
                        'id'       => 'assigned',
                        'multiple' => true,
                        'size'     => 20,
                        'style'    => 'width:100%',
                        'class'    => 'form-control',
                    ]);
                    ?>
                </div>

                <?php Box::end(); ?>
            </div>
        </div>
    </div>
<?php
$this->registerJs("rbac.init({
        name: " . json_encode($id) . ",
        route: '" . Url::toRoute(['role-search']) . "',
        routeAssign: '" . Url::toRoute(['assign', 'id' => $id, 'action' => 'assign']) . "',
        routeDelete: '" . Url::toRoute(['assign', 'id' => $id, 'action' => 'delete']) . "',
        routeSearch: '" . Url::toRoute(['route-search']) . "'
    });", yii\web\View::POS_READY);
