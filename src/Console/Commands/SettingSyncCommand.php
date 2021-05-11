<?php

namespace ItDevgroup\LaravelSettingLite\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use ItDevgroup\LaravelSettingLite\Model\Setting;

/**
 * Class SettingSyncCommand
 * @package ItDevgroup\LaravelSettingLite\Console\Commands
 */
class SettingSyncCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'setting:sync';
    /**
     * @var string
     */
    protected $description = 'Synchronization of settings';
    /**
     * @var string|null
     */
    private ?string $dataClassName = null;
    /**
     * @var string|null
     */
    private ?string $dataMethodName = null;
    /**
     * @var bool|null
     */
    private ?bool $syncCreate = false;
    /**
     * @var bool|null
     */
    private ?bool $syncDelete = false;
    /**
     * @var Collection|null
     */
    private ?Collection $syncUpdateFields = null;
    /**
     * @var string|null
     */
    private ?string $modelName = null;

    /**
     * @throws Exception
     */
    public function handle()
    {
        $this->setupConfig();

        if (!$this->dataClassName || !$this->dataMethodName) {
            $this->error('Config sync not setup class name or class static method');
            return;
        }

        $data = $this->getData();

        $this->checkData($data);
    }

    /**
     * @return void
     */
    private function setupConfig(): void
    {
        $this->dataClassName = Config::get('setting_lite.data.class');
        $this->dataMethodName = Config::get('setting_lite.data.method');
        $this->syncCreate = (bool)Config::get('setting_lite.sync.create');
        $this->syncDelete = (bool)Config::get('setting_lite.sync.delete');
        $this->syncUpdateFields = Collection::make(Config::get('setting_lite.sync.update_fields'));
        $this->modelName = Config::get('setting_lite.model');
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return $this->dataClassName::{$this->dataMethodName}();
    }

    /**
     * @param array $data
     * @throws Exception
     */
    private function checkData(array $data): void
    {
        $data = $this->getDataFormatted($data);

        /** @var Setting $row */
        foreach ($this->modelName::query()->cursor() as $row) {
            if (!$data->get($row->key)) {
                if ($this->syncDelete) {
                    $row->delete();
                }
                continue;
            }
            if ($data->get($row->key)) {
                $this->updateRow($row, Collection::make($data->get($row->key)));
                $data->offsetUnset($row->key);
            }
        }

        $this->createRows($data);
    }

    /**
     * @param array $data
     * @return Collection
     */
    private function getDataFormatted(array $data): Collection
    {
        $collect = Collection::make();

        foreach ($data as $row) {
            $collect->put($row['key'], $row);
        }

        return $collect;
    }

    /**
     * @param Setting $setting
     * @param Collection $data
     */
    private function updateRow(Setting $setting, Collection $data): void
    {
        foreach ($this->syncUpdateFields as $field) {
            if ($field == 'options') {
                $this->prepareFieldOptions($data);
            }
            $setting->$field = $data->get($field);
        }
        $setting->save();
    }

    /**
     * @param Collection $data
     */
    private function createRows(Collection $data): void
    {
        if (!$this->syncCreate) {
            return;
        }

        foreach ($data as $row) {
            $row = Collection::make($row);
            $row->offsetUnset('id');
            $setting = new $this->modelName();
            foreach ($row->keys() as $field) {
                if ($field == 'options') {
                    $this->prepareFieldOptions($row);
                }
                $setting->$field = $row->get($field);
            }
            $setting->save();
        }
    }

    /**
     * @param Collection $data
     */
    private function prepareFieldOptions(Collection $data)
    {
        if (!$data->get('options')) {
            $data->put('options', null);
            return;
        } elseif (is_array($data->get('options'))) {
            return;
        }

        $data->put('options', Collection::make(json_decode($data->get('options'), true))->toArray());
    }
}
