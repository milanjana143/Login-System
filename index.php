<!DOCTYPE html>
<html>
<head>
<title>Login / Signup</title>
</head>

<body>

<h2>Login</h2>

<form action="login.php" method="post">

Username:<br>
<input type="text" name="username"><br>

Password:<br>
<input type="password" name="password"><br><br>

<input type="submit" value="Login">

</form>

<hr>

<h2>Signup</h2>

<form action="sendotp.php" method="post">

Username:<br>
<input type="text" name="username"><br>

Password:<br>
<input type="password" name="password"><br>

Phone Number:<br>
<input type="text" name="phone"><br><br>

<input type="submit" value="Signup">

</form>

</body>
</html>