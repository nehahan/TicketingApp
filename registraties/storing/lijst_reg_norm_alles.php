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

if(isset($_GET['medew'])){
	$medewerker = $_GET['medew'];
	$query_list_all = "SELECT * FROM reg_storing WHERE medew = '$medewerker' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
	echo 'list for ' . $medewerker;
}

if(isset($_GET['gebouw'])){
	$gebouw = $_GET['gebouw'];
	$query_list_all = "SELECT * FROM reg_storing WHERE gebouw = '$gebouw' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
	echo 'list for ' . $gebouw;
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
	case 'medew' : $li = 'td'; 
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
	/*
$( "#refresh_alarmmeldingen" ).click(function() {
  document.getElementById("main-heading").innerHTML = "Alarmmeldingen";
});*/
</script>
<!--Start of the table heading and content-->
	<div class="row storing-header">
		<div class ="col-md-4">
			<!--<button style = "padding:5px;" class="btn btn-primary" type="button"><a style="color:white" href="#" data-href="registraties\storing\nieuw_reg.php" name ="newregdata" value = "New Reg Data" onclick="changeName('newregdata','new_reg')" class="openPopup" value ="newregdata">Nieuw Registratie</a></button>-->
		</div>
		<div class ="col-md-4">
			<h4 id = "content-heading">Storingen & Reparaties</h4>
			<h6>Aantal Registraties: <?php echo $totalRows_list_all ?></h6>
		</div>
		<div class ="col-md-4">
			
		</div>	
			<!--<a href="index_1.php?page=storing&&link=alles" class="small">(See All)</a>-->
	</div>
	<div class="row storing-table">
	<!--Start of the table-->
		<table class="fixed_header">
				<tr>
					<th style="width:5%"><a href="index_1.php?page=storing_alles&&link=nr&&sort=<?php echo $sort?>&&allereg=alles">Nr.</a></th>
					<th style="width:10%"><a href="index_1.php?page=storing_alles&&link=datum&&sort=<?php echo $sort?>&&allereg=alles">Datum</a></th>
					<th style="width:10%"><a href="index_1.php?page=storing_alles&&link=gebouw&&sort=<?php echo $sort?>&&allereg=alles">Gebouw</a></th>
					<th style="width:10%">Apparatuur</th>
					<th style="width:10%">Korte Omschrijving</th>
					<th style="width:10%"><a href="index_1.php?page=storing_alles&&link=medew&&sort=<?php echo $sort?>&&allereg=alles">Toegewezen aan</a></th>
					<th style="width:10%">Bedrijf</th>
					<th style="width:10%"><a href="index_1.php?page=storing_alles&&link=prioriteit&&sort=<?php echo $sort?>&&allereg=alles">Prioriteit</a></th>
					<th style="width:5%"><a href="index_1.php?page=storing_alles&&link=afgehandeld&&sort=<?php echo $sort?>&&allereg=alles">Klaar</a></th>
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
				
				<tr style ="height:50px; border: 1px solid red; background:#cce6ff">
					<td style="width:5%">	
					<a href="#" name ="updatedata" value = "Update Data" onclick="changeName('updatedata','reg')" data-href="registraties\storing\registratie.php?reg_ID=<?php echo $row_list_all['reg_ID'];?>"  class="openPopup"><?php echo $row_list_all['reg_ID'];?></a>
					</td>
					<td style="width:10%"><?php echo $date; ?></td>
					<td style="width:10%"><?php echo substr($row_list_all['gebouw'], 0, 16); ?> </p></td>
					<td style="width:10%"><?php echo substr($row_list_all['app'], 0, 15); ?>    </p></td>
					<td style = "word-break: break-all; width:10%"><?php echo substr($row_list_all['omsch_kort'], 0, 35); ?> </p></td>
					<td style = "word-break: break-all; width:10%"><?php echo substr($row_list_all['td_new'], 0, 35); ?></p></td>
					<td style="width:10%"><?php echo substr($row_list_all['bedrijf'], 0, 15); ?></p></td>
					<td style="width:10%"><?php echo $row_list_all['prioriteit']; ?></p></td>
					<td style="width:5%"><?php echo $row_list_all['afgehandeld']; ?></p></td>
				</tr>
				<?php
				}while ($row_list_all = mysqli_fetch_assoc($list_all)); 
				?>	
		</table>
	</div>	
	<!--End of the table heading and content-->
		<!-- Modal for registraties (when you click on Nr(data) -->
			<div class="modal fade" data-backdrop="static" data-keyboard = "false" id="myModal_storing" tabindex="-1" role="dialog" aria-labelledby="registratie_title" aria-hidden="true">
				<div class="modal-xl modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content modal-dialog modal-xl">
						<div class="modal-header" style="background-color:#5F9EA0">
							<h5 class="modal-title w-100 text-center" id="registratie_title"><strong>Storingen &amp; Reparaties</strong> -  Registratie</h5>
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
							<input  style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="submit" form ="reg" id = "btnToChange" name = "updatedata" onclick="enableDisable(); window.location.reload();" value="Opslaan"/>
							
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
});

</script>

<?php
mysqli_free_result($list_all);
?>