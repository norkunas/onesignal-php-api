<?php

namespace OneSignal\Tests;

use GuzzleHttp\Client;
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

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testBadInstance()
    {
        $this->api->unknownInstance;
    }

    public function testConfig()
    {
        $config = new Config();
        $this->api->setConfig($config);

        $this->assertSame($config, $this->api->getConfig());
    }

    public function testClient()
    {
        $client = new Client();
        $this->api->setClient($client);

        $this->assertSame($client, $this->api->getClient());
    }
}
