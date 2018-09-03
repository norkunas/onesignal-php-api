<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\DeviceFocusResolver;
use PHPUnit\Framework\TestCase;

class DeviceFocusResolverTest extends TestCase
{
    /**
     * @var DeviceFocusResolver
     */
    private $deviceFocusResolver;

    public function setUp()
    {
        $this->deviceFocusResolver = new DeviceFocusResolver();
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'state' => 'fakeState',
            'active_time' => 245,
        ];

        $this->assertEquals($expectedData, $this->deviceFocusResolver->resolve($expectedData));
    }

    public function testResolveDefaultValues()
    {
        $expectedData = [
            'state' => 'ping',
            'active_time' => 23,
        ];

        $this->assertEquals($expectedData, $this->deviceFocusResolver->resolve(['active_time' => 23]));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testResolveWithMissingRequiredValue()
    {
        $this->deviceFocusResolver->resolve([]);
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['state' => 666]],
            [['active_time' => 'wrongType']],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $requiredOptions = [
            'active_time' => 234,
        ];

        $this->deviceFocusResolver->resolve(array_merge($requiredOptions, $wrongOption));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testResolveWithWrongOption()
    {
        $this->deviceFocusResolver->resolve(['active_time' => 23, 'wrongOption' => 'wrongValue']);
    }
}
