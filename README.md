## 
## Install for Lumen

**1.** Open file `bootstrap/app.php`

Uncommented strings

```
$app->withFacades();
$app->withEloquent();
```

Added after **$app->configure('app');**

```
$app->configure('setting_lite');
```

add new service provider

```
$app->register(\ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider::class);
```

**2.** Run commands

For creating config file

```
php artisan setting:publish --tag=config
```

For creating lang file

```
php artisan setting:publish --tag=lang
```

For creating migration file

```
php artisan setting:publish --tag=migration
```

For generate table

```
php artisan migrate
```

## Install for laravel

**1.** Open file **config/app.php** and search
```
    'providers' => [
        ...
    ]
```
Add to section
```
        \ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider::class,
```
Example
```
    'providers' => [
        ...
        \ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider::class,
    ]
```

**2.** Run commands

For creating config file

```
php artisan vendor:publish --provider="ItDevgroup\LaravelSettingLite\Providers\SettingServiceProvider" --tag=config
```

For creating language file (if need for setting description)

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

## Next steps install for laravel and lumen

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

## Command for sync settings

```
php artisan setting:sync
```

## Custom model

###### Step 1

Create custom model for setting

Example:

File: **app/CustomFile.php**

Content:

```
<?php

namespace App;

class CustomFile extends \ItDevgroup\LaravelSettingLite\Model\Setting
{
}
```

If need added other code:

```
<?php

namespace App;

class CustomFile extends \ItDevgroup\LaravelSettingLite\Model\Setting
{    
    // other code
}
```

###### Step 2

Open **config/setting_lite.php** and change parameter "model", example:

```
...
// replace
'model' => \ItDevgroup\LaravelSettingLite\Model\Setting::class,
// to
'model' => \App\CustomFile::class,
```

###### Step 3

Use custom **\App\CustomFile** model everywhere instead of standard model **\ItDevgroup\LaravelSettingLite\Model\Setting**

## Usage function

Usage function for get setting value

```
setting('SETTING_KEY', 'DEFAULT VALUE IF EMPTY SETTING VALUE')
```

## Usage

#### Initialize service

```
$service = app(\ItDevgroup\LaravelSettingLite\SettingServiceInterface::class);
```

or injected

```
// use
use ItDevgroup\LaravelSettingLite\SettingServiceInterface;
// constructor
public function __construct(
    SettingServiceInterface $settingService
)
```

further we will use the variable **$service**

#### Get types for render on UI

```
$array = $service->getTypes();
```

#### Get groups

Only saved groups from table of settings

```
$array = $service->getGroups();
```

#### List of settings

All settings

```
$eloquentCollection = $service->getList();
```

Settings with filter. All filter parameters not required

```
$filter = (new \ItDevgroup\LaravelSettingLite\Model\SettingFilter())
    ->setIsPublic(true);
    
// or

$filter = (new \ItDevgroup\LaravelSettingLite\Model\SettingFilter())
    ->setKey('partial_key_name')
    ->setType('type_name')
    ->setGroup('group_name')
    ->setIsPublic(true);
$eloquentCollection = $service->getList($filter);
```

Settings with sorting

```
$eloquentCollection = $service->getList(null, $fieldName, $ascOrDesc);
$eloquentCollection = $service->getList(null, 'key', 'ASC');
```

#### Setting by ID

```
$setting = $service->getById(1);
```

#### Setting by KEY

```
$setting = $service->getByKey('SETTING_KEY');
```

#### Setting create

```
$setting = \ItDevgroup\LaravelSettingLite\Model\Setting::register(
    'key_1',
    'test value',
    'text',
    'Test'
);
$setting->options = ['val1', 'val2'];
$setting->is_public = true;
$service->createModel($setting);
```

#### Setting update

```
$setting = $service->getById(1);
$setting->value = 'test value';
$setting->options = ['val1', 'val2'];
$setting->is_public = true;
$service->updateModel($setting);
```

#### Setting delete

```
$setting = $service->getById(1);
$service->deleteModel($setting);
```

#### Test

For test need phpunit

```
vendor/bin/phpunit vendor/it-devgroup/laravel-setting-lite
```
