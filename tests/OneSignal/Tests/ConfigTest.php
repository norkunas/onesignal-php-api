<?php

namespace OneSignal\Tests;

use OneSignal\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @var Config
     */
    private $config;

    public function setUp()
    {
        $this->config = new Config();
    }

    public function testApplicationId()
    {
        $this->config->setApplicationId('application_id');

        $this->assertEquals('application_id', $this->config->getApplicationId());
    }

    public function testApplicationAuthKey()
    {
        $this->config->setApplicationAuthKey('application_auth_key');

        $this->assertEquals('application_auth_key', $this->config->getApplicationAuthKey());
    }

    public function testUserAuthKey()
    {
        $this->config->setUserAuthKey('user_auth_key');

        $this->assertEquals('user_auth_key', $this->config->getUserAuthKey());
    }
}
