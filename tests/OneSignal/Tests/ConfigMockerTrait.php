<?php

namespace OneSignal\Tests;

use OneSignal\Config;

trait ConfigMockerTrait
{
    public function createMockedConfig()
    {
        $config = $this->getMockBuilder(Config::class)->getMock();
        $config->method('getApplicationId')->willReturn('fakeApplicationId');
        $config->method('getApplicationAuthKey')->willReturn('fakeApplicationAuthKey');
        $config->method('getUserAuthKey')->willReturn('fakeUserAuthKey');

        return $config;
    }
}
