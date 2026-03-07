<?php
session_start();
include 'conn.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $otp = rand(100000,999999);
    $otp_expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

    $sql = "INSERT INTO users (username,email,password,otp,otp_expiry,is_verified)
            VALUES ('$username','$email','$hashedPassword','$otp','$otp_expiry',0)";

    $query = mysqli_query($conn,$sql);

    if($query){

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'milan.appservice@gmail.com';
            $mail->Password = 'zvpcrrgpaiapxeno';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('YOUR_GMAIL@gmail.com','OTP Login System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Email Verification OTP";
            $mail->Body = "Your OTP is: <b>$otp</b>. It will expire in 5 minutes.";

            $mail->send();

            $_SESSION['temp_user'] = $email;

            header("Location: otp_verification.php");
            exit();

        }catch(Exception $e){
            echo "Mail could not be sent.";
        }

    }else{
        echo "<script>alert('Registration Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        #container{
            border: 1px solid black;
            width: 450px;
            padding: 20px;
            margin-left: 400px;
            margin-top: 50px;
        }
        form{
            margin-left: 50px;
        }
        input[type=text],input[type=password]{
            width: 300px;
            height: 20px;
            padding: 10px;
        }
        label{
            font-size: 20px;
            font-weight: bold;
        }
        a{
            text-decoration: none;
            font-weight: bold;
            font-size: 21px;
            color: blue;
        }
        a:hover{
            cursor: pointer;
            color: purple;
        }
        input[type=submit]{
            width: 70px;
            background-color: blue;
            border: 1px solid blue;
            color: white;
            font-weight: bold;
            padding: 7px;
            margin-left: 130px;
        }
        input[type=submit]:hover{
            background-color: purple;
            cursor: pointer;
            border: 1px solid purple;
        }
    </style>
</head>
<body>
    <div id="container">
        <form method="post" action="registration.php">
            <label for="username">Username:</label><br>
            <input type="text" name="username" placeholder="Enter Username" required><br><br>

            <label for="email">Email:</label><br>
            <input type="text" name="email" placeholder="Enter Your Email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" name="password" placeholder="Enter Password" required><br><br>
            <input type="submit" name="register" value="Register"><br><br>
            <label>Already have an account? </label><a href="index.php">Login</a>
        </form>
    </div>

</body>
</html>