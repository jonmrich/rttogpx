<?php

$tripId = $_POST["tripId"];
$tripId = 26811305;

$final = [];
$curl  = curl_init();
$headers   = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Content-Type: application/json';
curl_setopt_array($curl, array(
    CURLOPT_URL            => "https://roadtrippers.com/api/v2/trips/" . $tripId,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => "GET",
    CURLOPT_HTTPHEADER     => $headers,
));
$response = curl_exec($curl);
$err      = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $obj       = json_decode($response, true);
    $trip_name = $obj['trip']['name'];
    if ($obj['trip']['description']) {
        $trip_description = $obj['trip']['description'];
    } else { $trip_description = "Not provided";}

    $trip_path = "https://roadtrippers.com/trips/" . $obj['trip']['id'];
    $results   = $obj['trip']['waypoints'];

 $number_test = 0;
    foreach ($results as $data) {
      //  $latitude   = $data['start_location'][1];
       // $longitude  = $data['start_location'][0];
        $name       = $data['name'];
$coor_list .= $data['start_location'][0].','.$data['start_location'][1].';';
$name_list .= $data['name'].';';
$number_test =++$number_test;
    }

 $coor_list = substr_replace($coor_list ,"",-1);
 $name_list = substr_replace($name_list ,"",-1);

 //var_dump($coor_list);
 //var_dump($number_test);



   $curl  = curl_init();
$headers   = array();
$headers[] = 'Accept: application/x-www-form-urlencoded';
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt_array($curl, array(
    CURLOPT_URL            => "https://api.mapbox.com/matching/v5/mapbox/driving/".$coor_list."?access_token=pk.eyJ1Ijoiam9ubXJpY2giLCJhIjoiY2s0YW1kcGVyMDNxODNsdTFvOTF0YXRyOSJ9.2RlJieQgzxsd8H-QfSlFoQ",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => "GET",
    CURLOPT_HTTPHEADER     => $headers,
));
$response2 = curl_exec($curl);
$err      = curl_error($curl);
curl_close($curl);
echo $response2;
}