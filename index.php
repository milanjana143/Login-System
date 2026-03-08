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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Secure Access</title>

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

/* Body Background Image */
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

/* Login Card */
.login-container{
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
    font-size:15px;
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

/* Forgot password */
.actions{
    text-align:right;
    margin-bottom:25px;
}

.actions a{
    font-size:14px;
    text-decoration:none;
    color:var(--text-muted);
}

.actions a:hover{
    color:var(--primary);
}

/* Button */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    font-size: 19px;
    font-weight:650;
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

/* Mobile Responsive */
@media (max-width: 480px){

    body{
        padding:15px;
    }

    .login-container{
        width:100%;
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

    button{
        padding:12px;
        font-size:18px;
    }

}

</style>
</head>

<body>

<div class="login-container">

    <div class="header">
        <h2>Welcome Back</h2>
        <p>Please enter your details to sign in</p>
    </div>

    <form method="post">

        <div class="input-group">
            <input type="email" name="email" placeholder="Email Address" required>
            <i class="fas fa-envelope"></i>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fas fa-lock"></i>
        </div>

        <div class="actions">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>

        <button type="submit" name="login">Log In</button>

        <div class="footer">
            Don't have an account?
            <a href="registration.php">Sign Up</a>
        </div>

    </form>

</div>

</body>
</html>