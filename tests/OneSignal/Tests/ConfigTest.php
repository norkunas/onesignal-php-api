<?php

namespace OneSignal\Tests;

use OneSignal\Config;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;

class ConfigTest extends TestCase
{
    use SetUpTearDownTrait;

    /**
     * @var Config
     */
    private $config;

    public function doSetUp()
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
