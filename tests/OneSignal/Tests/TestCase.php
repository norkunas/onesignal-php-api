<?php

namespace OneSignal\Tests;

use OneSignal\Config;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function getMockedOneSignal()
    {
        $config = new Config();
        $config->setApplicationId('app_1');
        $config->setUserAuthKey('user_auth');
        $config->setApplicationAuthKey('app_auth');

        return $this->getMockBuilder('OneSignal\OneSignal')
            ->setConstructorArgs([$config])
            ->setMethods(['request'])
            ->getMock();
    }
}
