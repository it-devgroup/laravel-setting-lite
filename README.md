## 
## Description

System settings for the site, using the database. 

- convenient and easy way to get values from system settings
- command to synchronize system settings between seeds and database

## Install

Open file **config/app.php** and add service provider (optional, usage automatically register its service providers)

```
    'providers' => [
        ...
        \ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider::class,
    ]
```

## Run commands

For creating config file

```
php artisan vendor:publish --provider="ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider" --tag=config
```

For creating language file (if need for setting description or custom exception text)

```
php artisan vendor:publish --provider="ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider" --tag=lang
```

For creating migration file

```
php artisan setting:publish --tag=migration
```

For generate table

```
php artisan migrate
```

## Configure seed file

**1.** Create seeder file if not exists for settings.
In the created seed file, you need to add a static method (for example, `public static function data()`).
The method must return an array of standard to fill the database

**2.** Open config file `config/setting_lite.php` and add this class and method in exists parameters

```
'data' => [
    'class' => SettingTableSeeder::class,
    'method' => 'data',
],
```

**3** Example content seeder file `database/seeders/SettingTableSeeder.php`

```
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ItDevgroup\LaravelSettingLite\Model\SettingModel;

class SettingTableSeeder extends Seeder
{
    public static function data()
    {
        return [
            [
                'id' => 1,
                'key' => 'set_1',
                'type' => Setting::TYPE_LIST,
                'group' => 'Main',
                'is_public' => false,
                'options' => json_encode(['v1', 'v2']),
                'created_at' => '2021-02-03 15:00:00',
                'updated_at' => '2021-02-03 15:00:00',
            ],
            [
                'id' => 2,
                'key' => 'set_2',
                'type' => Setting::TYPE_BOOLEAN,
                'group' => 'Main',
                'is_public' => true,
                'created_at' => '2021-02-03 15:00:00',
                'updated_at' => '2021-02-03 15:00:00',
            ],
            ...
        ];
    }
}
```

## Command for sync settings

```
php artisan setting:sync
```

## Usage

Get setting value

```
setting('SETTING_KEY', 'DEFAULT VALUE IF EMPTY SETTING VALUE');
```

Get types for render on UI

```
return \ItDevgroup\LaravelSettingLite\Model\SettingModel::getTypes();
```

Get groups

Only saved groups from table of settings

```
return \ItDevgroup\LaravelSettingLite\Model\SettingModel::query()
    ->groupBy('group')
    ->orderBy('group', 'ASC')
    ->pluck('group')->toArray();
```
