<?php
include('../../connect/functions.php'); 
//This function does parsing the URL for required information
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

mysqli_select_db($connect_storing, $database_connect_storing);
$query_bedrijf = "SELECT * FROM reg_bedrijven";
$bedrijf = mysqli_query($connect_storing, $query_bedrijf) or die(mysqli_error($connect_storing));
$row_bedrijf = mysqli_fetch_assoc($bedrijf);
$totalRows_bedrijf = mysqli_num_rows($bedrijf);
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

</head>

<body>
	<div class="container form-modal">
		<p height = "40px" align="center"><strong>Registraties algemeen</strong> - Bedrijf</p> 
		<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties/storing/updatecode.php" id="new_bedrijf" name="new_bedrijf" method="POST">
			<div>
				<p>Bedrijf Naam : 
				<input size="40px"type="text" name="bedrijf" id="bedrijf" />
				</p>
			</div>
			</br>
			<div class = "row">
				<p class = "col-md-4">Fax : 
				<input type="text" name="fax" id="fax" />
				</p>
				<p class = "col-md-4">Telefoon : 
				<input type="text" name="telefoon" id="telefoon" />
				</p>
				<p class = "col-md-4">E-mail : 
				<input type="text" name="email" id="email" />
				</p>
			</div>
			</br>
			<div class ="row">
				<p class = "col-md-6">Contactpersoon 1 :
				<input name="cont_pers1" type="text" id="cont_pers1" value="<?php echo $row_bedrijf['cont_pers1']; ?>" />
				</p>
				<p class = "col-md-6">
				<textarea name="cont_pers1_omschr" cols="35" rows="3" id="cont_pers1_omschr" placeholder="Omschrijving voor Contactpersoon 1"><?php echo $row_bedrijf['cont_pers1_omsch']; ?></textarea>
				</p>
			</div>
			</br>
			<div class ="row">
				  <p class = "col-md-6">Contactpersoon 2 :
					<input name="cont_pers2" type="text" id="cont_pers2" value="<?php echo $row_bedrijf['cont_pers2']; ?>" />
				  </p>
				  <p class = "col-md-6">
					<textarea name="cont_pers2_omschr" cols="35" rows="3" id="cont_pers2_omschr"><?php echo $row_bedrijf['cont_pers2_omsch']; ?></textarea>
				  </p>
			</div>
			<p>Zichtbaar : 
				<select name="zichtbaar" id="zichtbaar">
				<option value="Nee" <?php if (!(strcmp("Nee", $row_bedrijf['zichtbaar']))) {echo "selected=\"selected\"";} ?>>Nee</option>
				<option value="Ja" <?php if (!(strcmp("Ja", $row_bedrijf['zichtbaar']))) {echo "selected=\"selected\"";} ?>>Ja</option>
				</select>
			</p>
			<div>
				<p>Omschrijving : </p>
				<p>
				<textarea name="omschr" cols="115" rows="5" id="omschr" placeholder="Omschrijving voor Contactpersoon 2"></textarea>
				</p>
			</div>
				<input type="hidden" name="submit2" type="submit" class="p_list_top" id="submit2" value="Registreer dit bedrijf" />
				<input type="hidden" name="MM_insert" value="new_reg" />
		</form>
	</div>

</body>
</html>
<?php
mysqli_free_result($bedrijf);
?>