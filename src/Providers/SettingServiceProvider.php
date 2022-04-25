<?php

namespace ItDevgroup\LaravelSettingLite\Providers;

use Illuminate\Support\ServiceProvider;
use ItDevgroup\LaravelSettingLite\Console\Commands\SettingPublishCommand;
use ItDevgroup\LaravelSettingLite\Console\Commands\SettingSyncCommand;
use ItDevgroup\LaravelSettingLite\SettingService;
use ItDevgroup\LaravelSettingLite\SettingServiceInterface;

/**
 * Class SettingServiceProvider
 * @package ItDevgroup\LaravelSettingLite\Providers
 */
class SettingServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $appVersion;

    /**
     * @return void
     */
    public function boot()
    {
        $this->appVersion = explode('.', $this->app->version())[0];

        $this->loadCustomCommands();
        $this->loadCustomConfig();
        $this->loadCustomPublished();
        $this->loadCustomClasses();
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
                    __DIR__ . '/../../resources/lang' => $this->appVersion >= 9
                        && get_class($this->app) != 'Laravel\Lumen\Application'
                            ? base_path('lang') : resource_path('lang')
                ],
                'lang'
            );
        }
    }

    /**
     * @return void
     */
    private function loadCustomClasses()
    {
        $this->app->singleton(SettingServiceInterface::class, SettingService::class);
    }
}
