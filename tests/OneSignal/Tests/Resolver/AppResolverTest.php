<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\AppResolver;

class AppResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AppResolver
     */
    private $appResolver;

    public function setUp()
    {
        $this->appResolver = new AppResolver();
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'name' => 'value',
            'apns_env' => 'sandbox',
            'apns_p12' => 'value',
            'apns_p12_password' => 'value',
            'gcm_key' => 'value',
            'chrome_key' => 'value',
            'safari_apns_p12' => 'value',
            'chrome_web_key' => 'value',
            'safari_apns_p12_password' => 'value',
            'site_name' => 'value',
            'safari_site_origin' => 'value',
            'safari_icon_16_16' => 'value',
            'safari_icon_32_32' => 'value',
            'safari_icon_64_64' => 'value',
            'safari_icon_128_128' => 'value',
            'safari_icon_256_256' => 'value',
            'chrome_web_origin' => 'value',
            'chrome_web_gcm_sender_id' => 'value',
            'chrome_web_default_notification_icon' => 'value',
            'chrome_web_sub_domain' => 'value',
        ];

        $this->assertEquals($expectedData, $this->appResolver->resolve($expectedData));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testResolveWithMissingRequiredValue()
    {
        $this->appResolver->resolve([]);
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['name' => 666]],
            [['apns_env' => 666]],
            [['apns_p12' => 666]],
            [['apns_p12_password' => 666]],
            [['gcm_key' => 666]],
            [['chrome_key' => 666]],
            [['safari_apns_p12' => 666]],
            [['chrome_web_key' => 666]],
            [['safari_apns_p12_password' => 666]],
            [['site_name' => 666]],
            [['safari_site_origin' => 666]],
            [['safari_icon_16_16' => 666]],
            [['safari_icon_32_32' => 666]],
            [['safari_icon_64_64' => 666]],
            [['safari_icon_128_128' => 666]],
            [['safari_icon_256_256' => 666]],
            [['chrome_web_origin' => 666]],
            [['chrome_web_gcm_sender_id' => 666]],
            [['chrome_web_default_notification_icon' => 666]],
            [['chrome_web_sub_domain' => 666]],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $requiredOptions = [
            'name' => 'fakeName',
        ];

        $this->appResolver->resolve(array_merge($requiredOptions, $wrongOption));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testResolveWithWrongOption()
    {
        $this->appResolver->resolve(['wrongOption' => 'wrongValue']);
    }
}
