<?php
namespace OneSignal;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Apps
{
    /**
     * @var OneSignal
     */
    protected $api;

    /**
     * Constructor
     *
     * @param OneSignal $api
     */
    public function __construct(OneSignal $api)
    {
        $this->api = $api;
    }

    public function getOne($id)
    {
        return $this->api->request('GET', '/apps/' . $id, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getUserAuthKey(),
            ],
        ]);
    }

    public function getAll()
    {
        return $this->api->request('GET', '/apps', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getUserAuthKey(),
            ],
        ]);
    }

    public function add(array $data)
    {
        $data = $this->resolve($data);

        return $this->api->request('POST', '/apps', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getUserAuthKey(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    public function update($id, array $data)
    {
        $data = $this->resolve($data);

        return $this->api->request('PUT', '/apps/' . $id, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getUserAuthKey(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
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
