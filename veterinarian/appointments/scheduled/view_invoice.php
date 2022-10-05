<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
$output = '';

$randomNum = substr(str_shuffle("0123456789"), 0, 6);
$sql = "SELECT * FROM invoice WHERE invoice_ref = '$randomNum'";
$result = $conn->query($sql);
if($result -> num_rows >= 1){
	echo "<script>window.location.reload();</script>";
}
														
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT appointments.*, services.service_title, services.service_cost, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		$output .= "
		<table class='table table-striped table-borderless'> 
			<tbody>
				<tr hidden>
					<td></td>
					<td id='invoice_id'>".$row['id']."</td>
				</tr>
				<tr hidden>
					<td></td>
					<td id='invoice_userid'>".$row['user_id']."</td>
				</tr>
				<tr>
					<td>Invoice #</td>
					<td id='invoice_ref'>".$randomNum."</td>
				</tr>
				<tr>
					<td>Full Name</td>
					<td id='invoice_fullname'>".$row['c_fullname']."</td>
				</tr>
				<tr>
					<td>Pet Name</td>
					<td id='invoice_petname'>".$row['pet_name']."</td>
				</tr>
				<tr>
					<td>Service</td>
					<td id='invoice_service'>".ucfirst(strtolower($row['service_title']))."</td>
				</tr>
				<tr>
					<td>Branch</td>
					<td id='invoice_branch'>".$row['name']."</td>
				</tr>
				<tr>
					<td>Date</td>
					<td id='invoice_date'>".date("F d, Y", strtotime($row['date']))."</td>
				</tr>
				<tr>
					<td>Time</td>
					<td id='invoice_time'>".$row['timeslot']."</td>
				</tr>
				<tr>
					<td>Service Cost</td>
					<td id='invoice_cost'>".number_format($row['service_cost'])."</td>
				</tr>
			</tbody>
		</table>";
		
	}
	echo $output;
}
?>