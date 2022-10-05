<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

require_once('../../PHPMailer/src/Exception.php');
require_once('../../PHPMailer/src/PHPMailer.php');
require_once('../../PHPMailer/src/SMTP.php');

$id = $_POST['id'];
$fullname = $_POST['fullname'];
$service = $_POST['service'];
$date = date("Y-m-d", strtotime($_POST['date']));
$time = $_POST['time'];
$status = $_POST['status'];
//NOTIFICATION
$category = 'appointment';
$services = $service;
$icon = 'fa-calendar-check';
$title = 'Update Appointment';
$nstatus = $status;
$ndate = date("Y-m-d");
$ntime = date("H:i");
$notif_status = '1';

$getID = "SELECT appointments.user_id, user_profile.email FROM appointments INNER JOIN user_profile ON user_profile.user_id = appointments.user_id WHERE appointments.id = '$id'";
$getresult = $conn->query($getID);
if($getresult -> num_rows > 0){
	$row = $getresult -> fetch_assoc();
	$clientEmail = $row['email'];
	$clientID = $row['user_id'];
	if($status == 'scheduled' || $status == 'rescheduled' || $status == 'cancel' || $status == 'done'){
		$updateappointment = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
		$updateappointment -> bind_param("ss", $status, $id);
		$urls = web_root.'veterinarian/notifications/?notif_id='.$id.'&category=appointment&services='.$service.'&appointment_id='.$id.'&date='.$date.'&time='.$time;
		$updates = $conn->prepare("UPDATE notification SET url = ? WHERE id = ?");
		$updates -> bind_param("ss", $urls, $id);
		if($updateappointment->execute() && $updates->execute()){
			$token = $id;
			$url = web_root.'client/notifications/?notif_id='.$token.'&category='.$category.'&services='.$services.'&appointment_id='.$id.'&date='.$date.'&time='.$time;
			$sqlnotify = $conn->prepare("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$sqlnotify -> bind_param("sssssssssss", $token, $user, $clientID, $category, $services, $icon, $url, $title, $ndate, $ntime, $notif_status);
			if($sqlnotify->execute()){
				appointment($fullname, $clientEmail, $date, $time, $service, $status);
				echo 'success';
			}else{
				echo 'failed';
			}
		}
	}else{
		$updateappointment = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
		$updateappointment -> bind_param("ss", $status, $id);
		if($updateappointment->execute()){
			echo 'success';
		}
	}
}

function appointment($fullname, $email, $date, $time, $service, $status){
	$from = "vawvetclinic.not.official@gmail.com";
	$e = ucfirst($status);
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = "smtp";

	$mail->SMTPDebug  = 0;  
	$mail->SMTPAuth   = TRUE;
	$mail->SMTPSecure = "tls";
	$mail->Port       = 587;
	$mail->Host       = "smtp.gmail.com";
	$mail->Username   = "john.montero1109@gmail.com";
	$mail->Password   = "SECRETNOCLUE";	
	$mail->IsHTML(true);
	$mail->AddAddress($email, $fullname);
	$mail->SetFrom("vawvetclinic.not.official@gmail.com", "VAW Vet Clinic $e of Appointment");
	//$mail->AddReplyTo($email, $fullname);
	//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
	$mail->Subject = "$e of Appointment";
	$message = '
	<html>
		<body>
			<div>
				<p>Greetings <b>'.$fullname.'</b>,</p>
				This is your '.$status.' appointment details for the Vets at Work Veterinary Clinic
				<br><br>
				<b>Type of Service:</b> '.$service.'<br>
				<b>Day & Time:</b> '. date("F d, Y", strtotime($date)).' & '. date("g:i A", strtotime($time)) .'<br>
				<b>Status:</b> '. ucfirst($status) .'<br>
				<b>Venue:</b> Unit B/F Divino Amore Bldg., # 8 Holy Spirit Drive, Don Antonio Heights, Quezon City<br>
				<br>
				Please confirm if this works for you. Contact us for your suggestions. Thank you very much our dear fur parents!
				<br>
				<br>
				<b>Thank you</b>,<br>
				Vets at Work Veterinary Clinic
			</div>
		</body>
	</html>	
	';
	
	$mail->MsgHTML($message); 
	if(!$mail->Send()) {
		
	} else {
		
	}	
}
?>