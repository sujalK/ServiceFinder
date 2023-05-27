<?php 
include "../helpers/initialize.php";

if (isset($_GET)) {
    // get the data from the URL
    $service_id = $connection->escape_string(htmlspecialchars(trim($_GET['service_id'])));
    $latitude   = $connection->escape_string(htmlspecialchars(trim($_GET['lat'])));
    $longitude  = $connection->escape_string(htmlspecialchars(trim($_GET['lng'])));

    // update the latitude and the longitude
    $sql = "UPDATE services SET lat = '{$latitude}', lng='{$longitude}' WHERE id=". $service_id;

    if ($connection->query($sql)) {
        echo json_encode(['success' => true]);
    }
}