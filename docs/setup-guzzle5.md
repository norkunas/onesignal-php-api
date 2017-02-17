# Setup with Guzzle5

```composer require guzzlehttp/psr7 php-http/guzzle5-adapter norkunas/onesignal-php-api:dev-master```

Note: if you already have some psr7 implementation then skip requiring it.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle5\Client as GuzzleAdapter;
use Http\Client\Common\HttpMethodsClient as HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use OneSignal\Config;
use OneSignal\Devices;
use OneSignal\OneSignal;

$config = new Config();
$config->setApplicationId('your_application_id');
$config->setApplicationAuthKey('your_application_auth_key');
$config->setUserAuthKey('your_auth_key');

$guzzle = new GuzzleClient([
    // ..config
]);

$client = new HttpClient(new GuzzleAdapter($guzzle), new GuzzleMessageFactory());
$api = new OneSignal($config, $client);
```
