<?php
// 1 Create and obtain variables
// Securing variables and gathered data
// request info that had been posted or gotten (htmlentities makes it more secure)
$username = htmlentities($_REQUEST["username"]);
//$password = htmlentities($_REQUEST["password"]);

// Making sure variables are filled in
if(empty($username)){
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
$found = $access->getUser($username);

 if ($found['username'] == $username)
 {
   // Set username session variable
   session_start();
   $_SESSION['username'] = $_POST['username'];
   // 4 Close connection
   $access->dissconnect();
   // Jump to secured page
   header('Location: home.php');
 }
else {
  // Jump to login page
  header('Location:index.php');
}

 ?>
