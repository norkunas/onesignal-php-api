<?php
namespace OneSignal;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Devices
{
    const IOS = 0;
    const ANDROID = 1;
    const AMAZON = 2;
    const WINDOWS_PHONE = 3;

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
     * @return \GuzzleHttp\Message\Response
     */
    public function getOne($id)
    {
        return $this->api->request('GET', '/players/' . $id);
    }

    /**
     * Get information about all registered devices for your application.
     *
     * Application auth key must be set.
     *
     * @param int $limit  Results offset (results are sorted by ID)
     * @param int $offset How many devices to return (max 50)
     *
     * @return array
     */
    public function getAll($limit = 50, $offset = 0)
    {
        return $this->api->request('GET', '/players?' . http_build_query([
            'limit' => max(0, min(50, filter_var($limit, FILTER_VALIDATE_INT))),
            'offset' => max(0, min(50, filter_var($offset, FILTER_VALIDATE_INT))),
        ]), [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
            'json' => [
                'app_id' => $this->api->getConfig()->getApplicationId(),
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
            ->setDefault('app_id', $this->api->getConfig()->getApplicationId());

        return $resolver->resolve($data);
    }
}
