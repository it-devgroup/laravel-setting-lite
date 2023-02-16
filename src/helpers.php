<?php

use ItDevgroup\LaravelSettingLite\Model\SettingModel;

if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        $builder = SettingModel::query();
        $builder->where('key', '=', $key);

        $value = $builder->first()?->value;

        if (!$value) {
            $value = $default;
        }

        return $value;
    }
}
