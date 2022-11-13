<?php
include('../../connect/functions.php'); 
/*
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "new_reg")) {
  $insertSQL = sprintf("INSERT INTO reg_storing (gebouw, ruimte, app, omsch_kort, omschrijving, prioriteit, medew, medew_actie, melder, meld_org, meld_tel) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['gebouw'], "text"),
                       GetSQLValueString($_POST['ruimte'], "text"),
                       GetSQLValueString($_POST['app'], "text"),
                       GetSQLValueString($_POST['omsch-kort'], "text"),
                       GetSQLValueString($_POST['omschrijving'], "text"),
                       GetSQLValueString($_POST['prioriteit'], "text"),
                       GetSQLValueString($_POST['medew'], "text"),
                       GetSQLValueString($_POST['medew_actie'], "text"),
                       GetSQLValueString($_POST['melder'], "text"),
                       GetSQLValueString($_POST['meld_org'], "text"),
                       GetSQLValueString($_POST['meld_tel'], "text"));

  mysqli_select_db($connect_storing, $database_connect_storing);
  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));

  $insertGoTo = "lijst_reg_norm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
*/
mysqli_select_db($connect_storing, $database_connect_storing);
$query_list_all = "SELECT * FROM reg_storing ORDER BY datum ASC";
$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
$row_list_all = mysqli_fetch_assoc($list_all);
$totalRows_list_all = mysqli_num_rows($list_all);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_prioriteit = "SELECT * FROM reg_prioriteit";
$prioriteit = mysqli_query($connect_storing, $query_prioriteit) or die(mysqli_error($connect_storing));
$row_prioriteit = mysqli_fetch_assoc($prioriteit);
$totalRows_prioriteit = mysqli_num_rows($prioriteit);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_gebouw = "SELECT gebouw FROM reg_gebouw ORDER BY gebouw ASC";
$gebouw = mysqli_query($connect_storing, $query_gebouw) or die(mysqli_error($connect_storing));
$row_gebouw = mysqli_fetch_assoc($gebouw);
$totalRows_gebouw = mysqli_num_rows($gebouw);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_medewerker = "SELECT name FROM reg_medew WHERE zichtbaar = 'ja' ORDER BY name ASC";
$medewerker = mysqli_query($connect_storing, $query_medewerker) or die(mysqli_error($connect_storing));
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
<style type="text/css" media="print">
body {
	margin:0px;
	
  zoom:68%; /*or whatever percentage you need, play around with this number*/
}
#bedrijf{
	width:300px;
}
</style>
</head>

<body>
	<div>
	<div class="container form-modal">	
		<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties\storing\updatecode.php" id="new_reg" name="new_reg" method="POST">
			<p height = "40px" align="center">Nieuw Registratie</p>
			  <!--<p>Datum : <label id ="current-date"> </label></p>-->
			<div class= "row">
				<div class = "col-md-6 right-alignment">
					<p>Medewerker : 
						<?php echo $_SESSION['user']['name']; ?>
						<input type="hidden" name="medew" id="medew" value ="<?php echo $_SESSION['user']['name']; ?>"/>
						
					</p>
					<p>Gebouw * : 
						
						<select name="gebouw" id="gebouw">
						<option value="">kies...</option>
						<?php
						do {  
						?>
						<option value="<?php echo $row_gebouw['gebouw']?>"><?php echo $row_gebouw['gebouw']?></option>
						<?php
						} while ($row_gebouw = mysqli_fetch_assoc($gebouw));
						$rows = mysqli_num_rows($gebouw);
						if($rows > 0) {
						mysqli_data_seek($gebouw, 0);
						$row_gebouw = mysqli_fetch_assoc($gebouw);
						}
						?>
						</select>
					</p>
					<p>Ruimte : 
						
						<input type="text" name="ruimte" id="ruimte" />
						
					</p>
					<p>Apparatuur * : 
						
						<input type="text" name="app" id="app" />
						
					</p>
					<p>Prioriteit * : 
						<select name="prioriteit" id="prioriteit">
						<option value="">kies...</option>
						<?php
						do {  
						?>
						<option value="<?php echo $row_prioriteit['prioriteit']?>"><?php echo $row_prioriteit['prioriteit']?></option>
						<?php
						} while ($row_prioriteit = mysqli_fetch_assoc($prioriteit));
						$rows = mysqli_num_rows($prioriteit);
						if($rows > 0) {
						mysqli_data_seek($prioriteit, 0);
						$row_prioriteit = mysqli_fetch_assoc($prioriteit);
						}
						?>
						</select>
					</p>
				</div>
				<div class = "col-md-6 right-alignment less-priority">
					<p>Gemeld Door : <input type="text" name="melder" id="melder" placeholder = "(Indien anders dan iemand bij BIO)" /></p>
					<p>Actie ondernomen door : 
						<select name="medew_actie" id="medew_actie">
						<option value="" <?php if (!(strcmp("", $row_list_all['medew']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						<?php
						do {  
						?>
						<option value="<?php echo $row_medewerker['name']?>"<?php if (!(strcmp($row_medewerker['name'], $row_list_all['medew']))) {echo "selected=\"selected\"";} ?>><?php echo $row_medewerker['name']?></option>
						<?php
						} while ($row_medewerker = mysqli_fetch_assoc($medewerker));
						$rows = mysqli_num_rows($medewerker);
						if($rows > 0) {
						mysqli_data_seek($medewerker, 0);
						$row_medewerker = mysqli_fetch_assoc($medewerker);
						}
						?>
						</select>
					</p>
					<p>Organisatie :
						
						<input type="text" name="meld_org" id="meld_org" />
						
					</p>
					<p>Telefoonnummer : 
						
						<input type="text" name="meld_tel" id="meld_tel" />
						
					</p>
				</div>
			</div>
			</br>
			<div style = "display:flex; justify-content: space-between" width="100%">
				<p>Korte omschrijving * : 
				<input name="omsch-kort" type="text" id="omsch-kort" size="40" maxlength="40" />
			  </p>
			</div>
			<div style = "display:flex; justify-content: space-between" width="100%">
				<p>Omschrijving : </p><span>
					<textarea name="omschrijving" cols="85" rows="10" id="omschrijving"></textarea></span>
					
			</div>
			<div style = "display:flex; justify-content: space-between" width="100%" border="2px" cellpadding="3" cellspacing="0">
			  <p>
				<label></label>
				<strong>* =</strong><strong>Verplicht veld</strong></p></td>
			  </p>
			</div>
			<input type="hidden" name="MM_insert" value="new_reg" />
		</form>
	</div>
	</div>
</body>
</html>
<?php
mysqli_free_result($list_all);

mysqli_free_result($prioriteit);

mysqli_free_result($gebouw);

mysqli_free_result($medewerker);
?>