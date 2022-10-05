<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

require_once('../../../PHPMailer/src/Exception.php');
require_once('../../../PHPMailer/src/PHPMailer.php');
require_once('../../../PHPMailer/src/SMTP.php');

$id = $_POST['id'];
$branch_id = $_POST['branch_id'];
$status = $_POST['status'];

//NOTIFICATION
$category = 'appointment';
$icon = 'fa-calendar-check';
$title = 'Update Appointment';
$nstatus = $status;
$ndate = date("Y-m-d");
$ntime = date("H:i");
$notif_status = '1';

$bname = "";
$baddress = "";
$branchsql = "SELECT name, address FROM branch WHERE branch_id = '$branch_id'";
$bresult = $conn->query($branchsql);
if($bresult -> num_rows > 0) {
	$brow = $bresult -> fetch_assoc();
	$bname .= ucfirst($brow['name']);
	$baddress .= $brow['address'];
}

$getID = "SELECT appointments.user_id, appointments.c_fullname, services.service_title, appointments.date, appointments.timeslot, user_profile.email FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id INNER JOIN user_profile ON user_profile.user_id = appointments.user_id WHERE appointments.id = '$id'";
$getresult = $conn->query($getID);
if($getresult -> num_rows > 0){
	$getRow = $getresult -> fetch_assoc();
	$fullname = $getRow['c_fullname'];
	$clientEmail = $getRow['email'];
	$clientID = $getRow['user_id'];
	$services = $getRow['service_title'];
	$date = $getRow['date'];
	$time = $getRow['timeslot'];
	if(!empty($status)){
		$sql = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
		$sql->bind_param("ss", $status, $id);
		if($sql->execute()){
			$token = $id;
			$url = web_root.'client/notifications/?notif_id='.$token.'&category='.$category.'&services='.$services.'&appointment_id='.$id.'&date='.$date.'&time='.$time;
			$sqlnotify = $conn->prepare("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$sqlnotify -> bind_param("sssssssssss", $token, $user, $clientID, $category, $services, $icon, $url, $title, $ndate, $ntime, $notif_status);
			if($sqlnotify->execute()){
				appointment($fullname, $clientEmail, $date, $time, $services, $bname, $baddress, $status);
				echo 'success';
			}else{
				echo 'failed';
			}
		}else{
			echo 'failed';
		}
	}else{
		echo 'invalid';
	}	
}else{
	echo 'invalid';
}

function appointment($fullname, $email, $date, $time, $service, $branch, $branch_address, $status){
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
				<b>Branch:</b> '. $branch .'<br>
				<b>Venue:</b> '. $branch_address .'<br>
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