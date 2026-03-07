<?php
session_start();
include 'conn.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $query = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($query);

    if($data){

        if($data['is_verified'] == 0){

            echo "<script>alert('Please verify your email first.');</script>";

        }
        else{

            if(password_verify($password,$data['password'])){

                $_SESSION['user_id'] = $data['id'];

                header("Location: dashboard.php");
                exit();

            }else{

                echo "<script>alert('Invalid Password');</script>";

            }

        }

    }else{

        echo "<script>alert('Email not registered');</script>";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<style>
#container{
    margin-left:400px;
    border:1px solid black;
    width:440px;
    padding:20px;
    margin-top:40px;
}

input[type=text],input[type=password]{
    width:300px;
    height:20px;
    padding:10px;
}

label{
    font-size:20px;
    font-weight:bold;
}

form{
    margin-left:50px;
}

a{
    text-decoration:none;
    font-weight:bold;
    font-size:21px;
    color:blue;
}

a:hover{
    cursor:pointer;
    color:purple;
}

input[type=submit]{
    width:70px;
    background-color:blue;
    border:1px solid blue;
    color:white;
    font-weight:bold;
    padding:7px;
    margin-left:130px;
}

input[type=submit]:hover{
    background-color:purple;
    cursor:pointer;
    border:1px solid purple;
}
</style>

</head>

<body>

<div id="container">

<form method="post">

<label>Email</label><br>
<input type="email" name="email" placeholder="Enter Your Email" required>
<br><br>

<label>Password</label><br>
<input type="password" name="password" placeholder="Enter Your Password" required>
<br><br>

<input type="submit" name="login" value="Login">

<br><br>

<label>Don't have an account? </label>
<a href="registration.php">Sign Up</a>

</form>

</div>

</body>
</html>