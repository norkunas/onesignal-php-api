<?php

namespace OneSignal\Tests;

use OneSignal\Config;
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

    public function testRequestParseJSONResponse()
    {
        $expectedData = [
            'content' => 'jsondata',
        ];

        $fakeResponse = $this->getMockBuilder(ResponseInterface::class)
            ->getMock();
        $fakeResponse->method('getBody')->willReturn(json_encode($expectedData));

        $client = $this->getMockBuilder('Http\Client\Common\HttpMethodsClient')
            ->disableOriginalConstructor()
            ->getMock();
        $client->method('send')->willReturn($fakeResponse);

        $this->api->setClient($client);

        $this->assertEquals($expectedData, $this->api->request('fakeMethod', 'fakeURI'));
    }

    /**
     * @expectedException \OneSignal\Exception\OneSignalException
     */
    public function testRequestHandleExceptions()
    {
        $client = $this->getMockBuilder('Http\Client\Common\HttpMethodsClient')
            ->disableOriginalConstructor()
            ->getMock();
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
