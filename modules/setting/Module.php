<?php

namespace mistim\modules\setting;


/**
 * Class Module
 * @package mistim\modules\setting
 */
class Module extends \yii\base\Module
{
    /**
     * @var string the default route of this module. Defaults to 'default'.
     * The route may consist of child module ID, controller ID, and/or action ID.
     * For example, `help`, `post/create`, `admin/post/create`.
     * If action ID is not given, it will take the default value as specified in
     * [[Controller::defaultAction]].
     */
    public $defaultRoute = 'main';

    /**
     * Initializes the module.
     *
     * This method is called after the module is created and initialized with property values
     */
    public function init()
    {
        parent::init();
    }
}