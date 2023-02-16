<?php

namespace ItDevgroup\LaravelSettingLite\Providers;

use Illuminate\Support\ServiceProvider;
use ItDevgroup\LaravelSettingLite\Console\Commands\SettingPublishCommand;
use ItDevgroup\LaravelSettingLite\Console\Commands\SettingSyncCommand;
use ItDevgroup\LaravelSettingLite\Model\SettingModel;
use ItDevgroup\LaravelSettingLite\Observers\SettingModelObserver;

/**
 * Class SettingServiceProvider
 * @package ItDevgroup\LaravelSettingLite\Providers
 */
class SettingServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->loadCustomCommands();
        $this->loadCustomConfig();
        $this->loadCustomPublished();
        $this->loadObservers();
    }

    /**
     * @return void
     */
    private function loadCustomCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    SettingSyncCommand::class,
                    SettingPublishCommand::class,
                ]
            );
        }
    }

    /**
     * @return void
     */
    private function loadCustomConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/setting_lite.php', 'setting_lite');
    }

    /**
     * @return void
     */
    private function loadCustomPublished()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../../config' => base_path('config')
                ],
                'config'
            );
            $this->publishes(
                [
                    __DIR__ . '/../../migration' => database_path('migrations')
                ],
                'migration'
            );
            $this->publishes(
                [
                    __DIR__ . '/../../resources/lang' => app('path.lang')
                ],
                'lang'
            );
        }
    }

    /**
     * @return void
     */
    private function loadObservers()
    {
        SettingModel::observe(SettingModelObserver::class);
    }
}
