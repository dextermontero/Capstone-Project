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
		$service_id = $row['id'];
		$chk = $conn->prepare("UPDATE services SET status = '0', archive_status = '0' WHERE service_id = ?");
		$chk -> bind_param("s", $service_id);
		if($chk->execute()){
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