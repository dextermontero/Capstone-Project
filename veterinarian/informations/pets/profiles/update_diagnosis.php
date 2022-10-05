<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

$diagID = $_POST['diagnoseID'];
$serviceDate = $_POST['date_service'];
$diagnosis = $_POST['diagnosis'];
$notes = $_POST['notes'];

$sql = $conn->prepare("UPDATE diagnosis_records SET diagnosis = ?, additional_notes = ?, date = ? WHERE id = ?");
$sql->bind_param("ssss", $diagnosis, $notes, $serviceDate, $diagID);
if($sql->execute()){
	echo 'success';
}else{
	echo 'failed';
}
?>