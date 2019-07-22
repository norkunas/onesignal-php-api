<?php

namespace OneSignal\Tests;

use OneSignal\Config;

trait ConfigMockerTrait
{
    public function createMockedConfig()
    {
        $config = $this->createMock(Config::class);
        $config->method('getApplicationId')->willReturn('fakeApplicationId');
        $config->method('getApplicationAuthKey')->willReturn('fakeApplicationAuthKey');
        $config->method('getUserAuthKey')->willReturn('fakeUserAuthKey');

        return $config;
    }
}
