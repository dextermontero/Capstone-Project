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
		
		$output .= '
		<form action="" method="POST">
			<div class="row">
				<span id="utreatment_id" hidden>'.$row['treatment_id'].'</span>
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label for="utreatment_title">Treatment</label>
						<input type="text" class="form-control" id="utreatment_title" placeholder="Enter Treatment Title">
					</div>
				</div>
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label for="uf_procedure">First Procedure</label>
						<textarea class="form-control"  id="uf_procedure" placeholder="Enter F Procedure" rows="3" disabled>'.ucfirst($row['f_procedure']).'</textarea>
					</div>									
				</div>
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label for="n_procedure">Next Procedure</label>
						<textarea class="form-control"  id="n_procedure" placeholder="Enter Next Procedure" rows="3"></textarea>
					</div>									
				</div>				
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label for="utreatment_cost">Treatment Cost</label>
						<input type="text" class="form-control" id="utreatment_cost" placeholder="Enter Treatment Cost">
					</div>									
				</div>
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label for="treatment_status">Past Treatment Status</label>
						<select class="form-control" id="treatment_status">
						<option selected disabled>-- Select Past Treatment Status</option>
							<option value= "ongoing">Ongoing</option>
							<option value= "done">Done</option>
						</select>
					</div>								
				</div>					
			</div>
		</form>
		<script>
		$("#utreatment_cost").keypress(function(e) {
			$(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});		
		</script>
		
		';
	}
	echo $output;
}

?>