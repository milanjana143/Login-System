<?php
$host = "localhost";
$user = "root";
$pass = "";   // keep empty
$db   = "otp_verify";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>