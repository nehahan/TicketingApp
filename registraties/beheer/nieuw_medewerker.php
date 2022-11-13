<?php
include('../../connect/functions.php'); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	global $connect_storing;
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connect_storing, $theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_medewerker = "-1";
if (isset($_GET['medew_ID'])) {
  $colname_medewerker = $_GET['medew_ID'];
}
mysqli_select_db($connect_storing, $database_connect_storing);
$query_medewerker = sprintf("SELECT * FROM reg_medew WHERE id = %s", GetSQLValueString($colname_medewerker, "int"));
$medewerker = mysqli_query($connect_storing,$query_medewerker) or die(mysqli_error($connect_storing));
$row_medewerker = mysqli_fetch_assoc($medewerker);
$totalRows_medewerker = mysqli_num_rows($medewerker);
?>
<!DOCTYPE html>
<html>
<head>
<title>Bio storingen en registraties</title>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta charset="utf-8"> -->
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

$(document).ready(function(){
if (<?php echo isUser()?>){
	$(".admin-control *").attr("disabled", "disabled");
}
else{
	$(".admin-control *").removeAttr('disabled');	
}
});


</script>
</head>
<body>
	<div class="container form-modal">	
      <!--    <a href="../../intranet/index.php"><strong>Intranet</strong></a></p>-->
		<p height = "40px" align="center"><strong>Registraties algemeen</strong> - Medewerker</p> 

		<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties/storing/updatecode.php" id="new_medewerker" name="new_medewerker" method="POST">
		<?php echo display_error(); ?>
		<div class = "row">
			<div class = "col-md-4 right-alignment" >
				<p>Naam :
				<input name="medewerker" type="text" id="medewerker" value="<?php echo $row_medewerker['name']; ?>" />
				
				</p>
				<p>Functie :
				<input name="functie" type="text" id="functie" value="<?php echo $row_medewerker['functie']; ?>" />
				</p>
			</div>
			<div class = "col-md-4 right-alignment">
				<p>Tel. Int. :
				<input name="telintern" type="text" id="telintern" value="<?php echo $row_medewerker['TelIntern']; ?>" />
				</p>
				
				<p>Tel. Ext. : 
				<input name="telextern" type="text" id="telextern" value="<?php echo $row_medewerker['TelExtern']; ?>" />
				</p>
			
			</div>
			
								
				
			<div class = "col-md-4 right-alignment">
				<div class = "admin-control">
					<p>Controle registraties :
					<select name="RegControl" id="RegControl">
					  <option value="nee" <?php if (!(strcmp("nee", $row_medewerker['RegControl']))) {echo "selected=\"selected\"";} ?>>nee</option>
					  <option value="ja" <?php if (!(strcmp("ja", $row_medewerker['RegControl']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>
					<p>Controle Alarm : 
					<select name="AlarmControl" id="AlarmControl">
					<option value="nee" <?php if (!(strcmp("nee", $row_medewerker['AlarmControl']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_medewerker['AlarmControl']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>
					<p>User Type : 
					<select name="usertype" id="usertype">
					<option value="user" <?php if (!(strcmp("user", $row_medewerker['user_type']))) {echo "selected=\"selected\"";} ?>>User</option>
					<option value="admin" <?php if (!(strcmp("admin", $row_medewerker['user_type']))) {echo "selected=\"selected\"";} ?>>Admin</option>
					</select>
					</p>
				</div>
			</div>
		</div>
	<div class="row">
				<div class = "change-username-passwd col-md-12 right-alignment" >
					<?php  if ($_SESSION['user']['name']==$row_medewerker['name'] or $_SESSION['user']['user_type'] == 'admin') : ?>
					<a href = "#" onclick= "changeUserPass()">Change Username/Password</a>
					<div hidden>
						<label>Username :</label>
						<input type="text" name="username" />
						<br>
						<label>Password :</label>
						<input id = "password_1" type="password" name="password_1"/>
						<br>
						<label>Confirm password : </label>
						<input id = "password_2" type="password" name="password_2"/>
						<br>
						<label id = 'message'></label>
						<br>
						</div>
						<script>
							function changeUserPass(){
								$(".change-username-passwd *").removeAttr('hidden');
							}

													
							$('#password_1, #password_2').on('keyup', function () {
							  if (($('#password_1').val() == $('#password_2').val()) && $('#password_1').val().length != 0 && $('#password_2').val().length != 0 ) {
								$('#message').html('Matching').css('color', 'green');
							  } else 
								$('#message').html('Not Matching or Empty field').css('color', 'red');
							});
						</script>
					<?php endif ?>
					
				</div>	
				<div>
					<label>E-mail : </label>
					<input size="35" name="email" type="text" id="email" value="<?php echo $row_medewerker['email']; ?>" />
				</div>
			</div>
		</div>
        <div>
			<p>
			<input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_medewerker['medew_ID']; ?>" />
			</p>
			<p>
			<input type="hidden" name="submit2" type="submit" class="p_list_top" id="submit2" value="registreer" />
			<input type="hidden" name="MM_insert" value="new_reg" />
			</p>
        </div>      
    </form>
  </div>
</body>
</html>
<?php
mysqli_free_result($medewerker);
?>