<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

$petID = $_POST['petid'];
$userID = $_POST['userid'];
$diagnose = $_POST['diagnose'];
$notes = $_POST['addnotes'];
$date = $_POST['date'];
//NOTIFICATION
//NOTIFICATION
$category = 'diagnosis';
$services = 'Medical Diagnosis';
$icon = 'fa fa-medkit';
$title = 'Medical Diagnosis';
$ndate = date("Y-m-d");
$ntime = date("H:i");
$notif_status = '1';

$sql = $conn->prepare("INSERT INTO diagnosis_records(pet_id, user_id, diagnosis, additional_notes, date)VALUES(?, ?, ?, ?, ?)");
$sql->bind_param("sssss", $petID, $userID, $diagnose, $notes, $date);
if($sql->execute()){
	$s = "SELECT id FROM diagnosis_records WHERE user_id = '$userID' AND pet_id = '$petID' AND diagnosis = '$diagnose'";
	$u = $conn->query($s);
	if($u -> num_rows > 0){
		$t = $u -> fetch_assoc();
		$diagID = $t['id'];
		$url = web_root.'client/pets/profiles/profile.php?pet_id='.$petID.'&diagnose='.$diagID;
		$sqlnotify = $conn->prepare("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$sqlnotify -> bind_param("sssssssssss", $diagID, $user, $userID, $category, $services, $icon, $url, $title, $ndate, $ntime, $notif_status);
		if($sqlnotify->execute()){
			//appointment($fullname, $clientEmail, $date, $time, $service, $status);
			echo 'success';
		}else{
			echo 'failed2';
		}		
	}else{
		echo 'failed3';
	}
}else{
	echo 'failed1';
}
?>