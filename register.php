<!--File name - register.php
This file registers a new user as a "user" by default.
Preceeding pages-
login.php (login page)

proceeding pages-
index_1.php
-->


<?php include("connect/functions.php") ?>

<!DOCTYPE html>

<html>
<head>
	<title>Registration system PHP and MySQL</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
<div class="header">
	<h2>Bio Storingen en Registraties</h2>
	<br>
	<h2>Register</h2>
</div>
<form method="post" action="register.php">
	
	<?php echo display_error(); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username;?>" placeholder="username" autofocus>
	</div>
	<div class="input-group">
		<label>Full Name</label>
		<input type="text" name="name" value="<?php echo $name;?>" placeholder="First-name Last-name">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" placeholder="example@domain.com"  value="<?php echo $email;?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn">Register</button>
	</div>
	<p>
		Already a member? <a href="login.php">Sign in</a>
	</p>
</form>
</body>
</html>