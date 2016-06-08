<?php

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

use mistim\theme\adminlte\widgets\Menu;

$controller = Yii::$app->controller;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu',
        ],
        'encodeLabels' => false,
        'activateParents' => true,
        'items' => [
            [
                'label' => Yii::t('admin', 'MAIN NAVIGATION'),
                'options' => ['class' => 'header']
            ],
            [
                'label' => '<span>' . Yii::t('admin', 'Dashboard') . '</span>',
                'url' => '/admin',
                'icon' => 'fa-dashboard',
                'visible' => Yii::$app->user->can('/admin/main/index') || Yii::$app->user->can('/admin/*'),
                'active' => $controller->id === 'main',
            ],
            [
                'label' => '<span>' . Yii::t('admin', 'Administrators') . '</span>',
                'url' => '/admin/administrator',
                'icon' => 'fa-street-view',
                'active' => $controller->id === 'administrator',
                'visible' => Yii::$app->user->can('/admin/administrator/index') || Yii::$app->user->can('/admin/*'),
            ],
            [
                'label' => '<span>' . Yii::t('admin', 'Access rules') . '</span>',
                'url' => '#',
                'icon' => 'fa-user-secret',
                'option' => 'treeview',
                'visible' => (
                    (
                        Yii::$app->user->can('/admin/rbac/assignment/index') || Yii::$app->user->can('/admin/rbac/role/index') ||
                        Yii::$app->user->can('/admin/rbac/permission/index') || Yii::$app->user->can('/admin/rbac/route/index') ||
                        Yii::$app->user->can('/admin/rbac/rule/index')
                    ) || Yii::$app->user->can('/admin/rbac/*')
                ),
                'items' => [
                    [
                        'label' => Yii::t('admin', 'Assignment'),
                        'url' => ['/admin/rbac/assignment'],
                        'active' => $controller->id === 'assignment',
                        'visible' => Yii::$app->user->can('/admin/rbac/assignment/index') || Yii::$app->user->can('/admin/rbac/*'),
                    ],
                    [
                        'label' => Yii::t('admin', 'Role'),
                        'url' => ['/admin/rbac/role'],
                        'active' => $controller->id === 'role',
                        'visible' => Yii::$app->user->can('/admin/rbac/role/index') || Yii::$app->user->can('/admin/rbac/*'),
                    ],
                    [
                        'label' => Yii::t('admin', 'Permission'),
                        'url' => ['/admin/rbac/permission'],
                        'active' => $controller->id === 'permission',
                        'visible' => Yii::$app->user->can('/admin/rbac/permission/index') || Yii::$app->user->can('/admin/rbac/*'),
                    ],
                    [
                        'label' => Yii::t('admin', 'Route'),
                        'url' => ['/admin/rbac/route'],
                        'active' => $controller->id === 'route',
                        'visible' => Yii::$app->user->can('/admin/rbac/route/index') || Yii::$app->user->can('/admin/rbac/*'),
                    ],
                    [
                        'label' => Yii::t('admin', 'Rule'),
                        'url' => ['/admin/rbac/rule'],
                        'active' => $controller->id === 'rule',
                        'visible' => Yii::$app->user->can('/admin/rbac/rule/index') || Yii::$app->user->can('/admin/rbac/*'),
                    ],
                ]
            ],
            [
                'label' => '<span>' . Yii::t('admin', 'Settings') . '</span>',
                'url' => ['/admin/setting'],
                'icon' => 'fa-cogs',
                'active' => $controller->id === 'setting',
                'visible' => Yii::$app->user->can('/admin/setting/index') || Yii::$app->user->can('/admin/*'),
            ],
            [
                'label' => '<span>' . Yii::t('admin', 'Translations') . '</span>',
                'url' => '#',
                'icon' => 'fa-language',
                'option' => 'treeview',
                'visible' => Yii::$app->user->can('/admin/language/index') || Yii::$app->user->can('/admin/translation-admin/index')
                    || Yii::$app->user->can('/admin/translation-public/index') || Yii::$app->user->can('/admin/*'),
                'items' => [
                    [
                        'label' => Yii::t('admin', 'Languages'),
                        'url' => ['/admin/language'],
                        'active' => $controller->id === 'language',
                        'visible' => Yii::$app->user->can('/admin/language/index') || Yii::$app->user->can('/admin/*'),
                    ],
                    [
                        'label' => Yii::t('admin', 'Translation admin'),
                        'url' => ['/admin/translation-admin'],
                        'active' => $controller->id === 'translation-admin',
                        'visible' => Yii::$app->user->can('/admin/translation-admin/index') || Yii::$app->user->can('/admin/*'),
                    ],
                    [
                        'label' => Yii::t('admin', 'Translation public'),
                        'url' => ['/admin/translation-public'],
                        'active' => $controller->id === 'translation-public',
                        'visible' => Yii::$app->user->can('/admin/translation-public/index') || Yii::$app->user->can('/admin/*'),
                    ]
                ]
            ],
        ]
    ]
);