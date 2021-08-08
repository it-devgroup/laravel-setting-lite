<?php

namespace ItDevgroup\LaravelSettingLite\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ItDevgroup\LaravelSettingLite\Model\SettingFilter;
use ItDevgroup\LaravelSettingLite\Test\Resource\SettingModelTest;

/**
 * Class ServiceTest
 */
class ServiceTest extends TestCase
{
    /**
     * @test
     */
    public function serviceTestListResult()
    {
        $res = $this->service->getList();
        $this->assertCount(3, $res);
    }

    /**
     * @test
     */
    public function serviceTestByIdSuccess()
    {
        $res = $this->service->getById(1);
        $this->assertTrue($res instanceof Model);
    }

    /**
     * @test
     */
    public function serviceTestByIdError()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->getById(0);
    }

    /**
     * @test
     */
    public function serviceTestByKeySuccess()
    {
        $res = $this->service->getByKey('key_1');
        $this->assertTrue($res instanceof Model);
    }

    /**
     * @test
     */
    public function serviceTestByKeyError()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->getByKey('0');
    }

    /**
     * @test
     */
    public function serviceTestGetTypesSuccess()
    {
        $res = $this->service->getTypes();
        $this->assertEquals(
            $res,
            [
                'text',
                'multilinetext',
                'boolean',
                'integer',
                'float',
                'list',
                'multilist',
            ]
        );
    }

    /**
     * @test
     */
    public function serviceTestGetGroupsSuccess()
    {
        $res = $this->service->getGroups();
        $this->assertEquals(
            $res,
            [
                'Group 1',
                'Group 2',
                'Group 3',
            ]
        );
    }

    /**
     * @test
     */
    public function serviceTestFilterResult()
    {
        $filter = new SettingFilter();

        $this->assertNull($filter->getKey());
        $this->assertNull($filter->getType());
        $this->assertNull($filter->getGroup());
        $this->assertNull($filter->isPublic());

        $filter->setKey('key_1');
        $this->assertTrue($filter->getKey() == 'key_1');

        $filter->setType('type_1');
        $this->assertTrue($filter->getType() == 'type_1');

        $filter->setGroup('group 1');
        $this->assertTrue($filter->getGroup() == 'group 1');

        $filter->setIsPublic(true);
        $this->assertTrue($filter->isPublic());
        $filter->setIsPublic(false);
        $this->assertFalse($filter->isPublic());
    }
}
