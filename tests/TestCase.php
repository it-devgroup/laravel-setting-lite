<?php

namespace ItDevgroup\LaravelSettingLite\Test;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 */
class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::partialMock()
            ->shouldReceive('get')
            ->andReturnUsing(function ($path) {
                switch ($path) {
                    case 'setting_lite.description_field_from_lexicon':
                        return true;
                    case 'setting_lite.lexicon':
                        return 'setting_lite';
                }

                return null;
            });

        Lang::partialMock()
            ->shouldReceive('has')
            ->andReturnTrue();

        Lang::partialMock()
            ->shouldReceive('get')
            ->andReturnUsing(function ($path) {
                switch ($path) {
                    case 'setting_lite.setting.key_1':
                        return 'description from lexicon';
                    case 'setting_lite.setting.upd_key_1':
                        return 'upd description from lexicon';
                }

                return null;
            });

        parent::setUp();
    }
}
