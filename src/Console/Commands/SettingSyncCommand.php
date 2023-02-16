<?php

namespace ItDevgroup\LaravelSettingLite\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use ItDevgroup\LaravelSettingLite\Model\SettingModel;

/**
 * Class SettingSyncCommand
 * @package ItDevgroup\LaravelSettingLite\Console\Commands
 */
class SettingSyncCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected $signature = 'setting:sync';
    /**
     * @inheritdoc
     */
    protected $description = 'Synchronization of settings';
    private ?string $dataClassName = null;
    private ?string $dataMethodName = null;
    private ?bool $syncCreate = false;
    private ?bool $syncDelete = false;
    private ?Collection $syncUpdateFields = null;

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

        /** @var SettingModel $row */
        foreach (SettingModel::query()->cursor() as $row) {
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
     * @param SettingModel $setting
     * @param Collection $data
     */
    private function updateRow(SettingModel $setting, Collection $data): void
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
            $setting = new SettingModel();
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
