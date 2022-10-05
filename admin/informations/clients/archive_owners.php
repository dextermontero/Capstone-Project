<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

$id = $_POST['id'];
$category = 'owners';

$sql = $conn->prepare("INSERT INTO archive(id, user_id, category)VALUES(?, ?, ?)");
$sql->bind_param("sss", $id, $user, $category);
if($sql->execute()){
	$update = $conn->prepare("UPDATE user_profile SET archive_status = '1' WHERE user_id = ?");
	$update -> bind_param("s", $id);
	$update1 = $conn->prepare("UPDATE login_tbl SET archive_status = '1' WHERE uid = ?");
	$update1 -> bind_param("s", $id);	
	if($update->execute() && $update1->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}else{
	echo 'failed';
}
?>