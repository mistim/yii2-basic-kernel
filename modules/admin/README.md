Admin Module for Yii 2
=========

Usage
------------
Once the extension is installed, simply modify your application configuration as follows:

        return [
            //....
            'bootstrap' => [
                    // ....
                    'mistim\kernel\modules\admin\Bootstrap',
                ],
            'modules' => [
                // .....
                'admin' => [
                    'class'          => 'mistim\kernel\modules\admin\Module',
                    'panelName'      => 'Admin Panel',
                    'panelShortName' => 'AP',
                    //'adminPath'      => 'admin-q7y'
                ],
            ],
        ];


Run migrations:

    php yii migrate/up --migrationPath=@app/modules/admin/migrations


