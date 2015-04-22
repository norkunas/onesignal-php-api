# OneSignal API for PHP

## Install using Composer

```
composer require norkunas/onesignal-php-api
```

### Info

All API responses can be found at [Official Documentation](http://documentation.onesignal.com/v2.0/docs/server-api-overview).

### Initialize
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use OneSignal\Config;
use OneSignal\Devices;
use OneSignal\OneSignal;

$config = new Config();
$config->setApplicationId('your_application_id');
$config->setApplicationAuthKey('your_application_auth_key');
$config->setUserAuthKey('your_auth_key');

$api = new \OneSignal\OneSignal($config);
```

### Applications
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
```php
$notifications = $api->notifications->getAll();
$notification = $api->notifications->getOne('notification_id');

$api->notifications->add([
    'contents' => [
        'en' => 'Notification message'
    ],
    'included_segments' => ['All'],
    'data' => ['foo' => 'bar'],
    'isChrome' => true,
    'send_after' => new \DateTime('1 hour'),
    // ..other options
]));

$api->notifications->open('notification_id');
$api->notifications->cancel('notification_id');
```

### Catching errors
```php
use OneSignal\Exception\OneSignalException;

try {
    $api->notifications->getOne('notification_id');
} catch (OneSignalException $e) {
    $httpStatusCode = $e->getStatusCode();
    $errors = $e->getErrors();
}
```
