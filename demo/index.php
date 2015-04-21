<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \OneSignal\Client();
$client->setApplicationId('fa2c7836-e7f2-11e4-a050-2fad00aaa11c');
$client->setApplicationAuthKey('ZmEyYzc4OWEtZTdmMi0xMWU0LWEwNTEtNzc5NjYwMDc3NzEw');
$client->setUserAuthKey('NDJmNmQzMWEtZTdmNi0xMWU0LWE1ZGEtOWY2MTk0NzMxM2Mx');

$api = new \OneSignal\OneSignal($client);

//var_dump($api->apps->getAll());
//var_dump($api->apps->getOne('fa2c7836-e7f2-11e4-a050-2fad00aaa11c'));
//var_dump($api->apps->add(['name' => 'app name', 'gcm_key' => 'key']));
//var_dump($api->apps->update('fa2c7836-e7f2-11e4-a050-2fad00aaa11c', ['name' => 'new app name']));

//var_dump($api->devices->getAll());
//var_dump($api->devices->getOne('f659291e-e803-11e4-ab79-9bb217de3469'));

/*var_dump($api->devices->add([
    'device_type' => \OneSignal\Devices::ANDROID,
    'identifier' => 'abcdefghijklmn',
]));*/
/*var_dump($api->devices->update('ecaf317a-e802-11e4-8e3e-33451c7676b6', [
    'session_count' => 2,
]));*/

//var_dump($api->notifications->getAll());
//var_dump($api->notifications->getOne('12a3edf2-e7ff-11e4-90c0-5ff9eb7af3bd'));
//var_dump($api->notifications->open('2ebfde20-e803-11e4-945a-6f19f26819b1'));
var_dump($api->notifications->add([
    'headings' => ['en' => 'test heading'],
    'contents' => ['en' => 'one more test for today'],
    'included_segments' => ['All'],
    'data' => ['foo' => 'bar'],
    //'delivery_time_of_day' => new DateTime(),
    //'send_after' => new \DateTime(),
]));
//var_dump($api->notifications->cancel('2ebfde20-e803-11e4-945a-6f19f26819b1'));
