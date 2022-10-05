<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$time_id = $_POST['newId'];
$time = $_POST['time'];

$sql = $conn->prepare("UPDATE time_schedule SET time = ? WHERE time_id = ?");
$sql -> bind_param("ss", $time, $time_id);
if($sql->execute()){
	echo 'success';
}else{
	echo 'failed';
}
?>