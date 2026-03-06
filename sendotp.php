<?php
session_start();

$username=$_POST['username'];
$password=$_POST['password'];
$phone=$_POST['phone'];

$otp=rand(100000,999999);

$_SESSION['otp']=$otp;
$_SESSION['username']=$username;
$_SESSION['password']=$password;
$_SESSION['phone']=$phone;

echo "Your OTP is: ".$otp;   // demo only

?>

<form action="verifyotp.php" method="post">

Enter OTP:<br>
<input type="text" name="otp"><br><br>

<input type="submit" value="Verify">

</form>