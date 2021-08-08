<?php

namespace ItDevgroup\LaravelSettingLite\Test\Resource;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionSupport;

/**
 * Class SettingDB
 * @package ItDevgroup\LaravelSettingLite\Test\Resource
 */
class SettingDB extends Builder
{
    /**
     * @var bool
     */
    private bool $failedResult = false;

    /**
     * @param string $column
     * @param string $direction
     * @return self
     */
    public function orderBy($column, $direction = 'asc')
    {
        return $this;
    }

    /**
     * @param array|string ...$groups
     * @return self
     */
    public function groupBy(...$groups)
    {
        return $this;
    }

    /**
     * @param string $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return self
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->failedResult = $value == '0';

        return $this;
    }

    public function first($columns = ['*'])
    {
        $this->model = new SettingModelTest();
        if ($this->failedResult) {
            return null;
        }

        return $this->get()->first();
    }

    /**
     * @param string $column
     * @param null $key
     * @return CollectionSupport
     */
    public function pluck($column, $key = null)
    {
        return $this->get()->pluck($column);
    }

    /**
     * @param array|string|string[] $columns
     * @return Collection|SettingDB[]
     */
    public function get($columns = ['*'])
    {
        $data = new Collection();
        $model = new SettingModelTest();
        $model->key = 'test_1';
        $model->value = 'value 1';
        $model->group = 'Group 1';
        $data->push(
            $model
        );
        $model = new SettingModelTest();
        $model->key = 'test_2';
        $model->value = 'value 2';
        $model->group = 'Group 2';
        $data->push(
            $model
        );
        $model = new SettingModelTest();
        $model->key = 'test_3';
        $model->value = 'value 3';
        $model->group = 'Group 3';
        $data->push(
            $model
        );

        return $data;
    }

}
