<?php

namespace OneSignal\Tests\Resolver;

use OneSignal\Resolver\SegmentResolver;
use OneSignal\Tests\PrivateAccessorTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\SetUpTearDownTrait;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SegmentResolverTest extends TestCase
{
    use PrivateAccessorTrait;
    use SetUpTearDownTrait;

    /**
     * @var SegmentResolver
     */
    private $segmentResolver;

    public function doSetUp()
    {
        $this->segmentResolver = new SegmentResolver();
    }

    public function testResolveWithValidValues()
    {
        $expectedData = [
            'id' => '52d5a7cb-59fe-4d0c-a0b9-9a39a21475ad',
            'name' => 'Custom Segment',
            'filters' => [],
        ];

        $this->assertEquals($expectedData, $this->segmentResolver->resolve($expectedData));
    }

    public function wrongValueTypesProvider()
    {
        return [
            [['id' => 666, 'name' => '']],
            [['name' => 666]],
            [['filters' => 666, 'name' => '']],
        ];
    }

    /**
     * @dataProvider wrongValueTypesProvider
     */
    public function testResolveWithWrongValueTypes($wrongOption)
    {
        $this->expectException(InvalidOptionsException::class);

        $this->segmentResolver->resolve($wrongOption);
    }

    public function testResolveWithWrongOption()
    {
        $this->expectException(UndefinedOptionsException::class);

        $this->segmentResolver->resolve(['wrongOption' => 'wrongValue']);
    }

    /****** Private functions testing ******/

    public function testNormalizeFilters()
    {
        $method = $this->getPrivateMethod(SegmentResolver::class, 'normalizeFilters');

        $inputData = [
            new OptionsResolver(),
            [
                ['wrongField' => 'wrongValue'],
                ['field' => 'session_count', 'relation' => '>', 'value' => '1'],
                ['operator' => 'AND'],
                ['field' => 'tag', 'relation' => '!=', 'key' => 'tag_key', 'value' => '1'],
                ['operator' => 'OR'],
                ['field' => 'last_session', 'relation' => '<', 'value' => '30'],
            ],
        ];

        $expectedData =
            [
                ['field' => 'session_count', 'relation' => '>', 'value' => '1'],
                ['operator' => 'AND'],
                ['field' => 'tag', 'relation' => '!=', 'key' => 'tag_key', 'value' => '1'],
                ['operator' => 'OR'],
                ['field' => 'last_session', 'relation' => '<', 'value' => '30'],
            ];

        $this->assertEquals($expectedData, $method->invokeArgs($this->segmentResolver, $inputData));
    }
}
