<?php

namespace mistim\modules\admin;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package mistim\extensions
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // add admin rules for UrlManager
        $rulePath = __DIR__  . '/config/rules.php';

        if (file_exists($rulePath))
        {
            $app->getUrlManager()->addRules(require($rulePath));
        }
    }
}