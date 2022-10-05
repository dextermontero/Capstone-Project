<?php
require_once("../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}

$sql = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$id = $row['admin_id'];
	$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
	$date = date("Y-m-d");
	$time = date("H:i:s");
	$activity = "Log out at administrator portal";
	$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
	$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
	if($ab->execute()){
		session_start();
		session_unset();
		session_destroy();
		unset($_COOKIE['redirect']); 
		setcookie('redirect', null, -1, '/');       
		header("location: ../");
	}else {
		echo 'failed';
	}	
}	
?>