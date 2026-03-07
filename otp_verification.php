<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['temp_user'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['temp_user'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_otp = $_POST['otp'];

    $sql = "SELECT * FROM users WHERE email='$email' AND otp='$user_otp'";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($query);

    if ($data) {

        $otp_expiry = strtotime($data['otp_expiry']);

        if ($otp_expiry >= time()) {

            $update = "UPDATE users 
                       SET is_verified = 1, otp = NULL, otp_expiry = NULL 
                       WHERE email = '$email'";

            mysqli_query($conn, $update);

            unset($_SESSION['temp_user']);

            echo "<script>
                    alert('Email verified successfully. Please login.');
                    window.location='index.php';
                  </script>";

        } else {

            echo "<script>
                    alert('OTP has expired. Please register again.');
                    window.location='registration.php';
                  </script>";

        }

    } else {

        echo "<script>alert('Invalid OTP. Please try again.');</script>";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OTP Verification</title>

<style>
#container{
    border:1px solid black;
    width:400px;
    margin-left:400px;
    margin-top:50px;
    height:330px;
}

form{
    margin-left:50px;
}

p{
    margin-left:50px;
}

h1{
    margin-left:50px;
}

input[type=number]{
    width:290px;
    padding:10px;
    margin-top:10px;
}

button{
    background-color:orange;
    border:1px solid orange;
    width:120px;
    padding:9px;
    margin-left:90px;
}

button:hover{
    cursor:pointer;
    opacity:.9;
}
</style>

</head>

<body>

<div id="container">

<h1>Email Verification</h1>

<p>
Enter the 6 digit OTP sent to your email:<br>
<b><?php echo $email; ?></b>
</p>

<form method="post">

<label style="font-weight:bold;font-size:18px;">Enter OTP Code:</label><br>

<input type="number" name="otp" placeholder="Six-Digit OTP" required>

<br><br>

<button type="submit">Verify OTP</button>

</form>

</div>

</body>
</html>