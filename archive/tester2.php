<?php

use phpGPX\Models\GpxFile;
use phpGPX\Models\Link;
use phpGPX\Models\Metadata;
use phpGPX\Models\Point;
use phpGPX\Models\Segment;
use phpGPX\Models\Track;

require_once 'vendor/autoload.php';

$tripId = $_POST["tripId"];
$tripId = 26811305;

$final = [];
$curl  = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL            => "https://maps.roadtrippers.com/api/v2/trips/" . $tripId,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => "GET",
    CURLOPT_HTTPHEADER     => array(),
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

    $link                            = new Link();
    $link->href                      = $trip_path;
    $link->text                      = $trip_name;
    $gpx_file                        = new GpxFile();
    $gpx_file->metadata              = new Metadata();
    $gpx_file->metadata->time        = new \DateTime();
    $gpx_file->metadata->description = $trip_description;
    $gpx_file->metadata->links[]     = $link;
    $track                           = new Track();
    $track->name                     = sprintf($trip_name);
    $track->type                     = 'DRIVE';
    $track->source                   = sprintf("Roadtrippers");
    $segment                         = new Segment();
//segments
    foreach ($results as $data) {
        $point             = new Point(Point::TRACKPOINT);
        $point->latitude   = $data['start_location'][1];
        $point->longitude  = $data['start_location'][0];
        $point->name       = $data['name'];
        $segment->points[] = $point;
    }
    //waypoints
    $wp = [];
    $increment = 0;
    $x = 'A';
    foreach ($results as $data) {
        $point            = new Point(Point::WAYPOINT);
        $point->latitude  = $data['start_location'][1];
        $point->longitude = $data['start_location'][0];
        $point->name      = 'WP-'.$x.'-'.$data['name'];
       $point-> time =  new DateTime('+ '.$increment.' MINUTE');
        $wp[]             = $point;
        $increment++;
        $x++;
    }
    //add waypoints to gpx
    $gpx_file->waypoints = $wp;
    //add segments to track
    $track->segments[] = $segment;
    $track->recalculateStats();
    //add track to gpx
    $gpx_file->tracks[] = $track;
    $gpx_file->save($trip_name . '.gpx', \phpGPX\phpGPX::XML_FORMAT);
    //$gpx_file->save($trip_name . '.json', \phpGPX\phpGPX::JSON_FORMAT);
    header("Content-Type: application/gpx+xml");
    header("Content-Disposition: attachment; filename=" . $trip_name . ".gpx");
    echo $gpx_file->toXML()->saveXML();
    exit();
}
