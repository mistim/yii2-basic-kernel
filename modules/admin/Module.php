<?php
namespace mistim\modules\admin;

use mistim\modules\setting\models\Setting;
use Yii;
use yii\base\Theme;

/**
 * Class Module
 * @package mistim\modules\admin
 */
class Module extends \yii\base\Module
{
    /** @var string $language */
    public $language = 'en';

    /** @var string $defaultRoute */
    public $defaultRoute = 'main';

    /** @var string $identityClass */
    public $identityClass = 'mistim\modules\admin\models\AdminAuth';

    /** @var string $loginUrl */
    public $loginUrl = '/admin/main/login';

    /** @var string $panelName */
    public $panelName = 'Admin Panel';

    /** @var string $panelShortName */
    public $panelShortName = 'AP';

    protected static $mainPageForRole = [
        'Administrator'  => 'main',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::configure($this, require(__DIR__ . '/config/main.php'));

        Yii::$app->name = $this->panelName;
        Yii::$app->language = Setting::getValue('languageAdminPanel') ?: $this->language;

        if (YII_WEB_APP) {
            $this->configUser();
            $this->configTheme();
            $this->setMainPage();
        }

        $this->configTranslations();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function configUser()
    {
        Yii::$app->user->identityClass = $this->identityClass;
        Yii::$app->user->loginUrl = $this->loginUrl;
        Yii::$app->user->enableAutoLogin = true;
        Yii::$app->user->identityCookie = [
            'name' => md5('admin' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configTheme()
    {
        Yii::$app->view->theme = new Theme([
            'pathMap' => ['@app/views' => '@vendor/mistim/yii2-basic-kernel/modules/admin/views'],
        ]);

        $this->layoutPath = Yii::getAlias('@vendor/mistim/yii2-basic-kernel/modules/admin/views/layouts/');
        $this->layout = 'main';

        Yii::$app->assetManager->bundles = [];
    }

    /**
     * @inheritdoc
     */
    protected function configTranslations()
    {
        Yii::$app->i18n->translations['admin*'] = [
            'class'                 => 'yii\i18n\DbMessageSource',
            'sourceLanguage'        => 'en-US',
            //'enableCaching'         => true,
            //'cachingDuration'       => 60,
            'on missingTranslation' => ['mistim\components\TranslationEventHandler', 'handleMissingTranslation']
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setMainPage()
    {
        if (!Yii::$app->user->isGuest)
        {
            $role = Yii::$app->user->identity->getRole();

            if (array_key_exists($role, self::$mainPageForRole))
            {
                $this->defaultRoute = self::$mainPageForRole[$role];
            }
        }
    }
}