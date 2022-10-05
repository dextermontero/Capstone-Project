<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}

$month = date("m");

$visitorsCounter = "SELECT date_format(date, '%b - %e') as 'date',COUNT(*) as visitor FROM visitors WHERE month(date) = '$month' GROUP BY date ORDER BY date ASC LIMIT 5";

$result = $conn->query($visitorsCounter);

$data = array();
foreach($result as $row){
	$data[] = $row;
}

echo json_encode($data);
?>