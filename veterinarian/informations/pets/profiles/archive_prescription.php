<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}
$id = $_POST['id'];
$category = 'prescription';
$sql = $conn->prepare("INSERT INTO archive(id, user_id, category)VALUES(?, ?, ?)");
$sql->bind_param("sss", $id, $user, $category);
if($sql->execute()){
	$update = $conn->prepare("UPDATE prescription_records SET archive_status = '1' WHERE prescription_id = ?");
	$update -> bind_param("s", $id);
	if($update->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}else{
	echo 'failed';
}
?>