<?php

namespace OneSignal\Tests;

use OneSignal\OneSignal;

/**
 * @covers OneSignal
 */
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

    /**
     * @covers OneSignal::__get
     */
    public function testInstances()
    {
        $this->assertInstanceOf('OneSignal\Apps', $this->api->apps);
        $this->assertInstanceOf('OneSignal\Devices', $this->api->devices);
        $this->assertInstanceOf('OneSignal\Notifications', $this->api->notifications);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testBadInstance()
    {
        $this->api->unknownInstance;
    }

    public function testConfig()
    {
        $this->assertInstanceOf('OneSignal\Config', $this->api->getConfig());
    }

    public function testClient()
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->api->getClient());
    }
}
