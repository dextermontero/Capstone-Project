<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
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
$fullname = $_POST['fullname'];
$date = date("Y-m-d", strtotime($_POST['date']));
$pet = $_POST['pet'];
$time = $_POST['time'];
$branch = $_POST['branch'];
$service = $_POST['service'];

//NOTIFICATION
$receiver = 'veterinarian';
$category = 'appointment';
$services = $service;
$icon = 'fa-calendar-alt';
$title = 'Update Appointment';
$ndate = date("Y-m-d");
$ntime = date("H:i");
$notif_status = '1';

//GET SERVICE NAME 
$ctitle = "";
$cstart = $date.' '.date("H:i", strtotime($time));
$cend = $cstart;
$csql = "SELECT service_title FROM services WHERE service_id = '$service'";
$cresult = $conn->query($csql);
if($cresult -> num_rows > 0) {
	$crow = $cresult -> fetch_assoc();
	$ctitle .= ucfirst($crow['service_title']);
}

$bname = "";
$baddress = "";
$branchsql = "SELECT name, address FROM branch WHERE branch_id = '$branch'";
$bresult = $conn->query($branchsql);
if($bresult -> num_rows > 0) {
	$brow = $bresult -> fetch_assoc();
	$bname .= ucfirst($brow['name']);
	$baddress .= $brow['address'];
}

$sql = "SELECT * FROM appointments WHERE date = '$date' AND timeslot = '$time' AND shows = '1'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	echo 'exist';
}else{
	$sql = $conn->prepare("UPDATE appointments SET pet_name = ?, service_id = ?, date = ?, timeslot = ? WHERE id = ?");
	$sql->bind_param("sssss", $pet, $service, $date, $time, $id);
	$sqlc = $conn->prepare("UPDATE calendar_events SET title = ?, start_event = ?, end_event = ? WHERE token = ?");
	$sqlc -> bind_param("ssss", $ctitle, $cstart, $cend, $id);
	if($sql->execute() && $sqlc->execute()){
		$sa = "SELECT * FROM appointments WHERE id = '$id'";
		$ra = $conn->query($sa);
		if($ra -> num_rows > 0){
			$ro = $ra -> fetch_assoc();
			$status = $ro['status'];
			$sl = "SELECT firstname, lastname, email FROM user_profile WHERE user_id = '$user'";
			$sr = $conn->query($sl);
			if($sr -> num_rows > 0){
				$srow = $sr -> fetch_assoc();
				$fullname = ucfirst($srow['firstname']) .' '. ucfirst($srow['lastname']);
				$email = $srow['email'];
				$delold = $conn->prepare("DELETE FROM notification WHERE id = ?");
				$delold -> bind_param("s", $id);
				if($delold->execute()){
					$token = $id;
					$url = web_root.'veterinarian/notifications/?notif_id='.$token.'&category='.$category.'&services='.$services.'&appointment_id='.$id.'&date='.$date.'&time='.$time;
					$sqlnotify = $conn->prepare("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$sqlnotify -> bind_param("sssssssssss", $token, $user, $receiver, $category, $services, $icon, $url, $title, $ndate, $ntime, $notif_status);
					if($sqlnotify->execute()){
						echo 'success';
						appointment($fullname, $email, $date, $time, $ctitle, $bname, $baddress, $status);
					}else{
						echo 'failed';
					}				
				}
			}			
		}else {
			echo 'failed';
		}
	}else{
		echo 'failed';
	}
}


function appointment($fullname, $email, $date, $time, $service, $branch, $branch_address, $status){
	$from = "vawvetclinic.not.official@gmail.com";
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = "smtp";

	$mail->SMTPDebug  = 0;  
	$mail->SMTPAuth   = TRUE;
	$mail->SMTPSecure = "tls";
	$mail->Port       = 587;
	$mail->Host       = "smtp.gmail.com";
	$mail->Username   = "vawvetclinic.not.official1@gmail.com";
	$mail->Password   = "SECRETNOCLUE";	
	$mail->IsHTML(true);
	$mail->AddAddress($email, $fullname);
	$mail->SetFrom("vawvetclinic.not.official@gmail.com", "VAW Vet Clinic Update of Appointment");
	//$mail->AddReplyTo($email, $fullname);
	//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
	$mail->Subject = "Update of Appointment";
	$message = '
	<html>
		<body>
			<div>
				<p>Greetings <b>'.$fullname.'</b>,</p>
				This is your updated appointment details that you requested for Vets at Work Veterinary Clinic
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
				<b>Regards</b>,<br>
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