<?php
session_start();
include 'conn.php';

if(!isset($_SESSION['reset_email'])){
header("Location: forgot_password.php");
exit();
}

$email = $_SESSION['reset_email'];

if(isset($_POST['verify_otp'])){

$user_otp = $_POST['otp'];

$sql = "SELECT * FROM users WHERE email='$email' AND otp='$user_otp'";
$query = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($query);

if($data){

$otp_expiry = strtotime($data['otp_expiry']);

if($otp_expiry >= time()){

header("Location: reset_password.php");
exit();

}else{

echo "<script>alert('OTP expired');</script>";

}

}else{

echo "<script>alert('Invalid OTP');</script>";

}

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Verify Reset OTP</title>

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
.otp-container{
    width:100%;
    max-width:400px;
    padding:40px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(0,0,0,0.6);
    text-align:center;
    animation:fadeIn .7s ease;
    background: rgba(30,30,30,0.75);
}

/* Header */
.header h2{
    color:var(--text);
    margin-bottom:10px;
}

.header p{
    color:var(--text-muted);
    font-size:14px;
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
    font-weight:600;
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

    .otp-container{
        padding:25px;
        border-radius:12px;
    }

    .header h2{
        font-size:20px;
    }

}

</style>
</head>

<body>

<div class="otp-container">

<div class="header">
<h2>Password Reset Verification</h2>
<p>
Enter the 6-digit OTP sent to your email<br>
<b><?php echo $email; ?></b>
</p>
</div>

<form method="post">

<div class="input-group">
<input type="number" name="otp" placeholder="Enter OTP Code" required>
<i class="fas fa-key"></i>
</div>

<button type="submit" name="verify_otp">Verify OTP</button>

</form>

</div>

</body>
</html>