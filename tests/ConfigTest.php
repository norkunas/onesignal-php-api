<?php

declare(strict_types=1);

namespace OneSignal\Tests;

use OneSignal\Config;

class ConfigTest extends OneSignalTestCase
{
    public function testGetApplicationId(): void
    {
        self::assertSame('fakeApplicationId', $this->createConfig()->getApplicationId());
    }

    public function testGetApplicationAuthKey(): void
    {
        self::assertSame('fakeApplicationAuthKey', $this->createConfig()->getApplicationAuthKey());
    }

    public function testGetUserAuthKey(): void
    {
        self::assertSame('fakeUserAuthKey', $this->createConfig()->getUserAuthKey());
    }

    public function testGetApiUrlWithLegacyKey(): void
    {
        self::assertSame(Config::LEGACY_API_URL, $this->createConfig()->getApiUrl());
    }

    public function testGetApiUrlWithV2Key(): void
    {
        $config = new Config('fakeApplicationId', 'os_v2_app_fakeApplicationAuthKey');

        self::assertSame(Config::API_URL, $config->getApiUrl());
    }

    public function testGetApiUrlWithExplicitAuthKey(): void
    {
        $config = new Config('fakeApplicationId', 'fakeApplicationAuthKey', 'os_v2_org_fakeOrganizationAuthKey');

        self::assertSame(Config::LEGACY_API_URL, $config->getApiUrl());
        self::assertSame(Config::API_URL, $config->getApiUrl($config->getUserAuthKey()));
    }

    public function testGetApiUrlWithExplicitLegacyAuthKey(): void
    {
        $config = new Config('fakeApplicationId', 'os_v2_app_fakeApplicationAuthKey', 'fakeUserAuthKey');

        self::assertSame(Config::API_URL, $config->getApiUrl());
        self::assertSame(Config::LEGACY_API_URL, $config->getApiUrl($config->getUserAuthKey()));
    }

    /**
     * @dataProvider provideAuthKeys
     */
    public function testIsV2Key(bool $expected, ?string $authKey): void
    {
        self::assertSame($expected, Config::isV2Key($authKey));
    }

    /**
     * @return iterable<string, array{bool, string|null}>
     */
    public function provideAuthKeys(): iterable
    {
        yield 'v2 key' => [true, 'os_v2_app_fakeApplicationAuthKey'];
        yield 'exact app prefix' => [true, 'os_v2_app_'];
        yield 'organization key' => [true, 'os_v2_org_fakeOrganizationAuthKey'];
        yield 'exact shared prefix' => [true, 'os_v2_'];
        yield 'legacy key' => [false, 'fakeApplicationAuthKey'];
        yield 'prefix not at the beginning' => [false, 'fakeos_v2_app_Key'];
        yield 'unrelated os prefix' => [false, 'os_v1_app_fakeKey'];
        yield 'null' => [false, null];
    }
}
