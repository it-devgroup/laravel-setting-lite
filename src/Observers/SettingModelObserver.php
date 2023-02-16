<?php

namespace ItDevgroup\LaravelSettingLite\Observers;

use ItDevgroup\LaravelSettingLite\Exceptions\SettingException;
use ItDevgroup\LaravelSettingLite\Model\SettingModel;

/**
 * Class SettingModelObserver
 * @package ItDevgroup\LaravelSettingLite\Observers
 */
class SettingModelObserver
{
    /**
     * @param SettingModel $model
     * @return void
     * @throws SettingException
     */
    public function creating(SettingModel $model): void
    {
        $count = SettingModel::query()
            ->where('key', '=', $model->key)
            ->count();
        if ($count) {
            throw SettingException::keyDuplicate($model);
        }
    }

    /**
     * @param SettingModel $model
     * @return void
     * @throws SettingException
     */
    public function updating(SettingModel $model): void
    {
        $count = SettingModel::query()
            ->where('key', '=', $model->key)
            ->where('id', '!=', $model->id)
            ->count();
        if ($count) {
            throw SettingException::keyDuplicate($model);
        }
    }
}
