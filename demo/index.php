<?php
require __DIR__ . '/../vendor/autoload.php';

$config = new \OneSignal\Config();
$config->setApplicationId('c9db1278-e86a-11e4-a96f-6b54d71a9e36');
$config->setApplicationAuthKey('YzlkYjEyZGMtZTg2YS0xMWU0LWE5NzAtYTcwYmZiYmU3NmVj');
$config->setUserAuthKey('NDJmNmQzMWEtZTdmNi0xMWU0LWE1ZGEtOWY2MTk0NzMxM2Mx');

$api = new \OneSignal\OneSignal($config);

try {
    //var_dump($api->apps->getAll());
    //var_dump($api->apps->getOne('c9db1278-e86a-11e4-a96f-6b54d71a9e36'));
    //var_dump($api->apps->add(['name' => 'app name', 'gcm_key' => 'key']));
    //var_dump($api->apps->update('aabe07fe-e8da-11e4-ae67-175a24949d0d', ['name' => 'new app name']));

    //var_dump($api->devices->getAll());
    //var_dump($api->devices->getOne('f715be08-e8da-11e4-be26-23a53a7af709'));

    /*var_dump($api->devices->add([
        'device_type' => \OneSignal\Devices::ANDROID,
        'identifier' => 'abcdefghijklmn',
    ]));*/
    /*var_dump($api->devices->update('f715be08-e8da-11e4-be26-23a53a7af709', [
        'session_count' => 2,
    ]));*/

    //var_dump($api->notifications->getAll());
    //var_dump($api->notifications->getOne('38dc8fdc-e8c3-11e4-87f3-0b1ff219297a'));
    var_dump($api->notifications->add([
        //'headings' => ['en' => 'test heading'],
        'contents' => ['en' => 'one more test'],
        'included_segments' => ['All'],
        'data' => ['foo' => 'bar'],
        'isChrome' => true,
        //'delivery_time_of_day' => new DateTime(),
        'send_after' => new \DateTime('tomorrow'),
    ]));
    //var_dump($api->notifications->open('38dc8fdc-e8c3-11e4-87f3-0b1ff219297a'));
    //var_dump($api->notifications->cancel('38dc8fdc-e8c3-11e4-87f3-0b1ff219297a'));
} catch (\OneSignal\Exception\OneSignalException $e) {
    var_dump($e->getErrors(), $e->getStatusCode());
}
