<?php

declare(strict_types=1);

namespace OneSignal;

use OneSignal\Resolver\ResolverFactory;

class Notifications extends AbstractApi
{
    private $resolverFactory;

    public function __construct(OneSignal $client, ResolverFactory $resolverFactory)
    {
        parent::__construct($client);

        $this->resolverFactory = $resolverFactory;
    }

    /**
     * Get information about notification with provided ID.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     */
    public function getOne(string $id): array
    {
        $request = $this->createRequest('GET', "/notifications/$id?app_id={$this->client->getConfig()->getApplicationId()}");
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }

    /**
     * Get information about all notifications.
     *
     * Application authentication key and ID must be set.
     *
     * @param int $limit  How many notifications to return (max 50)
     * @param int $offset Results offset (results are sorted by ID)
     */
    public function getAll(int $limit = null, int $offset = null): array
    {
        $query = ['app_id' => $this->client->getConfig()->getApplicationId()];

        if ($limit !== null) {
            $query['limit'] = $limit;
        }

        if ($offset !== null) {
            $query['offset'] = $offset;
        }

        $request = $this->createRequest('GET', '/notifications?'.http_build_query($query));
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }

    /**
     * Send new notification with provided data.
     *
     * Application authentication key and ID must be set.
     */
    public function add(array $data): array
    {
        $resolvedData = $this->resolverFactory->createNotificationResolver()->resolve($data);

        $request = $this->createRequest('POST', '/notifications');
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->createStream($resolvedData));

        return $this->client->sendRequest($request);
    }

    /**
     * Open notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     */
    public function open(string $id): array
    {
        $request = $this->createRequest('PUT', "/notifications/$id");
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->createStream([
            'app_id' => $this->client->getConfig()->getApplicationId(),
            'opened' => true,
        ]));

        return $this->client->sendRequest($request);
    }

    /**
     * Cancel notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     */
    public function cancel(string $id): array
    {
        $request = $this->createRequest('DELETE', "/notifications/$id?app_id={$this->client->getConfig()->getApplicationId()}");
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");

        return $this->client->sendRequest($request);
    }

    /**
     * View the devices sent a notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     */
    public function history(string $id, array $data): array
    {
        $resolvedData = $this->resolverFactory->createNotificationHistoryResolver()->resolve($data);

        $request = $this->createRequest('POST', "/notifications/$id/history");
        $request = $request->withHeader('Authorization', "Basic {$this->client->getConfig()->getApplicationAuthKey()}");
        $request = $request->withHeader('Cache-Control', 'no-cache');
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withBody($this->createStream($resolvedData));

        return $this->client->sendRequest($request);
    }
}
