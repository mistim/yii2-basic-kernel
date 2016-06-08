<?php

return [
    'modules' => [
        'rbac' => [
            'class' => 'mistim\modules\rbac\Module',
            //Some controller property maybe need to change.
            'controllerMap' => [
                'assignment' => [
                    'class'         => 'mistim\modules\rbac\controllers\AssignmentController',
                    'userClassName' => 'mistim\modules\admin\models\AdminAuth',
                ]
            ]
        ],
        'setting' => [
            'class' => 'mistim\modules\setting\Module',
        ],
    ],
];