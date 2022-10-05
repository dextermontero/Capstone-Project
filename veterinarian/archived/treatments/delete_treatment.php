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
		$treatment_id = $row['id'];
		
		$chk = $conn->prepare("DELETE FROM pet_treatment_records WHERE treatment_id = ?");
		$chk -> bind_param("s", $treatment_id);
		$chk1 = $conn->prepare("DELETE FROM archive WHERE archive_id = ?");
		$chk1 -> bind_param("s", $id);
		if($chk->execute() && $chk1->execute()){
			$s = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
			$r = $conn->query($s);
			if($r -> num_rows > 0){
				$ro = $r -> fetch_assoc();
				$id = $ro['vet_id'];
				$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
				$date = date("Y-m-d");
				$time = date("H:i:s");
				$activity = "<b>$fullname</b> deleting pet treatment information";
				$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
				$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
				if($ss->execute()){
					echo 'success';
				}
			}else {
				echo 'invalid';
			}
		}else{
			echo 'failed';
		}		

	}else{
		echo 'failed';
	}		
}
?>