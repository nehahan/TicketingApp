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
$query_bedrijven = "SELECT * FROM reg_bedrijven ORDER BY bedrijf ASC";
$bedrijven = mysqli_query($connect_storing, $query_bedrijven) or die(mysqli_error($connect_storing));
$row_bedrijven = mysqli_fetch_assoc($bedrijven);
$totalRows_bedrijven = mysqli_num_rows($bedrijven);



?>
<script>
 function changeName(o,f){
	 document.getElementById('btnToChange_bedrijf').name = o;
	 document.getElementById('btnToChange_bedrijf').setAttribute('form', f);
    }
</script>
	<div class="row storing-header">
		<div class ="col-md-4">
			<button style = "padding:5px;" class="btn btn-primary" type="button"><a style="color:white" href="#" data-href="registraties\beheer\nieuw_bedrijf.php" name ="newbedrijf" value = "newbedrijf" onclick="changeName('newbedrijf','new_bedrijf')" class="openPopup" value ="newbedrijf">Nieuw Bedrijf</a></button>
		</div>
		<div class ="col-md-4">
			<h4 id = "content-heading">Storingen & Reparaties-lijst Bedrijven</h4>
		</div>
		<div class ="col-md-4">
			<p class="small">Aantal Registraties: <?php echo $totalRows_bedrijven ?></p>
		</div>	
			<!--<a href="index_1.php?page=storing&&link=alles" class="small">(See All)</a>-->
	</div>
	<div class="row storing-table">
	<!--Start of the table-->
		<table class="fixed_header">
				<tr>
					<th style="width:20%">Naam</th>
					<th style="width:10%">Telefoon</th>
					<th style="width:20%">E-mail</th>
					<th style="width:20%">Contactpersoon 1</th>
					<th style="width:10%">Contactpersoon 2</th>
					<th style="width:15%">Zichtbaar</th>
				</tr>				
					<?php
					
					//create a json format for later use
					//Fill data in the list and in the modal
					//while ($row_list_all = mysqli_fetch_assoc($list_all))
					//{

					do {
						//Datum opmaken
						
						
					?>
					<tr style ="height:50px; border: 1px solid orange; background:#f8dcd3">
					
					<td style="width:20%"><a href="#" name ="updatebedrijf" value = "Update Bedrijf" onclick="changeName('updatebedrijf','update_bedrijf')" data-href="registraties/beheer/bedrijf.php?bedrijf=<?php echo $row_bedrijven['bedrijf_ID']; ?>"  class="openPopup"><?php echo $row_bedrijven['bedrijf']; ?></a></td>
					<td style="width:10%"><?php echo $row_bedrijven['telefoon']; ?></td>
					<td style="width:20%"><a href="mailto:<?php echo $row_bedrijven['email']; ?>"><?php echo $row_bedrijven['email']; ?></a></td>
					<td style="width:20%"><?php echo $row_bedrijven['cont_pers1']; ?></td>
					<td style="width:10%"><?php echo $row_bedrijven['cont_pers2']; ?></td>
					<td style="width:15%"><?php echo $row_bedrijven['zichtbaar']; ?></td>
					</tr>
					
					<?php } while ($row_bedrijven = mysqli_fetch_assoc($bedrijven)); ?>
		</table>
	</div>	
		<!-- Modal for registraties (when you click on Nr(data) -->
			<div class="modal fade" data-backdrop="static" data-keyboard = "false" id="myModal_bedrijf" tabindex="-1" role="dialog" aria-labelledby="registratie_title" aria-hidden="true">
				<div class="modal-xl modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content modal-dialog modal-xl">
						<div class="modal-header" style="background-color:#5F9EA0">
							<h5 class="modal-title w-100 text-center" id="registratie_title"><strong>Storingen & Reparaties</strong> -  Bedrijf</h5>
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
							<input  style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="submit" form ="reg" id = "btnToChange_bedrijf" name = "updatedata" onclick="enableDisable(); window.location.reload();"/>
							
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
            $('#myModal_bedrijf').modal({show:true});
        });
    }); 
});

</script>			  

<?php
mysqli_free_result($bedrijven);
?>