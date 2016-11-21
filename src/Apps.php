<?php

namespace OneSignal;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Apps
{
    protected $api;

    public function __construct(OneSignal $api)
    {
        $this->api = $api;
    }

    /**
     * Get information about application with provided ID.
     *
     * User authentication key must be set.
     *
     * @param string $id ID of your application
     *
     * @return array
     */
    public function getOne($id)
    {
        return $this->api->request('GET', '/apps/'.$id, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getUserAuthKey(),
        ]);
    }

    /**
     * Get information about all your created applications.
     *
     * User authentication key must be set.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->api->request('GET', '/apps', [
            'Authorization' => 'Basic '.$this->api->getConfig()->getUserAuthKey(),
        ]);
    }

    /**
     * Create a new application with provided data.
     *
     * User authentication key must be set.
     *
     * @param array $data Application data
     *
     * @return array
     */
    public function add(array $data)
    {
        $data = $this->resolve($data);

        return $this->api->request('POST', '/apps', [
            'Authorization' => 'Basic '.$this->api->getConfig()->getUserAuthKey(),
        ], json_encode($data));
    }

    /**
     * Update application with provided data.
     *
     * User authentication key must be set.
     *
     * @param string $id   ID of your application
     * @param array  $data New application data
     *
     * @return array
     */
    public function update($id, array $data)
    {
        $data = $this->resolve($data);

        return $this->api->request('PUT', '/apps/'.$id, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getUserAuthKey(),
        ], json_encode($data));
    }

    protected function resolve(array $data)
    {
        $resolver = new OptionsResolver();

        $resolver
            ->setRequired('name')
            ->setAllowedTypes('name', 'string')
            ->setDefined('apns_env')
            ->setAllowedTypes('apns_env', 'string')
            ->setAllowedValues('apns_env', ['sandbox', 'production'])
            ->setDefined('apns_p12')
            ->setAllowedTypes('apns_p12', 'string')
            ->setDefined('apns_p12_password')
            ->setAllowedTypes('apns_p12_password', 'string')
            ->setDefined('gcm_key')
            ->setAllowedTypes('gcm_key', 'string')
            ->setDefined('chrome_key')
            ->setAllowedTypes('chrome_key', 'string')
            ->setDefined('safari_apns_p12')
            ->setAllowedTypes('safari_apns_p12', 'string')
            ->setDefined('chrome_web_key')
            ->setAllowedTypes('chrome_web_key', 'string')
            ->setDefined('safari_apns_p12_password')
            ->setAllowedTypes('safari_apns_p12_password', 'string')
            ->setDefined('site_name')
            ->setAllowedTypes('site_name', 'string')
            ->setDefined('safari_site_origin')
            ->setAllowedTypes('safari_site_origin', 'string')
            ->setDefined('safari_icon_16_16')
            ->setAllowedTypes('safari_icon_16_16', 'string')
            ->setDefined('safari_icon_32_32')
            ->setAllowedTypes('safari_icon_32_32', 'string')
            ->setDefined('safari_icon_64_64')
            ->setAllowedTypes('safari_icon_64_64', 'string')
            ->setDefined('safari_icon_128_128')
            ->setAllowedTypes('safari_icon_128_128', 'string')
            ->setDefined('safari_icon_256_256')
            ->setAllowedTypes('safari_icon_256_256', 'string')
            ->setDefined('chrome_web_origin')
            ->setAllowedTypes('chrome_web_origin', 'string')
            ->setDefined('chrome_web_gcm_sender_id')
            ->setAllowedTypes('chrome_web_gcm_sender_id', 'string')
            ->setDefined('chrome_web_default_notification_icon')
            ->setAllowedTypes('chrome_web_default_notification_icon', 'string')
            ->setDefined('chrome_web_sub_domain')
            ->setAllowedTypes('chrome_web_sub_domain', 'string');

        return $resolver->resolve($data);
    }
}
