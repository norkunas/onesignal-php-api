<?php

namespace OneSignal;

use OneSignal\Resolver\ResolverFactory;

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

    const ALEXA = 10;

    const EMAIL = 11;

    protected $api;

    private $resolverFactory;

    public function __construct(OneSignal $api, ResolverFactory $resolverFactory)
    {
        $this->api = $api;
        $this->resolverFactory = $resolverFactory;
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

        return $this->api->request('GET', '/players/'.$id.'?'.http_build_query($query));
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

        return $this->api->request('GET', '/players?'.http_build_query($query), [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
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
        $data = $this->resolverFactory->createNewDeviceResolver()->resolve($data);

        return $this->api->request('POST', '/players', [], json_encode($data));
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
        $data = $this->resolverFactory->createExistingDeviceResolver()->resolve($data);

        return $this->api->request('PUT', '/players/'.$id, [], json_encode($data));
    }

    /**
     * Delete existing registered device from your application.
     *
     * OneSignal supports DELETE on the players API endpoint which is not documented in their official documentation
     * Reference: https://documentation.onesignal.com/docs/handling-personal-data#section-deleting-users-or-other-data-from-onesignal
     *
     * Application auth key must be set.
     *
     * @param string $id Device ID
     *
     * @return array
     */
    public function delete($id)
    {
        $query = [
            'app_id' => $this->api->getConfig()->getApplicationId(),
        ];

        return $this->api->request('DELETE', '/players/'.$id.'?'.http_build_query($query), [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
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
        $data = $this->resolverFactory->createDeviceSessionResolver()->resolve($data);

        return $this->api->request('POST', '/players/'.$id.'/on_session', [], json_encode($data));
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
        $data = $this->resolverFactory->createDevicePurchaseResolver()->resolve($data);

        return $this->api->request('POST', '/players/'.$id.'/on_purchase', [], json_encode($data));
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
        $data = $this->resolverFactory->createDeviceFocusResolver()->resolve($data);

        return $this->api->request('POST', '/players/'.$id.'/on_focus', [], json_encode($data));
    }

    /**
     * Export all information about devices in a CSV format for your application.
     *
     * Application auth key must be set.
     *
     * @param array  $extraFields     Additional fields that you wish to include.
     *                                Currently supports: "location", "country", "rooted"
     * @param string $segmentName     A segment name to filter the scv export by.
     *                                Only devices from that segment will make it into the export
     * @param int    $lastActiveSince An epoch to filter results to users active after this time
     *
     * @return array
     */
    public function csvExport(array $extraFields = [], $segmentName = null, $lastActiveSince = null)
    {
        $url = '/players/csv_export?app_id='.$this->api->getConfig()->getApplicationId();

        $headers = [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ];

        $body = [
            'extra_fields' => $extraFields,
        ];

        if (null !== $segmentName) {
            $body['segment_name'] = $segmentName;
        }

        if (null !== $lastActiveSince) {
            $body['last_active_since'] = (string) $lastActiveSince;
        }

        return $this->api->request('POST', $url, $headers, json_encode($body));
    }
}
