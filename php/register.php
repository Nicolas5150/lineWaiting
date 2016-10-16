<?php
// 1 Create and obtain variables
// Securing variables and gathered data
// request info that had been posted or gotten (htmlentities makes it more secure)
$username = htmlentities($_REQUEST["username"]);
$password = htmlentities($_REQUEST["password"]);
$email = htmlentities($_REQUEST["email"]);
$fullName = htmlentities($_REQUEST["fullName"]);

// Making sure variables are filled in
if(empty($username) || empty($password) || empty($email) || empty($fullName)){
    $returnArray["status"] = "400";
    $returnArray["message"] = "all data must be included";
    echo json_encode($returnArray);
    return;
}

// Secure password using sha1 encryption function
$salt = openssl_random_pseudo_bytes(20);
$securedPassword = sha1($password . $salt);

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

// 3 Insert user info into database
$result = $access->registerUser($username, $securedPassword, $salt, $email, $fullName);

if($result)
{
    // Get user from access.php function
    $user = $access->getUser($username);

    // Put into returnArray the data from the MYSQL database
    $returnArray["status"] = "200";
    $returnArray["message"] = "Successfully Registered";
    $returnArray["id"] = $user["id"];
    $returnArray["username"] =$user["username"];
    $returnArray["email"] = $user["email"];
    $returnArray["fullName"] = $user["fullName"];
    $returnArray["ava"] = $user["ava"];

    // Start a new session bassed off the users new account
    session_start();
    $_SESSION['userDetails'] = array();
    $_SESSION['userDetails'][] = $user["username"];
    $_SESSION['userDetails'][] = $user["email"];
    $_SESSION['userDetails'][] = $user["fullName"];

    /* Testing Purpose
    foreach($_SESSION['userDetails'] as $item)
    {
      echo $item;
    }
    */
}

else{
    $returnArray["status"] = "400";
    $returnArray["message"] = "Data not passing register user function";
}

// 4 Close connection
$access->dissconnect();

// TURN BACK ON FOR IOS LATER
// 5 Json data
// echo json_encode($returnArray);

header("Location: home.php");
return;
?>
