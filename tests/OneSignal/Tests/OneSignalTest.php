<?php

namespace OneSignal\Tests;

use Http\Client\Common\HttpMethodsClient;
use OneSignal\Apps;
use OneSignal\Config;
use OneSignal\Devices;
use OneSignal\Notifications;
use OneSignal\OneSignal;
use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;

class OneSignalTest extends TestCase
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
        $this->assertInstanceOf(Apps::class, $this->api->apps);
        $this->assertInstanceOf(Devices::class, $this->api->devices);
        $this->assertInstanceOf(Notifications::class, $this->api->notifications);
    }

    public function testIfInstanceIsCached()
    {
        $this->assertInstanceOf(Apps::class, $this->api->apps);
        $this->assertInstanceOf(Apps::class, $this->api->apps);
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
        $client = $this->createMock(HttpMethodsClient::class);

        $api = new OneSignal(null, $client);

        $this->assertInstanceOf(HttpMethodsClient::class, $api->getClient());
    }

    public function testClientWithSetterAndGetter()
    {
        $client = $this->createMock(HttpMethodsClient::class);

        $this->api->setClient($client);

        $this->assertInstanceOf(HttpMethodsClient::class, $this->api->getClient());
    }

    public function testConfigWithSetterAndGetter()
    {
        $this->api->setConfig(new Config());

        $this->assertInstanceOf(Config::class, $this->api->getConfig());
    }

    public function testRequestParseJSONResponse()
    {
        $expectedData = [
            'content' => 'jsondata',
        ];

        $fakeResponse = $this->createMock(ResponseInterface::class);
        $fakeResponse->method('getBody')->willReturn(json_encode($expectedData));

        $client = $this->createMock(HttpMethodsClient::class);
        $client->method('send')->willReturn($fakeResponse);

        $this->api->setClient($client);

        $this->assertEquals($expectedData, $this->api->request('fakeMethod', 'fakeURI'));
    }

    /**
     * @expectedException \OneSignal\Exception\OneSignalException
     */
    public function testRequestHandleExceptions()
    {
        $client = $this->createMock(HttpMethodsClient::class);
        $client->method('send')->will($this->throwException(new \Exception()));

        $this->api->setClient($client);
        $this->api->request('DummyMethod', 'DummyURI');
    }

    /**
     * @expectedException \OneSignal\Exception\OneSignalException
     */
    public function testMagicGetHandleRequest()
    {
        $this->api->unexistingService;
    }
}
