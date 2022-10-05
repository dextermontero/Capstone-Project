<?php
require_once("../../include/initialize.php");
session_start();
setlocale(LC_MONETARY, 'en_US');
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$id = $_POST['id'];
$category = 'branches';

$sql = $conn->prepare("UPDATE branch SET archive_status = '1' WHERE branch_id = ?");
$sql -> bind_param("s", $id);
if($sql->execute()){
	$archive = $conn->prepare("INSERT INTO archive(id, user_id, category)VALUES(?, ?, ?)");
	$archive -> bind_param("sss", $id, $user, $category);
	if($archive->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}else{
	echo 'failed';
}

?>