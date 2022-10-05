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
	$meetingID = $_POST['id'];
	$sql = "SELECT zoom_meeting.meeting_id, zoom_meeting.topic, zoom_meeting.link, zoom_meeting.password, zoom_meeting.date, zoom_meeting.time, user_profile.firstname, user_profile.lastname FROM zoom_meeting INNER JOIN user_profile ON zoom_meeting.to_client = user_profile.user_id WHERE meeting_id = '$meetingID'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		$fullname = ucfirst($row['firstname']).' '. ucfirst($row['lastname']);
		$output .= '
		<div class="row">
			<div class="col-lg-12 col-12">
				<div class="form-group">
					<label for="edit_name">Customer Name</label>
					<input type="text" class="form-control" id="edit_name" placeholder="'.$fullname.'" value="'.$fullname.'" disabled>
				</div>
			</div>			
			<div class="col-lg-12 col-12">
				<div class="form-group">
					<label for="edit_topic">Topic Meeting</label>
					<input type="text" class="form-control" id="edit_topic" placeholder="'.$row['topic'].'" value="'.$row['topic'].'">
				</div>
			</div>
			<div class="col-lg-6 col-6">
				<div class="form-group">
					<label for="edit_date">Date Meeting</label>
					<input type="date" class="form-control" id="edit_date" placeholder="'.$row['date'].'" value="'.$row['date'].'">
				</div>							
			</div>
			<div class="col-lg-6 col-6">
				<div class="form-group">
					<label for="edit_time">Start Meeting</label>
					<input type="time" class="form-control" id="edit_time" placeholder="'.$row['time'].'" value="'.$row['time'].'">
				</div>							
			</div>			
			<div class="col-lg-12 col-12">
				<div class="form-group">
					<label for="edit_meetingID">Meeting ID</label>
					<input type="text" class="form-control" id="edit_meetingID" placeholder="'.$row['meeting_id'].'" value="'.$row['meeting_id'].'" disabled>
				</div>
			</div>
			<div class="col-lg-12 col-12">
				<div class="form-group">
					<label for="edit_meetingLINK">Meeting Link</label>
					<textarea class="form-control text-wrap" id="edit_meetingLINK" rows="3" disabled>'.$row['link'].'</textarea>
				</div>
			</div>	
			<div class="col-lg-12 col-12">
				<div class="form-group">
					<label for="edit_meetingPASSWORD">Meeting Password</label>
					<input type="text" class="form-control" id="edit_meetingPASSWORD" placeholder="'.$row['password'].'" value="'.$row['password'].'" disabled>
				</div>							
			</div>
		</div>';
	}
	echo $output;
}
?>

