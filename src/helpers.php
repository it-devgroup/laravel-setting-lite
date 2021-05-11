<?php

if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        /** @var \ItDevgroup\LaravelSettingLite\SettingServiceInterface $setting */
        $setting = app(\ItDevgroup\LaravelSettingLite\SettingServiceInterface::class);

        try {
            $value = $setting->getByKey($key)->value;
        } catch (Exception $e) {
            $value = null;
        }

        if (!$value) {
            $value = $default;
        }

        return $value;
    }
}
