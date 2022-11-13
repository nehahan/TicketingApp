<!--
This is prefilled form that opens when the modal is shown. Modal is shown when the reg_ID is clicked .
-->

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

//Fill the data from the database
$query_list_all = "SELECT * FROM reg_storing WHERE controle = 'nee' ORDER BY datum DESC";
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
if (isset($_GET['reg_ID'])) {
  $colname_registratie = $_GET['reg_ID'];
}else{
	$colname_registratie = $row_list_all['reg_ID'];
}

mysqli_select_db($connect_storing, $database_connect_storing);
$query_registratie = sprintf("SELECT * FROM reg_storing WHERE reg_ID = %s", GetSQLValueString($colname_registratie, "int"));
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
$query_prioriteit = "SELECT * FROM reg_prioriteit";
$prioriteit = mysqli_query($connect_storing, $query_prioriteit) or die(mysqli_error($connect_storing));
$row_prioriteit = mysqli_fetch_assoc($prioriteit);
$totalRows_prioriteit = mysqli_num_rows($prioriteit);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_gebouwen = sprintf("SELECT * FROM reg_gebouw WHERE gebouw = %s",GetSQLValueString($row_registratie['gebouw'],"text"));
$gebouwen = mysqli_query($connect_storing, $query_gebouwen) or die(mysqli_error($connect_storing));
$row_gebouwen = mysqli_fetch_assoc($gebouwen);
$totalRows_gebouwen = mysqli_num_rows($gebouwen);

mysqli_select_db($connect_storing, $database_connect_storing);
$query_medew = "SELECT name FROM reg_medew WHERE RegControl = 'ja' ORDER BY name ASC";
$medew = mysqli_query($connect_storing, $query_medew) or die(mysqli_error($connect_storing));
$row_medew = mysqli_fetch_assoc($medew);
$totalRows_medew = mysqli_num_rows($medew);

/*
mysqli_select_db($connect_storing, $database_connect_storing);
$query_zichtbaar_medew = "SELECT name FROM reg_medew WHERE zichtbaar = 'ja' ORDER BY name ASC";
$zichtbaar_medew = mysqli_query($connect_storing, $query_medew) or die(mysqli_error($connect_storing));
$row_zichtbaar_medew = mysqli_fetch_assoc($zichtbaar_medew);
$totalRows_zichtbaar_medew = mysqli_num_rows($zichtbaar_medew);
*/

mysqli_select_db($connect_storing, $database_connect_storing);
$query_medew_user = "SELECT name FROM reg_medew WHERE zichtbaar = 'ja' ORDER BY name ASC";
$medew_user = mysqli_query($connect_storing, $query_medew_user) or die(mysqli_error($connect_storing));
$row_medew_user = mysqli_fetch_assoc($medew_user);
$totalRows_medew_user = mysqli_num_rows($medew_user);


mysqli_select_db($connect_storing, $database_connect_storing);
$query_bedrijven = "SELECT bedrijf_ID, bedrijf FROM reg_bedrijven ORDER BY bedrijf ASC";
$bedrijven = mysqli_query($connect_storing, $query_bedrijven) or die(mysqli_error($connect_storing));
$row_bedrijven = mysqli_fetch_assoc($bedrijven);
$totalRows_bedrijven = mysqli_num_rows($bedrijven);
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
	
  zoom:68%; /*or whatever percentage you need, play around with this number*/
}
#bedrijf{
	width:300px;
}
</style>
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
		<form onsubmit="setTimeout(function(){window.location.reload();},30)" action="registraties\storing\updatecode.php" id = "reg" name = "reg" method="POST">
		<!--Here $editFormAction will change VERY VERY IMPORTANT-->
			<p height = "40px" align="center">Informatie voor <strong> Registratie Nummer : <?php echo $row_registratie['reg_ID']; ?></strong></p>
			</br>
			<div style = "display:flex; justify-content: space-between" width="100%" border="2px" cellpadding="3" cellspacing="0">
				<p><em>Gemeld Op: <?php $datumNu = date("d-m-Y G:i");
				echo date("d-m-Y G:i",$unixtime); ?> </em></p>   
				<p><em>laatste aanpassing op : <?php echo $row_registratie['datum2']; ?></em></p>
			</div>
				
			<div style = "display:flex; justify-content: space-between" width="100%" border="2px" cellpadding="3" cellspacing="0"> 
				<p><a href="index_1.php?medew=<?php echo $row_registratie['medew']; ?>">Medewerker </a>: <label><?php echo $row_registratie['medew']; ?></label></p>
				<p><a href="index_1.php?gebouw=<?php echo $row_registratie['gebouw']; ?>">Gebouw </a>:  
				<?php
				$gebouw1 = $row_registratie['gebouw'];
				?>
			   <em><?php echo strtok( $gebouw1, -6); ?></em></p>
				
			</div>
			
			<div class="row">
				<div class="col-md-6 first-col right-alignment">
					<p>Ruimte : <input name="ruimte" maxlength="30" size="30" type="text" id="ruimte" value="<?php echo $row_registratie['ruimte']; ?>" /></p>
						 
					<p>*Prioriteit : 
						 
						<select name="prioriteit" id="prioriteit">
						<?php
							do {  
						?>
						<option value="<?php echo $row_prioriteit['prioriteit']?>"<?php if (!(strcmp($row_prioriteit['prioriteit'], $row_registratie['prioriteit']))) {echo "selected=\'selected\'";} ?>> 
						<?php echo $row_prioriteit['prioriteit']?>
						  </option>
						<?php
							} while ($row_prioriteit = mysqli_fetch_assoc($prioriteit));
							  $rows = mysqli_num_rows($prioriteit);
							  if($rows > 0) {
								  mysqli_data_seek($prioriteit, 0);
								  $row_prioriteit = mysqli_fetch_assoc($prioriteit);
							  }
						?>
						</select></p>
						
				
					<p>*Apparatuur :  <input name="app" type="text" id="app" value="<?php echo $row_registratie['app']; ?>" /></p>
					
					<p>*Korte Omschrijving : 
					<input name="omsch_kort" size="45" maxlength="40" id="omsch_kort" value = "<?php echo $row_registratie['omsch_kort']; ?>"/></p>
					
				</div>
				
				<div class="col-md-6 second-col right-alignment">
					<div class = "low_priority">
						<p>Gemeld Door : <label><input name="melder" maxlength="30" size="25" type="text" id="melder" value="<?php echo $row_registratie['melder']; ?>" placeholder = "(Indien anders dan iemand bij BIO)"/> </label></p>
						<p>Telefoonnummer : <input name="meld_tel" maxlength="15" size="15" type="text" id="meld_tel" value="<?php echo $row_registratie['meld_tel']; ?>" /></p>
						<p>Organistatie : <label> 
							<input name="meld_org" maxlength="30" size="25" type="text" id="meld_org" value="<?php echo $row_registratie['meld_org']; ?>" />
							</label> </p>
					<!--	<p>Direct actie ondernomen door : <em><?php echo $row_registratie['medew_actie']; ?></em></p></label>-->
					</div>
				</div>
			</div>
			</br>
			<div> 
				

			</div>
			</br>
			<div> 
				<p><strong>Omschrijving : </strong></p>
				<p> 
					<label> 
					<textarea name="omschrijving" cols="115" rows="5" id="omschrijving"><?php echo $row_registratie['omschrijving']; ?></textarea>
					</label>
				  </p>
			</div>
			</br>
			<div> 
				<p><strong>Voortgang : </strong></p>
				<label>
				<textarea name="bedrijf_plan" cols="115" rows="10" id="bedrijf_plan"><?php echo $row_registratie['bedrijf_plan']; ?></textarea>
				</label>
			</div>
			</br>
			<div style="width:80%; display:flex; justify-content: space-between"> 
				<p><a href="index_1.php?td_new=<?php echo $row_registratie['td_new']; ?>">Toegewezen aan : </a>
				 <label>
						<select name="td_new" id="td_new">
						
						  <option value=" " <?php if (!(strcmp(" ", $row_registratie['td_new']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						  <?php
							do {  
							?>
								 <option value="<?php echo $row_medew_user['name'];?>"<?php if (!(strcmp($row_medew_user['name'], $row_registratie['td_new']))) {$td_old = $row_registratie['td_new']; echo "selected=\"selected\"";}
								 else{$td_old = $row_registratie['td'];} ?>> 
								<?php echo $row_medew_user['name'];?>
								</option>
								<?php
									} while ($row_medew_user = mysqli_fetch_assoc($medew_user));
									$rows_user = mysqli_num_rows($medew_user);
									if($rows_user > 0) {
										mysqli_data_seek($medew_user, 0);
										$row_medew_user = mysqli_fetch_assoc($medew_user);
									}
								?>
							
						</select></label></p>
						<input style="display:none" name="td" id="td" value="<?php echo $td_old ?>" />
				<!--<em><small>(hier invullen wie actie onderneemt)</small></em>-->
				<!--<p>Uren TD : </p>
				<p align="left"><label><input name="td_uren" type="text" id="td_uren2" value="<?php echo $row_registratie['td_uren']; ?>" /></label>
				</p>-->
				<p>Klaar :
						<select name="afgehandeld" id="afgehandeld">
						  <option value="nee" <?php if (!(strcmp("nee", $row_registratie['afgehandeld']))) {echo "selected=\"selected\"";} ?>>nee</option>
						  <option value="ja" <?php if (!(strcmp("ja", $row_registratie['afgehandeld']))) {echo "selected=\"selected\"";} ?>>ja</option>
						</select>
					</p>
			</div>
			</br>
			<div class="admin-control">
				<p><strong>Opdracht Derden : </strong></p>
				<div id="derden"> 
					<p>Opdracht Verstrekt Door : 
						<label> 
						<select name="bedrijf_opdr" id="bedrijf_opdr">
						  <option value="" <?php if (!(strcmp("", $row_registratie['bedrijf_opdr']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						  <?php
							do {  
							?>
											  <option value="<?php echo $row_medew['name']?>"<?php if (!(strcmp($row_medew['name'], $row_registratie['bedrijf_opdr']))) {echo "selected=\"selected\"";} ?>> 
											  <?php echo $row_medew['name']?>
											  </option>
											  <?php
							} while ($row_medew = mysqli_fetch_assoc($medew));
							  $rows = mysqli_num_rows($medew);
							  if($rows > 0) {
								  mysqli_data_seek($medew, 0);
								  $row_medew = mysqli_fetch_assoc($medew);
							  }
							?>
						</select>
						</label>
					</p>
					<p>Op : <label><input name="bedrijf_datum" type="text" id="bedrijf_datum" value="<?php echo $row_registratie['bedrijf_datum']; ?>" /></label></p>
					<p>Aan Bedrijf : 
						<select name="bedrijf" id="bedrijf">
						  <option value="" <?php if (!(strcmp("", $row_registratie['bedrijf']))) {echo "selected=\"selected\"";} ?>>kies...</option>
						  <?php
							do {  
							?>
											  <option value="<?php echo $row_bedrijven['bedrijf']?>"<?php if (!(strcmp($row_bedrijven['bedrijf'], $row_registratie['bedrijf']))) {echo "selected=\"selected\"";} ?>> 
											  <?php echo $row_bedrijven['bedrijf']?>
											  </option>
											  <?php
							} while ($row_bedrijven = mysqli_fetch_assoc($bedrijven));
							  $rows = mysqli_num_rows($bedrijven);
							  if($rows > 0) {
								  mysqli_data_seek($bedrijven, 0);
								  $row_bedrijven = mysqli_fetch_assoc($bedrijven);
							  }
							?>
						</select>
					</p>
				</div>
			
				<p><strong>Controle : </strong></p>
			
				<div class = "row" >
					
					<p class = "col-md-3">Controle : 
						
						<select name="controle" id="controle">
						  <option value="nee" <?php if (!(strcmp("nee", $row_registratie['controle']))) {echo "selected=\"selected\"";} ?>>nee</option>
						  <option value="ja" <?php if (!(strcmp("ja", $row_registratie['controle']))) {echo "selected=\"selected\"";} ?>>ja</option>
						</select>
					  </p>
					<p class = "col-md-4">Kostenplaats : 
						<?php
							// $kostenplaats = $row_gebouwen['gebouw'];
							 //echo substr( $kostenplaats, -3); 
							 echo $row_gebouwen['kostenpl'];
						?>
					</p>
					
					<p class = "col-md-5" >Controle door : 
					<label> 
					<select name="medew_controle" id="medew_controle">
					<option value="" <?php if (!(strcmp("", $row_registratie['medew_controle']))) {echo "selected=\"selected\"";} ?> >kies...</option>
					<?php do {	?>
					<option value="<?php echo $row_medew['name']?>"<?php if (!(strcmp($row_medew['name'], $row_registratie['medew_controle']))) {echo "selected=\"selected\"";} ?>> 
					<?php echo $row_medew['name']?>
					</option>
					<?php
						} while ($row_medew = mysqli_fetch_assoc($medew));
						  $rows = mysqli_num_rows($medew);
						  if($rows > 0) {
							  mysqli_data_seek($medew, 0);
							  $row_medew = mysqli_fetch_assoc($medew);
						  }
						?>
					</select>
					</label>
					</p>
					<?php echo display_error(); ?>
				</div>
<script>
    $('#controle').change(function(){
        if($('#controle').val() == 'ja') {
            $('#medew_controle').attr('required', ''); 
        } else {
            $('#medew_controle').removeAttr('required'); 
        } 
    });
</script>
			</div> <!--admin-control-->	
			</br>
			<div type="hidden">
			
				<p><input type="hidden" name="MM_insert" value="new_reg"/></p>
				<input type="hidden" name="MM_update" value="reg" />
				<input type="hidden" name="datum2" value="<?php echo $datumNu; ?>" />
				<input type="hidden" name="reg_ID" value="<?php echo $row_registratie['reg_ID']; ?>" />
				<input type="hidden" name="MM_update" value="reg" />
			</div>
			</br>
			<p align="center"><strong> Registratie Nummer : <?php echo $row_registratie['reg_ID']; ?></strong></p>	
			
		</form>
	</div>
</body>

</html>
<?php
mysqli_free_result($medew);

mysqli_free_result($registratie);

mysqli_free_result($prioriteit);

mysqli_free_result($gebouwen);

mysqli_free_result($bedrijven);
?>