<?php

namespace OneSignal\Tests;

use OneSignal\Notifications;

class NotificationsTest extends TestCase
{
    public function testGetOne()
    {
        $data = [
            'id' => "481a2734-6b7d-11e4-a6ea-4b53294fa671",
            'successful' => 15,
            'failed' => 1,
            'converted' => 3,
            'remaining' => 0,
            'queued_at' => 1415914655,
            'send_after' => 1415914655,
            'url' =>  "https://yourWebsiteToOpen.com",
            'data' => [
                'foo' => 'bar',
                'your' => 'custom metadata'
            ],
            'canceled' => false,
            'headings' => [
                'en' => 'English and default langauge heading',
                'es' => 'Spanish language heading'
            ],
            'contents' => [
                'en' => 'English language content',
                'es' => 'Hola'
            ]
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('GET', '/notifications/481a2734-6b7d-11e4-a6ea-4b53294fa671?app_id=app_1')
            ->willReturn($data);

        $notifications = new Notifications($oneSignal);

        $this->assertSame($data, $notifications->getOne('481a2734-6b7d-11e4-a6ea-4b53294fa671'));
    }

    public function testGetAll()
    {
        $data = [
            'total_count' => 3,
            'offset' => 1,
            'limit' => 2,
            'notifications' => [
                [
                    'id' => '481a2734-6b7d-11e4-a6ea-4b53294fa671',
                    'successful' => 15,
                    'failed' => 1,
                    'converted' => 3,
                    'remaining' => 0,
                    'queued_at' => 1415914655,
                    'send_after' => 1415914655,
                    'canceled' => false,
                    'url' => 'https://yourWebsiteToOpen.com',
                    'data' => null,
                    'headings' => [
                        'en' => 'English and default langauge heading',
                        'es' => 'Spanish language heading'
                    ],
                    'contents' => [
                        'en' => 'English and default content',
                        'es' => 'Hola'
                    ]
                ],
                [
                    'id' => 'b6b326a8-40aa-13e5-b91b-bf8bc3fa26f7',
                    'successful' => 5,
                    'failed' => 2,
                    'converted' => 0,
                    'remaining' => 0,
                    'queued_at' => 1415915123,
                    'send_after' => 1415915123,
                    'canceled' =>  false,
                    'url' => null,
                    'data' => [
                        'foo' => 'bar',
                        'your' => 'custom metadata'
                    ],
                    'headings' => [
                        'en' => 'English and default langauge heading',
                        'es' => 'Spanish language heading'
                    ],
                    'contents' => [
                        'en' => 'English and default content',
                        'es' => 'Hola'
                    ]
                ]
            ]
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('GET', '/notifications?limit=2&offset=1&app_id=app_1')
            ->willReturn($data);

        $notifications = new Notifications($oneSignal);

        $this->assertSame($data, $notifications->getAll(2, 1));
    }

    public function testSendToAllSubscribers()
    {
        $postData = [
            'app_id' => 'app_1',
            'contents' => [
                'en' => 'English message',
            ],
            'included_segments' => ['All'],
            'buttons' => [
                [
                    'id' => 'id1',
                    'text' => 'I\'m lucky!',
                    'icon' => 'ic_menu_share',
                ],
            ],
            'web_buttons' => [
                [
                    'id' => 'like-button',
                    'text' => 'Like',
                    'icon' => 'http://i.imgur.com/N8SN8ZS.png',
                    'url' => 'https://yoursite.com',
                ],
            ],
        ];

        $returnData = [
            'id' => '458dcec4-cf53-11e3-add2-000c2940e62c',
            'recipients' => 3,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/notifications', [
                'headers' => [
                    'Authorization' => 'Basic app_auth',
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData
            ])
            ->willReturn($returnData);

        $notifications = new Notifications($oneSignal);

        $this->assertSame($returnData, $notifications->add($postData));
    }

    public function testSendBasedOnFilters()
    {
        $postData = [
            'app_id' => 'app_1',
            'contents' => [
                'en' => 'English message',
            ],
            'filters' => [
                [
                    'field' => 'tag',
                    'key' => 'level',
                    'relation' => '>',
                    'value' => 10,
                ],
                [
                    'operator' => 'OR',
                ],
                [
                    'field' => 'amount_spent',
                    'relation' => '>',
                    'value' => '0'
                ],
            ],
        ];

        $returnData = [
            'id' => '458dcec4-cf53-11e3-add2-000c2940e62c',
            'recipients' => 2,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('POST', '/notifications', [
                'headers' => [
                    'Authorization' => 'Basic app_auth',
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData
            ])
            ->willReturn($returnData);

        $notifications = new Notifications($oneSignal);

        $this->assertSame($returnData, $notifications->add($postData));
    }

    public function testOpen()
    {
        $postData = [
            'app_id' => 'app_1',
            'opened' => true,
        ];

        $returnData = [
            'status' => true,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('PUT', '/notifications/b6b326a8-40aa-13e5-b91b-bf8bc3fa26f7', [
                'headers' => [
                    'Authorization' => 'Basic app_auth',
                    'Content-Type' => 'application/json',
                ],
                'json' => $postData
            ])
            ->willReturn($returnData);

        $notifications = new Notifications($oneSignal);

        $this->assertSame($returnData, $notifications->open('b6b326a8-40aa-13e5-b91b-bf8bc3fa26f7'));
    }

    public function testCancel()
    {
        $returnData = [
            'status' => true,
        ];

        $oneSignal = $this->getMockedOneSignal();
        $oneSignal->expects($this->once())
            ->method('request')
            ->with('DELETE', '/notifications/b6b326a8-40aa-13e5-b91b-bf8bc3fa26f7?app_id=app_1')
            ->willReturn($returnData);

        $notifications = new Notifications($oneSignal);

        $this->assertSame($returnData, $notifications->cancel('b6b326a8-40aa-13e5-b91b-bf8bc3fa26f7'));
    }
}
