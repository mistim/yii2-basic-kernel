<?php

/**
 * Head layout.
 */

use mistim\theme\adminlte\assets\AdminLteAsset;
use mistim\theme\adminlte\assets\BootboxAsset;
use mistim\kernel\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<title><?= Html::encode($this->title); ?></title>
<?= Html::csrfMetaTags(); ?>
<?php $this->head(); ?>
	<link rel="icon" type="image/png" href="/img/icons/favicon-32x32.png" sizes="32x32">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<?php
AdminLteAsset::register($this);
AdminAsset::register($this);
//AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();

$this->registerMetaTag(
    [
        'charset' => Yii::$app->charset
    ]
);
$this->registerMetaTag(
    [
        'name' => 'viewport',
        'content' => 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
    ]
);
$this->registerLinkTag(
    [
        'rel' => 'canonical',
        'href' => Url::canonical()
    ]
); ?>