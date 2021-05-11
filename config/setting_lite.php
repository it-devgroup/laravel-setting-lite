<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table name
    |--------------------------------------------------------------------------
    | Table name for settings
    */
    'table' => 'settings',

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    | Setting model (default): \ItDevgroup\LaravelSettingLite\Model\Setting::class
    | Change to your custom class if you need to extend the model or change the table name
    | A custom class for setting must inherit the base class \ItDevgroup\LaravelSettingLite\Model\Setting
    */
    'model' => \ItDevgroup\LaravelSettingLite\Model\Setting::class,

    /*
    |--------------------------------------------------------------------------
    | Data from seeder file
    |--------------------------------------------------------------------------
    | Required
    | class - class seeder file (example): Database\Seeders\SettingTableSeeder::class
    | method - static method with array of data with seeder format
    | Example seeder file database/seeders/SettingTableSeeder.php:
    | class SettingTableSeeder extends Seeder
    | {
    | ...
    |     public static function data()
    |     {
    |         return [
    |             [
    |                'id' => 1,
    |                'key' => 'key_1',
    |                ...
    |            ],
    |            [
    |                'id' => 2,
    |                'key' => 'key_2',
    |                ...
    |            ],
    |            ...
    |        ];
    |    }
    | }
    */
    'data' => [
        'class' => '',
        'method' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespace for lexicon
    |--------------------------------------------------------------------------
    | Optional.
    | For default value of description field for setting.
    | If the lexicon filename is "web.php" then the value should be "web".
    | Default format: [
    |     'setting' => [
    |         'KEY_NAME' => 'KEY DEFAULT DESCRIPTION',
    |     ]
    | ]
    | Example: [
    |     'setting' => [
    |         'site_name' => 'Example site name',
    |     ]
    | ]
    | For get value from lexicon file in model need call of property $model->description_default
    */
    'lexicon' => 'setting_lite',

    /*
    |--------------------------------------------------------------------------
    | Set value field description from lexicon
    |--------------------------------------------------------------------------
    | If field of description is empty - set value field description from lexicon
    */
    'description_field_from_lexicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Config for sync command
    |--------------------------------------------------------------------------
    */
    'sync' => [
        /*
        |--------------------------------------------------------------------------
        | Creating new setting if not exists to database
        |--------------------------------------------------------------------------
        | true - create
        | false - not create
        */
        'create' => true,
        /*
        |--------------------------------------------------------------------------
        | Deleting setting if setting been deleted in seeder file
        |--------------------------------------------------------------------------
        | true - delete
        | false - not delete
        */
        'delete' => true,
        /*
        |--------------------------------------------------------------------------
        | List of fields which has being updated auto at sync
        |--------------------------------------------------------------------------
        | array [
        |   'field_1',
        |   'field_2'
        | ]
        */
        'update_fields' => [
            'options',
            'type',
            'group',
            'is_public',
        ]
    ]
];
