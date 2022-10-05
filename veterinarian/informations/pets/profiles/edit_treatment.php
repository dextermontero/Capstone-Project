<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

$output = '';

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM pet_treatment_records WHERE treatment_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		
		if($row['n_procedure'] == '' || $row['n_procedure'] == null){
			$output .= '
			<form action="" method="POST">
				<div class="row">
					<span id="etreatment_id" hidden>'.$row['treatment_id'].'</span>
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="etreatment_title">Treatment</label>
							<input type="text" class="form-control" id="etreatment_title" placeholder="Enter Treatment Title" value="'.ucfirst($row['treatment']).'">
						</div>
					</div>
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="ef_procedure">First Procedure</label>
							<textarea class="form-control"  id="ef_procedure" placeholder="Enter F Procedure" rows="3">'.ucfirst($row['f_procedure']).'</textarea>
						</div>									
					</div>				
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="etreatment_cost">Treatment Cost</label>
							<input type="text" class="form-control" id="etreatment_cost" placeholder="Enter Treatment Cost" value="'.$row['service_cost'].'">
						</div>									
					</div>					
				</div>
			</form>
			<script>
			$("#etreatment_cost").keypress(function(e) {
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if ((event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
			});		
			</script>
			
			';			
		}else{
			$output .= '
			<form action="" method="POST">
				<div class="row">
					<span id="etreatment_id" hidden>'.$row['treatment_id'].'</span>
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="etreatment_title">Treatment</label>
							<input type="text" class="form-control" id="etreatment_title" placeholder="Enter Treatment Title" value="'.ucfirst($row['treatment']).'">
						</div>
					</div>
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="ef_procedure">First Procedure</label>
							<textarea class="form-control"  id="ef_procedure" placeholder="Enter F Procedure" rows="3">'.ucfirst($row['f_procedure']).'</textarea>
						</div>									
					</div>
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="en_procedure">Next Procedure</label>
							<textarea class="form-control"  id="en_procedure" placeholder="Enter Next Procedure" rows="3">'.ucfirst($row['n_procedure']).'</textarea>
						</div>									
					</div>				
					<div class="col-lg-12 col-12">
						<div class="form-group">
							<label for="etreatment_cost">Treatment Cost</label>
							<input type="text" class="form-control" id="etreatment_cost" placeholder="Enter Treatment Cost" value="'.$row['service_cost'].'">
						</div>									
					</div>					
				</div>
			</form>
			<script>
			$("#etreatment_cost").keypress(function(e) {
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if ((event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
			});		
			</script>
			
			';			
			
		}
	}
	echo $output;
}

?>