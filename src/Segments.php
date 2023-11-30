<?php

declare(strict_types=1);

namespace OneSignal;

use OneSignal\Dto\Segments\CreateSegment;
use OneSignal\Dto\Support\Pagination;

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
    public function list(Pagination $paginationDto): array
    {
        $app_id = $this->client->getConfig()->getApplicationId();

        $request = $this->createRequest('GET', '/apps/'.$app_id.'/segments?'.http_build_query($paginationDto->toArray()));
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
        $app_id = $this->client->getConfig()->getApplicationId();

        $request = $this->createRequest('POST', '/apps/'.$app_id.'/segments');
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
     * @param string $id Segment ID
     */
    public function delete(string $id): array
    {
        $app_id = $this->client->getConfig()->getApplicationId();

        $request = $this->createRequest('DELETE', '/apps/'.$app_id.'/segments/'.$id);
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }
}
