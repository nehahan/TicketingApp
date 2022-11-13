<?php

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

mysqli_select_db($connect_storing, $database_connect_storing);
$query_medewerkers = "SELECT * FROM reg_medew ORDER BY name ASC";
$medewerkers = mysqli_query($connect_storing, $query_medewerkers) or die(mysqli_error($connect_storing));
$row_medewerkers = mysqli_fetch_assoc($medewerkers);
$totalRows_medewerkers = mysqli_num_rows($medewerkers);

?>
<script>
 function changeName(o,f){
	 document.getElementById('btnToChange_medewerker').name = o;
	 document.getElementById('btnToChange_medewerker').setAttribute('form', f);
    }
</script>
	<div class="row storing-header">
		<div class ="col-md-4">
		<?php  
						if($_SESSION['user']['user_type'] == "admin")	:?>
			<button style = "padding:5px;" class="btn btn-primary" type="button"><a style="color:white" href="#" data-href="registraties\beheer\nieuw_medewerker.php" name ="newmedewerker" value = "New Medewerker" onclick="changeName('newmedewerker','new_medewerker')" class="openPopup" value ="newmedewerker">Nieuw Mederwerker</a></button>
			<?php endif ?>
		</div>
	
		<div class ="col-md-4">
			<h4 id = "content-heading">Registraties algemeen - lijst Medewerkers</h4>
		</div>
		<div class ="col-md-4">
			<p class="small">Aantal Registraties: <?php echo $totalRows_medewerkers ?></p>
		</div>	
			<!--<a href="index_1.php?page=storing&&link=alles" class="small">(See All)</a>-->
	</div>
	<div class="row storing-table">
	<!--Start of the table-->
		<table class="fixed_header">

				<tr>
					<th style="width:20%">Naam</th>
					<th style="width:10%">User/Admin</th>
					<th style="width:10%">Controle</th>
					<th style="width:5%">Zichtbaar</th>
					<th style="width:15%">Tel.Intern</th>
					<th style="width:15%">Tel.Extern</th>
					<th style="width:20%">E-mail</th>
					
				</tr>	
					<?php
					
					//create a json format for later use
					//Fill data in the list and in the modal
					//while ($row_list_all = mysqli_fetch_assoc($list_all))
					//{

					do {
						//Datum opmaken
						
						
					?>
				<tr style ="height:50px; border: 1px solid orange; background:#D5F5E3">
					<td style="width:20%"><a href="#" name ="updatemedewerker" value = "Update Medewerker" onclick="changeName('updatemedewerker','update_medewerker')" data-href="registraties\beheer\medewerker.php?medew_ID=<?php echo $row_medewerkers['id']; ?>"  class="openPopup"><?php echo $row_medewerkers['name']; ?></a></td>
					<td style="width:10%"><?php echo $row_medewerkers['user_type']; ?></td>
					<td style="width:10%"><?php echo $row_medewerkers['RegControl']; ?></td>
					<td style="width:5%"><?php echo $row_medewerkers['zichtbaar']; ?></td>
					<td style="width:15%"><?php echo $row_medewerkers['TelIntern']; ?></td>
					<td style="width:15%"><?php echo $row_medewerkers['TelExtern']; ?></td>
					<td style="width:20%"><a href="mailto:<?php echo $row_medewerkers['email']; ?>"><?php echo $row_medewerkers['email']; ?></a></td>
					</tr>
					<?php } while ($row_medewerkers = mysqli_fetch_assoc($medewerkers)); ?>
		</table>
	</div>	
		<!-- Modal for registraties (when you click on Nr(data) -->
			<div class="modal fade" data-backdrop="static" data-keyboard = "false" id="myModal_medewerker" tabindex="-1" role="dialog" aria-labelledby="registratie_title" aria-hidden="true">
				<div class="modal-xl modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content modal-dialog modal-xl">
						<div class="modal-header" style="background-color:#5F9EA0">
							<h5 class="modal-title w-100 text-center" id="registratie_title"><strong>Storingen &amp; Reparaties</strong> -  Medewerkers</h5>
							<button data-toggle="modal" type="reset" 
							onclick="window.location.reload();"
							class="close" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
						</div>
						<div class="modal-footer">
							<!--Only one submit button required-->
							<input  style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="submit" form ="medewerker" id = "btnToChange_medewerker" name = "updatedata" onclick="enableDisable(); window.location.reload();" value="Opslaan"/>
							
							<input style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="reset" onclick ="window.location.reload();" value="Cancel"/>
						</div>
					</div>
				</div>
			</div>
			<!--Modal ends-->
			
<!--Script to open the form inside the modal. Passing the reg_Id throught data- attribute href.-->
			
<script>
$(document).ready(function(){
    $('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
        $('.modal-body').load(dataURL,function(){
            $('#myModal_medewerker').modal({show:true});
        });
    }); 
});

</script>			  

<?php
mysqli_free_result($medewerkers);
?>
