<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\NotificationHistoryResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class NotificationHistoryResolverTest extends TestCase
{
    use SetUpTearDownTrait;

    /**
     * @var NotificationHistoryResolver
     */
    private $notificationHistoryResolver;

    public function doSetUp()
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

    public function testResolveWithMissingRequiredValue()
    {
        $this->expectException(MissingOptionsException::class);

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
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->expectException(InvalidOptionsException::class);

        $this->notificationHistoryResolver->resolve($wrongOption);
    }

    public function testResolveWithWrongOption()
    {
        $this->expectException(UndefinedOptionsException::class);

        $this->notificationHistoryResolver->resolve(['events' => 'sent', 'wrongOption' => 'wrongValue']);
    }
}
