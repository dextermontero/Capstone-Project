<?php
require_once("../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}
$query = "SELECT appointments.id, services.service_title,COUNT(service_title) as count_service FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id GROUP BY services.service_title";

$result = $conn->query($query);
$data = array();
foreach($result as $row){
	$data[] = $row;
}
echo json_encode($data);
?>