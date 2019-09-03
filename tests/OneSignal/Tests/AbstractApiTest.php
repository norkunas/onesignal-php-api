<?php

namespace OneSignal\Tests;

use OneSignal\OneSignal;
use OneSignal\Resolver\ResolverFactory;
use OneSignal\Resolver\ResolverInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractApiTest extends TestCase
{
    use ConfigMockerTrait;

    /**
     * @var OneSignal
     */
    protected $api;

    /**
     * @var ResolverFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resolverFactory;

    public function setUp()
    {
        $mockResolver = $this->createMock(ResolverInterface::class);
        $mockResolver->method('resolve')->willReturnArgument(0);

        $resolverFactory = $this->createMock(ResolverFactory::class);
        $resolverMethods = array_filter(get_class_methods($resolverFactory), function ($method) {
            return 0 === strpos($method, 'create');
        });
        foreach ($resolverMethods as $method) {
            $resolverFactory->method($method)->willReturn($mockResolver);
        }

        $this->resolverFactory = $resolverFactory;

        $api = $this->createMock(OneSignal::class);
        $api->method('request')->willReturnCallback([$this, 'requestCallback']);
        $api->method('getConfig')->willReturn($this->createMockedConfig());
        $this->api = $api;
    }

    public function requestCallback()
    {
        list($method, $url, $header, $body) = func_get_args();

        return [$method, $url, $header, $body];
    }
}
