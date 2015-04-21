<?php
function sendMessage(){
    $content = array(
        "en" => 'English Message'
    );

    $fields = array(
        'app_id' => "fa2c7836-e7f2-11e4-a050-2fad00aaa11c",
        'included_segments' => array('All'),
        'send_after' => 'Fri May 02 2014 00:00:00 GMT-0700 (PDT)',
        'data' => array("foo" => "bar"),
        'isChrome' => true,
        'contents' => $content
    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://gamethrive.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic ZmEyYzc4OWEtZTdmMi0xMWU0LWEwNTEtNzc5NjYwMDc3NzEw'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

$response = sendMessage();
$return["allresponses"] = $response;
$return = json_encode( $return);

print("\n\nJSON received:\n");
print($return);
print("\n");