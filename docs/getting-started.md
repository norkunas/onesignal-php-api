# Installing OneSignal API for PHP

1. [Setup with Guzzle5](/docs/setup-guzzle5.md)
2. [Setup with Guzzle6](/docs/setup-guzzle6.md)

# Now make some api calls

Note: All API responses can be found at [Official Documentation](https://documentation.onesignal.com/reference).

### Applications
Possible options are listed at [Official Documentation](https://documentation.onesignal.com/reference#create-an-app).
```php
// Get the list of your OneSignal applications
$myApps = $api->apps->getAll();
// Get the information about your specific OneSignal application
$myApp = $api->apps->getOne('application_id');

$newApp = $api->apps->add([
    'name' => 'app name',
    'gcm_key' => 'key'
]);

$api->apps->update('application_id', ['name' => 'new app name']);
```

### Devices
Possible options are listed at [Official Documentation](https://documentation.onesignal.com/reference#add-a-device).
```php
$devices = $api->devices->getAll();
$device = $api->devices->getOne('device_id');

$newDevice = $api->devices->add([
    'device_type' => Devices::ANDROID,
    'identifier' => 'abcdefghijklmn',
]);

$api->devices->update('device_id', [
    'session_count' => 2,
]);
```

### Notifications
Possible options are listed at [Official Documentation](https://documentation.onesignal.com/reference#create-notification).
```php
$notifications = $api->notifications->getAll();
$notification = $api->notifications->getOne('notification_id');
// Do not combine targeting parameters
$api->notifications->add([
    'contents' => [
        'en' => 'Notification message'
    ],
    'included_segments' => ['All'],
    'data' => ['foo' => 'bar'],
    'isChrome' => true,
    'send_after' => new \DateTime('1 hour'),
    'filters' => [
        [
            'field' => 'tag',
            'key' => 'is_vip',
            'relation' => '!=',
            'value' => 'true',
        ],
        [
            'operator' => 'OR',
        ],
        [
            'field' => 'tag',
            'key' => 'is_admin',
            'relation' => '=',
            'value' => 'true',
        ],
    ],
    // ..other options
]));

$api->notifications->open('notification_id');
$api->notifications->cancel('notification_id');
```
