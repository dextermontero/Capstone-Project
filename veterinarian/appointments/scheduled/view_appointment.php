<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
$output = '';
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT appointments.*, services.service_title, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		$row = $result -> fetch_assoc();
		$output .= '
			<div class="row">
				<span id="app_id" hidden>'.$row['id'].'</span>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="client_name">Client Name</label>
						<input type="text" class="form-control" id="client_name" value="'.$row['c_fullname'].'" placeholder=="'.$row['c_fullname'].'" disabled>
					</div>					
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="client_service">Service</label>
						<input type="text" class="form-control" id="client_service" value="'.$row['service_title'].'" placeholder=="'.$row['service_title'].'" disabled>
					</div>					
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="client_date">Date</label>
						<input type="text" class="form-control" id="client_date" value="'.date("F d, Y", strtotime($row['date'])).'" placeholder=="'.date("F d, Y", strtotime($row['date'])).'" disabled>
					</div>					
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="client_time">Time</label>
						<input type="text" class="form-control" id="client_time" value="'.$row['timeslot'].'" placeholder=="'.$row['timeslot'].'" disabled>
					</div>					
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="branches">Branch</label>
						<input type="text" class="form-control branches" id="'.$row['branch_id'].'" value="'.ucfirst($row['name']).'" placeholder=="'.$row['name'].'" disabled>
					</div>					
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="client_status">Status</label>
						<select class="form-control" id="client_status">
							<option selected disabled>Select Status</option>
							<option value= "scheduled">Scheduled</option>
							<option value= "pending">Pending</option>
						</select>
					</div>			
				</div>
			</div>';
	}
	echo $output;
}
?>

