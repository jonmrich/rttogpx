<?php
$tripId = $_POST["tripId"];
$tripId = 26811305;

$final = [];
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://maps.roadtrippers.com/api/v2/trips/".$tripId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  echo "cURL Error #:" . $err;
} else {
$obj  = json_decode($response, true);
$name = $obj['trip']['name'];
$path = "https://maps.roadtrippers.com/trips/" . $obj['trip']['id'];
$results = $obj['trip']['waypoints'];

echo json_encode($results);
}
