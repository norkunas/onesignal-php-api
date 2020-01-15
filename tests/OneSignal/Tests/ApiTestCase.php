<?php

declare(strict_types=1);

namespace OneSignal\Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use OneSignal\Config;
use OneSignal\OneSignal;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Psr18Client;

abstract class ApiTestCase extends OneSignalTestCase
{
    protected function createClientMock($response = null): OneSignal
    {
        $config = new Config('fakeApplicationId', 'fakeApplicationAuthKey', 'fakeUserAuthKey');

        $httpClient = new Psr18Client(new MockHttpClient($response));

        $requestFactory = $streamFactory = new Psr17Factory();

        return new OneSignal($config, $httpClient, $requestFactory, $streamFactory);
    }

    protected function loadFixture(string $fileName): string
    {
        return file_get_contents(__DIR__."/Fixtures/$fileName");
    }
}
