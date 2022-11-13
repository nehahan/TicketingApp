<!-- Filename - registraties\alarm\lijst_alarm_norm.php
This file is included in index_1.php as a link in nav bar.

preceeding links -  Landing page - index_1.php
proceeding links -  
Nieuw melding,
Nr.alarm,  
sort by links-nr,datum,gebouw,medewerker, prioritiet
alles - to display all previous alarm data
files removed after sort incorporated successfully-
files to be removed or removed (check readme file)from registraties/alarm are-
Kopie van lijst_alarm_gebouw_all.php
lijst_alarm_all.php
lijst_alarm_gebouw_all.php
lijst_alarm_gebouw.php
-->

<?php 

mysqli_select_db($connect_storing,$database_connect_storing);
$query_list_all = "SELECT * FROM reg_alarm WHERE controle = 'nee' ORDER BY datum DESC";
$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error());
$row_list_all = mysqli_fetch_assoc($list_all);
$totalRows_list_all = mysqli_num_rows($list_all);


//Get the page parameter from the url for order by variable(link = $li) and sort(sort= $sort) direction
//check for sort variable
if(isset($_GET['sort'])){
	$sort = $_GET['sort'];
}else{
	$sort = 'ASC';
}

//check for order by variable
if(isset($_GET['link'])){
	if($_GET['link'] == 'alles'){
		$query_list_all = "SELECT * FROM reg_alarm ORDER BY datum DESC";
	}else{
		switch($_GET['link']){
			case 'nr' : $li = 'alarm_ID'; 
					break;
			case 'datum' : $li = 'datum'; 
					break;
			case 'gebouw' : $li = 'gebouw'; 
					break;
			case 'medew' : $li = 'td'; 
					break;
			case 'prioriteit' : $li = 'prioriteit'; 
					break;
		}
		$query_list_all = "SELECT * FROM reg_alarm WHERE controle = 'nee' ORDER BY $li $sort";
	}
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
}

//$unixtime = strtotime($blog['datum']); 
//toggle sort by varaible
$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

//$unixtime = strtotime($blog['datum']);

if(isset($_GET['medew'])){
	$medewerker = $_GET['medew'];
	$query_list_all = "SELECT * FROM reg_alarm WHERE medewerker = '$medewerker' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
	//echo 'list for ' . $medewerker;
}

if(isset($_GET['gebouw'])){
	$gebouw = $_GET['gebouw'];
	$query_list_all = "SELECT * FROM reg_alarm WHERE gebouw = '$gebouw' ORDER BY datum DESC";
	$list_all = mysqli_query($connect_storing, $query_list_all) or die(mysqli_error($connect_storing));
	$row_list_all = mysqli_fetch_assoc($list_all);
	$totalRows_list_all = mysqli_num_rows($list_all);
	
}

?>
<script>
 function changeName(o,f){
	 document.getElementById('btnToChange_1').name = o;
	 document.getElementById('btnToChange_1').setAttribute('form', f);
    }
</script>
<!--Start of the table heading and content-->

<!--Start of the table heading and content-->
	<div class="row storing-header">
		<div class ="col-md-4">
			<button style = "border: 1px solid red;padding:5px;background-color:#f4a688" class="btn btn-primary" type="button"><a style="color:white" href="#" data-href="registraties\alarm\nieuw_alarmmelding.php" name ="newalarmmelding" onclick="changeName('newalarmmelding','new_alarmmelding')" class="openPopup" value ="newalarmmelding">Nieuw Alarmmelding</a></button>
		</div>
		<div class ="col-md-4">
			<h4 id = "content-heading">Alarm Registraties</h4>
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
					<th style="width:5%"><a href="index_1.php?page=alarm&&link=nr&&sort=<?php echo $sort?>">Nr.</a></th>
					<th style="width:10%"><a href="index_1.php?page=alarm&&link=datum&&sort=<?php echo $sort?>">Datum</a></th>
					<th style="width:5%"><a href="?page=alarm&&link=gebouw&&sort=<?php echo $sort?>">AL_Gebouw</a></th>
					<th style="width:15%">Ruimte</th>
					<th style="width:15%">Soort melding</th>
					<th style="width:15%">Melding door</th>
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
				<tr style ="height:50px; border: 1px solid red; background:#f4a688">
				
					<td style="width:5%">
					<a href="#" name ="updatealarm" value = "Update Alarm" onclick="changeName('updatealarm','alarm')" data-href="registraties\alarm\alarmmelding.php?alarm_ID=<?php echo $row_list_all['alarm_ID'];?>"  class="openPopup"><?php echo $row_list_all['alarm_ID']; ?></a></td>
					<td style="width:10%"><?php echo $date; ?></td>
					<td style="width:5%"><?php echo substr($row_list_all['gebouw'], 0, 50); ?> </p></td>
					<td style="width:15%"><?php echo substr($row_list_all['ruimte'], 0, 15); ?>    </p></td>
					<td style="width:15%"><?php echo substr($row_list_all['melding_soort'], 0, 35); ?> </p></td>
					<td style="width:15%"><?php echo substr($row_list_all['medewerker'], 0, 20); ?></p></td>
				</tr>

				<?php
			/*}*/
			} while ($row_list_all = mysqli_fetch_assoc($list_all));
			?>
			
		</table>
	</div>	
	<!--End of the table heading and content-->
		<!-- Modal for registraties (when you click on Nr(data) -->
			<div class="modal fade" data-backdrop="static" data-keyboard = "false" id="myModal_alarm" tabindex="-1" role="dialog" aria-labelledby="alarm_title" aria-hidden="true">
				<div class="modal-xl modal-dialog modal-dialog-centered" role="document" >
					<div class="modal-content modal-dialog modal-xl">
						<div class="modal-header" style="background-color:#F8C471">
							<h5 class="modal-title w-100 text-center" id="alarm_title"><strong>Alarmmeldingen- Alarm Melding</strong> -  Registratie</h5>
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
							<input  style="white-space: normal;word-wrap: break-word;font-size:14px; padding:1px;" class="btn btn-primary" type="submit" form ="alarm" id = "btnToChange_1" name = "updatealarm" value="Opslaan" />
							
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
            $('#myModal_alarm').modal({show:true});
        });
    }); 
});

</script>

<?php
mysqli_free_result($list_all);
?>



