<?php
$json = file_get_contents("trip.json");
$obj = json_decode($json);
print_r($obj);