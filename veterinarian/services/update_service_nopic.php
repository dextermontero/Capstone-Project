<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$sid = $_POST['sid'];
$title = $_POST['s_title'];
$description = $_POST['s_description'];
$cost = $_POST['s_cost'];
$sql = $conn->prepare("UPDATE services SET service_title = ?, service_description = ?, service_cost = ? WHERE service_id = ?");
$sql -> bind_param("ssss", $title, $description, $cost, $sid);
if($sql->execute()){
	$s = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
	$r = $conn->query($s);
	if($r -> num_rows > 0){
		$ro = $r -> fetch_assoc();
		$id = $ro['vet_id'];
		$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
		$date = date("Y-m-d");
		$time = date("H:i:s");
		$activity = "<b>$fullname</b> update services information at [service title : $title]";
		$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
		$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
		if($ss->execute()){
			echo 'success';
		}
	}
}else {
	echo 'failed';
}
?>