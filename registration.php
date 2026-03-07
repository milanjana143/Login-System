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

    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn,$check);

    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('Email already registered. Please login.'); window.location='index.php';</script>";
        exit();
    }

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
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register | Create Account</title>

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
.register-container{
    width:100%;
    max-width:400px;
    padding:40px;
    background:var(--card-bg);
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

/* Input Fields */
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

    .register-container{
        padding:25px;
        border-radius:12px;
        background: rgba(30,30,30,0.75);
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

}

</style>
</head>

<body>

<div class="register-container">

    <div class="header">
        <h2>Create Account</h2>
        <p>Register to access the system</p>
    </div>

    <form method="post">

        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
            <i class="fas fa-user"></i>
        </div>

        <div class="input-group">
            <input type="email" name="email" placeholder="Email Address" required>
            <i class="fas fa-envelope"></i>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fas fa-lock"></i>
        </div>

        <button type="submit" name="register">Register</button>

        <div class="footer">
            Already have an account?
            <a href="index.php">Log In</a>
        </div>

    </form>

</div>

</body>
</html>