<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$category = 'reviews';

	$sql = $conn->prepare("INSERT INTO archive(id, user_id, category)VALUES(?, ?, ?)");
	$sql->bind_param("sss", $id, $user, $category);
	if($sql->execute()){
		$chk = $conn->prepare("UPDATE reviews SET archive_status = '1' WHERE review_id = ?");
		$chk -> bind_param("s", $id);
		if($chk->execute()){
			echo 'success';
		}else{
			echo 'failed';
		}
	}else{
		echo 'failed';
	}
}

?>