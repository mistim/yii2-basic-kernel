<?php

namespace mistim\modules\rbac\components;

use yii\rbac\Rule;

/**
 * Class BizRule
 * @package mistim\modules\rbac\components
 */
class BizRule extends Rule
{
    /**
     * @var
     */
    public $expression;

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return $this->expression === '' || $this->expression === null || @eval($this->expression) != 0;
    }
}