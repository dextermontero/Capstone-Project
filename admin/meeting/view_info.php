<?php
require_once("../../include/initialize.php");
require_once('../../include/zoom-config.php');
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
$output = "";
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM appointments WHERE id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		$output .= '
		<form action="" method="POST">
			<span id="client_avail" hidden>'.$row['user_id'].'</span>
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="form-group">
						<label for="topic_meeting">Topic Meeting</label>
						<input type="text" class="form-control" id="topic_meeting" placeholder="Enter Topic Meeting" value="'.$row['service'].'" disabled>
					</div>
				</div>
				<div class="col-lg-6 col-6">
					<div class="form-group">
						<label for="date_meeting">Date Meeting</label>
						<input type="date" class="form-control" id="date_meeting" placeholder="Enter Topic Meeting" value="'.$row['date'].'" disabled>
					</div>							
				</div>
				<div class="col-lg-6 col-6">
					<div class="form-group">
						<label for="start_meeting">Start Meeting</label>
						<input type="time" class="form-control" id="start_meeting" placeholder="Enter Topic Meeting" value="'.date("H:i", strtotime($row['timeslot'])).'" disabled>
					</div>							
				</div>							
			</div>
		</form>	
		';
	}
	echo $output;
}
?>