<?php

declare(strict_types=1);

namespace OneSignal;

use OneSignal\Dto\Segment\CreateSegment;
use OneSignal\Dto\Segment\ListSegments;

class Segments extends AbstractApi
{
    public function __construct(OneSignal $client)
    {
        parent::__construct($client);
    }

    /**
     * Get information about all segments.
     *
     * Application authentication key and ID must be set.
     */
    public function list(ListSegments $listSegmentsDto): array
    {
        $appId = $this->client->getConfig()->getApplicationId();

        $request = $this->createRequest('GET', '/apps/'.$appId.'/segments?'.http_build_query($listSegmentsDto->toArray()));
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }

    /**
     * Create new segment with provided data.
     *
     * Application authentication key and ID must be set.
     */
    public function create(CreateSegment $createSegmentDto): array
    {
        $appId = $this->client->getConfig()->getApplicationId();

        $request = $this->createRequest('POST', '/apps/'.$appId.'/segments');
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->createStream($createSegmentDto->toArray()));

        return $this->client->sendRequest($request);
    }

    /**
     * Delete segment.
     *
     * Application authentication key and ID must be set.
     *
     * @param non-empty-string $id Segment ID
     */
    public function delete(string $id): array
    {
        $appId = $this->client->getConfig()->getApplicationId();

        $request = $this->createRequest('DELETE', '/apps/'.$appId.'/segments/'.$id);
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }
}
