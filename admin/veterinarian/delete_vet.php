<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['vet_id'])){
	$id = $_POST['vet_id'];
	$q = "SELECT firstname, lastname, photo FROM vet_profile WHERE vet_id = '$id'";
	$qr = $conn->query($q);
	if($qr -> num_rows > 0){
		$qrr = $qr -> fetch_assoc();
		$name = ucfirst($qrr['firstname']) .' '. ucfirst($qrr['lastname']);
		$specific = $qrr['photo'];
		$sql = "DELETE FROM login_tbl WHERE uid = '$id'";
		$sql1 = "DELETE FROM vet_profile WHERE vet_id = '$id'";
		$res = $conn->query($sql);
		$res1 = $conn->query($sql1);
		if ($res && $res1) {
			$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
			$r = $conn->query($s);
			if($r -> num_rows > 0){
				$ro = $r -> fetch_assoc();
				$id = $ro['admin_id'];
				$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
				$date = date("Y-m-d");
				$time = date("H:i:s");
				$activity = "<b>$fullname</b> deleting veterinarian information at [Vet Name : $name]";
				$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
				$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
				if($ss->execute()){
					unlink("../../dist/img/profiles/$specific");
					echo 'success';
				}else {
					echo 'failed';
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
}else {
	echo 'invalid';
}
?>