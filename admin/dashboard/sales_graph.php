<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}

$query = "SELECT SUM(billing.amount) AS amounts, DATE_FORMAT(billing.date,'%Y') AS months FROM `billing` WHERE billing.status = 'paid' AND billing.archive_status = '0' GROUP BY DATE_FORMAT(date,'%Y') ORDER BY DATE_FORMAT(date,'%Y') ASC";

$result = $conn->query($query);

$data = array();
foreach($result as $row){
	$data[] = $row;
}

echo json_encode($data);
?>