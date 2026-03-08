<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, gender FROM users WHERE id='$user_id'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

$username = $data['username'];
$current_gender = $data['gender'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Developer Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>

*{
box-sizing:border-box;
}

body{
margin:0;
font-family:Segoe UI, sans-serif;
color:white;

background:url("images/background.jpeg") no-repeat center top;
background-size:cover;

min-height:100vh;
}



/* overlay */

.overlay{
background:rgba(0,0,0,0.65);
min-height:100vh;
}

/* NAVBAR */

/* .topbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 30px;
background:rgba(0,0,0,0.7);
flex-wrap:wrap;
} */


.topbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 30px;

background:linear-gradient(
to right,
rgba(0,0,0,0.85),
rgba(20,20,20,0.70),
rgba(0,0,0,0.85)
);

backdrop-filter:blur(6px);
flex-wrap:wrap;
}

.username{
font-size:22px;
font-weight:bold;
}

.logout{
background:#ff4d4d;
padding:8px 16px;
border-radius:6px;
text-decoration:none;
color:white;
}

/* MAIN CONTAINER */

.container{
max-width:900px;
margin:auto;
margin-top:70px;
background: rgba(30,30,30,0.82);
padding:40px;
border-radius:12px;
text-align:center;
}

.container h1{
font-size:32px;
margin-bottom:20px;
}

.container p{
color:#d1d5db;
line-height:1.6;
}

/* SOCIAL LINKS */

.social{
margin-top:25px;
display:flex;
justify-content:center;
flex-wrap:wrap;
gap:15px;
}

.social a{
padding:10px 20px;
background:#21262d;
border-radius:8px;
text-decoration:none;
color:white;
transition:0.3s;
}

.social a:hover{
background:#30363d;
}

.avatar{
width:43px;
height:43px;
border-radius:50%;
vertical-align:middle;
margin-right:8px;
}

/* RESPONSIVE */

@media (max-width:768px){

.container{
background: rgba(30,30,30,0.82);
padding:40px;
}

.topbar{
flex-direction:row;
gap:10px;
text-align:center;
}

.username{
font-size:20px;
}

.container{
margin:30px 20px;
padding:25px;
}

.container h1{
font-size:26px;
}

}

@media (max-width:480px){

.container{
background: rgba(30,30,30,0.82);
padding:40px;
}

.container h1{
font-size:22px;
}

.social{
flex-direction:column;
}

.social a{
width:100%;
text-align:center;
}

}


.settings-icon{
    font-size:24px;
    color:#b0b0b0;
    margin-right:12px;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    transition:0.3s;
    
}

.settings-icon:hover{
    color:#d0d0d0;  
    transform:rotate(25deg);
}

.topbar-right{
display:flex;
align-items:center;
gap:12px;
}


/* mobile responsive */
@media (max-width:480px){

.settings-icon{
    font-size:20px;
    margin-right:8px;
}

}




</style>
</head>

<body>

<div class="overlay">

<div class="topbar">

<div class="username">

<?php
if($current_gender == "male"){
echo '<img src="images/male.png" class="avatar">';
}else{
echo '<img src="images/female.png" class="avatar">';
}
?>

Welcome, <?php echo ucwords($username) ?> 👋

</div>


<div class="topbar-right">

<a href="account_settings.php" class="settings-icon">
<i class="fas fa-cog"></i>
</a>

<a class="logout" href="logout.php">Logout</a>

</div>

</div>

<div class="container">

<h1>I am Milan Jana 💻</h1>

<p style="text-align:left;">
 I am a Computer Application student with the skill of frontend development.
 I actively seek remote freelancing opportunities to apply my knowledge in real-world projects.
</p>

<p style="text-align:left;">
 My job is to build your website so that it is functional and user-friendly but at the same time attractive.
 Moreover, I add my personal touch to your product and make sure that it is eye-catching and easy to use. My aim is
 to bring across your message and identity in the most creative way.

</p>


<div class="social">

<a href="https://milan-jana-portfolio.vercel.app/" target="_blank">🌐 Portfolio</a>

<a href="https://linkedin.com/in/milanjana143" target="_blank">💼 LinkedIn</a>


</div>

</div>

</div>

</body>
</html>