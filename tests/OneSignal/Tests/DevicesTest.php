<?php

namespace OneSignal\Tests;

use OneSignal\Devices;

class DevicesTest extends TestCase
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
            'tags' => ['a' => '1', 'foo' => 'bar'],
            'last_active' => 1395096859,
            'amount_spent' => 0.0,
            'created_at' => 1395096859,
            'invalid_identifier' => false,
            'badge_count' =>  0,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('GET', '/players/ffffb794-ba37-11e3-8077-031d62f86ebf?app_id=app_1')
            ->willReturn($data);

        $devices = new Devices($oneSignal);

        $this->assertSame($data, $devices->getOne('ffffb794-ba37-11e3-8077-031d62f86ebf'));
    }

    public function testGetAll()
    {
        $data = [
            'total_count' => 1,
            'offset' => 0,
            'limit' => 300,
            'players' => [
                'identifier' => 'ce777617da7f548fe7a9ab6febb56cf39fba6d382000c0395666288d961ee566',
                'session_count' => 1,
                'language' => 'en',
                'timezone' => -28800,
                'game_version' => '1.0',
                'device_os' => '7.0.4',
                'device_type' => 0,
                'device_model' => 'iPhone',
                'ad_id' => null,
                'tags' => ['a' => '1', 'foo' => 'bar'],
                'last_active' => 1395096859,
                'amount_spent' => 0.0,
                'created_at' => 1395096859,
                'invalid_identifier' => false,
                'badge_count' => 0,
            ],
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('GET', '/players?limit=300&offset=0&app_id=app_1')
            ->willReturn($data);

        $devices = new Devices($oneSignal);

        $this->assertSame($data, $devices->getAll());
    }

    public function testAdd()
    {
        $postData = [
            'app_id' => 'app_1',
            'identifier' => 'ce777617da7f548fe7a9ab6febb56cf39fba6d382000c0395666288d961ee566',
            'language' => 'en',
            'timezone' => -28800,
            'game_version' => '1.0',
            'device_os' => '7.0.4',
            'device_type' => 0,
            'device_model' => 'iPhone 8,2',
            'tags' => [
                'a' => '1',
                'foo' => 'bar',
            ],
        ];

        $returnData = [
            'success' => true,
            'id' => 'ffffb794-ba37-11e3-8077-031d62f86ebf',
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/players', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $devices = new Devices($oneSignal);

        $this->assertSame($returnData, $devices->add($postData));
    }

    public function testUpdate()
    {
        $postData = [
            'app_id' => 'app_1',
            'identifier' => 'ce777617da7f548fe7a9ab6febb56cf39fba6d382000c0395666288d961ee566',
            'language' => 'en',
            'timezone' => -28800,
            'game_version' => '1.0',
            'device_os' => '7.0.4',
            'device_model' => 'iPhone 8,2',
            'tags' => [
                'a' => '1',
                'foo' => 'bar',
            ],
        ];

        $returnData = [
            'success' => true,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('PUT', '/players/ffffb794-ba37-11e3-8077-031d62f86ebf', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $devices = new Devices($oneSignal);

        $this->assertSame($returnData, $devices->update('ffffb794-ba37-11e3-8077-031d62f86ebf', $postData));
    }

    public function testOnSession()
    {
        $postData = [
            'language' => 'es',
            'timezone' => -28800,
            'game_version' => '1.0',
            //'device_os' => '7.0.4',
        ];

        $returnData = [
            'status' => true,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/players/ffffb794-ba37-11e3-8077-031d62f86ebf/on_session', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $devices = new Devices($oneSignal);

        $this->assertSame($returnData, $devices->onSession('ffffb794-ba37-11e3-8077-031d62f86ebf', $postData));
    }

    public function testOnPurchase()
    {
        $postData = [
            'purchases' => [
                [
                    'sku' => 'SKU123',
                    'iso' => 'USD',
                    'amount' => 0.99,
                ],
            ],
        ];

        $returnData = [
            'status' => true,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/players/ffffb794-ba37-11e3-8077-031d62f86ebf/on_purchase', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $devices = new Devices($oneSignal);

        $this->assertSame($returnData, $devices->onPurchase('ffffb794-ba37-11e3-8077-031d62f86ebf', $postData));
    }

    public function testOnFocus()
    {
        $postData = [
            'state' => 'ping',
            'active_time' => 60,
        ];

        $returnData = [
            'status' => true,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/players/ffffb794-ba37-11e3-8077-031d62f86ebf/on_focus', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData,
            ])
            ->willReturn($returnData);

        $devices = new Devices($oneSignal);

        $this->assertSame($returnData, $devices->onFocus('ffffb794-ba37-11e3-8077-031d62f86ebf', $postData));
    }

    public function testCsvExport()
    {
        $data = [
            'csv_file_url' => 'https://onesignal.com/csv_exports/b2f7f966-d8cc-11e4-bed1-df8f05be55ba/users_184948440ec0e334728e87228011ff41_2015-11-10.csv.gz',
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/players/csv_export?app_id=app_1')
            ->willReturn($data);

        $devices = new Devices($oneSignal);

        $this->assertSame($data, $devices->csvExport());
    }
}
