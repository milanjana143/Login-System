Google -> Manage google account (Select that gmail account, by which you want to sent OTP) -> Search for app password -> Enter a app name (project name, like- Demo Project) -> Create -> Copy the app password (Keep it in private) -> Done

Replace these details in forgot_password.php & registration.php
$mail->Username = ' ';   // Your OTP sender email id
$mail->Password = ' ';   // App password