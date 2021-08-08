<?php

namespace ItDevgroup\LaravelSettingLite\Test;

use ItDevgroup\LaravelSettingLite\SettingService;
use ItDevgroup\LaravelSettingLite\Test\Resource\SettingModelTest;
use PHPUnit\Framework\TestCase as BaseTestCase;
use ReflectionClass;

/**
 * Class TestCase
 */
class TestCase extends BaseTestCase
{
    /**
     * @var ReflectionClass|null
     */
    protected ?ReflectionClass $reflectionClass = null;
    /**
     * @var SettingService|object|null
     */
    protected ?SettingService $service = null;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->reflectionClass = new ReflectionClass(SettingService::class);
        $this->service = $this->reflectionClass->newInstanceWithoutConstructor();
        $reflectionProperty = $this->reflectionClass->getProperty('modelName');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(
            $this->service,
            SettingModelTest::class
        );
    }
}
