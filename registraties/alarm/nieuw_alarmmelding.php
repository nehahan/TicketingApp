
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

$maxRows_registratie = 1;
$pageNum_registratie = 0;
if (isset($_GET['pageNum_registratie'])) {
  $pageNum_registratie = $_GET['pageNum_registratie'];
}
$startRow_registratie = $pageNum_registratie * $maxRows_registratie;

$colname_registratie = "-1";
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

//Datum opmaken
$unixtime = strtotime($row_registratie['datum']);
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
		<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties/storing/updatecode.php" id="new_alarmmelding" name="new_alarmmelding" method="POST">
			<p height = "40px" align="center">Nieuw Alarmmelding</p>
			<div>
				<p>Datum: Wordt voor u ingevuld..</p>
						  <?php
				$datumNu = date("d-m-Y G:i");
				?>
			</div>
			<div class = "row">
				<div class = "col-md-6 right-alignment">
					<p>Medewerker : 
						<label><?php echo $_SESSION['user']['name']; ?>
						<input style="display:none" name="medew" id="medew" value ="<?php echo $_SESSION['user']['name']; ?>"/>
						</label>
					</p>
					<p>Oorzaak : 
						<select name="oorzaak" id="oorzaak">
						  <option value="" <?php if (!(strcmp("", $row_registratie['oorzaak']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						  <?php
						do {  
						?>
						  <option value="<?php echo $row_oorzaak['oorzaak']?>"<?php if (!(strcmp($row_oorzaak['oorzaak'], $row_registratie['oorzaak']))) {echo "selected=\"selected\"";} ?>><?php echo $row_oorzaak['oorzaak']?></option>
						  <?php
						} while ($row_oorzaak = mysqli_fetch_assoc($oorzaak));
						$rows = mysqli_num_rows($oorzaak);
						if($rows > 0) {
						mysqli_data_seek($oorzaak, 0);
						$row_oorzaak = mysqli_fetch_assoc($oorzaak);
						}
						?>
						</select>
					</p>
					<p>Ruimte : 
						<input name="ruimte" type="text" id="ruimte" value="<?php echo $row_registratie['ruimte']; ?>" />
					</p>
				</div>	
				
			<!--	<a href="#" onclick="MM_popupMsg('Brand = brandontwikkeling of iets dat tot brand kan leiden en brandstichting\rongewenste brandmelding = door: roken, bakken, braden, uitlaatgassen, laswerkzaamheden, kwade opzet.\ronechte brandmelding = door: stoom van douche of waterkoker, atmosferische invloeden, vervuilde melder, stof of lijmwerkzaamheden')">uitleg soorten melding</a>
				-->
				<div class = "col-md-6 right-alignment">
					<p>Storing : 
						<select name="storing" id="storing">
						<option value="n.v.t." <?php if (!(strcmp("n.v.t.", $row_registratie['storing']))) {echo "selected=\"selected\"";} ?>>kies eventueel...</option>
						<?php
						do {  
						?>
						<option value="<?php echo $row_storing['storing']?>"<?php if (!(strcmp($row_storing['storing'], $row_registratie['storing']))) {echo "selected=\"selected\"";} ?>><?php echo $row_storing['storing']?></option>
						<?php
						} while ($row_storing = mysqli_fetch_assoc($storing));
						$rows = mysqli_num_rows($storing);
						if($rows > 0) {
						mysqli_data_seek($storing, 0);
						$row_storing = mysqli_fetch_assoc($storing);
						}
						?>
						</select>
					</p>
					<p>Soort Melding : *
						<select name="melding_soort" id="melding_soort">
						  <option value="" <?php if (!(strcmp("", $row_registratie['melding_soort']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						  <?php
						do {  
						?>
						  <option value="<?php echo $row_soort['soort']?>"<?php if (!(strcmp($row_soort['soort'], $row_registratie['melding_soort']))) {echo "selected=\"selected\"";} ?>><?php echo $row_soort['soort']?></option>
						  <?php
						} while ($row_soort = mysqli_fetch_assoc($soort));
						$rows = mysqli_num_rows($soort);
						if($rows > 0) {
						mysqli_data_seek($soort, 0);
						$row_soort = mysqli_fetch_assoc($soort);
						}
						?>
						</select>
					</p>
					<?php
						$gebouw1 = $row_registratie['gebouw'];
					?>
					<p>Gebouw : * 
						<select name="gebouw" id="gebouw">
						  <option value="" <?php if (!(strcmp("", $row_registratie['gebouw']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						  <?php
						do {  
						?>
						  <option value="<?php echo $row_gebouw['gebouw']?>"<?php if (!(strcmp($row_gebouw['gebouw'], $row_registratie['gebouw']))) {echo "selected=\"selected\"";} ?>><?php echo $row_gebouw['gebouw']?></option>
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
				</div>
			</div>

			</br>
			<div class="row">
				<p class="col-md-2"><strong>Ondernomen actie </strong></p>
				<div class="col-md-5 right-alignment">
					<p><strong>Brandalarm</strong></p>
					<p>Tel. Contact Meldkamer : 
					<select name="br_tel" id="br_tel">
					<option value="nee" <?php if (!(strcmp("nee", $row_registratie['br_tel']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_registratie['br_tel']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>
					<p>Inzet BHV-team : 
					<select name="br_bhv" id="br_bhv">
					<option value="nee" <?php if (!(strcmp("nee", $row_registratie['br_bhv']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_registratie['br_bhv']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>
					<p>Brandweer op Bio : 
					<select name="br_br" id="br_br">
					<option value="nee" <?php if (!(strcmp("nee", $row_registratie['br_br']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_registratie['br_br']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>
				</div>
				
				<div class="col-md-5 right-alignment">
					<p><strong>Inbraakalarm</strong></p>
					<p>Tel. Contact Meldkamer : 
					<label>
					<select name="inb_meld" id="inb_meld">
					<option value="nee" <?php if (!(strcmp("nee", $row_registratie['inb_meld']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_registratie['inb_meld']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</label>
					</p>
					<p>Zelf Onderzocht : 
					<select name="inb_zelf" id="inb_zelf">
					<option value="nee" <?php if (!(strcmp("nee", $row_registratie['inb_zelf']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_registratie['inb_zelf']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>
					<p>Ronde met Beveiligingsbeamte : 
					<select name="inb_bev" id="inb_bev">
					<option value="nee" <?php if (!(strcmp("nee", $row_registratie['inb_bev']))) {echo "selected=\"selected\"";} ?>>nee</option>
					<option value="ja" <?php if (!(strcmp("ja", $row_registratie['inb_bev']))) {echo "selected=\"selected\"";} ?>>ja</option>
					</select>
					</p>	
				</div>
			</div>
				</br>
			<div>
				<p>Opmerkingen :  </p><p>
				<textarea name="opmerking" id="opmerking" cols="115" rows="5"><?php echo $row_registratie['opmerking']; ?></textarea>
				</p>
			</div>
			<p><strong>* =</strong><strong>Verplicht Veld</strong></p>	
			<div>
				<!--
				<input type="hidden" name="MM_insert" value="new_reg" />
				<input type="hidden" name="MM_update" value="reg" />-->
				<input type="hidden" name="datum2" value="<?php echo $datumNu; ?>" />
				<input name="alarm_ID" type="hidden" id="alarm_ID" value="<?php echo $row_registratie['alarm_ID']; ?>" />
				<!--<input type="hidden" name="MM_update" value="reg" />
				<input type="hidden" name="MM_update" value="reg" />
				<input type="hidden" name="MM_insert" value="reg" />-->
			</div>
		</form>
	</div>
</body>
</html>
<?php
mysqli_free_result($medew);

mysqli_free_result($oorzaak);

mysqli_free_result($storing);

mysqli_free_result($soort);

mysqli_free_result($gebouw);

mysqli_free_result($registratie);
?>