<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\AppResolver;
use OneSignal\Resolver\DeviceFocusResolver;
use OneSignal\Resolver\DevicePurchaseResolver;
use OneSignal\Resolver\DeviceResolver;
use OneSignal\Resolver\DeviceSessionResolver;
use OneSignal\Resolver\NotificationResolver;
use OneSignal\Resolver\ResolverFactory;
use OneSignal\Tests\ConfigMockerTrait;
use PHPUnit\Framework\TestCase;

class ResolverFactoryTest extends TestCase
{
    use ConfigMockerTrait;

    /**
     * @var ResolverFactory
     */
    private $resolverFactory;

    public function setUp()
    {
        $this->resolverFactory = new ResolverFactory($this->createMockedConfig());
    }

    public function testFactoryInstantiations()
    {
        $this->assertInstanceOf(AppResolver::class, $this->resolverFactory->createAppResolver());
        $this->assertInstanceOf(DeviceSessionResolver::class, $this->resolverFactory->createDeviceSessionResolver());
        $this->assertInstanceOf(DevicePurchaseResolver::class, $this->resolverFactory->createDevicePurchaseResolver());
        $this->assertInstanceOf(DeviceFocusResolver::class, $this->resolverFactory->createDeviceFocusResolver());
        $this->assertInstanceOf(NotificationResolver::class, $this->resolverFactory->createNotificationResolver());

        $newDeviceResolver = $this->resolverFactory->createNewDeviceResolver();
        $this->assertInstanceOf(DeviceResolver::class, $newDeviceResolver);
        $this->assertEquals(true, $newDeviceResolver->getIsNewDevice());

        $existingDeviceResolver = $this->resolverFactory->createExistingDeviceResolver();
        $this->assertInstanceOf(DeviceResolver::class, $existingDeviceResolver);
        $this->assertEquals(false, $existingDeviceResolver->getIsNewDevice());
    }
}
