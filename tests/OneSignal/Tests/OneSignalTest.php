<?php

namespace OneSignal\Tests;

use OneSignal\Config;
use OneSignal\OneSignal;

class OneSignalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OneSignal
     */
    private $api;

    public function setUp()
    {
        $this->api = new OneSignal();
    }

    public function testInstances()
    {
        $this->assertInstanceOf('OneSignal\Apps', $this->api->apps);
        $this->assertInstanceOf('OneSignal\Devices', $this->api->devices);
        $this->assertInstanceOf('OneSignal\Notifications', $this->api->notifications);
    }

    public function testIfInstanceIsCached()
    {
        $this->assertInstanceOf('OneSignal\Apps', $this->api->apps);
        $this->assertInstanceOf('OneSignal\Apps', $this->api->apps);
    }

    /**
     * @expectedException \OneSignal\Exception\OneSignalException
     */
    public function testBadInstance()
    {
        $this->api->unknownInstance;
    }

    public function testClientSetFromConstructor()
    {
        $client = $this->getMockBuilder('Http\Client\Common\HttpMethodsClient')
            ->disableOriginalConstructor()
            ->getMock();

        $api = new OneSignal(null, $client);

        $this->assertInstanceOf('Http\Client\Common\HttpMethodsClient', $api->getClient());
    }

    public function testClientWithSetterAndGetter()
    {
        $client = $this->getMockBuilder('Http\Client\Common\HttpMethodsClient')
            ->disableOriginalConstructor()
            ->getMock();

        $this->api->setClient($client);

        $this->assertInstanceOf('Http\Client\Common\HttpMethodsClient', $this->api->getClient());
    }

    public function testConfigWithSetterAndGetter()
    {
        $this->api->setConfig(new Config());

        $this->assertInstanceOf('OneSignal\Config', $this->api->getConfig());
    }
}
