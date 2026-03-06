<?php

include("db.php");

$username=$_POST['username'];
$password=$_POST['password'];

$query="SELECT * FROM users 
WHERE username='$username' 
AND password='$password'
AND verified=1";

$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0)
{
echo "Login Successful";
}
else
{
echo "Invalid username or password";
}

?>