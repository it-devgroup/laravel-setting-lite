<?php

namespace ItDevgroup\LaravelSettingLite\Test;

use ItDevgroup\LaravelSettingLite\Model\SettingModel;

/**
 * Class ModelTest
 * @package ItDevgroup\LaravelSettingLite\Test
 */
class SettingTest extends TestCase
{
    /**
     * @test
     */
    public function settingTestModelCreate()
    {
        $model = new SettingModel(
            [
                'key' => 'key_1',
                'description' => 'desc1',
                'value' => 'val1',
                'options' => [
                    'v1',
                    'v2'
                ],
                'type' => SettingModel::TYPE_TEXT,
                'group' => 'Main',
                'is_public' => true,
            ]
        );

        $this->assertTrue($model->key == 'key_1');
        $this->assertTrue($model->description == 'desc1');
        $this->assertTrue($model->value == 'val1');
        $this->assertCount(2, $model->options);
        $this->assertTrue($model->type == SettingModel::TYPE_TEXT);
        $this->assertTrue($model->group == 'Main');
        $this->assertTrue($model->is_public == true);
    }

    /**
     * @test
     */
    public function settingTestModelCreateWithDescriptionLexicon()
    {
        $model = new SettingModel(
            [
                'key' => 'key_1',
                'value' => 'val1',
                'options' => [
                    'v1',
                    'v2'
                ],
                'type' => SettingModel::TYPE_TEXT,
                'group' => 'Main',
                'is_public' => true,
            ]
        );

        $this->assertTrue($model->key == 'key_1');
        $this->assertTrue($model->description == 'description from lexicon');
        $this->assertTrue($model->value == 'val1');
        $this->assertCount(2, $model->options);
        $this->assertTrue($model->type == SettingModel::TYPE_TEXT);
        $this->assertTrue($model->group == 'Main');
        $this->assertTrue($model->is_public == true);
    }

    /**
     * @test
     */
    public function settingTestModelUpdate()
    {
        $model = new SettingModel(
            [
                'key' => 'key_1',
                'description' => 'desc1',
                'value' => 'val1',
                'options' => [
                    'v1',
                    'v2'
                ],
                'type' => SettingModel::TYPE_TEXT,
                'group' => 'Main',
                'is_public' => true,
            ]
        );

        $model->key = 'upd_key_1';
        $model->description = 'upd desc1';
        $model->value = 'upd val1';
        $model->options = ['v3'];
        $model->type = SettingModel::TYPE_BOOLEAN;
        $model->group = 'Main2';
        $model->is_public = false;

        $this->assertTrue($model->key == 'upd_key_1');
        $this->assertTrue($model->description == 'upd desc1');
        $this->assertTrue($model->value == 'upd val1');
        $this->assertCount(1, $model->options);
        $this->assertTrue($model->type == SettingModel::TYPE_BOOLEAN);
        $this->assertTrue($model->group == 'Main2');
        $this->assertTrue($model->is_public == false);

        $model->description = '';

        $this->assertTrue($model->description == 'upd description from lexicon');
    }

    /**
     * @test
     */
    public function settingTestTypes()
    {
        $this->assertCount(10, SettingModel::getTypes());
    }
}
