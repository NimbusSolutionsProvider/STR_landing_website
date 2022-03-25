<?php

//opne server error
ini_set('display_errors', 1);
error_reporting(1);

//select time zone
date_default_timezone_set('Asia/Kolkata');

//for the database
$servername = "sts-landing-page.cyruinkuaezb.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "Regel!123";
$dbname = "STRental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 
// Check connection
if($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

?>
