<?php

namespace OneSignal;

use OneSignal\Resolver\ResolverFactory;

class Apps
{
    protected $api;

    private $resolverFactory;

    public function __construct(OneSignal $api, ResolverFactory $resolverFactory)
    {
        $this->api = $api;
        $this->resolverFactory = $resolverFactory;
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
        $data = $this->resolverFactory->createAppResolver()->resolve($data);

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
        $data = $this->resolverFactory->createAppResolver()->resolve($data);

        return $this->api->request('PUT', '/apps/'.$id, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getUserAuthKey(),
        ], json_encode($data));
    }

    /**
     * Create a new segment for application with provided data.
     *
     * @param string $appId ID of your application
     * @param array  $data  Segment Data
     *
     * @return array
     */
    public function createSegment($appId, array $data)
    {
        $data = $this->resolverFactory->createSegmentResolver()->resolve($data);

        return $this->api->request('POST', '/apps/'.$appId.'/segments', [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ], json_encode($data));
    }

    /**
     * Delete existing segment from your application.
     *
     * Application auth key must be set.
     *
     * @param string $appId     Application ID
     * @param string $segmentId Segment ID
     *
     * @return array
     */
    public function deleteSegment($appId, $segmentId)
    {
        return $this->api->request('DELETE', '/apps/'.$appId.'/segments/'.$segmentId, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }
}
