<?php
require_once("../../../include/initialize.php");
session_start();
$redirect = "redirect";
if($_SESSION['roles'] == 'client'){
  	setcookie($redirect, "636c69656e74", time() + 30 * 60 * 1000, "/");
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
	
}

$sql = "SELECT COUNT(*) as 'total_notify' FROM notification WHERE receiver = '$user' AND status = '1' AND archive_status = '0'";
$result = $conn->query($sql);
$data = 0;
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	if($row['total_notify'] > 10){
		$data = '10 +';
	}else{
		$data = $row['total_notify'];
	}
}else{
	$data = 0;
}
echo json_encode($data);
?>