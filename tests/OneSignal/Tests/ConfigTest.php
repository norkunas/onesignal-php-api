<?php

declare(strict_types=1);

namespace OneSignal\Tests;

class ConfigTest extends OneSignalTestCase
{
    public function testGetApplicationId(): void
    {
        $this->assertSame('fakeApplicationId', ($this->createConfig())->getApplicationId());
    }

    public function testGetApplicationAuthKey(): void
    {
        $this->assertSame('fakeApplicationAuthKey', ($this->createConfig())->getApplicationAuthKey());
    }

    public function testGetUserAuthKey(): void
    {
        $this->assertSame('fakeUserAuthKey', ($this->createConfig())->getUserAuthKey());
    }
}
