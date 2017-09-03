<?php

namespace OneSignal\Tests;

use OneSignal\Apps;

class AppsTest extends AbstractApiTest
{
    /**
     * @var Apps
     */
    private $apps;

    public function setUp()
    {
        parent::setUp();

        $this->apps = new Apps($this->api, $this->resolverFactory);
    }

    public function testGetOne()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'GET',
            '/apps/'.$fakeId,
            ['Authorization' => 'Basic fakeUserAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->apps->getOne($fakeId));
    }

    public function testGetAll()
    {
        $expectedRequest = [
            'GET',
            '/apps',
            ['Authorization' => 'Basic fakeUserAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->apps->getAll());
    }

    public function testAdd()
    {
        $expectedRequest = [
            'POST',
            '/apps',
            ['Authorization' => 'Basic fakeUserAuthKey'],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createAppResolver');
        $this->assertEquals($expectedRequest, $this->apps->add(['data' => 'myData']));
    }

    public function testUpdate()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'PUT',
            '/apps/'.$fakeId,
            ['Authorization' => 'Basic fakeUserAuthKey'],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createAppResolver');
        $this->assertEquals($expectedRequest, $this->apps->update($fakeId, ['data' => 'myData']));
    }
}
