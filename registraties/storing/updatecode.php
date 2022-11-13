<?php
include('../../connect/functions.php'); 
//This function does parsing the URL for required information
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	global $connect_storing;
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($connect_storing, $theValue);

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

if (isset($_POST["newincidentdata"])) {
  $insertSQL = sprintf("INSERT INTO reg_incident (melder, locatie, aard_incident, anders_NL_aard, alarmeren_int, anders_NL_alm_int, alarmeren_ext, anders_NL_alm_ext, ontruimingsignal, gebeurd_data, onder_actie_wie, aktie_afgehan, medewerker) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						GetSQLValueString($_POST['meldernaam'], "text"),
						GetSQLValueString($_POST['locatie'], "text"),
						GetSQLValueString($_POST['aard'], "text"),
						GetSQLValueString($_POST['anders_NL_aard'], "text"),
						GetSQLValueString($_POST['alert_intern'], "text"),
						GetSQLValueString($_POST['anders_NL_alm_int'], "text"),
						GetSQLValueString($_POST['alert_extern'], "text"),
						GetSQLValueString($_POST['anders_NL_alm_ext'], "text"),
						GetSQLValueString($_POST['ontruimingsig'], "text"),
						GetSQLValueString($_POST['gebeurddata'], "text"),
						GetSQLValueString($_POST['odernomenactie'], "text"),
						GetSQLValueString($_POST['aktieafgehan'], "text"),
						GetSQLValueString($_POST['medew'], "text"));
	//Run the SQL query
  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

if (isset($_POST["updateincident"])) {
  $insertSQL = sprintf("UPDATE reg_incident SET melder=%s, locatie=%s, aard_incident=%s, anders_NL_aard=%s, alarmeren_int=%s, anders_NL_alm_int=%s, alarmeren_ext=%s, anders_NL_alm_ext=%s, ontruimingsignal=%s, gebeurd_data=%s, onder_actie_wie=%s, aktie_afgehan=%s, medewerker=%s WHERE Incident_ID=%s",
						GetSQLValueString($_POST['meldernaam'], "text"),
						GetSQLValueString($_POST['locatie'], "text"),
						GetSQLValueString($_POST['aard'], "text"),
						GetSQLValueString($_POST['anders_NL_aard'], "text"),
						GetSQLValueString($_POST['alert_intern'], "text"),
						GetSQLValueString($_POST['anders_NL_alm_int'], "text"),
						GetSQLValueString($_POST['alert_extern'], "text"),
						GetSQLValueString($_POST['anders_NL_alm_ext'], "text"),
						GetSQLValueString($_POST['ontruimingsig'], "text"),
						GetSQLValueString($_POST['gebeurddata'], "text"),
						GetSQLValueString($_POST['odernomenactie'], "text"),
						GetSQLValueString($_POST['aktieafgehan'], "text"),
						GetSQLValueString($_POST['medew'], "text"),
						GetSQLValueString($_POST['Incident_ID'], "int"));
	//Run the SQL query
  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

//Update data on some trigger in reg_storing
if (isset($_POST["updatedata"])) {
	
  $updateSQL = sprintf("UPDATE reg_storing SET datum2=%s, ruimte=%s, app=%s, omsch_kort=%s, omschrijving=%s, td=%s, td_new=%s, bedrijf=%s, bedrijf_plan=%s, bedrijf_opdr=%s, bedrijf_datum=%s, prioriteit=%s, afgehandeld=%s, medew_controle=%s, melder=%s, meld_org=%s, meld_tel=%s, controle=%s WHERE reg_ID=%s",
                       GetSQLValueString($_POST['datum2'], "text"),
                       GetSQLValueString($_POST['ruimte'], "text"),
                       GetSQLValueString($_POST['app'], "text"),
                       GetSQLValueString($_POST['omsch_kort'], "text"),
                       GetSQLValueString($_POST['omschrijving'], "text"),
                       GetSQLValueString($_POST['td'], "text"),
                       GetSQLValueString($_POST['td_new'], "text"),
                       GetSQLValueString($_POST['bedrijf'], "text"),
                       GetSQLValueString($_POST['bedrijf_plan'], "text"),
                       GetSQLValueString($_POST['bedrijf_opdr'], "text"),
                       GetSQLValueString($_POST['bedrijf_datum'], "date"),
                       GetSQLValueString($_POST['prioriteit'], "text"),
                       GetSQLValueString($_POST['afgehandeld'], "text"),
                       GetSQLValueString($_POST['medew_controle'], "text"),
                       GetSQLValueString($_POST['melder'], "text"),
                       GetSQLValueString($_POST['meld_org'], "text"),
                       GetSQLValueString($_POST['meld_tel'], "text"),
                       GetSQLValueString($_POST['controle'], "text"),
                       GetSQLValueString($_POST['reg_ID'], "int"));

//Run the SQL query
  $Result1 = mysqli_query($connect_storing, $updateSQL) or die(mysqli_error($connect_storing));
	
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

if (isset($_POST["newregdata"])) {
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

  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

if (isset($_POST["updatealarm"])) {
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
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php?page=alarm");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

if (isset($_POST["newalarmmelding"])) {
  $insertSQL = sprintf("INSERT INTO reg_alarm (alarm_ID, melding_soort, gebouw, ruimte, oorzaak, storing, medewerker, br_tel, br_bhv, br_br, inb_meld, inb_zelf, inb_bev, opmerking) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['alarm_ID'], "int"),
                       GetSQLValueString($_POST['melding_soort'], "text"),
                       GetSQLValueString($_POST['gebouw'], "text"),
                       GetSQLValueString($_POST['ruimte'], "text"),
                       GetSQLValueString($_POST['oorzaak'], "text"),
                       GetSQLValueString($_POST['storing'], "text"),
                       GetSQLValueString($_POST['medew'], "text"),
                       GetSQLValueString($_POST['br_tel'], "text"),
                       GetSQLValueString($_POST['br_bhv'], "text"),
                       GetSQLValueString($_POST['br_br'], "text"),
                       GetSQLValueString($_POST['inb_meld'], "text"),
                       GetSQLValueString($_POST['inb_zelf'], "text"),
                       GetSQLValueString($_POST['inb_bev'], "text"),
                       GetSQLValueString($_POST['opmerking'], "text"));
	//Run the SQL query
  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

if (isset($_POST["updatemedewerker"])) {
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);
	if ($password_1 == $password_2 and $password_1 != NULL and $password_2 != NULL){
		$password = md5($password_1);
	}else{
		$password = $password_1;
	}
  $updateSQL = sprintf("UPDATE reg_medew SET name=%s, functie=%s, TelIntern=%s, TelExtern=%s, email=%s, RegControl=%s, AlarmControl=%s, zichtbaar=%s, user_type=%s, username = %s, password = %s WHERE id=%s",
                       GetSQLValueString($_POST['medewerker'], "text"),
                       GetSQLValueString($_POST['functie'], "text"),
                       GetSQLValueString($_POST['telintern'], "text"),
                       GetSQLValueString($_POST['telextern'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['RegControl'], "text"),
                       GetSQLValueString($_POST['AlarmControl'], "text"),
                       GetSQLValueString($_POST['zichtbaar'], "text"),
					   GetSQLValueString($_POST['usertype'], "text"),
					   GetSQLValueString($_POST['username'], "text"),
					   GetSQLValueString($password, "text"),
                       GetSQLValueString($_POST['hiddenField'], "int"));
  $Result1 = mysqli_query($connect_storing, $updateSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}


if (isset($_POST["newmedewerker"])) {
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);
	if ($password_1 == $password_2 and $password_1 != NULL and $password_2 != NULL){
		$password = md5($password_1);
	}else{
		echo '<script>alert("passwords dont match. Password not updated")</script>';
	}
	
	
  $insertSQL = sprintf("INSERT INTO reg_medew (name, functie, TelIntern, TelExtern, email, RegControl, AlarmControl,user_type,username,password) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medewerker'], "text"),
                       GetSQLValueString($_POST['functie'], "text"),
                       GetSQLValueString($_POST['telintern'], "text"),
                       GetSQLValueString($_POST['telextern'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['RegControl'], "text"),
                       GetSQLValueString($_POST['AlarmControl'], "text"),
					   GetSQLValueString($_POST['usertype'], "text"),
					   GetSQLValueString($_POST['username'], "text"),
					   GetSQLValueString($password, "text")
					   
					   );
  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("<script>window.location.href</script>");
}else{
	echo '<script>alert("Data not Updated")</script>';
}


if (isset($_POST["updatebedrijf"])) {
  $updateSQL = sprintf("UPDATE reg_bedrijven SET bedrijf=%s, telefoon=%s, fax=%s, email=%s, omschr=%s, cont_pers1=%s, cont_pers1_omsch=%s, cont_pers2=%s, cont_pers2_omsch=%s,  zichtbaar = %s WHERE bedrijf_ID=%s",
                       GetSQLValueString($_POST['bedrijf'], "text"),
                       GetSQLValueString($_POST['telefoon'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['omschr'], "text"),
                       GetSQLValueString($_POST['cont_pers1'], "text"),
                       GetSQLValueString($_POST['cont_pers1_omschr'], "text"),
                       GetSQLValueString($_POST['cont_pers2'], "text"),
                       GetSQLValueString($_POST['cont_pers2_omschr'], "text"),
					   GetSQLValueString($_POST['zichtbaar'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "int")
					   );
  $Result1 = mysqli_query($connect_storing, $updateSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}


if (isset($_POST["newbedrijf"])) {
 $insertSQL = sprintf("INSERT INTO reg_bedrijven (bedrijf, telefoon, fax, email, omschr, cont_pers1, cont_pers1_omsch, cont_pers2, cont_pers2_omsch,zichtbaar) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['bedrijf'], "text"),
                       GetSQLValueString($_POST['telefoon'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['omschr'], "text"),
                       GetSQLValueString($_POST['cont_pers1'], "text"),
                       GetSQLValueString($_POST['cont_pers1_omschr'], "text"),
                       GetSQLValueString($_POST['cont_pers2'], "text"),
                       GetSQLValueString($_POST['cont_pers2_omschr'], "text"),
					   GetSQLValueString($_POST['zichtbaar'], "text"));
  $Result1 = mysqli_query($connect_storing, $insertSQL) or die(mysqli_error($connect_storing));
}else{
	echo '<script>alert("$_POST not set")</script>';
}
global $Result1;
  if ($Result1){
	echo '<script>alert("Data Updated")</script>';
	header("location:../../index_1.php");
}else{
	echo '<script>alert("Data not Updated")</script>';
}

?>