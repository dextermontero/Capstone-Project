<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$branch_id = $_POST['branchID'];
$time = $_POST['time_manage'];
$status = '1';
$sql = $conn->prepare("INSERT INTO time_schedule(branch_id, time, status)VALUES(?, ?, ?)");
$sql -> bind_param("sss", $branch_id, $time, $status);
if($sql->execute()){
	echo 'success';
}else{
	echo 'failed';
}
?>