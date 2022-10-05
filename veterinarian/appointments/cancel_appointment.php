<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
$shows = 0;
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = $conn->prepare("UPDATE appointments SET shows = ?, status = 'cancelled' WHERE id = ?");
	$sql->bind_param("ss", $shows, $id);
	if($sql->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}
?>