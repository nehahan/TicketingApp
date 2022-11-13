
<?php 

//check if link to 'see all records' is clicked or not.

if(isset($_GET['allereg'])){
	$all_reg = $_GET['allereg'];
	if($all_reg =='alles'){
		$query_list_all = "SELECT * FROM reg_incident ORDER BY datum DESC";
	}elseif(empty($all_reg) or ($all_reg == 'nietalles')){
		$query_list_all = "SELECT * FROM reg_incident ORDER BY datum DESC";
	}
	
}else{
	
	$all_reg = '';
	$query_list_all = "SELECT * FROM reg_incident ORDER BY datum DESC";
}
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);

//Fill the data from the database



//Get the page parameter from the url for order by variable(link = $li) and sort(sort= $sort) direction
//check for sort variable
/*
if(isset($_GET['sort'])){
	$sort = $_GET['sort'];
}else{
	$sort = 'ASC';
}

if(isset($_GET['td_new'])){
	$medewerker = $_GET['td_new'];
	$query_list_all = "SELECT * FROM reg_storing WHERE td_new = '$medewerker'  AND controle = 'nee' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
}

if(isset($_GET['klaar'])){
	$medewerker = $_GET['klaar'];
	$query_list_all = "SELECT * FROM reg_storing WHERE afgehandeld = 'ja' AND controle = 'nee' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
}
/*on submitting the form "reg" td_new was filled as NULL , hence the check on td_new for NULL*/
/*
if(isset($_GET['assigned'])){
	$query_list_all = "SELECT * FROM reg_storing WHERE (td_new = '' OR td_new is NULL) AND controle = 'nee' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
}


if(isset($_GET['medew'])){
	$medewerker = $_GET['medew'];
	$query_list_all = "SELECT * FROM reg_storing WHERE medew = '$medewerker' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
	//echo 'list for ' . $medewerker;
}

if(isset($_GET['gebouw'])){
	$gebouw = $_GET['gebouw'];
	$query_list_all = "SELECT * FROM reg_storing WHERE gebouw = '$gebouw' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
	
}
*//*
//check for order by variable
if(isset($_GET['link'])){
	switch($_GET['link']){
	case 'nr' : $li = 'reg_ID'; 
			break;
	case 'datum' : $li = 'datum'; 
			break;
	case 'gebouw' : $li = 'gebouw'; 
			break;
	case 'medew' : $li = 'td_new'; 
			break;
	case 'prioriteit' : $li = 'prioriteit'; 
			break;
	case 'afgehandeld' : $li = 'afgehandeld'; 
			break;
	}	
	if($all_reg == 'alles'){
		$query_list_all = "SELECT * FROM reg_storing ORDER BY $li $sort";
	}elseif(empty($all_reg) or $all_reg == 'nietalles'){
		$query_list_all = "SELECT * FROM reg_storing WHERE controle = 'nee' ORDER BY $li $sort";
	}
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
}

//toggle sort by varaible
$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';
*/
?>
<script>
 function changeName(o,f){
	 document.getElementById('btnToChange').name = o;
	 document.getElementById('btnToChange').setAttribute('form', f);
    }
</script>
<!--Start of the table heading and content-->
	<div class="row storing_header_incidents">
		<div class ="col-md-4">
			<button style = "padding:5px;background-color:#c0ded9;border: 1px solid red" class="btn btn-primary" type="button"><a style="color:black" href="#" data-href="registraties\incidents\nieuw_incident.php"  value = "New Incident Data" onclick="changeName('newincidentdata','new_incident')" class="openPopup" value ="newincidentdata">Nieuw Calamiteit</a></button>
		</div>
		<div class ="col-md-4">
			<h4 id = "content-heading">Calamiteiten</h4>
			<h6>Aantal Calamiteiten: <?php echo $totalRows_list_all ?></h6>
		</div>
	</div>
	
	<div class="row storing_table_incidents">
	<!--Start of the table-->
		<table class="fixed_header_incidents">
				<tr>
					<th>Nr.</th>
					<th>Datum</th>
					<th>Locatie</th>
					<th>Aard/Calamiteit</th>
					<th>Melder</th>
				</tr>
				<?php
					do {
						//Datum opmaken
						if (is_null($row_list_all['datum'])) {
							break;
						$date = '';
					} else {
						$date = date("d-m-Y", strtotime($row_list_all['datum']));
					}
				?>
				<tr style ="width:100%; height:50px; border: 1px solid red; background-color:#c0ded9">	
					<td>	
					<a href="#" name ="updateincident" value = "Update Incident" onclick="changeName('updateincident','update_incident')" data-href="registraties\incidents\incident.php?Incident_ID=<?php echo $row_list_all['Incident_ID'];?>"  class="openPopup"><?php echo $row_list_all['Incident_ID'];?></a>
					</td>
					<td><?php echo $date; ?></td>
					<td><?php echo $row_list_all['locatie']; ?></td>
					<td><?php echo $row_list_all['aard_incident']; ?></td>
					<td><?php echo $row_list_all['melder']; ?></td>
				</tr>
				<?php
					}while ($row_list_all = mysqli_fetch_assoc($list_all)); 
				?>	
		</table>
	</div>	
	<!--End of the table heading and content-->
		<!-- Modal for registraties (when you click on Nr(data) -->
			<div class="modal fade" data-backdrop="static" data-keyboard = "false" id="myModal_incidents" tabindex="-1" role="dialog" aria-labelledby="registratie_title" aria-hidden="true">
				<div class="modal-xl modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content modal-dialog modal-xl">
						<div class="modal-header" style="background-color:#c0ded9">
							<h5 class="modal-title w-100 text-center" id="registratie_title"><strong> Calamiteiten</strong></h5>
							<button data-toggle="modal" type="reset" onclick="window.location.reload();" class="close" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div id="printContent" class="modal-body">
						</div>
						<div class="modal-footer">
							<!--Only one submit button required-->
							 <button class="printOnClick" type="button"><img src="images\icons8-print-40.png" alt="Print" class="image"></button>
							 <!--<input class="printOnClick" type="button" value="Print">-->
							<input  style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="submit" form ="incident" id = "btnToChange" name = "updateincident" onclick="enableDisable(); " value="Opslaan"/>
							
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
            $('#myModal_incidents').modal({show:true});
        });
    }); 
	$('.printOnClick').on('click',function(){
		var printURL = document.getElementById("printContent").innerHTML;
		var a = window.open('', '', 'height=500, width=500');
        a.document.write(printURL);
		setTimeout(function(){
		a.document.close();
		a.print();}, 1000);
	});
	
});

</script>

<?php
mysqli_free_result($list_all);
?>