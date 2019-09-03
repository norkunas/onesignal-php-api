<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\NotificationHistoryResolver;
use PHPUnit\Framework\TestCase;

class NotificationHistoryResolverTest extends TestCase
{
    /**
     * @var NotificationHistoryResolver
     */
    private $notificationHistoryResolver;

    public function setUp()
    {
        $this->notificationHistoryResolver = new NotificationHistoryResolver();
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'events' => 'sent',
            'email' => 'example@example.com',
        ];

        $this->assertEquals($expectedData, $this->notificationHistoryResolver->resolve($expectedData));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\MissingOptionsException
     */
    public function testResolveWithMissingRequiredValue()
    {
        $this->notificationHistoryResolver->resolve([]);
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['events' => 666, 'email' => 'example@example.com']],
            [['events' => 'sent', 'email' => 666]],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->notificationHistoryResolver->resolve($wrongOption);
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testResolveWithWrongOption()
    {
        $this->notificationHistoryResolver->resolve(['events' => 'sent', 'wrongOption' => 'wrongValue']);
    }
}
