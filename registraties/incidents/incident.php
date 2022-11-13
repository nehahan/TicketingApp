
<?php
include('../../connect/functions.php'); 

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	global $connect_storing;
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connect_storing,$theValue) : mysqli_escape_string($theValue);

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

//Fill the data from the database
$query_list_all = "SELECT * FROM reg_incident ORDER BY datum DESC";
$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
$row_list_all = mysqli_fetch_assoc($list_all);
$totalRows_list_all = mysqli_num_rows($list_all);


//What is this if statement used for?
$maxRows_registratie = 1;
$pageNum_registratie = 0;

if (isset($_GET['pageNum_registratie'])) {
  $pageNum_registratie = $_GET['pageNum_registratie'];
}
$startRow_registratie = $pageNum_registratie * $maxRows_registratie;

$colname_registratie = "-1";

//Added logic to dynamically add data. Refer to lijst_reg_norm.php .
if (isset($_GET['Incident_ID'])) {
  $colname_registratie = $_GET['Incident_ID'];
}else{
	$colname_registratie = $row_list_all['Incident_ID'];
}
mysqli_select_db($connect_storing, $database_connect_storing);
$query_registratie = sprintf("SELECT * FROM reg_incident WHERE Incident_ID = %s", GetSQLValueString($colname_registratie, "int"));
$query_limit_registratie = sprintf("%s LIMIT %d, %d", $query_registratie, $startRow_registratie, $maxRows_registratie);
$registratie = mysqli_query($connect_storing, $query_limit_registratie) or die(mysqli_error());
$row_registratie = mysqli_fetch_assoc($registratie);
/*
if (isset($_GET['alarm_ID'])) {
  $colname_registratie = $_GET['alarm_ID'];
}
mysqli_select_db($connect_storing, $database_connect_storing);
$query_registratie = sprintf("SELECT * FROM reg_alarm WHERE alarm_ID = %s", GetSQLValueString($colname_registratie, "int"));
$query_limit_registratie = sprintf("%s LIMIT %d, %d", $query_registratie, $startRow_registratie, $maxRows_registratie);
$registratie = mysqli_query($connect_storing, $query_limit_registratie) or die(mysqli_error());
$row_registratie = mysqli_fetch_assoc($registratie);

if (isset($_GET['totalRows_registratie'])) {
  $totalRows_registratie = $_GET['totalRows_registratie'];
} else {
  $all_registratie = mysqli_query($connect_storing, $query_registratie);
  $totalRows_registratie = mysqli_num_rows($all_registratie);
}
$totalPages_registratie = ceil($totalRows_registratie/$maxRows_registratie)-1;

mysqli_select_db($connect_storing, $database_connect_storing);
$query_medew = "SELECT * FROM reg_medew ORDER BY name ASC";
$medew = mysqli_query($connect_storing, $query_medew) or die(mysqli_error($connect_storing));
$row_medew = mysqli_fetch_assoc($medew);
$totalRows_medew = mysqli_num_rows($medew);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_oorzaak = "SELECT * FROM alarm_oorzaak";
$oorzaak = mysqli_query($connect_storing, $query_oorzaak) or die(mysqli_error());
$row_oorzaak = mysqli_fetch_assoc($oorzaak);
$totalRows_oorzaak = mysqli_num_rows($oorzaak);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_storing = "SELECT * FROM alarm_storing";
$storing = mysqli_query($connect_storing, $query_storing) or die(mysqli_error());
$row_storing = mysqli_fetch_assoc($storing);
$totalRows_storing = mysqli_num_rows($storing);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_soort = "SELECT * FROM alarm_soort";
$soort = mysqli_query($connect_storing, $query_soort) or die(mysqli_error());
$row_soort = mysqli_fetch_assoc($soort);
$totalRows_soort = mysqli_num_rows($soort);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_gebouw = "SELECT * FROM reg_gebouw";
$gebouw = mysqli_query($connect_storing, $query_gebouw) or die(mysqli_error());
$row_gebouw = mysqli_fetch_assoc($gebouw);
$totalRows_gebouw = mysqli_num_rows($gebouw);

$queryString_registratie = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_registratie") == false && 
        stristr($param, "totalRows_registratie") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_registratie = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_registratie = sprintf("&totalRows_registratie=%d%s", $totalRows_registratie, $queryString_registratie);
*/
//Datum opmaken
//$unixtime = strtotime($row_registratie['datum']);
$datumNu = date("d-m-Y G:i");
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
	
	zoom:150%; /*or whatever percentage you need, play around with this number*/
}

</style>
</head>

<body>
	<div class="container form-modal">	
		<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties/storing/updatecode.php" id="update_incident" name="update_incident" method="POST">
			<p height = "40px" align="center">Informatie voor  <strong>Calamiteit Nummer : <?php echo $row_registratie['Incident_ID']; ?></p></strong>
			<p ></strong></p>
			<div class = "row">
				<div class = "col-md-6 right-alignment">
					<p> Naam Melder : 
					<input type="text" name="meldernaam" id="meldernaam" value = "<?php echo $row_registratie['melder']; ?>"/>
					</p>
					<p> Locatie : 
					<input type="text" name="locatie" id="locatie" value = "<?php echo $row_registratie['locatie']; ?>"/>
					</p>
				</div>
				<div class = "col-md-6 right-alignment">
					<p>Datum & Tijd: <?php echo $row_registratie['datum']; ?></p>
						  
				</div>	
			</div>
			<br>
			
			<div class = "row">
				<div class = "col-md-12 right-alignment">
					<p><strong>Aard Incident</strong> : 
						<select name="aard" id="aard">
						<option value=" " <?php if (!(strcmp(" ", $row_registratie['aard_incident']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						<option value ="Letsel"<?php if (!(strcmp("Letsel", $row_registratie['aard_incident']))) {echo "selected=\"selected\"";} ?>>Letsel </option>
						<option value ="Brand"<?php if (!(strcmp("Brand", $row_registratie['aard_incident']))) {echo "selected=\"selected\"";} ?>>Brand </option>
						<option value ="Explosie"<?php if (!(strcmp("Explosie", $row_registratie['aard_incident']))) {echo "selected=\"selected\"";} ?>>Explosie</option>
						<option value ="Incident Met Gevaarlijk Stoffen"<?php if (!(strcmp("Incident Met Gevaarlijk Stoffen", $row_registratie['aard_incident']))) {echo "selected=\"selected\"";} ?>>Incident met gevaarlijk stoffen </option>
						<option value ="Anders NL"<?php if (!(strcmp("Anders NL", $row_registratie['aard_incident']))) {echo "selected=\"selected\"";} ?>>Anders NL</option>
						</select>
					<span style = "display:none" id="aard_anders_NL" ><input id = "anders_NL_aard_input" type="text" name="anders_NL_aard" value = "<?php echo $row_registratie['anders_NL_aard']; ?>"/></span>
					</p>
				</div>	
			</div>
			<br>
			<strong><p>Alarmeren</p></strong>
			<p>Wie is er in eerste instantie gewaarschuwd?</p>
			<div class = "row">	
				<div class = "col-md-4" style = "text-align: right;">	
					<p>Alarm Int. : </p>
					<p>Alarmeren Ext. : </p>
					<p>Is het ontruimingssignaal gegeven? : </p>
				</div>
				<div class ="col-md-8">
					<p>
						<select name="alert_intern" id="alert_intern">
						<option value ="Central Punt / Receptioniste">Central Punt / Receptioniste</option>
						<option value ="BHV's">BHV's </option>
						<option value ="Werkgever">Werkgever</option>
						<option value ="Anders NL">Anders NL</option>
						</select>
					<span style = "display:none" id="alert_intern_anders_NL"><input id = "anders_NL_alm_int_input" type="text" name="anders_NL_alm_int" value = "<?php echo $row_registratie['anders_NL_alm_int']; ?>" /></span>
					</p>
					
					<p>
						<select name="alert_extern" id="alert_extern">
						<option value ="112">112</option>
						<option value ="Anders NL">Anders NL</option>
						</select>
					<span style = "display:inline;display:none" id="alert_extern_anders_NL" ><input id = "anders_NL_alm_ext_input" type="text" name="anders_NL_alm_ext" value = "<?php echo $row_registratie['anders_NL_alm_ext']; ?>"/></span>
					</p>
					
					<p>
						<select name="ontruimingsig" id="ontruimingsig">
						<option value ="Ja">Ja</option>
						<option value ="Nee">Nee</option>
						<option value ="N.V.T">N.V.T</option>
						</select>
					</p>
				</div>
			</div>	
			<div class = "row">
				<div class = "col-md-12">
					<p>Wat is er gebeurd? : </p>
					
					<p><textarea name="gebeurddata" id="gebeurddata" cols="115" rows="5"><?php echo $row_registratie['gebeurd_data']; ?></textarea></p>
					
					<p>Ondernomen actie en door wie?</p>
					
					<p><textarea name="odernomenactie" id="odernomenactie" cols="115" rows="5"><?php echo $row_registratie['onder_actie_wie']; ?></textarea></p>
					
					<p>Aktie afgehandled : 
						<select name="aktieafgehan" id="aktieafgehan">
						<option value ="Ja">Ja</option>
						<option value ="Nee">Nee</option>
						</select>
					</p>
				</div>	
			</div>	
					
			<div class ="row">
				<div class = "col-md-6">
					<p>Formulier ingevuld door : <?php echo $row_registratie['medewerker']; ?>
						<input style="display:none" name="medew" id="medew" value ="<?php echo $row_registratie['medewerker']; ?>"/>
					</p>					
					
				</div>
				<div class = "col-md-6">
					<p>Handtekening : </p>
					<textarea cols="15" rows="2"></textarea></p>
				</div>
			</div>	
				<input type="hidden" name="datum" value="<?php echo $datumNu; ?>" />
				<input type="hidden" name="Incident_ID" value="<?php echo $row_registratie['Incident_ID']; ?>" />
		</form>
	</div>
<script>
var val1 = $("#aard").val();
if(val1 === "Anders NL"){
	  $("#aard_anders_NL").show();
  }else{
	  $("#aard_anders_NL").hide();
  };
var val2 = $("#alert_intern").val();
if(val2 === "Anders NL"){
	  $("#alert_intern_anders_NL").show();
  }else{
	  $("#alert_intern_anders_NL").hide();
  };
var val3 = $("#alert_extern").val();
if(val3 === "Anders NL"){
	  $("#alert_extern_anders_NL").show();
  }else{
	  $("#alert_extern_anders_NL").hide();
  };
  

$(function () {
  $("#aard").change(function() {
    var val = $(this).val();
    if(val === "Anders NL") {
        $("#aard_anders_NL").show();
    }else{
		$("#aard_anders_NL").hide();
		$("#anders_NL_aard_input").val("");
		
	}
  });
    $("#alert_intern").change(function() {
    var val = $(this).val();
    if(val === "Anders NL") {
        $("#alert_intern_anders_NL").show();
    }else{
		$("#alert_intern_anders_NL").hide();
		$("#anders_NL_alm_int_input").val("")
	}
  });
    $("#alert_extern").change(function() {
    var val = $(this).val();
    if(val === "Anders NL") {
        $("#alert_extern_anders_NL").show();
    }else{
		$("#alert_extern_anders_NL").hide();
		$("#anders_NL_alm_ext_input").val("");
	}
  });
  
  
});

</script>	
</body>
</html>
