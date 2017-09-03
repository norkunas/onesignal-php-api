<?php

namespace OneSignal\Resolver;

use OneSignal\Config;

class ResolverFactory
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function createAppResolver()
    {
        return new AppResolver();
    }

    public function createDeviceSessionResolver()
    {
        return new DeviceSessionResolver();
    }

    public function createDevicePurchaseResolver()
    {
        return new DevicePurchaseResolver();
    }

    public function createDeviceFocusResolver()
    {
        return new DeviceFocusResolver();
    }

    public function createNewDeviceResolver()
    {
        return new DeviceResolver($this->config, true);
    }

    public function createExistingDeviceResolver()
    {
        return new DeviceResolver($this->config, false);
    }

    public function createNotificationResolver()
    {
        return new NotificationResolver($this->config);
    }
}
