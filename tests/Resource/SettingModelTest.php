<?php

namespace ItDevgroup\LaravelSettingLite\Test\Resource;

use ItDevgroup\LaravelSettingLite\Model\Setting;
use ReflectionClass;
use ReflectionException;

/**
 * Class SettingModelTest
 * @package ItDevgroup\LaravelSettingLite\Test\Resource
 */
class SettingModelTest extends Setting
{
    /**
     * @return SettingDB|object
     * @throws ReflectionException
     */
    public static function query()
    {
        return (new ReflectionClass(SettingDB::class))
            ->newInstanceWithoutConstructor();
    }
}
