<?php
$lat = htmlentities($_REQUEST["lat"]);

// Making sure variables are filled in
if(empty($lat)){
    $returnArray["status"] = "400";
    $returnArray["message"] = "all data must be included";
    echo json_encode($returnArray);
    return;
}

// 2 Build Connection
// Build connection in secure way
$file = parse_ini_file("waiting.ini");

// Store vars from file
$host = trim($file["dbHost"]);
$user = trim($file["dbUser"]);
$pass = trim($file["dbPass"]);
$name = trim($file["dbName"]);

require("Secure/access.php");
$access = new access($host, $user, $pass, $name);
$access->connect();

// 3 verify username in the database
// Retrieve username and password from database according to user's input
//$user = ($_SESSION['userDetails']['username']);
//$_SESSION['userDetails'][] = $lat;
$access->addLocation($lat);
?>
