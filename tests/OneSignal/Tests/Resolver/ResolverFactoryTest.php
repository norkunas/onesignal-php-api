<?php

declare(strict_types=1);

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\ResolverFactory;
use OneSignal\Tests\OneSignalTestCase;

class ResolverFactoryTest extends OneSignalTestCase
{
    /**
     * @var ResolverFactory
     */
    private $resolverFactory;

    protected function setUp(): void
    {
        $this->resolverFactory = new ResolverFactory($this->createConfig());
    }

    public function testFactoryInstantiations(): void
    {
        $newDeviceResolver = $this->resolverFactory->createNewDeviceResolver();
        $this->assertTrue($newDeviceResolver->getIsNewDevice());

        $existingDeviceResolver = $this->resolverFactory->createExistingDeviceResolver();
        $this->assertFalse($existingDeviceResolver->getIsNewDevice());
    }
}
