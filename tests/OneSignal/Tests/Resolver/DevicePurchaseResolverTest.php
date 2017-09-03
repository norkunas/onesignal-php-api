<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\DevicePurchaseResolver;

class DevicePurchaseResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DevicePurchaseResolver
     */
    private $devicePurchaseResolver;

    public function setUp()
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

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testResolveWithMissingRequiredValue()
    {
        $this->devicePurchaseResolver->resolve([]);
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testResolveWithMissingRequiredPurchaseValue()
    {
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
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $requiredOptions = [
            'purchases' => [[
                'sku' => 'value',
                'amount' => 56.4,
                'iso' => 'value',
            ]],
        ];

        $this->devicePurchaseResolver->resolve(array_merge($requiredOptions, $wrongOption));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongPurchasesValueTypes()
    {
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

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testResolveWithWrongOption()
    {
        $this->devicePurchaseResolver->resolve(['wrongOption' => 'wrongValue']);
    }
}
