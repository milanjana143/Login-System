<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT username FROM users WHERE id='$user_id'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

$username = $data['username'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
</head>

<body>

<h1>Welcome to the Dashboard!</h1>

<h2>Hello, <?php echo $username; ?> 👋</h2>

<p><a href="logout.php">Logout</a></p>

</body>
</html>