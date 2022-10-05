<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$time_id = $_POST['newId'];

$sql = $conn->prepare("DELETE FROM time_schedule WHERE time_id = ?");
$sql -> bind_param("s", $time_id);
if($sql->execute()){
	echo 'success';
}else{
	echo 'failed';
}
?>