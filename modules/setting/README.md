Setting Module for Yii 2
=========


Usage
------------
Once the extension is installed, simply modify your application configuration as follows:

        return [
            //....
            'modules' => [
                .....
                'admin' => [
                    'class' => 'mistim\kernel\modules\admin\Module',
                    'modules' => [
                        'setting' => [
                            'class' => 'mistim\kernel\modules\setting\Module',
                        ],
                    ]
                ],
            ],
        ];


Run migrations:

    php yii migrate/up --migrationPath=@app/modules/setting/migrations

