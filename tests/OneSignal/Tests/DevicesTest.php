<?php

namespace OneSignal\Tests;

use OneSignal\Devices;

class DevicesTest extends AbstractApiTest
{
    /**
     * @var Devices;
     */
    private $devices;

    public function setUp()
    {
        parent::setUp();

        $this->devices = new Devices($this->api, $this->resolverFactory);
    }

    public function testGetOne()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'GET',
            '/players/'.$fakeId.'?app_id=fakeApplicationId',
            [],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->devices->getOne($fakeId));
    }

    public function testGetAll()
    {
        $expectedRequest = [
            'GET',
            '/players?limit=3&offset=12&app_id=fakeApplicationId',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->devices->getAll(3, 12));
    }

    public function testAdd()
    {
        $expectedRequest = [
            'POST',
            '/players',
            [],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createNewDeviceResolver');
        $this->assertEquals($expectedRequest, $this->devices->add(['data' => 'myData']));
    }

    public function testUpdate()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'PUT',
            '/players/'.$fakeId,
            [],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createExistingDeviceResolver');
        $this->assertEquals($expectedRequest, $this->devices->update($fakeId, ['data' => 'myData']));
    }

    public function testOnSession()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'POST',
            '/players/'.$fakeId.'/on_session',
            [],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createDeviceSessionResolver');
        $this->assertEquals($expectedRequest, $this->devices->onSession($fakeId, ['data' => 'myData']));
    }

    public function testOnPurchase()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'POST',
            '/players/'.$fakeId.'/on_purchase',
            [],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createDevicePurchaseResolver');
        $this->assertEquals($expectedRequest, $this->devices->onPurchase($fakeId, ['data' => 'myData']));
    }

    public function testCsvExport()
    {
        $expectedRequest = [
            'POST',
            '/players/csv_export?app_id=fakeApplicationId',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            '{"extra_fields":["myField1","myField2"]}',
        ];

        $this->assertEquals($expectedRequest, $this->devices->csvExport(['myField1', 'myField2']));
    }
}
