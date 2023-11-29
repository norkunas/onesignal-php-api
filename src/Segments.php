<?php

declare(strict_types=1);

namespace OneSignal;

use OneSignal\Resolver\ResolverFactory;

class Segments extends AbstractApi
{
    private $resolverFactory;

    public function __construct(OneSignal $client, ResolverFactory $resolverFactory)
    {
        parent::__construct($client);

        $this->resolverFactory = $resolverFactory;
    }

    /**
     * Get information about all segments.
     *
     * Application authentication key and ID must be set.
     *
     * @param int $limit  How many segments to return (max 50)
     * @param int $offset Results offset
     */
    public function getAll(int $limit = null, int $offset = null): array
    {
        $app_id = $this->client->getConfig()->getApplicationId();

        $query = [];

        if ($limit !== null) {
            $query['limit'] = $limit;
        }

        if ($offset !== null) {
            $query['offset'] = $offset;
        }

        $request = $this->createRequest('GET', '/apps/'.$app_id.'/segments?'.http_build_query($query));
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }

    /**
     * Create new segment with provided data.
     *
     * Application authentication key and ID must be set.
     */
    public function add(array $data): array
    {
        $app_id = $this->client->getConfig()->getApplicationId();
        $resolvedData = $this->resolverFactory->createSegmentResolver()->resolve($data);

        $request = $this->createRequest('POST', '/apps/'.$app_id.'/segments');
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->createStream($resolvedData));

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
