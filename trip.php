<?php



$tripId = $_POST["tripId"];
//$tripId = 26811305;


$curl  = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL            => "https://maps.roadtrippers.com/api/v2/trips/" . $tripId,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => "GET",
    CURLOPT_HTTPHEADER     => array('Access-Control-Allow-Origin: *'),
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

    $trip_path = "https://maps.roadtrippers.com/trips/" . $obj['trip']['id'];
    $results   = $obj['trip']['waypoints'];
echo $response;

}
