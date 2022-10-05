<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM archive WHERE archive_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		$review_id = $row['id'];
		$chk = $conn->prepare("UPDATE user_profile SET archive_status = '0' WHERE user_id = ?");
		$chk -> bind_param("s", $review_id);
		$chk1 = $conn->prepare("UPDATE login_tbl SET archive_status = '0' WHERE uid = ?");
		$chk1 -> bind_param("s", $review_id);		
		if($chk->execute() && $chk1->execute()){
			$chk1 = $conn->prepare("DELETE FROM archive WHERE archive_id = ?");
			$chk1 -> bind_param("s", $id);
			if($chk1->execute()){
				echo 'success';
			}else{
				echo 'failed';
			}
		}else{
			echo 'failed';
		}
	}else{
		
	}
}
?>