<?php

namespace OneSignal\Tests;

use OneSignal\Apps;

class AppsTest extends TestCase
{
    public function testGetOne()
    {
        $data = [
            'identifier' => 'ce777617da7f548fe7a9ab6febb56cf39fba6d382000c0395666288d961ee566',
            'session_count' => 1,
            'language' => 'en',
            'timezone' => -28800,
            'game_version' => '1.0',
            'device_os' => '7.0.4',
            'device_type' => 0,
            'device_model' => 'iPhone',
            'ad_id' => null,
            'tags' => [
                'a' => '1',
                'foo' => 'bar',
            ],
            'last_active' => 1395096859,
            'amount_spent' => 0.0,
            'created_at' => 1395096859,
            'invalid_identifier' => false,
            'badge_count' =>  0,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('GET', '/apps/92911750-242d-4260-9e00-9d9034f139ce')
            ->willReturn($data);

        $apps = new Apps($oneSignal);

        $this->assertSame($data, $apps->getOne('92911750-242d-4260-9e00-9d9034f139ce'));
    }

    public function testGetAll()
    {
        $data = [
            [
                'id' => '92911750-242d-4260-9e00-9d9034f139ce',
                'name' => 'Your app 1',
                'players' => 150,
                'messagable_players' => 143,
                'updated_at' => '2014-04-01T04:20:02.003Z',
                'created_at' => '2014-04-01T04:20:02.003Z',
                'gcm_key' => 'a gcm push key',
                'chrome_key' => 'A Chrome Web Push GCM key',
                'chrome_web_origin' => 'Chrome Web Push Site URL',
                'chrome_web_gcm_sender_id' => 'Chrome Web Push GCM Sender ID',
                'chrome_web_default_notification_icon' => 'http://yoursite.com/chrome_notification_icon',
                'chrome_web_sub_domain' => 'your_site_name',
                'apns_env' => 'sandbox',
                'apns_certificates' => 'Your apns certificate',
                'safari_apns_cetificate' => 'Your Safari APNS certificate',
                'safari_site_origin' => 'The homename for your website for Safari Push, including http or https',
                'safari_push_id' => 'The certificate bundle ID for Safari Web Push',
                'safari_icon_16_16' => 'http://onesignal.com/safari_packages/92911750-242d-4260-9e00-9d9034f139ce/16x16.png',
                'safari_icon_32_32' => 'http://onesignal.com/safari_packages/92911750-242d-4260-9e00-9d9034f139ce/16x16@2.png',
                'safari_icon_64_64' => 'http://onesignal.com/safari_packages/92911750-242d-4260-9e00-9d9034f139ce/32x32@2x.png',
                'safari_icon_128_128' => 'http://onesignal.com/safari_packages/92911750-242d-4260-9e00-9d9034f139ce/128x128.png',
                'safari_icon_256_256' => 'http://onesignal.com/safari_packages/92911750-242d-4260-9e00-9d9034f139ce/128x128@2x.png',
                'site_name' => 'The URL to your website for Web Push',
                'basic_auth_key' => 'NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj',
            ],
            [
                'id' => 'e4e87830-b954-11e3-811d-f3b376925f15',
                'name' => 'Your app 2',
                'players' => 100,
                'messagable_players' => 80,
                'updated_at' => '2014-04-01T04:20:02.003Z',
                'created_at' => '2014-04-01T04:20:02.003Z',
                'gcm_key' => 'a gcm push key',
                'chrome_key' => 'A Chrome Web Push GCM key',
                'chrome_web_origin' => 'Chrome Web Push Site URL',
                'chrome_web_gcm_sender_id' => 'Chrome Web Push GCM Sender ID',
                'chrome_web_default_notification_icon' => 'http://yoursite.com/chrome_notification_icon',
                'chrome_web_sub_domain' => 'your_site_name',
                'apns_env' => 'sandbox',
                'apns_certificates' => 'Your apns certificate',
                'safari_apns_cetificate' => 'Your Safari APNS certificate',
                'safari_site_origin' => 'The homename for your website for Safari Push, including http or https',
                'safari_push_id' => 'The certificate bundle ID for Safari Web Push',
                'safari_icon_16_16' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/16x16.png',
                'safari_icon_32_32' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/16x16@2.png',
                'safari_icon_64_64' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/32x32@2x.png',
                'safari_icon_128_128' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/128x128.png',
                'safari_icon_256_256' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/128x128@2x.png',
                'site_name' => 'The URL to your website for Web Push',
                'basic_auth_key' => 'NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj',
            ],
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('GET', '/apps')
            ->willReturn($data);

        $apps = new Apps($oneSignal);

        $this->assertSame($data, $apps->getAll());
    }

    public function testAdd()
    {
        $postData = [
            'name' => 'Your app 1',
            'apns_env' => 'production',
            'apns_p12' => 'asdsadcvawe223cwef...',
            'apns_p12_password' => 'FooBar',
            'gcm_key' => 'a gcm push key',
        ];

        $returnData = [
            'id' => 'e4e87830-b954-11e3-811d-f3b376925f15',
            'name' => 'Your app 1',
            'players' => 0,
            'messagable_players' => 0,
            'updated_at' => '2014-04-01T04:20:02.003Z',
            'created_at' => '2014-04-01T04:20:02.003Z',
            'gcm_key' => 'a gcm push key',
            'chrome_key' => 'A Chrome Web Push GCM key',
            'chrome_web_origin' => 'Chrome Web Push Site URL',
            'chrome_web_default_notification_icon' => 'http://yoursite.com/chrome_notification_icon',
            'chrome_web_sub_domain' => 'your_site_name',
            'apns_env' => 'production',
            'apns_certificates' => 'Your apns certificate',
            'safari_apns_cetificate' => 'Your Safari APNS certificate',
            'safari_site_origin' => 'The homename for your website for Safari Push, including http or https',
            'safari_push_id' => 'The certificate bundle ID for Safari Web Push',
            'safari_icon_16_16' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/16x16.png',
            'safari_icon_32_32' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/16x16@2.png',
            'safari_icon_64_64' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/32x32@2x.png',
            'safari_icon_128_128' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/128x128.png',
            'safari_icon_256_256' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/128x128@2x.png',
            'site_name' => 'The URL to your website for Web Push',
            'basic_auth_key' => 'NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj',
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/apps', [
                'headers' => [
                    'Authorization' => 'Basic ' . $oneSignal->getConfig()->getUserAuthKey(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $apps = new Apps($oneSignal);

        $this->assertSame($returnData, $apps->add($postData));
    }

    public function testUpdate()
    {
        $postData = [
            'name' => 'Your app 1',
            'apns_env' => 'production',
            'apns_p12' => 'asdsadcvawe223cwef...',
            'apns_p12_password' => 'FooBar',
            'gcm_key' => 'a gcm push key',
        ];

        $returnData = [
            'id' => 'e4e87830-b954-11e3-811d-f3b376925f15',
            'name' => 'Your app 1',
            'players' => 0,
            'messagable_players' => 0,
            'updated_at' => '2014-04-01T04:20:02.003Z',
            'created_at' => '2014-04-01T04:20:02.003Z',
            'gcm_key' => 'a gcm push key',
            'chrome_key' => 'A Chrome Web Push GCM key',
            'chrome_web_origin' => 'Chrome Web Push Site URL',
            'chrome_web_default_notification_icon' => 'http://yoursite.com/chrome_notification_icon',
            'chrome_web_sub_domain' => 'your_site_name',
            'apns_env' => 'production',
            'apns_certificates' => 'Your apns certificate',
            'safari_apns_cetificate' => 'Your Safari APNS certificate',
            'safari_site_origin' => 'The homename for your website for Safari Push, including http or https',
            'safari_push_id' => 'The certificate bundle ID for Safari Web Push',
            'safari_icon_16_16' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/16x16.png',
            'safari_icon_32_32' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/16x16@2.png',
            'safari_icon_64_64' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/32x32@2x.png',
            'safari_icon_128_128' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/128x128.png',
            'safari_icon_256_256' => 'http://onesignal.com/safari_packages/e4e87830-b954-11e3-811d-f3b376925f15/128x128@2x.png',
            'site_name' => 'The URL to your website for Web Push',
            'basic_auth_key' => 'NGEwMGZmMjItY2NkNy0xMWUzLTk5ZDUtMDAwYzI5NDBlNjJj',
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('PUT', '/apps/e4e87830-b954-11e3-811d-f3b376925f15', [
                'headers' => [
                    'Authorization' => 'Basic ' . $oneSignal->getConfig()->getUserAuthKey(),
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $apps = new Apps($oneSignal);

        $this->assertSame($returnData, $apps->update('e4e87830-b954-11e3-811d-f3b376925f15', $postData));
    }
}
