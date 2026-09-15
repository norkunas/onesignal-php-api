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
        yield 'exact prefix' => [true, 'os_v2_app_'];
        yield 'legacy key' => [false, 'fakeApplicationAuthKey'];
        yield 'organization key' => [false, 'os_v2_org_fakeOrganizationAuthKey'];
        yield 'prefix not at the beginning' => [false, 'fakeos_v2_app_Key'];
        yield 'null' => [false, null];
    }
}
