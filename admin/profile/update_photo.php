<?php
require_once("../../include/initialize.php");
include("../../include/ImageResize.php");
use \Gumlet\ImageResize;
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$save_location = '../../dist/img/profiles/';
$query = "SELECT admin_id, photo FROM admin_profile WHERE admin_id = '$user'";
$result = $conn->query($query);
if($result -> num_rows > 0) {
	$row = $result -> fetch_assoc();
	$id = $row['admin_id'];
	$specific = $row['photo'];
	if($row['photo'] == 'default.png'){
		
	}else{
		unlink("../../dist/img/profiles/$specific");
	}
	$file = $id.'_'.$_FILES['file']['name'];
	$path = $save_location.$file;
	$file_extension = pathinfo($path, PATHINFO_EXTENSION);
	$file_extension = strtolower($file_extension);	
	$valid_ext = array("jpeg","jpg","png");	
	$resizeImage = $path;
	if(in_array($file_extension, $valid_ext)){
		if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
			$image = new ImageResize($path);
			$image->resize(315,315);
			$image->save($resizeImage);
			$sql = $conn->prepare("UPDATE admin_profile SET photo = ? WHERE admin_id = ?");
			$sql -> bind_param("ss", $file, $user);
			if($sql->execute()){
				$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
				$r = $conn->query($s);
				if($r -> num_rows > 0){
					$ro = $r -> fetch_assoc();
					$id = $ro['admin_id'];
					$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
					$date = date("Y-m-d");
					$time = date("H:i:s");
					$activity = "<b>$fullname</b> update profile picture at admin portal";
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