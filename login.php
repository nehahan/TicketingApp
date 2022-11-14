<!-- File name - login.php
This file is the starting and ending page of this process. This should be displayed at the beginning before logging in and after log out.
Preceeding pages -
index.php ( This is a prompt page that asks the user to log out first if already logged in (mostly in the cases where user closes the ware without logging out and another user tries to open the pages.)
index_1.php (logout link opens this page)
admin\create_user.php (this page will be accessible only to the admin.)

Proceeding pages -
index_1.php ( This is the main landing page)
register.php (Sign up page)
-->


<?php include('connect/functions.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>Ticketing App</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id = "login-page">
	<div class = "container ">
		<div class="header">
		<h1>Ticketing App</h1>
		<br>
			<h2>Login</h2>
		</div>
		<div>
		<form id ="login" method="post" action="login.php">

			<?php echo display_error(); ?>

			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username"  placeholder="username" autofocus>
				
				<label>Password</label>
				<input type="password"  placeholder="password" name="password">
				
				<button type="submit" class="btn" name="login_btn">Login</button>
				
			</div>
			
			<p id="login-footer">
				
			</p>
		</form>
		</div>
	</div>
</body>
</html>