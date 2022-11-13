<!-- File name - index_1.php
This is the landing page after one logs in.
preceeding pages- Login Page (login.php) and Register Page (register.php)
In the header the are proceeding links Logout and Nav tabs
check header file - header.php

In the content-
Storingen and Reparaties(INCLUDED file -- registraties\storing\lijst_reg_norm.php),
Refer to included file-
Sto & Repa > Nieuw reg(),
Sto & Repa > Nr.data.  
Sto & Repa > sort by links-nr,datum,gebouw,medewerker, prioritiet

Alarmmelding(INCLUDED file -- registraties\alarm\lijst_alarm_norm.php),

In the footer-
footer file included - footer.php
Footer link to local database - phpAdmin - 
$database_connect_storing = "registraties";
$connect_storing = mysqli_connect('localhost', 'root', 'Sb1234#', 'registraties');
-->
<?php
//include this file to access isLogggedIn function
include('connect/functions.php'); 
//This checks whether the user/admin has logged in or not and likewise directs to the main login page.
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Bio storingen en registraties</title>
<!-- files INCLUDED to use bootstrap -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="refresh" content="28800;url=logout.php" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
<link href="style.css" rel="stylesheet" type="text/css">

<script>
//enable the input elements inside div-admin-control when submitting the from		
function enableDisable(){
	$(".admin-control *").removeAttr('disabled');
};
</script>
</head>

<body>
	<div class="container mt-3 main-body">
		<!-- Header  -->
			<!--Title and Logout(index.html,logout.php),
				Nav tabs-
				Storingen and Reparaties(INCLUDED file -- registraties\storing\lijst_reg_norm.php),

				Refer to included file-
				Sto & Repa > Nieuw reg(),
				Sto & Repa > Nr.data.  
				Sto & Repa > sort by links-nr,datum,gebouw,medewerker, prioritiet -->
		<div class= "row jumbotron bio_sto">
			
				<div class="profile_info col-md-4" >
					<img src="images/user_profile.png">
					<p>
					<?php  if (isset($_SESSION['user'])) : ?>
					<a href="index_1.php?td_new=<?php echo $_SESSION['user']['name']; ?>" >
					<strong><?php echo $_SESSION['user']['name']; ?> </strong> </a>
					<small><i>(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
					</small></p>
					<p><a href="index.php?logout='1'">Logout</a></p>
					<?php endif ?>
				</div>
				<div class = "col-md-4">
					<h2 id ="main-heading">Stichting Bio</h2>
				</div>
				<div class = "col-md-4">
		<!--			<div>
				<?php  
						if($_SESSION['user']['user_type'] == "admin")	:?>
								<a class ="btn" style="padding-top: 5px;"href="index.php?li=new-medewerker" class="openPopup">New Medewerker</a>
				<?php endif ?>
			</div>
			-->		
				</div>
		
				<div class="row nav nav-tabs nav-justified">
						<a id ="refresh_storingen" class="nav-link" href="index_1.php?page=storing&&allereg=nietalles" >Storingen en reparaties</a>
						<a id ="refresh_alarmmeldingen" onclick = "disableButtons()" class="nav-link" href="index_1.php?page=alarm">Alarmmeldingen</a>
						<a id ="refresh_indcidents" onclick = "disableButtons()" class="nav-link" href="index_1.php?page=incidents">Calamiteiten</a>
						<!--<a class="nav-link disabled"  href="index_1.php?page=melding">Meldingen ongevallen</a>
						<a class="nav-link disabled"  href="index_1.php?page=camera">Camerabeelden</a>-->
				</div>
		</div>

		
		<!-- open the links according to the nav tabs selected -->
			<?php
						if(isset($_GET['page'])){
			//Get the page parameter from the url
				switch($_GET['page']){
					case 'storing' : $page = 'registraties\storing\lijst_reg_norm.php'; 
										break;
					case 'alarm' : $page = 'registraties\alarm\lijst_alarm_norm.php'; 
										break;
					case 'melding' : $page = 'melding'; 
										break;
					case 'camera' : $page = 'camera'; 
										break;
					case 'storing_alles' : $page = 'registraties\storing\lijst_reg_norm_alles.php';
										break;
					case 'beheer' : $page = 'registraties\beheer\beheer.php';
										break;
					case 'beheer_bedrijven' : $page = 'registraties\beheer\beheer_bedrijven.php';
										break;							
					case 'beheer_medewerkers' : $page = 'registraties\beheer\beheer_medewerkers.php';
										break;
					case 'incidents' : $page = 'registraties\incidents\lijst_incidents_norm.php';
										break;
				}
			}else{
				$page = 'registraties/storing/lijst_reg_norm.php';
			}
			include($page); 
			?>
	
		<!--  Footer proceeding links- beheer dBase (registraties\beheer\beheer.php)-->
		
		<div class="row footer">
			<!--link - registraties\storing\lijst_all.php -->
			<p class="col-md-12" style="align:center"><a href="index_1.php?page=storing_alles&&allereg=alles"><strong><font size="+2">Laat 
			  ALLE Registraties zien, ook de Afgehandelde</font></strong></a><br />
			  <!--registraties\beheer\beheer.php-->
			<a class="col-md-12" href="index_1.php?page=beheer">Beheer dBase</a></p>  
		</div>
	</div>
	
<script>
function disableButtons(){
	document.getElementById('jobsNotAssigned').style.display = "none";
	document.getElementById('finishedJobs').style.display = "none";
};
</script>
</body>
</html>

