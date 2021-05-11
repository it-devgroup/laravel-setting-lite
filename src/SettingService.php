<?php

namespace ItDevgroup\LaravelSettingLite;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use ItDevgroup\LaravelSettingLite\Model\Setting;
use ItDevgroup\LaravelSettingLite\Model\SettingFilter;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionException;

/**
 * Class SettingService
 * @package ItDevgroup\LaravelSettingLite
 */
class SettingService implements SettingServiceInterface
{
    /**
     * @var string
     */
    private string $modelName;

    /**
     * SettingService constructor.
     */
    public function __construct()
    {
        $this->modelName = Config::get('setting_lite.model');
    }

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
    ): Collection {
        /** @var Builder $builder */
        $builder = $this->modelName::query();
        $this->filter($builder, $filter);
        $builder->orderBy($sortField, $sortDirection);

        return $builder->get();
    }

    /**
     * @param int $id
     * @return Setting|Model|null
     */
    public function getById(int $id): ?Model
    {
        /** @var Builder $builder */
        $builder = $this->modelName::query();
        $builder->where('id', '=', $id);

        return $builder->firstOrFail();
    }

    /**
     * @param string $key
     * @return Setting|Model|null
     */
    public function getByKey(string $key): ?Model
    {
        /** @var Builder $builder */
        $builder = $this->modelName::query();
        $builder->where('key', '=', $key);

        return $builder->firstOrFail();
    }

    /**
     * @param Setting $setting
     * @return bool
     */
    public function createModel(Setting $setting): bool
    {
        return $setting->save();
    }

    /**
     * @param Setting $setting
     * @return bool
     */
    public function updateModel(Setting $setting): bool
    {
        return $setting->save();
    }

    /**
     * @param Setting $setting
     * @return bool
     * @throws Exception
     */
    public function deleteModel(Setting $setting): bool
    {
        return $setting->delete();
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getTypes(): array
    {
        $class = new ReflectionClass($this->modelName);
        if (!count($class->getConstants())) {
            return [];
        }

        $data = [];
        /** @var ReflectionClassConstant $constant */
        foreach ($class->getReflectionConstants() as $constant) {
            if (substr($constant->getName(), 0, 5) != 'TYPE_') {
                continue;
            }

            $data[] = $constant->getValue();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        /** @var Builder $builder */
        $builder = $this->modelName::query();
        $builder->groupBy('group');
        $builder->orderBy('group', 'ASC');

        return $builder->pluck('group')->toArray();
    }

    /**
     * @param Builder $builder
     * @param SettingFilter|null $filter
     */
    private function filter(Builder $builder, ?SettingFilter $filter = null): void
    {
        if (!$filter) {
            return;
        }

        if ($filter->getKey()) {
            $builder->where('key', 'LIKE', sprintf('%%%s%%', $filter->getKey()));
        }
        if ($filter->getType()) {
            $builder->where('type', '=', $filter->getType());
        }
        if ($filter->getGroup()) {
            $builder->where('group', '=', $filter->getGroup());
        }
        if (!is_null($filter->isPublic())) {
            $builder->where('is_public', '=', $filter->isPublic());
        }
    }
}
