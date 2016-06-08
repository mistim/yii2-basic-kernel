<?php

return [
    'modules' => [
        'rbac' => [
            'class' => 'mistim\kernel\modules\rbac\Module',
            //Some controller property maybe need to change.
            'controllerMap' => [
                'assignment' => [
                    'class'         => 'mistim\kernel\modules\rbac\controllers\AssignmentController',
                    'userClassName' => 'mistim\kernel\modules\admin\models\AdminAuth',
                ]
            ]
        ],
        'setting' => [
            'class' => 'mistim\kernel\modules\setting\Module',
        ],
    ],
];