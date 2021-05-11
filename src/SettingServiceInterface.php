<?php

namespace ItDevgroup\LaravelSettingLite;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use ItDevgroup\LaravelSettingLite\Model\Setting;
use ItDevgroup\LaravelSettingLite\Model\SettingFilter;

/**
 * Interface SettingServiceInterface
 * @package ItDevgroup\LaravelSettingLite
 */
interface SettingServiceInterface
{
    /**
     * @param SettingFilter|null $filter
     * @param string|null $sortField
     * @param string|null $sortDirection
     * @return Collection
     */
    public function getList(
        ?SettingFilter $filter = null,
        ?string $sortField = 'key',
        ?string $sortDirection = 'ASC'
    ): Collection;

    /**
     * @param int $id
     * @return Setting|Model|null
     */
    public function getById(int $id): ?Model;

    /**
     * @param string $key
     * @return Setting|Model|null
     */
    public function getByKey(string $key): ?Model;

    /**
     * @param Setting $setting
     * @return bool
     */
    public function createModel(Setting $setting): bool;

    /**
     * @param Setting $setting
     * @return bool
     */
    public function updateModel(Setting $setting): bool;

    /**
     * @param Setting $setting
     * @return bool
     */
    public function deleteModel(Setting $setting): bool;

    /**
     * @return array
     */
    public function getTypes(): array;

    /**
     * @return array
     */
    public function getGroups(): array;
}
