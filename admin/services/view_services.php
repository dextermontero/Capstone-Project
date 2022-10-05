<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$branches = "";

$b = "SELECT branch_id, name FROM branch";
$bc = $conn->query($b);
if($bc -> num_rows > 0){
	while($rows = $bc -> fetch_assoc()){
		$branches .= '
			<option value="'.$rows['branch_id'].'">'.ucfirst($rows['name']).'</option>	
		';
	}
}else{
	$branches .= '<option selected disabled>-- No Branch data --</option>';
}


$output = '';

if(isset($_POST['sid'])){
	$sid = $_POST['sid'];
	$sql = "SELECT services.service_id, services.service_title, services.service_description, services.service_cost, services.service_photo, services.branch_id, branch.name FROM services LEFT JOIN branch ON branch.branch_id = services.branch_id WHERE services.service_id = '$sid' AND services.status = '1' AND services.archive_status = '0'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		while($row = $result -> fetch_assoc()){
			$branch_name = "";
			if($row['name'] == '' || $row['name'] == null){
				$branch_name .= 'All Branch';
			}else{
				$branch_name .= ucfirst($row['name']);
			}
			$output .= '
			<style type="text/css">
			#editIMG {
				height : 100%;
				width: 100%;
			}
			@media only screen and (max-width: 768px) { 
				#editIMG {
					height: 100%;
					width: 80%;
				}	
			}
			@media screen and (max-width: 800px) {
				#editIMG {
					height: 100%;
					width: 80%;
				}	
			}
			@media screen and (max-width: 1000px) {
				#editIMG {
					height: 100%;
					width: 80%;
				}
			}			
			</style>
			<form action="" method="POST">
				<div class="row">
					<span id="edit_service_id" hidden>'.$row['service_id'].'</span>
					<div class="col-lg-4 col-12" style="height:200px;margin-bottom:15%;">
						<img src="'.web_root.'dist/img/services/'.$row['service_photo'].'" class="img-fluid mx-auto d-block w-100" id="editIMG">
						<input type="file" class="form-control-file pt-3" accept="image/*" id="preveditIMG">
					</div>
					<div class="col-lg-8 col-12">
						<div class="form-group">
							<label for="service_title_edit">Service Title</label>
							<input type="text" class="form-control" id="service_title_edit" placeholder="Enter Service Title" value="'.$row['service_title'].'">
						</div>							
						<div class="form-group">
							<label for="service_description_edit">Service Description</label>
							<textarea class="form-control" id="service_description_edit" rows="5" placeholder="Enter Service Description">'.$row['service_description'].'</textarea>
						</div>
						<div class="form-group">
							<label for="branches">Branch</label>
							<select class="form-control" id="branches">
								<option value="'.$row['branch_id'].'" selected>'.$branch_name.'</option>
								<option value="all">All Branch</option>
								'.$branches.'
							</select>
						</div>						
						<div class="form-group">
							<label for="service_cost_edit">Service Cost</label>
							<input type="text" class="form-control" id="service_cost_edit" placeholder="₱ 0" value="'.$row['service_cost'].'">
						</div>
					</div>
				</div>
			</form>
			<script>
				preveditIMG.onchange = evt => {
					const[file] = preveditIMG.files
					if(file) {
						editIMG.src = URL.createObjectURL(file);
					}
				}
				$("#service_cost_edit").keypress(function(e) {
					$(this).val($(this).val().replace(/[^\d].+/, ""));
					if ((event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});	

				var myInput = document.getElementById("service_cost_edit");
				myInput.onpaste = e => e.preventDefault();				
			</script>
			';
		}
		echo $output;
	}
}

?>