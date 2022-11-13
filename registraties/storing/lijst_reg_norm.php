<!-- Filename - registraties\storing\lijst_reg_norm.php
This file is included in index_1.php as a link in nav bar.

preceeding links -  Landing page - index_1.php
proceeding links -  
Nieuw reg,
Nr.data,  
sort by links-nr,datum,gebouw,medewerker, prioritiet
alles - display all previous data
removed files-
	registraties\storing\lijst_nr.php and ..lijst_nr2.php and ..lijst_all_nr.phpand .. lijst_all_nr2.php
	registraties\storing\lijst_reg_norm2.php
	registraties\storing\lijst_gebouw.php and ..lijst_all_gebouw.php and ..lijst_all_gebouw.php
	registraties\storing\lijst_td.php and ..lijst_all_td.php
	registraties\storing\lijst_prioriteit.php and ..lijst_all_prioriteit.php 
	registraties\storing\lijst_all.php and lijst_all2.php and lijst_all_bedrijf.php
-->

<?php 

//check if link to 'see all records' is clicked or not.

if(isset($_GET['allereg'])){
	$all_reg = $_GET['allereg'];
	if($all_reg =='alles'){
		$query_list_all = "SELECT * FROM reg_storing ORDER BY datum DESC";
	}elseif(empty($all_reg) or ($all_reg == 'nietalles')){
		$query_list_all = "SELECT * FROM reg_storing WHERE controle = 'nee' ORDER BY datum DESC";
	}
	
}else{
	
	$all_reg = '';
	$query_list_all = "SELECT * FROM reg_storing WHERE controle = 'nee' ORDER BY datum DESC";
}
$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);

//Fill the data from the database



//Get the page parameter from the url for order by variable(link = $li) and sort(sort= $sort) direction
//check for sort variable

if(isset($_GET['sort'])){
	$sort = $_GET['sort'];
}else{
	$sort = 'ASC';
}
if(isset($_GET['td_new'])){
	$medewerker = $_GET['td_new'];
	$query_list_all = "SELECT * FROM reg_storing WHERE td_new = '$medewerker'  AND controle = 'nee'";
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

?>
<script>
 function changeName(o,f){
	 document.getElementById('btnToChange').name = o;
	 document.getElementById('btnToChange').setAttribute('form', f);
    }
</script>
<!--Start of the table heading and content-->
	<div class="row storing-header">
		<div class ="col-md-4">
			<button style = "padding:5px;" class="btn btn-primary" type="button"><a style="color:white" href="#" data-href="registraties\storing\nieuw_reg.php" name ="newregdata" value = "New Reg Data" onclick="changeName('newregdata','new_reg')" class="openPopup" value ="newregdata">Nieuw Registratie</a></button>
		</div>
		<div class ="col-md-4">
			<h4 id = "content-heading">Storingen & Reparaties</h4>
			<h6>Aantal Registraties: <?php echo $totalRows_list_all ?></h6>
		</div>
		<div class ="col-md-4">
			<button id = "jobsNotAssigned" style = "margin:5px;float:right; padding:5px;" class="table-ele btn btn-primary" type="button"><a style="color:white" href="index_1.php?klaar=klaar_yes">Verholpen Storingen</a></button>
			<button id = "finishedJobs" style = "font-size: 12px;margin:5px;float:right; padding:5px;" class="table-ele btn btn-primary" type="button"><a style="color:white" href="index_1.php?assigned=notassigned">Storingen niet Toegewezen</a></button>
		</div>	
			<!--<a href="index_1.php?page=storing&&link=alles" class="small">(See All)</a>-->
	</div>
	
	<div class="row storing-table">
	<!--Start of the table-->
		<table class="fixed_header">
				<tr>
					<th class = "col-md-1"><a href="index_1.php?page=storing&&link=nr&&sort=<?php echo $sort?>">Nr.</a></th>
					<th class = "col-md-1"><a href="index_1.php?page=storing&&link=datum&&sort=<?php echo $sort?>">Datum</a></th>
					<th class = "col-md-1"><a href="index_1.php?page=storing&&link=gebouw&&sort=<?php echo $sort?>">Gebouw</a></th>
					<th class = "col-md-1">Apparatuur</th>
					<th class = "col-md-1">Korte Omschrijving</th>
					<th class = "col-md-1"><a href="index_1.php?page=storing&&link=medew&&sort=<?php echo $sort?>">Toegewezen aan</a></th>
					<th class = "col-md-1">Bedrijf</th>
					<th class = "col-md-1"><a href="index_1.php?page=storing&&link=prioriteit&&sort=<?php echo $sort?>">Prioriteit</a></th>
					<th class = "col-md-1"><a href="index_1.php?page=storing&&link=afgehandeld&&sort=<?php echo $sort?>">Klaar</a></th>
				</tr>
				<?php
				
				//create a json format for later use
				//Fill data in the list and in the modal
				//while ($row_list_all = mysqli_fetch_assoc($list_all))
				//{

				do {
					//Datum opmaken
					if (is_null($row_list_all['datum'])) {
						break;
						$date = '';
					} else {
						$date = date("d-m-Y", strtotime($row_list_all['datum']));
					}
					
					
				?>
				<tr style ="table-layout: fixed; width:100%; height:50px; border: 1px solid orange; background:#8ca3a3">
					<td class = "col-md-1">	
					<a href="#" name ="updatedata" value = "Update Data" onclick="changeName('updatedata','reg')" data-href="registraties\storing\registratie.php?reg_ID=<?php echo $row_list_all['reg_ID'];?>"  class="openPopup"><?php echo $row_list_all['reg_ID'];?></a>
					</td>
					<td class = "col-md-1"><?php echo $date; ?></td>
					<td class = "col-md-1"><?php echo substr($row_list_all['gebouw'], 0, 35); ?> </td>
					<td class = "col-md-1"><?php echo substr($row_list_all['app'], 0, 15); ?>    </td>
					<td style = "word-break: break-all;" class = "col-md-1"><?php echo substr($row_list_all['omsch_kort'], 0, 35); ?> </td>
					<td class = "col-md-1"><?php echo substr($row_list_all['td_new'], 0, 35); ?></td>
					<td class = "col-md-1"><?php echo substr($row_list_all['bedrijf'], 0, 35); ?></td>
					<td class = "col-md-1"><?php echo $row_list_all['prioriteit']; ?></td>
					<td class = "col-md-1"><?php echo $row_list_all['afgehandeld']; ?></td>
				</tr>
				<?php
				}while ($row_list_all = mysqli_fetch_assoc($list_all)); 
				?>	
		</table>
	</div>	

	<!--End of the table heading and content-->
		<!-- Modal for registraties (when you click on Nr(data) -->
			<div class="modal fade" data-backdrop="static" data-keyboard = "false" id="myModal_storing" tabindex="-1" role="dialog" aria-labelledby="registratie_title" aria-hidden="true">
				<div  class="modal-xl modal-dialog modal-dialog-centered" role="document" >
					<div  class="modal-content modal-dialog modal-xl">
						<div  class="modal-header" style="background-color:#5F9EA0">
							<h5 class="modal-title w-100 text-center" id="registratie_title"><strong>Storingen &amp; Reparaties</strong> -  Registratie</h5>
							<button data-toggle="modal" type="reset" onclick="window.location.reload();" class="close" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div id="printContent" class="modal-body">
						</div>
						<div class="modal-footer">
							<!--Only one submit button required-->
							<!--<input class="printOnClick" type="button" value="click">-->
							<input  style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="submit" form ="reg" id = "btnToChange" name = "updatedata" onclick="enableDisable(); " value="Opslaan"/>
							
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
            $('#myModal_storing').modal({show:true});
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