<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\NotificationResolver;
use OneSignal\Tests\ConfigMockerTrait;
use OneSignal\Tests\PrivateAccessorTrait;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PHPUnit\Framework\TestCase;

class NotificationResolverTest extends TestCase
{
    use ConfigMockerTrait;
    use PrivateAccessorTrait;

    /**
     * @var NotificationResolver
     */
    private $notificationResolver;

    public function setUp()
    {
        $this->notificationResolver = new NotificationResolver($this->createMockedConfig());
    }

    public function testResolveWithValidValues()
    {
        $inpuData = [
            'contents' => ['value'],
            'headings' => ['value'],
            'subtitle' => ['value'],
            'isIos' => false,
            'isAndroid' => false,
            'isWP' => false,
            'isWP_WNS' => false,
            'isAdm' => false,
            'isChrome' => false,
            'isChromeWeb' => false,
            'isFirefox' => false,
            'isSafari' => false,
            'isAnyWeb' => false,
            'included_segments' => ['value'],
            'excluded_segments' => ['value'],
            'include_player_ids' => ['value'],
            'include_ios_tokens' => ['value'],
            'include_android_reg_ids' => ['value'],
            'include_external_user_ids' => ['value'],
            'include_wp_uris' => ['value'],
            'include_wp_wns_uris' => ['value'],
            'include_amazon_reg_ids' => ['value'],
            'include_chrome_reg_ids' => ['value'],
            'include_chrome_web_reg_ids' => ['value'],
            'app_ids' => ['value'],
            'filters' => [],
            'ios_badgeType' => 'SetTo',
            'ios_badgeCount' => 23,
            'ios_sound' => 'value',
            'android_sound' => 'value',
            'adm_sound' => 'value',
            'wp_sound' => 'value',
            'wp_wns_sound' => 'value',
            'data' => ['value'],
            'buttons' => [],
            'android_channel_id' => '09228c02-6188-4307-b139-402600213d0e',
            'existing_android_channel_id' => '09228c02-6188-4307-b139-402600213d0e',
            'android_background_layout' => ['value'],
            'small_icon' => 'value',
            'large_icon' => 'value',
            'ios_attachments' => ['key' => 'value'],
            'big_picture' => 'value',
            'adm_small_icon' => 'value',
            'adm_large_icon' => 'value',
            'adm_big_picture' => 'value',
            'web_buttons' => [
                [
                    'id' => 'value',
                    'text' => 'value',
                    'icon' => 'value',
                    'url' => 'value',
                ],
            ],
            'ios_category' => 'value',
            'chrome_icon' => 'value',
            'chrome_big_picture' => 'value',
            'chrome_web_icon' => 'value',
            'chrome_web_image' => 'value',
            'firefox_icon' => 'value',
            'url' => 'http://url.com',
            'send_after' => new \DateTime(),
            'delayed_option' => 'timezone',
            'delivery_time_of_day' => new \DateTime(),
            'android_led_color' => 'value',
            'android_accent_color' => 'value',
            'android_visibility' => -1,
            'collapse_id' => 'value',
            'content_available' => true,
            'mutable_content' => true,
            'android_background_data' => true,
            'amazon_background_data' => true,
            'template_id' => 'value',
            'android_group' => 'value',
            'android_group_message' => ['value'],
            'adm_group' => 'value',
            'adm_group_message' => ['value'],
            'ttl' => 23,
            'priority' => 10,
            'app_id' => 'value',
            'email_subject' => 'value',
            'email_body' => 'value',
            'email_from_name' => 'value',
            'email_from_address' => 'value',
            'external_id' => 'value',
        ];

        $expectedData = $inpuData;
        $expectedData['send_after'] = $expectedData['send_after']->format('Y-m-d H:i:sO');
        $expectedData['delivery_time_of_day'] = $expectedData['delivery_time_of_day']->format('g:iA');

        $this->assertEquals($expectedData, $this->notificationResolver->resolve($inpuData));
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['contents' => 666]],
            [['headings' => 666]],
            [['subtitle' => 666]],
            [['isIos' => 666]],
            [['isAndroid' => 666]],
            [['isWP' => 666]],
            [['isWP_WNS' => 666]],
            [['isAdm' => 666]],
            [['isChrome' => 666]],
            [['isChromeWeb' => 666]],
            [['isFirefox' => 666]],
            [['isSafari' => 666]],
            [['isAnyWeb' => 666]],
            [['included_segments' => 'wrongType']],
            [['excluded_segments' => 'wrongType']],
            [['include_player_ids' => 'wrongType']],
            [['include_ios_tokens' => 'wrongType']],
            [['include_android_reg_ids' => 666]],
            [['include_external_user_ids' => 666]],
            [['include_wp_uris' => 666]],
            [['include_wp_wns_uris' => 666]],
            [['include_amazon_reg_ids' => 666]],
            [['include_chrome_reg_ids' => 666]],
            [['include_chrome_web_reg_ids' => 666]],
            [['app_ids' => 666]],
            [['filters' => 666]],
            [['ios_badgeType' => 'wrongType']],
            [['ios_badgeCount' => 'wrongType']],
            [['ios_sound' => 666]],
            [['android_sound' => 666]],
            [['adm_sound' => 666]],
            [['wp_sound' => 666]],
            [['wp_wns_sound' => 666]],
            [['data' => 666]],
            [['buttons' => 666]],
            [['android_channel_id' => 666]],
            [['existing_android_channel_id' => 666]],
            [['android_background_layout' => 666]],
            [['small_icon' => 666]],
            [['large_icon' => 666]],
            [['ios_attachments' => 666]],
            [['big_picture' => 666]],
            [['adm_small_icon' => 666]],
            [['adm_large_icon' => 666]],
            [['adm_big_picture' => 666]],
            [['web_buttons' => 666]],
            [['ios_category' => 666]],
            [['chrome_icon' => 666]],
            [['chrome_big_picture' => 666]],
            [['chrome_web_icon' => 666]],
            [['chrome_web_image' => 666]],
            [['firefox_icon' => 666]],
            [['url' => 666]],
            [['send_after' => 666]],
            [['delayed_option' => 666]],
            [['delivery_time_of_day' => 666]],
            [['android_led_color' => 666]],
            [['android_accent_color' => 666]],
            [['android_visibility' => 'wrongType']],
            [['collapse_id' => 666]],
            [['content_available' => 666]],
            [['mutable_content' => 666]],
            [['android_background_data' => 666]],
            [['amazon_background_data' => 666]],
            [['template_id' => 666]],
            [['android_group' => 666]],
            [['android_group_message' => 666]],
            [['adm_group' => 666]],
            [['adm_group_message' => 666]],
            [['ttl' => 'wrongType']],
            [['priority' => 'wrongType']],
            [['app_id' => 666]],
            [['email_subject' => 666]],
            [['email_body' => 666]],
            [['email_from_name' => 666]],
            [['email_from_address' => 666]],
            [['external_id' => 666]],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->notificationResolver->resolve($wrongOption);
    }

    public function testResolveDefaultValues()
    {
        $expectedData = [
            'app_id' => 'fakeApplicationId',
        ];

        $this->assertEquals($expectedData, $this->notificationResolver->resolve([]));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testResolveWithWrongOption()
    {
        $this->notificationResolver->resolve(['wrongOption' => 'wrongValue']);
    }

    /****** Private functions testing ******/

    public function testNormalizeFilters()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'normalizeFilters');

        $inputData = [
            new OptionsResolver(),
            [
                ['field' => 'myField'],
                ['wrongField' => 'wrongValue'],
                ['operator' => 'OR'],
                ['operator' => 'AND'],
            ],
        ];

        $expectedData =
            [
                ['field' => 'myField'],
                ['operator' => 'OR'],
                ['operator' => 'OR'],
            ];

        $this->assertEquals($expectedData, $method->invokeArgs($this->notificationResolver, $inputData));
    }

    public function testFilterUrl()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'filterUrl');

        $this->assertEquals(true, $method->invokeArgs($this->notificationResolver, ['http://fakeUrl.com']));
        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, ['wrongUrl']));
    }

    public function testNormalizeButtons()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'normalizeButtons');

        $inputData = [
            ['wrongOption' => 'wrongValue'],
            ['text' => 'value', 'id' => 2],
            ['text' => 'value', 'id' => 8, 'icon' => 'iconValue'],
        ];

        $expectedData = [
            ['text' => 'value', 'id' => 2, 'icon' => null],
            ['text' => 'value', 'id' => 8, 'icon' => 'iconValue'],
        ];

        $this->assertEquals($expectedData, $method->invokeArgs($this->notificationResolver, [$inputData]));
    }

    public function testFilterAndroidBackgroundLayout()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'filterAndroidBackgroundLayout');

        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [[]]));

        $requiredData = [
            'image' => 'value',
            'headings_color' => 'value',
            'contents_color' => 'value',
        ];

        $this->assertEquals(true, $method->invokeArgs($this->notificationResolver, [$requiredData]));

        $inputData = array_merge($requiredData, ['image' => 45]);

        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [$inputData]));

        $inputData = array_merge($requiredData, ['wrongOption' => 'wrongValue']);

        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [$inputData]));
    }

    public function testFilterIosAttachments()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'filterIosAttachments');

        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [['option' => 666]]));
        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [[666 => 666]]));
        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [[666 => 'value']]));
        $this->assertEquals(true, $method->invokeArgs($this->notificationResolver, [['option' => 'value']]));
    }

    public function testFilterWebButtons()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'filterWebButtons');

        $inputData = [
            [
                'id' => 'value',
                'text' => 'value',
                'icon' => 'value',
                'url' => 'value',
            ],
        ];

        $this->assertEquals(true, $method->invokeArgs($this->notificationResolver, [$inputData]));

        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [array_merge(['wrongOption' => 'wrongValue'], $inputData)]));

        unset($inputData[0]['url']);

        $this->assertEquals(false, $method->invokeArgs($this->notificationResolver, [$inputData]));
    }

    public function testDateTime()
    {
        $method = $this->getPrivateMethod(NotificationResolver::class, 'normalizeDateTime');

        $inputData = new \DateTime();
        $expectedData = $inputData->format(NotificationResolver::SEND_AFTER_FORMAT);

        $this->assertEquals($expectedData, $method->invokeArgs($this->notificationResolver, [new OptionsResolver(), $inputData, NotificationResolver::SEND_AFTER_FORMAT]));
    }
}
