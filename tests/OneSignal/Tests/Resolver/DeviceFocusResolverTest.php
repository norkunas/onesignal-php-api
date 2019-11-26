<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\DeviceFocusResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class DeviceFocusResolverTest extends TestCase
{
    use SetUpTearDownTrait;

    /**
     * @var DeviceFocusResolver
     */
    private $deviceFocusResolver;

    public function doSetUp()
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

    public function testResolveWithMissingRequiredValue()
    {
        $this->expectException(MissingOptionsException::class);

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
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->expectException(InvalidOptionsException::class);

        $requiredOptions = [
            'active_time' => 234,
        ];

        $this->deviceFocusResolver->resolve(array_merge($requiredOptions, $wrongOption));
    }

    public function testResolveWithWrongOption()
    {
        $this->expectException(UndefinedOptionsException::class);

        $this->deviceFocusResolver->resolve(['active_time' => 23, 'wrongOption' => 'wrongValue']);
    }
}
