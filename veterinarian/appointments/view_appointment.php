<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
$output = '';
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM appointments WHERE id = '$id'";
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
						<input type="text" class="form-control" id="client_service" value="'.$row['service'].'" placeholder=="'.$row['service'].'" disabled>
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
						<label for="client_payment">Payment Status</label>
						<select class="form-control" id="client_payment">
						<option value= "'.$row['payment_status'].'" selected disabled>'.ucfirst($row['payment_status']).'</option>
							<option value= "unpaid">Unpaid</option>
							<option value= "paid">Paid</option>
						</select>
					</div>			
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="form-group">
						<label for="client_status">Payment Status</label>
						<select class="form-control" id="client_status">
							<option value= "'.$row['status'].'" selected disabled>'.ucfirst($row['status']).'</option>
							<option value= "scheduled">Scheduled</option>
							<option value= "rescheduled">Rescheduled</option>
							<option value= "pending">Pending</option>
							<option value= "scheduled">Scheduled</option>
							<option value= "done">Done</option>
						</select>
					</div>			
				</div>
			</div>	
		';
	}
	echo $output;
}
?>

