<?php

namespace OneSignal\Tests;

use OneSignal\Config;
use PHPUnit\Framework\MockObject\MockObject;

trait ConfigMockerTrait
{
    public function createMockedConfig()
    {
        /** @var MockObject $config */
        $config = $this->createMock(Config::class);
        $config->method('getApplicationId')->willReturn('fakeApplicationId');
        $config->method('getApplicationAuthKey')->willReturn('fakeApplicationAuthKey');
        $config->method('getUserAuthKey')->willReturn('fakeUserAuthKey');

        return $config;
    }
}
