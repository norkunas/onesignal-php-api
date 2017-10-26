<?php

namespace OneSignal;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Devices
{
    const DEVICES_LIMIT = 300;

    const IOS = 0;
    const ANDROID = 1;
    const AMAZON = 2;
    const WINDOWS_PHONE = 3;
    const WINDOWS_PHONE_MPNS = 3;
    const CHROME_APP = 4;
    const CHROME_WEB = 5;
    const WINDOWS_PHONE_WNS = 6;
    const SAFARI = 7;
    const FIREFOX = 8;
    const MACOS = 9;

    /**
     * @var OneSignal
     */
    protected $api;

    /**
     * Constructor.
     *
     * @param OneSignal $api
     */
    public function __construct(OneSignal $api)
    {
        $this->api = $api;
    }

    /**
     * Get information about device with provided ID.
     *
     * @param string $id Device ID
     *
     * @return array
     */
    public function getOne($id)
    {
        $query = [
            'app_id' => $this->api->getConfig()->getApplicationId(),
        ];

        return $this->api->request('GET', '/players/' . $id . '?' . http_build_query($query));
    }

    /**
     * Get information about all registered devices for your application.
     *
     * Application auth key must be set.
     *
     * @param int $limit  How many devices to return. Max is 300. Default is 300
     * @param int $offset Result offset. Default is 0. Results are sorted by id
     *
     * @return array
     */
    public function getAll($limit = self::DEVICES_LIMIT, $offset = 0)
    {
        $query = [
            'limit' => max(1, min(self::DEVICES_LIMIT, filter_var($limit, FILTER_VALIDATE_INT))),
            'offset' => max(0, filter_var($offset, FILTER_VALIDATE_INT)),
            'app_id' => $this->api->getConfig()->getApplicationId(),
        ];

        return $this->api->request('GET', '/players?' . http_build_query($query), [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
        ]);
    }

    /**
     * Register a device for your application.
     *
     * @param array $data Device data
     *
     * @return array
     */
    public function add(array $data)
    {
        $data = $this->resolve($data, function (OptionsResolver $resolver) {
            $resolver
                ->setRequired('device_type')
                ->setAllowedTypes('device_type', 'int')
                ->setAllowedValues('device_type', [
                    self::IOS,
                    self::ANDROID,
                    self::AMAZON,
                    self::WINDOWS_PHONE,
                    self::WINDOWS_PHONE_MPNS,
                    self::CHROME_APP,
                    self::CHROME_WEB,
                    self::WINDOWS_PHONE_WNS,
                    self::SAFARI,
                    self::FIREFOX,
                    self::MACOS,
                ]);
        });

        return $this->api->request('POST', '/players', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    /**
     * Update existing registered device for your application with provided data.
     *
     * @param string $id   Device ID
     * @param array  $data New device data
     *
     * @return array
     */
    public function update($id, array $data)
    {
        $data = $this->resolve($data);

        return $this->api->request('PUT', '/players/' . $id, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    /**
     * Call on new device session in your app.
     *
     * @param string $id   Device ID
     * @param array  $data Device data
     *
     * @return array
     */
    public function onSession($id, array $data)
    {
        $data = (new OptionsResolver())
            ->setDefined('identifier')
            ->setAllowedTypes('identifier', 'string')
            ->setDefined('language')
            ->setAllowedTypes('language', 'string')
            ->setDefined('timezone')
            ->setAllowedTypes('timezone', 'int')
            ->setDefined('game_version')
            ->setAllowedTypes('game_version', 'string')
            ->setDefined('device_model')
            ->setAllowedTypes('device_model', 'string')
            ->setDefined('ad_id')
            ->setAllowedTypes('ad_id', 'string')
            ->setDefined('sdk')
            ->setAllowedTypes('sdk', 'string')
            ->resolve($data);

        return $this->api->request('POST', '/players/' . $id . '/on_session', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    /**
     * Track a new purchase.
     *
     * @param string $id   Device ID
     * @param array  $data Device data
     *
     * @return array
     */
    public function onPurchase($id, array $data)
    {
        $data = (new OptionsResolver())
            ->setDefined('existing')
            ->setAllowedTypes('existing', 'bool')
            ->setRequired('purchases')
            ->setAllowedTypes('purchases', 'array')
            ->resolve($data);

        foreach ($data['purchases'] as $key => $purchase) {
            $data['purchases'][$key] = (new OptionsResolver())
                ->setRequired('sku')
                ->setAllowedTypes('sku', 'string')
                ->setRequired('amount')
                ->setAllowedTypes('amount', 'float')
                ->setRequired('iso')
                ->setAllowedTypes('iso', 'string')
                ->resolve($purchase);
        }

        return $this->api->request('POST', '/players/' . $id . '/on_purchase', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    /**
     * Increment the device's total session length.
     *
     * @param string $id   Device ID
     * @param array  $data Device data
     *
     * @return array
     */
    public function onFocus($id, array $data)
    {
        $data = (new OptionsResolver())
            ->setDefault('state', 'ping')
            ->setRequired('active_time')
            ->setAllowedTypes('active_time', 'int')
            ->resolve($data);

        return $this->api->request('POST', '/players/' . $id . '/on_focus', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    /**
     * Export all information about devices in a CSV format for your application.
     *
     * Application auth key must be set.
     *
     * @param array $data extra data to pass to the csv_export endpoint
     *
     * @return array
     */
    public function csvExport(array $data = [])
    {
        $url = '/players/csv_export?app_id=' . $this->api->getConfig()->getApplicationId();

        return $this->api->request('POST', $url, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
            'json' => $data,
        ]);
    }

    protected function resolve(array $data, callable $callback = null)
    {
        $resolver = new OptionsResolver();

        if (is_callable($callback)) {
            $callback($resolver);
        }

        $resolver
            ->setDefined('identifier')
            ->setAllowedTypes('identifier', 'string')
            ->setDefined('language')
            ->setAllowedTypes('language', 'string')
            ->setDefined('timezone')
            ->setAllowedTypes('timezone', 'int')
            ->setDefined('game_version')
            ->setAllowedTypes('game_version', 'string')
            ->setDefined('device_model')
            ->setAllowedTypes('device_model', 'string')
            ->setDefined('device_os')
            ->setAllowedTypes('device_os', 'string')
            ->setDefined('ad_id')
            ->setAllowedTypes('ad_id', 'string')
            ->setDefined('sdk')
            ->setAllowedTypes('sdk', 'string')
            ->setDefined('session_count')
            ->setAllowedTypes('session_count', 'int')
            ->setDefined('tags')
            ->setAllowedTypes('tags', 'array')
            ->setDefined('amount_spent')
            ->setAllowedTypes('amount_spent', 'float')
            ->setDefined('created_at')
            ->setAllowedTypes('created_at', 'int')
            ->setDefined('playtime')
            ->setAllowedTypes('playtime', 'int')
            ->setDefined('badge_count')
            ->setAllowedTypes('badge_count', 'int')
            ->setDefined('last_active')
            ->setAllowedTypes('last_active', 'int')
            ->setDefined('notification_types')
            ->setAllowedTypes('notification_types', 'int')
            ->setAllowedValues('notification_types', [1, -2])
            ->setDefined('test_type')
            ->setAllowedTypes('test_type', 'int')
            ->setAllowedValues('test_type', [1, 2])
            ->setDefault('app_id', $this->api->getConfig()->getApplicationId());

        return $resolver->resolve($data);
    }
}
