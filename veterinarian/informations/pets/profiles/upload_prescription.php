<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}
$prescription_name = $_POST['pres_name'];$pet_id = $_POST['pet_id'];
$date = date("Y-m-d");
$time = date("H:i:s");
$save_location = '../../../../dist/img/pet_profile/prescription/';
$vet = "SELECT firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
$vetr = $conn->query($vet);
if($vetr -> num_rows > 0){
	$vetrow = $vetr -> fetch_assoc();
	$vetname = ucfirst($vetrow['firstname']).' '. ucfirst($vetrow['lastname']);
	$chk = "SELECT pet_id, user_id, pet_name FROM pet_profile WHERE pet_id = '$pet_id'";
	$crest = $conn->query($chk);
	if($crest -> num_rows > 0){
		$crow = $crest -> fetch_assoc();
		$user_id = $crow['user_id'];
		$petname = $crow['pet_name'];
		$pet_id = $crow['pet_id'];
		$file = time().'_'.$_FILES['file']['name'];
		$path = $save_location.$file;
		$file_extension = pathinfo($path, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension);	
		$valid_ext = array("jpeg","jpg","png", "pdf");	
		if(in_array($file_extension, $valid_ext)){
			if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
				$sql = $conn->prepare("INSERT INTO prescription_records(pet_id, user_id, prescription_name, filename, veterinarian, date)VALUES(?, ?, ?, ?, ?, ?)");
				$sql -> bind_param("ssssss", $pet_id, $user_id, $prescription_name, $file, $vetname, $date);
				if($sql->execute()){
					$s = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
					$r = $conn->query($s);
					if($r -> num_rows > 0){
						$ro = $r -> fetch_assoc();
						$id = $ro['vet_id'];
						$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
						$activity = "<b>$fullname</b> upload prescription  [Pet Name : $petname]";
						$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
						$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
						if($ss->execute()){
							echo 'success';
						}
					}
				}else {
					echo 'failed';
				}				
			}
		}
	}
}
?>