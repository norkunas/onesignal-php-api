<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\DevicePurchaseResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class DevicePurchaseResolverTest extends TestCase
{
    use SetUpTearDownTrait;

    /**
     * @var DevicePurchaseResolver
     */
    private $devicePurchaseResolver;

    public function doSetUp()
    {
        $this->devicePurchaseResolver = new DevicePurchaseResolver();
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'existing' => false,
            'purchases' => [
                [
                    'sku' => 'fakeSku',
                    'amount' => 34.98,
                    'iso' => 'fakeIso',
                ],
            ],
        ];

        $this->assertEquals($expectedData, $this->devicePurchaseResolver->resolve($expectedData));
    }

    public function testResolveWithMissingRequiredValue()
    {
        $this->expectException(MissingOptionsException::class);

        $this->devicePurchaseResolver->resolve([]);
    }

    public function testResolveWithMissingRequiredPurchaseValue()
    {
        $this->expectException(MissingOptionsException::class);

        $wrongData = [
            'existing' => false,
            'purchases' => [
                [],
            ],
        ];

        $this->devicePurchaseResolver->resolve($wrongData);
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['existing' => 666]],
            [['purchases' => 666]],
            [[
                'purchases' => [[
                    'sku' => 666,
                    'amount' => 56.4,
                    'iso' => 'value',
                ]],
            ]],
            [[
                'purchases' => [[
                    'sku' => 'value',
                    'amount' => 'wrongType',
                    'iso' => 'value',
                ]],
            ]],
            [[
                'purchases' => [[
                    'sku' => 'value',
                    'amount' => 56.4,
                    'iso' => 666,
                ]],
            ]],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->expectException(InvalidOptionsException::class);

        $requiredOptions = [
            'purchases' => [[
                'sku' => 'value',
                'amount' => 56.4,
                'iso' => 'value',
            ]],
        ];

        $this->devicePurchaseResolver->resolve(array_merge($requiredOptions, $wrongOption));
    }

    public function testResolveWithWrongPurchasesValueTypes()
    {
        $this->expectException(InvalidOptionsException::class);

        $wrongData = [
            'existing' => true,
            'purchases' => [
                [
                    'sku' => 666,
                    'amount' => 'wrongType',
                    'iso' => 666,
                ],
            ],
        ];

        $this->devicePurchaseResolver->resolve($wrongData);
    }

    public function testResolveWithWrongOption()
    {
        $this->expectException(UndefinedOptionsException::class);

        $this->devicePurchaseResolver->resolve(['wrongOption' => 'wrongValue']);
    }
}
