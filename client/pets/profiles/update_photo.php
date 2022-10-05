<?php
require_once("../../../include/initialize.php");
include("../../../include/ImageResize.php");
use \Gumlet\ImageResize;
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

$id = $_POST['id'];
$save_location = '../../../dist/img/pet_profile/';
$query = "SELECT pet_photo FROM pet_profile WHERE pet_id = '$id'";
$result = $conn->query($query);
if($result -> num_rows > 0) {
	$row = $result -> fetch_assoc();
	$specific = $row['pet_photo'];
	if($row['pet_photo'] == 'default.png'){
		
	}else{
		unlink("../../../dist/img/pet_profile/$specific");
	}
	$file = time().'_'.$_FILES['file']['name'];
	$path = $save_location.$file;
	$file_extension = pathinfo($path, PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);	
	$valid_ext = array("jpeg","jpg","png");	
	$resizeImage = $path;
	if(in_array($file_extension, $valid_ext)){
		if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
			$image = new ImageResize($path);
			$image->resize(516,515);
			$image->save($resizeImage);
			$sql = $conn->prepare("UPDATE pet_profile SET pet_photo = ? WHERE pet_id = ?");
			$sql -> bind_param("ss", $file, $id);
			if($sql->execute()){
				$s = "SELECT user_id, firstname, lastname FROM user_profile WHERE user_id = '$user'";
				$r = $conn->query($s);
				if($r -> num_rows > 0){
					$ro = $r -> fetch_assoc();
					$id = $ro['user_id'];
					$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
					$date = date("Y-m-d");
					$time = date("H:i:s");
					$activity = "<b>$fullname</b> update pet picture at clinic portal";
					$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
					$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
					if($ss->execute()){
						echo 'success';
					}else{
						echo 'failed';
					}
				}
			}else {
				echo 'failed';
			}			
		}			
	}else{
		echo 'invalid';
	}		
}
?>