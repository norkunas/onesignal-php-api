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
     * @var ResolverFactory
     */
    protected $resolverFactory;

    public function setUp()
    {
        /* Mock resolverFactory */
        $mockResolver = $this->getMockBuilder(ResolverInterface::class)->getMock();
        $mockResolver->method('resolve')->will($this->returnArgument(0));

        $resolverFactory = $this->getMockBuilder(ResolverFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        foreach (get_class_methods($resolverFactory) as $method) {
            $resolverFactory->method($method)->willReturn($mockResolver);
        }
        $this->resolverFactory = $resolverFactory;

        /* Mock api */
        $api = $this->getMockBuilder(OneSignal::class)->getMock();
        $api->method('request')->will($this->returnCallback([$this, 'requestCallback']));
        $api->method('getConfig')->willReturn($this->createMockedConfig());
        $this->api = $api;
    }

    public function requestCallback()
    {
        $args = func_get_args();
        $method = $args[0];
        $url = $args[1];
        $header = $args[2];
        $body = $args[3];

        return [$method, $url, $header, $body];
    }
}
