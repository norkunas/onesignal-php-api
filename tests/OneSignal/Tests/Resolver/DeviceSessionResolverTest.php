<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\DeviceSessionResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class DeviceSessionResolverTest extends TestCase
{
    use SetUpTearDownTrait;

    /**
     * @var DeviceSessionResolver
     */
    private $deviceSessionResolver;

    public function doSetUp()
    {
        $this->deviceSessionResolver = new DeviceSessionResolver();
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'identifier' => 'fakeIdentifier',
            'language' => 'fakeIdentifier',
            'timezone' => 234,
            'game_version' => 'fakeGameVersion',
            'device_os' => 'fakeDeviceOS',
            'device_model' => 'fakeDeviceModel',
            'ad_id' => 'fakeAdId',
            'sdk' => 'fakeSdk',
            'tags' => ['fakeTag'],
        ];

        $this->assertEquals($expectedData, $this->deviceSessionResolver->resolve($expectedData));
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
            [['tags' => 666]],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->expectException(InvalidOptionsException::class);

        $this->deviceSessionResolver->resolve($wrongOption);
    }

    public function testResolveWithWrongOption()
    {
        $this->expectException(UndefinedOptionsException::class);

        $this->deviceSessionResolver->resolve(['wrongOption' => 'wrongValue']);
    }
}
