<!--
Add comments!
-->
<?php
include('../../connect/functions.php'); 
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	global $connect_storing;
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connect_storing,$theValue) : mysqli_escape_string($connect_storing, $theValue);

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


/*
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "alarm")) {
  $updateSQL = sprintf("UPDATE reg_alarm SET datum2=%s, melding_soort=%s, ruimte=%s, oorzaak=%s, storing=%s, br_tel=%s, br_bhv=%s, br_br=%s, inb_meld=%s, inb_zelf=%s, inb_bev=%s, opmerking=%s, controle=%s, medew_controle=%s, werk=%s, werk_tot=%s, BMC=%s WHERE alarm_ID=%s",
                       GetSQLValueString($_POST['datum2'], "text"),
                       GetSQLValueString($_POST['melding_soort'], "text"),
                       GetSQLValueString($_POST['ruimte'], "text"),
                       GetSQLValueString($_POST['oorzaak'], "text"),
                       GetSQLValueString($_POST['storing'], "text"),
                       GetSQLValueString($_POST['br_tel'], "text"),
                       GetSQLValueString($_POST['br_bhv'], "text"),
                       GetSQLValueString($_POST['br_br'], "text"),
                       GetSQLValueString($_POST['inb_meld'], "text"),
                       GetSQLValueString($_POST['inb_zelf'], "text"),
                       GetSQLValueString($_POST['inb_bev'], "text"),
                       GetSQLValueString($_POST['opmerking'], "text"),
                       GetSQLValueString($_POST['controle'], "text"),
                       GetSQLValueString($_POST['medew_controle'], "text"),
                       GetSQLValueString($_POST['werkzaamheid'], "text"),
                       GetSQLValueString($_POST['werk_tot'], "text"),
                       GetSQLValueString($_POST['BMC'], "text"),
                       GetSQLValueString($_POST['alarm_ID'], "int"));


//Run the SQL query
  $Result1 = mysqli_query($connect_storing, $updateSQL) or die(mysqli_error($connect_storing));

  $updateGoTo = "lijst_alarm_norm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
*/
$maxRows_registratie = 1;
$pageNum_registratie = 0;
if (isset($_GET['pageNum_registratie'])) {
  $pageNum_registratie = $_GET['pageNum_registratie'];
}
$startRow_registratie = $pageNum_registratie * $maxRows_registratie;

$colname_registratie = "-1";

//Added logic to dynamically add data. Refer to lijst_reg_norm.php .
if (isset($_GET['alarm_ID'])) {
  $colname_registratie = $_GET['alarm_ID'];
}else{
	$colname_registratie = $row_list_all['alarm_ID'];
}


mysqli_select_db($connect_storing,$database_connect_storing);
$query_registratie = sprintf("SELECT * FROM reg_alarm WHERE alarm_ID = %s", GetSQLValueString($colname_registratie, "int"));
$query_limit_registratie = sprintf("%s LIMIT %d, %d", $query_registratie, $startRow_registratie, $maxRows_registratie);
$registratie = mysqli_query($connect_storing, $query_limit_registratie) or die(mysqli_error($connect_storing));
$row_registratie = mysqli_fetch_assoc($registratie);

if (isset($_GET['totalRows_registratie'])) {
  $totalRows_registratie = $_GET['totalRows_registratie'];
} else {
  $all_registratie = mysqli_query($connect_storing, $query_registratie);
  $totalRows_registratie = mysqli_num_rows($all_registratie);
}
$totalPages_registratie = ceil($totalRows_registratie/$maxRows_registratie)-1;

mysqli_select_db($connect_storing,$database_connect_storing);
$query_medew = "SELECT * FROM reg_medew WHERE AlarmControl = 'ja' ORDER BY name ASC";
$medew = mysqli_query($connect_storing, $query_medew) or die(mysqli_error($connect_storing));
$row_medew = mysqli_fetch_assoc($medew);
$totalRows_medew = mysqli_num_rows($medew);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_bmc = "SELECT * FROM reg_BMC ORDER BY BMC ASC";
$bmc = mysqli_query($connect_storing, $query_bmc) or die(mysqli_error($connect_storing));
$row_bmc = mysqli_fetch_assoc($bmc);
$totalRows_bmc = mysqli_num_rows($bmc);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_oorzaak = "SELECT * FROM alarm_oorzaak";
$oorzaak = mysqli_query($connect_storing, $query_oorzaak) or die(mysqli_error($connect_storing));
$row_oorzaak = mysqli_fetch_assoc($oorzaak);
$totalRows_oorzaak = mysqli_num_rows($oorzaak);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_storing = "SELECT * FROM alarm_storing";
$storing = mysqli_query($connect_storing, $query_storing) or die(mysqli_error($connect_storing));
$row_storing = mysqli_fetch_assoc($storing);
$totalRows_storing = mysqli_num_rows($storing);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_werkzaamheid = "SELECT * FROM alarm_werkzaamheden";
$werkzaamheid = mysqli_query( $connect_storing, $query_werkzaamheid) or die(mysqli_error($connect_storing));
$row_werkzaamheid = mysqli_fetch_assoc($werkzaamheid);
$totalRows_werkzaamheid = mysqli_num_rows($werkzaamheid);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_soort = "SELECT * FROM alarm_soort";
$soort = mysqli_query($connect_storing, $query_soort) or die(mysqli_error($connect_storing));
$row_soort = mysqli_fetch_assoc($soort);
$totalRows_soort = mysqli_num_rows($soort);
/*
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
$unixtime = strtotime($row_registratie['datum']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Modal form for alarmmelding</title>
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
			<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties/storing/updatecode.php" id = "alarm" name = "alarm" method="POST">
			<!--Section1-->
				<p align="center"><strong> Alarm Registatie Nummer : <?php echo $row_registratie['alarm_ID']; ?></strong></p>
				</br>
				<div style = "display:flex; justify-content: space-between" width="100%">
					<p><em>Gemeld op : <?php $datumNu = date("d-m-Y G:i"); echo date("d-m-Y G:i",$unixtime); ?></em></p>
					<p><em>Laatste Aanpassing Op : <?php echo $row_registratie['datum2']; ?></em></p>
					<p>Soort melding : 
					<select name="melding_soort" class="p_list_top" id="melding_soort">
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
				</div>
				</br>
				<div style = "display:flex; justify-content: space-between" width="100%">
					<p><a href="index_1.php?page=alarm&&gebouw=<?php echo $row_registratie['gebouw']; ?>">Gebouw</a> : <em><?php $gebouw1 = $row_registratie['gebouw']; echo strtok( $gebouw1, -6); ?></em></p>
				
					<p>Ruimte : <input name="ruimte" type="text" id="ruimte" value="<?php echo $row_registratie['ruimte']; ?>" /> </p>
					<p>Melding door Medewerker : <a href="index_1.php?page=alarm&&medew=<?php echo $row_registratie['medewerker']; ?>"> <?php echo $row_registratie['medewerker']; ?> </a></p>
				</div>
				</br>
				<div style = "display:flex; justify-content: space-between" width="100%">
					<p>Oorzaak : 
					<label>
					<select name="oorzaak" id="oorzaak">
					<option value="n.v.t." <?php if (!(strcmp("n.v.t.", $row_registratie['oorzaak']))) {echo "selected=\"selected\"";} ?>>n.v.t.</option>
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
					</label>
					</p>
					<p>Storing : 
					<label>
					<select name="storing" id="storing">
					<option value="n.v.t." <?php if (!(strcmp("n.v.t.", $row_registratie['storing']))) {echo "selected=\"selected\"";} ?>>n.v.t.</option>
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
					</label>
					</p>
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
					<p><strong>Opmerkingen : </strong></p>
					<label>
					<textarea name="opmerking" id="opmerking" cols="87" rows="5"><?php echo $row_registratie['opmerking']; ?></textarea>
					</label>
				</div>
				</br>

				<!--Section3-->
				<p><strong>Controle : </strong></p>
				<div class="row">
					
					<div class="col-md-7 right-alignment">
						
						<p>Werkzaamheden : 
						<label>
						<select name="werkzaamheid" id="werkzaamheid">
						<option value="n.v.t." <?php if (!(strcmp("n.v.t.", $row_registratie['werk']))) {echo "selected=\"selected\"";} ?>>n.v.t.</option>
						<?php
							do {  
						?>
						<option value="<?php echo $row_werkzaamheid['werkzaamheid']?>"<?php if (!(strcmp($row_werkzaamheid['werkzaamheid'], $row_registratie['werk']))) {echo "selected=\"selected\"";} ?>><?php echo $row_werkzaamheid['werkzaamheid']?></option>
						<?php
						} while ($row_werkzaamheid = mysqli_fetch_assoc($werkzaamheid));
						  $rows = mysqli_num_rows($werkzaamheid);
						  if($rows > 0) {
							  mysqli_data_seek($werkzaamheid, 0);
							  $row_werkzaamheid = mysqli_fetch_assoc($werkzaamheid);
						  }
						?>
						</select>
						</label>
						</p>            
						<p>Werkzaamheden tot: 
						<?php
						$kostenplaats = $row_registratie['gebouw'];
						?>
						
						<input name="werk_tot" type="text" id="werk_tot" value="<?php echo $row_registratie['werk_tot']; ?>" />
						<em>(datum invullen)</em></p>
					</div>
					</br>
					<div class="col-md-5 right-alignment">
						<p>Afgehandeld: 
						<select name="controle" id="controle">
						<option value="nee" <?php if (!(strcmp("nee", $row_registratie['controle']))) {echo "selected=\"selected\"";} ?>>nee</option>
						<option value="ja" <?php if (!(strcmp("ja", $row_registratie['controle']))) {echo "selected=\"selected\"";} ?>>ja</option>
						</select>
						<p>Afgehandeld door: 
						<select name="medew_controle" id="medew_controle">
						<option value="n.v.t." <?php if (!(strcmp("n.v.t.", $row_registratie['medew_controle']))) {echo "selected=\"selected\"";} ?>>n.v.t.</option>
						<option value="BBA" <?php if (!(strcmp("BBA", $row_registratie['medew_controle']))) {echo "selected=\"selected\"";} ?>>BBA</option>
						<option value="Ronny de Hullu" <?php if (!(strcmp("Ronny de Hullu", $row_registratie['medew_controle']))) {echo "selected=\"selected\"";} ?>>Ronny de Hullu</option>
						</select>
					</div>
				</div>		
				<div>
				
				<!--
					<p>
					<input name="submit4" type="submit" class="p_list_top" id="submit4" value="update melding" />
					</p>
		-->
					<!--<p>
					<input type="hidden" name="MM_insert" value="new_reg" />
					</p>
					<input type="hidden" name="MM_update" value="alarm" />-->
					<input type="hidden" name="datum2" value="<?php echo $datumNu; ?>" />
					
					<input name="alarm_ID" type="hidden" id="alarm_ID" value="<?php echo $row_registratie['alarm_ID']; ?>" />
					<!--
					<input type="hidden" name="MM_update" value="alarm" />
					<input type="hidden" name="MM_update" value="alarm" />-->
				</div>	
			</form>    
		</div>
</body>
</html>
<?php
mysqli_free_result($medew);

mysqli_free_result($bmc);

mysqli_free_result($oorzaak);

mysqli_free_result($storing);

mysqli_free_result($werkzaamheid);

mysqli_free_result($soort);

mysqli_free_result($registratie);
?>