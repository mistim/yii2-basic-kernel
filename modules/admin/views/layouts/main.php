<?php

/**
 * Theme main layout.
 *
 * @var \yii\web\View $this View
 * @var string $content Content
 */

use mistim\theme\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('head') ?>
    </head>
    <body class="sidebar-mini skin-green <?php if ($this->params['sidebar-collapse']) { echo 'sidebar-collapse'; } ?>">
    <?php $this->beginBody(); ?>

    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?= Yii::$app->homeUrl ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                        <?= Yii::$app->getModule('admin')->panelShortName ?>
                    </span>
                <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">
                        <?= Yii::$app->getModule('admin')->panelName ?>
                    </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?= Yii::t('admin', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <?php //if (Yii::$app->user->identity->profile->avatar_url) : ?>
                                <?php //Html::img(Yii::$app->user->identity->profile->urlAttribute('avatar_url'), ['class' => 'img-circle', 'alt' => Yii::$app->user->identity->username]) ?>
                                <?php //endif; ?>
                                <span class="hidden-xs"><?= Yii::$app->user->identity->username ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?php //if (Yii::$app->user->identity->profile->avatar_url) : ?>
                                    <?php //Html::img(Yii::$app->user->identity->profile->urlAttribute('avatar_url'), ['class' => 'img-circle', 'alt' => Yii::$app->user->identity->username]) ?>
                                    <?php //endif; ?>
                                    <p>
                                        Username: <strong><?= Yii::$app->user->identity->username ?></strong><br>
                                        Role: <strong><?= Yii::$app->user->identity->getRole() ?></strong><br>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center"></div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a(
                                            Yii::t('admin', 'Sign out'),
                                            ['/admin/main/logout'],
                                            ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                        ) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?= $this->render('sidebar-menu') ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= $this->title ?>
                    <?php if (isset($this->params['subtitle'])) : ?>
                        <small><?= $this->params['subtitle'] ?></small>
                    <?php endif; ?>
                </h1>
                <?= Breadcrumbs::widget(
                    [
                        'homeLink' => [
                            'label' => '<i class="fa fa-dashboard"></i> ' . Yii::t('admin', 'Home'),
                            'url' => '/'
                        ],
                        'encodeLabels' => false,
                        'tag' => 'ol',
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                    ]
                ) ?>
            </section>
            <!-- Main content -->
            <section class="content">
                <?= Alert::widget(); ?>
                <?= $content ?>
            </section><!-- /.content -->
            <!-- /.content -->
        </div>

        <!-- /.content-wrapper -->
        <?= $this->render('footer') ?>

    </div><!-- ./wrapper -->

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>