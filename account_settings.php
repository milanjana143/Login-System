<?php
session_start();
include 'conn.php';

$user_id = $_SESSION['user_id'];

/* UPDATE PROFILE */
if(isset($_POST['update_profile'])){

$new_username = mysqli_real_escape_string($conn, $_POST['username']);
$new_gender = mysqli_real_escape_string($conn, $_POST['gender']);

$update_sql = "UPDATE users 
SET username='$new_username', gender='$new_gender' 
WHERE id='$user_id'";

mysqli_query($conn, $update_sql);

/* prevent form resubmission */
header("Location: account_settings.php");
exit();

}

/* FETCH USER DATA */

$sql = "SELECT username, gender FROM users WHERE id='$user_id'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

$current_username = $data['username'];
$current_gender = $data['gender'];

?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Account Settings</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>

:root{
--primary:#4facfe;
--secondary:#00f2fe;
--card-bg:#1e1e1e;
--input-bg:#2d2d2d;
--text:#ffffff;
--text-muted:#a0a0a0;
}

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Poppins',sans-serif;

background:
linear-gradient(rgba(0,0,0,0.65),rgba(0,0,0,0.65)),
url("images/bg.jpeg");

background-size:cover;
background-position:center;

height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.settings-container{
width:100%;
max-width:420px;
padding:40px;
border-radius:16px;
background:rgba(30,30,30,0.75);
box-shadow:0 10px 30px rgba(0,0,0,0.6);
}

.header{
text-align:center;
margin-bottom:30px;
}

.header h2{
color:var(--text);
}

.header p{
color:var(--text-muted);
font-size:15px;
}

.input-group{
position:relative;
margin-bottom:20px;
}

.input-group input,
.input-group select{
width:100%;
padding:14px 14px 14px 45px;
border:none;
border-radius:8px;
background:var(--input-bg);
color:var(--text);
font-size:14px;
appearance:none;
-webkit-appearance:none;
-moz-appearance:none;
}

.input-group select{
background-image:url("data:image/svg+xml;utf8,<svg fill='white' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M5 7l5 5 5-5z'/></svg>");
background-repeat:no-repeat;
background-position:right 18px center;
background-size:14px;
}


.input-group input:focus,
.input-group select:focus{
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

button{
width:100%;
padding:14px;
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

.divider{
margin:30px 0;
height:1px;
background:#444;
}

.password-box{
text-align:center;
}

.password-box a{
display:block;
padding:14px;
border-radius:8px;
background:#2d2d2d;
color:white;
text-decoration:none;
margin-top:10px;
}

.password-box a:hover{
background:#3a3a3a;
}




/* Mobile Responsive */
@media (max-width: 480px){

    body{
        padding:15px;
    }

    .settings-container{
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

<div class="settings-container">

<div class="header">
<h2>Account Settings</h2>
<p>Update your account information</p>
</div>

<form method="post">

<!-- USERNAME -->

<div class="input-group">
<input type="text" name="username" value="<?php echo $current_username; ?>">
<i class="fas fa-user"></i>
</div>

<!-- GENDER -->

<div class="input-group">
<select name="gender">
<option value="male" <?php if($current_gender=='male') echo "selected"; ?>>Male</option>
<option value="female" <?php if($current_gender=='female') echo "selected"; ?>>Female</option>
</select>
<i class="fas fa-venus-mars"></i>
</div>

<button type="submit" name="update_profile">Save Changes</button>

</form>

<div class="divider"></div>

<div class="password-box">

<p style="color:#a0a0a0;">Want to change your password?</p>

<a href="forgot_password.php">
<i class="fas fa-key"></i> &nbsp;Change Password
</a>

</div>

</div>

</body>
</html>