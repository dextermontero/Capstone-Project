<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['sid'])){
	$id = $_POST['sid'];
	$sql = "SELECT service_photo, service_title FROM services WHERE service_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result->fetch_assoc();
		$title = $row['service_title'];
		$specific = $row['service_photo'];
		$si = "DELETE FROM services WHERE service_id = '$id'";
		$res = $conn->query($si);
		if ($res) {
			$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
			$r = $conn->query($s);
			if($r -> num_rows > 0){
				$ro = $r -> fetch_assoc();
				$id = $ro['admin_id'];
				$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
				$date = date("Y-m-d");
				$time = date("H:i:s");
				$activity = "<b>$fullname</b> deleting request services information at [service title : $title]";
				$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
				$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
				if($ss->execute()){
					unlink("../../dist/img/services/$specific");
					echo 'success';
				}
			}else {
				echo 'invalid';
			}				
		}else {
			echo 'failed';
		}
	}else {
		echo 'invalid';
	}		
}else{
	echo 'invalid';
}
?>