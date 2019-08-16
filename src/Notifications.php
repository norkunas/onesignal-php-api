<?php

namespace OneSignal;

use OneSignal\Resolver\ResolverFactory;

class Notifications
{
    const NOTIFICATIONS_LIMIT = 50;

    protected $api;

    private $resolverFactory;

    public function __construct(OneSignal $api, ResolverFactory $resolverFactory)
    {
        $this->api = $api;
        $this->resolverFactory = $resolverFactory;
    }

    /**
     * Get information about notification with provided ID.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     *
     * @return array
     */
    public function getOne($id)
    {
        $url = '/notifications/'.$id.'?app_id='.$this->api->getConfig()->getApplicationId();

        return $this->api->request('GET', $url, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }

    /**
     * Get information about all notifications.
     *
     * Application authentication key and ID must be set.
     *
     * @param int $limit  How many notifications to return (max 50)
     * @param int $offset Results offset (results are sorted by ID)
     *
     * @return array
     */
    public function getAll($limit = self::NOTIFICATIONS_LIMIT, $offset = 0)
    {
        $query = [
            'limit' => max(1, min(self::NOTIFICATIONS_LIMIT, filter_var($limit, FILTER_VALIDATE_INT))),
            'offset' => max(0, filter_var($offset, FILTER_VALIDATE_INT)),
            'app_id' => $this->api->getConfig()->getApplicationId(),
        ];

        return $this->api->request('GET', '/notifications?'.http_build_query($query), [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }

    /**
     * Send new notification with provided data.
     *
     * Application authentication key and ID must be set.
     *
     * @param array $data
     *
     * @return array
     */
    public function add(array $data)
    {
        $data = $this->resolverFactory->createNotificationResolver()->resolve($data);

        return $this->api->request('POST', '/notifications', [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ], json_encode($data));
    }

    /**
     * Open notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     *
     * @return array
     */
    public function open($id)
    {
        return $this->api->request('PUT', '/notifications/'.$id, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ], json_encode([
            'app_id' => $this->api->getConfig()->getApplicationId(),
            'opened' => true,
        ]));
    }

    /**
     * Cancel notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     *
     * @return array
     */
    public function cancel($id)
    {
        $url = '/notifications/'.$id.'?app_id='.$this->api->getConfig()->getApplicationId();

        return $this->api->request('DELETE', $url, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }

    /**
     * View the devices sent a notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id   Notification ID
     * @param array  $data
     *
     * @return array
     */
    public function history($id, array $data)
    {
        $url = '/notifications/'.$id.'/history?app_id='.$this->api->getConfig()->getApplicationId();

        $data = $this->resolverFactory->createNotificationResolver()->resolve($data);

        return $this->api->request('POST', $url, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
            'Cache-Control' => 'no-cache',
        ], json_encode($data));
    }
}
