<?php

declare(strict_types=1);

namespace OneSignal\Tests;

use OneSignal\Dto\Segment\CreateSegment;
use OneSignal\Dto\Segment\ListSegments;
use OneSignal\OneSignal;
use OneSignal\Response\Segment\CreateSegmentResponse;
use OneSignal\Response\Segment\DeleteSegmentResponse;
use OneSignal\Response\Segment\ListSegmentsResponse;
use OneSignal\Segments;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SegmentsTest extends ApiTestCase
{
    public function testList(): void
    {
        $client = $this->createClientMock(function (string $method, string $url, array $options): ResponseInterface {
            $this->assertSame('GET', $method);
            $this->assertSame(OneSignal::API_URL.'/apps/fakeApplicationId/segments?limit=300', $url);
            $this->assertArrayHasKey('accept', $options['normalized_headers']);
            $this->assertSame('Accept: application/json', $options['normalized_headers']['accept'][0]);

            return new MockResponse($this->loadFixture('segments_get_all.json'), ['http_code' => 200]);
        });

        $segments = new Segments($client);

        $responseData = $segments->list(new ListSegments(300));

        self::assertEquals(ListSegmentsResponse::makeFromResponse([
            'total_count' => 1,
            'offset' => 0,
            'limit' => 300,
            'segments' => [
                [
                    'id' => '4414c404-56a3-11ed-9b6a-0242ac120002',
                    'name' => 'Subscribed Users',
                    'created_at' => '2022-07-23T13:44:10.324Z',
                    'updated_at' => '2022-09-18T11:33:02.451Z',
                    'app_id' => '65c10914-56a3-11ed-9b6a-0242ac120002',
                    'read_only' => false,
                    'is_active' => true,
                ],
            ],
        ]), $responseData);
    }

    public function testCreate(): void
    {
        $client = $this->createClientMock(function (string $method, string $url, array $options): ResponseInterface {
            $this->assertSame('POST', $method);
            $this->assertSame(OneSignal::API_URL.'/apps/fakeApplicationId/segments', $url);
            $this->assertArrayHasKey('accept', $options['normalized_headers']);
            $this->assertArrayHasKey('content-type', $options['normalized_headers']);
            $this->assertSame('Accept: application/json', $options['normalized_headers']['accept'][0]);
            $this->assertSame('Content-Type: application/json', $options['normalized_headers']['content-type'][0]);

            return new MockResponse($this->loadFixture('segments_create.json'), ['http_code' => 201]);
        });

        $segments = new Segments($client);

        $responseData = $segments->create(new CreateSegment('Segment 2'));

        self::assertEquals(CreateSegmentResponse::makeFromResponse([
            'success' => true,
            'id' => '7ed2887d-bd24-4a81-8220-4b256a08ab19',
        ]), $responseData);
    }

    public function testDelete(): void
    {
        $client = $this->createClientMock(function (string $method, string $url, array $options): ResponseInterface {
            $this->assertSame('DELETE', $method);
            $this->assertSame(OneSignal::API_URL.'/apps/fakeApplicationId/segments/e4e87830-b954-11e3-811d-f3b376925f15', $url);
            $this->assertArrayHasKey('accept', $options['normalized_headers']);
            $this->assertArrayHasKey('authorization', $options['normalized_headers']);
            $this->assertSame('Accept: application/json', $options['normalized_headers']['accept'][0]);
            $this->assertSame('Authorization: Basic fakeApplicationAuthKey', $options['normalized_headers']['authorization'][0]);

            return new MockResponse($this->loadFixture('segments_delete.json'), ['http_code' => 200]);
        });

        $segments = new Segments($client);

        $responseData = $segments->delete('e4e87830-b954-11e3-811d-f3b376925f15');

        self::assertEquals(new DeleteSegmentResponse(true), $responseData);
    }
}
