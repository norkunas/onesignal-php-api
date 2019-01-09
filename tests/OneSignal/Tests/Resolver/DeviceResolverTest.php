<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Devices;
use OneSignal\Resolver\DeviceResolver;
use OneSignal\Tests\ConfigMockerTrait;
use PHPUnit\Framework\TestCase;

class DeviceResolverTest extends TestCase
{
    use ConfigMockerTrait;

    /**
     * @var DeviceResolver
     */
    private $deviceResolver;

    public function setUp()
    {
        $this->deviceResolver = new DeviceResolver($this->createMockedConfig());
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'identifier' => 'value',
            'language' => 'value',
            'timezone' => 3564,
            'game_version' => 'value',
            'device_model' => 'value',
            'device_os' => 'value',
            'ad_id' => 'value',
            'sdk' => 'value',
            'session_count' => 23,
            'tags' => ['value'],
            'amount_spent' => 34.2,
            'created_at' => 32,
            'playtime' => 56,
            'badge_count' => 12,
            'last_active' => 98,
            'notification_types' => -2,
            'test_type' => 1,
            'long' => 55.1684595,
            'lat' => 22.7624291,
            'country' => 'LT',
            'external_user_id' => 'value',
            'app_id' => 'value',
        ];

        $this->deviceResolver->setIsNewDevice(false);
        $this->assertEquals($expectedData, $this->deviceResolver->resolve($expectedData));

        $expectedData += [
            'device_type' => Devices::CHROME_APP,
        ];

        $this->deviceResolver->setIsNewDevice(true);
        $this->assertEquals($expectedData, $this->deviceResolver->resolve($expectedData));
    }

    public function testResolveDefaultValues()
    {
        $expectedData = [
            'app_id' => 'fakeApplicationId',
        ];

        $this->deviceResolver->setIsNewDevice(false);
        $this->assertEquals($expectedData, $this->deviceResolver->resolve([]));

        $inputData = [
            'device_type' => Devices::WINDOWS_PHONE,
        ];

        $this->deviceResolver->setIsNewDevice(true);
        $this->assertEquals(array_merge($inputData, $expectedData), $this->deviceResolver->resolve($inputData));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testResolveWithMissingRequiredValue()
    {
        $this->deviceResolver->setIsNewDevice(true);
        $this->deviceResolver->resolve([]);
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['identifier' => 666]],
            [['language' => 666]],
            [['timezone' => 'wrongType']],
            [['game_version' => 666]],
            [['device_model' => 666]],
            [['device_os' => 666]],
            [['ad_id' => 666]],
            [['sdk' => 666]],
            [['session_count' => 'wrongType']],
            [['tags' => 666]],
            [['amount_spent' => 'wrongType']],
            [['created_at' => 'wrongType']],
            [['playtime' => 'wrongType']],
            [['badge_count' => 'wrongType']],
            [['last_active' => 'wrongType']],
            [['notification_types' => 'wrongType']],
            [['test_type' => 'wrongType']],
            [['long' => true]],
            [['lat' => true]],
            [['country' => false]],
            [['app_id' => 666]],
            [['device_type' => 666]],
            [['external_user_id' => 666]],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $requiredOptions = [
            'device_type' => Devices::ANDROID,
        ];

        $this->deviceResolver->setIsNewDevice(true);
        $this->deviceResolver->resolve(array_merge($requiredOptions, $wrongOption));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testResolveWithWrongOption()
    {
        $this->deviceResolver->resolve(['wrongOption' => 'wrongValue']);
    }
}
