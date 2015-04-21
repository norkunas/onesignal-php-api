<?php
namespace OneSignal;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Apps
{
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
        return $this->http->get('https://onesignal.com/api/v1/apps/' . $id, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getUserAuthKey(),
            ],
        ])->json();
    }

    public function getAll()
    {
        return $this->http->get('https://onesignal.com/api/v1/apps', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getUserAuthKey(),
            ],
        ])->json();
    }

    public function add(array $data)
    {
        $data = $this->resolve($data);

        return $this->http->post('https://onesignal.com/api/v1/apps', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getUserAuthKey(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ])->json();
    }

    public function update($id, array $data)
    {
        $data = $this->resolve($data);

        return $this->http->put('https://onesignal.com/api/v1/apps/' . $id, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getUserAuthKey(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ])->json();
    }

    protected function resolve(array $data)
    {
        $resolver = new OptionsResolver();

        $resolver->setRequired('name');
        $resolver->setAllowedTypes('name', 'string');
        $resolver->setDefined(['apns_env', 'apns_p12', 'apns_password', 'gcm_key']);
        $resolver->setAllowedTypes('apns_env', 'string');
        $resolver->setAllowedValues('apns_env', ['sandbox', 'production']);
        $resolver->setAllowedTypes('apns_p12', 'string');
        $resolver->setAllowedTypes('apns_password', 'string');
        $resolver->setAllowedTypes('gcm_key', 'string');

        return $resolver->resolve($data);
    }
}
