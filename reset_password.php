<?php
session_start();
include 'conn.php';

if(!isset($_SESSION['reset_email'])){
header("Location: forgot_password.php");
exit();
}

$email = $_SESSION['reset_email'];

if(isset($_POST['reset_password'])){

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($conn,"UPDATE users SET password='$password', otp=NULL, otp_expiry=NULL WHERE email='$email'");

unset($_SESSION['reset_email']);

echo "<script>alert('Password changed successfully'); window.location='index.php';</script>";

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Reset Password</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- Font Awesome -->
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

/* Background */
body{
    font-family:'Poppins',sans-serif;

    background:
    linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
    url("images/background.jpeg");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Card */
.reset-container{
    width:100%;
    max-width:400px;
    padding:40px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.6);
    text-align:center;
    animation:fadeIn .7s ease;
    background:rgba(30,30,30,0.75);
}

/* Header */
.header h2{
    color:var(--text);
    margin-bottom:10px;
}

.header p{
    color:var(--text-muted);
    font-size:15px;
    margin-bottom:30px;
}

/* Input */
.input-group{
    position:relative;
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
    margin-top:25px;
    border:none;
    border-radius:8px;
    font-weight:650;
    font-size:19px;
    background:linear-gradient(to right,var(--primary),var(--secondary));
    cursor:pointer;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 15px rgba(79,172,254,.4);
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

    .reset-container{
        padding:25px;
        border-radius:12px;
    }

    .header h2{
        font-size:20px;
    }

     button{
        padding:12px;
        font-size:18px;
    }
}

</style>
</head>

<body>

<div class="reset-container">

<div class="header">
<h2>Reset Password</h2>
<p>Enter your new password below</p>
</div>

<form method="post">

<div class="input-group">
<input type="password" name="password" placeholder="Enter New Password" required>
<i class="fas fa-lock"></i>
</div>

<button type="submit" name="reset_password">Change Password</button>

</form>

</div>

</body>
</html>