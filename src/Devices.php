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
     * @var Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Constructor
     *
     * @param Client             $client
     * @param \GuzzleHttp\Client $guzzle
     */
    public function __construct(Client $client, \GuzzleHttp\Client $guzzle)
    {
        $this->client = $client;
        $this->http = $guzzle;
    }

    public function getOne($id)
    {
        return $this->http->get('https://onesignal.com/api/v1/players/' . $id, [
            'headers' => [
                //'Authorization' => 'Basic ' . $this->client->getApplicationAuthKey(),
            ],
        ])->json();
    }

    public function getAll($limit = null, $offset = null)
    {
        $url = 'https://onesignal.com/api/v1/players?app_id=' . $this->client->getApplicationId();

        if ($limit) {
            $url .= '&limit=' . $limit;
        }

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        return $this->http->get($url, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getApplicationAuthKey(),
            ],
        ])->json();
    }

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

        return $this->http->post('https://onesignal.com/api/v1/players', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ])->json();
    }

    public function update($id, array $data)
    {
        $data = $this->resolve($data);

        return $this->http->put('https://onesignal.com/api/v1/players/' . $id, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ])->json();
    }

    protected function resolve(array $data, callable $callback = null)
    {
        $resolver = new OptionsResolver();

        if (is_callable($callback)) {
            $callback($resolver);
        }

        $resolver
            ->setDefined('identifier')
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
            ->setDefault('app_id', $this->client->getApplicationId());

        return $resolver->resolve($data);
    }
}
