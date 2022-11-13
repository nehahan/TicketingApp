<!--I have added some changes in the comment on this branch iss110Jan-->

<?php include('connect/functions.php') ?>
<?php
   session_start();
   
   if(session_destroy()) {
      header("Location: login.php");
   }
?>
<!--
<!DOCTYPE html>
<html>
<head>
	<title>Bio storingen en registraties</title>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body id ="logout-page">
	<div class = "container">
		<div class="header">
			<h2>Bio Storingen en Registraties</h2>
			<br>
			<h2>Logout</h2>
			
		</div>-->
		
			<!-- logged in user information --> 
<!--		<div class="logout">
			<h3>You were inactive - </h5>	
			
			<br>
			<h3>You must log out first and log in again.</h5>
			<br>
			
			<a href="index.php?logout='1'" id ="logout-btn">Logout</a>
			<br>
		</div>
	</div>
</body>
</html> -->