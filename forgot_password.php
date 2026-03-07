<?php
session_start();
include 'conn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if(isset($_POST['send_otp'])){

$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email='$email'";
$query = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($query);

if($data){

$otp = rand(100000,999999);
$otp_expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

mysqli_query($conn,"UPDATE users SET otp='$otp', otp_expiry='$otp_expiry' WHERE email='$email'");

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'milan.appservice@gmail.com';
$mail->Password = 'zvpcrrgpaiapxeno';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('milan.appservice@gmail.com','Password Reset');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = "Password Reset OTP";
$mail->Body = "Your OTP for password reset is: <b>$otp</b>";

$mail->send();

$_SESSION['reset_email']=$email;

header("Location: verify_reset_otp.php");
exit();

}else{

echo "<script>alert('Email not registered');</script>";

}

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password | Secure Access</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>

/* Root Variables */
:root{
    --primary:#4facfe;
    --secondary:#00f2fe;
    --card-bg:#1e1e1e;
    --input-bg:#2d2d2d;
    --text:#ffffff;
    --text-muted:#a0a0a0;
}

/* Reset */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* Body Background */
body{
    font-family:'Poppins',sans-serif;

    background:
    linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
    url("images/bg.jpeg");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Card */
.login-container{
    width:100%;
    max-width:400px;
    padding:40px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.6);
    animation:fadeIn .7s ease;
    background: rgba(30,30,30,0.75);
}

/* Header */
.header{
    text-align:center;
    margin-bottom:35px;
}

.header h2{
    color:var(--text);
    margin-bottom:6px;
}

.header p{
    color:var(--text-muted);
    font-size:14px;
}

/* Inputs */
.input-group{
    position:relative;
    margin-bottom:20px;
}

.input-group input{
    width:100%;
    padding:14px 14px 14px 45px;
    border:none;
    border-radius:8px;
    background:var(--input-bg);
    color:var(--text);
    font-size:14px;
}

.input-group input:focus{
    outline:none;
    border:1px solid var(--primary);
}

.input-group i{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:var(--text-muted);
}

/* Button */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    font-weight:600;
    background:linear-gradient(to right,var(--primary),var(--secondary));
    cursor:pointer;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(79,172,254,.4);
}

/* Footer */
.footer{
    text-align:center;
    margin-top:25px;
    color:var(--text-muted);
}

.footer a{
    color:var(--primary);
    text-decoration:none;
    font-weight:600;
}

.footer a:hover{
    text-decoration:underline;
}

/* Animation */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* Mobile */
@media (max-width:480px){

    body{
        padding:15px;
    }

    .login-container{
        padding:25px;
        border-radius:12px;
    }

    .header h2{
        font-size:20px;
    }

    .header p{
        font-size:13px;
    }

    .input-group input{
        padding:12px 12px 12px 40px;
        font-size:13px;
    }

    button{
        padding:12px;
        font-size:14px;
    }

}

</style>
</head>

<body>

<div class="login-container">

<div class="header">
<h2>Forgot Password</h2>
<p>Enter your email to receive a password reset OTP</p>
</div>

<form method="post">

<div class="input-group">
<input type="email" name="email" placeholder="Email Address" required>
<i class="fas fa-envelope"></i>
</div>

<button type="submit" name="send_otp">Send OTP</button>

<div class="footer">
Remember your password?
<a href="index.php">Login</a>
</div>

</form>

</div>

</body>
</html>