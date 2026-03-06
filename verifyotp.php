<?php

session_start();
include("db.php");

$userotp=$_POST['otp'];

if($userotp==$_SESSION['otp'])
{

$username=$_SESSION['username'];
$password=$_SESSION['password'];
$phone=$_SESSION['phone'];

$query="INSERT INTO users(username,password,phone,verified)
VALUES('$username','$password','$phone',1)";

mysqli_query($conn,$query);

echo "Signup Successful";

}

else
{
echo "Invalid OTP";
}

?>