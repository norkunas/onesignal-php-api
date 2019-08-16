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

    public function testCreateSegment()
    {
        $fakeAppId = '85f0e7eb-df11-4a86-ab5a-603a6c0a14c6';
        $expectedRequest = [
            'POST',
            '/apps/'.$fakeAppId.'/segments',
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            '{"id":"52d5a7cb-59fe-4d0c-a0b9-9a39a21475ad","name":"Custom Segment","filters":[{"field":"session_count","relation":">","value":"1"},{"operator":"AND"},{"field":"tag","relation":"!=","key":"tag_key","value":"1"},{"operator":"OR"},{"field":"last_session","relation":"<","value":"30"}]}',
        ];

        $this->resolverFactory->expects($this->once())->method('createSegmentResolver');
        $this->assertEquals($expectedRequest, $this->apps->createSegment($fakeAppId, ['id' => '52d5a7cb-59fe-4d0c-a0b9-9a39a21475ad', 'name' => 'Custom Segment', 'filters' => [['field' => 'session_count', 'relation' => '>', 'value' => '1'], ['operator' => 'AND'], ['field' => 'tag', 'relation' => '!=', 'key' => 'tag_key', 'value' => '1'], ['operator' => 'OR'], ['field' => 'last_session', 'relation' => '<', 'value' => '30']]]));
    }

    public function testDeleteSegment()
    {
        $fakeAppId = '85f0e7eb-df11-4a86-ab5a-603a6c0a14c6';
        $fakeSegmentId = 'a98c618f-f680-4b3a-9cdd-0957873c13b6';
        $expectedRequest = [
            'DELETE',
            '/apps/'.$fakeAppId.'/segments/'.$fakeSegmentId,
            ['Authorization' => 'Basic fakeApplicationAuthKey'],
            null,
        ];

        $this->assertEquals($expectedRequest, $this->apps->deleteSegment($fakeAppId, $fakeSegmentId));
    }
}
