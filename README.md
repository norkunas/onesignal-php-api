# OneSignal API for PHP

[![Latest Stable Version](https://poser.pugx.org/norkunas/onesignal-php-api/v/stable)](https://packagist.org/packages/norkunas/onesignal-php-api)
[![Latest Unstable Version](https://poser.pugx.org/norkunas/onesignal-php-api/v/unstable)](https://packagist.org/packages/norkunas/onesignal-php-api)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/norkunas/onesignal-php-api/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/norkunas/onesignal-php-api/?branch=1.0)
[![Total Downloads](https://poser.pugx.org/norkunas/onesignal-php-api/downloads)](https://packagist.org/packages/norkunas/onesignal-php-api)
[![Build Status](https://travis-ci.org/norkunas/onesignal-php-api.svg?branch=1.0)](https://travis-ci.org/norkunas/onesignal-php-api)
[![StyleCI](https://styleci.io/repos/34352212/shield?style=flat&branch=1.0)](https://styleci.io/repos/34352212)
[![License](https://poser.pugx.org/norkunas/onesignal-php-api/license)](https://packagist.org/packages/norkunas/onesignal-php-api)

## Install

This packages requires an http adapter to work. You can choose any from
[php-http/client-implementation](https://packagist.org/providers/php-http/client-implementation)

Example with Guzzle v6 adapter, install it with [Composer](https://getcomposer.org/):

```
composer require php-http/guzzle6-adapter:^1.1 norkunas/onesignal-php-api
```

And now configure the service:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Common\HttpMethodsClient as HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use OneSignal\Config;
use OneSignal\OneSignal;

$config = new Config();
$config->setApplicationId('your_application_id');
$config->setApplicationAuthKey('your_application_auth_key');
$config->setUserAuthKey('your_auth_key');

$guzzle = new GuzzleClient([ // http://docs.guzzlephp.org/en/stable/quickstart.html
    // ..config
]);

$client = new HttpClient(new GuzzleAdapter($guzzle), new GuzzleMessageFactory());
$api = new OneSignal($config, $client);
```

## How to use this library

### Applications API

View the details of all of your current OneSignal applications ([official documentation](https://documentation.onesignal.com/reference#view-apps-apps)):

```php
$myApps = $api->apps->getAll();
```

View the details of a single OneSignal application ([official documentation](https://documentation.onesignal.com/reference#view-an-app)):

```php
$myApp = $api->apps->getOne('application_id');
```

Create a new OneSignal app ([official documentation](https://documentation.onesignal.com/reference#create-an-app)):

```php
$newApp = $api->apps->add([
    'name' => 'app name',
    'gcm_key' => 'key'
]);
```

Update the name or configuration settings of OneSignal application ([official documentation](https://documentation.onesignal.com/reference#update-an-app)):

```php
$api->apps->update('application_id', [
    'name' => 'new app name'
]);
```

### Devices API

View the details of multiple devices in one of your OneSignal apps ([official documentation](https://documentation.onesignal.com/reference#view-devices)):

```php
$devices = $api->devices->getAll();
```

View the details of an existing device in your configured OneSignal application ([official documentation](https://documentation.onesignal.com/reference#view-device)):

```php
$device = $api->devices->getOne('device_id');
```

Register a new device to your configured OneSignal application ([official documentation](https://documentation.onesignal.com/reference#add-a-device)):

```php
$newDevice = $api->devices->add([
    'device_type' => Devices::ANDROID,
    'identifier' => 'abcdefghijklmn',
]);
```

Update an existing device in your configured OneSignal application ([official documentation](https://documentation.onesignal.com/reference#edit-device)):

```php
$api->devices->update('device_id', [
    'session_count' => 2,
]);
```

### Notifications API

View the details of multiple notifications ([official documentation](https://documentation.onesignal.com/reference#view-notifications)):

```php
$notifications = $api->notifications->getAll();
```

Get the details of a single notification ([official documentation](https://documentation.onesignal.com/reference#view-notification)):

```php
$notification = $api->notifications->getOne('notification_id');
```

Create and send notifications or emails to a segment or individual users.
You may target users in one of three ways using this method: by Segment, by
Filter, or by Device (at least one targeting parameter must be specified) ([official documentation](https://documentation.onesignal.com/reference#create-notification)):

```php
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
```

Mark notification as opened ([official documentation](https://documentation.onesignal.com/reference#track-open)):

```php
$api->notifications->open('notification_id');
```

Stop a scheduled or currently outgoing notification ([official documentation](https://documentation.onesignal.com/reference#cancel-notification)):

```php
$api->notifications->cancel('notification_id');
```

## Questions?

If you have any questions please [open an issue](https://github.com/norkunas/onesignal-php-api/issues/new).

## License

This library is released under the MIT License. See the bundled [LICENSE](https://github.com/norkunas/onesignal-php-api/blob/master/LICENSE) file for details.
