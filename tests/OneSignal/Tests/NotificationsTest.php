<?php

namespace OneSignal\Tests;

use OneSignal\Notifications;

class NotificationsTest extends AbstractApiTest
{
    /**
     * @var Notifications
     */
    private $notifications;

    public function setUp()
    {
        parent::setUp();

        $this->notifications = new Notifications($this->api, $this->resolverFactory);
    }

    public function testGetOne()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'GET',
            '/notifications/'.$fakeId.'?app_id=fakeApplicationId',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->notifications->getOne($fakeId));
    }

    public function testGetAll()
    {
        $expectedRequest = [
            'GET',
            '/notifications?limit=3&offset=12&app_id=fakeApplicationId',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->notifications->getAll(3, 12));
    }

    public function testAdd()
    {
        $expectedRequest = [
            'POST',
            '/notifications',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            '{"data":"myData"}',
        ];

        $this->resolverFactory->expects($this->once())->method('createNotificationResolver');
        $this->assertEquals($expectedRequest, $this->notifications->add(['data' => 'myData']));
    }

    public function testOpen()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'PUT',
            '/notifications/'.$fakeId,
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            '{"app_id":"fakeApplicationId","opened":true}',
        ];

        $this->assertEquals($expectedRequest, $this->notifications->open($fakeId));
    }

    public function testCancel()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'DELETE',
            '/notifications/'.$fakeId.'?app_id=fakeApplicationId',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->notifications->cancel($fakeId));
    }

    public function testHistory()
    {
        $fakeId = 1234;
        $expectedRequest = [
            'POST',
            '/notifications/'.$fakeId.'/history?app_id=fakeApplicationId',
            ['Authorization' => 'Basic fakeApplicationAuthKey', 'Cache-Control' => 'no-cache'],
            '{"events":"sent","email":"example@example.com"}',
        ];

        $this->assertEquals($expectedRequest, $this->notifications->history($fakeId, ['events' => 'sent', 'email' => 'example@example.com']));
    }
}
