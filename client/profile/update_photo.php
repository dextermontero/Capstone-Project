<?php
require_once("../../include/initialize.php");
include("../../include/ImageResize.php");
use \Gumlet\ImageResize;
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$save_location = '../../dist/img/profiles/';
$query = "SELECT user_id, photo FROM user_profile WHERE user_id = '$user'";
$result = $conn->query($query);
if($result -> num_rows > 0) {
	$row = $result -> fetch_assoc();
  	$id = $row['user_id'];
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
			$sql = $conn->prepare("UPDATE user_profile SET photo = ? WHERE user_id = ?");
			$sql -> bind_param("ss", $file, $user);
			if($sql->execute()){
				$s = "SELECT user_id, firstname, lastname FROM user_profile WHERE user_id = '$user'";
				$r = $conn->query($s);
				if($r -> num_rows > 0){
					$ro = $r -> fetch_assoc();
					$id = $ro['user_id'];
					$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
					$date = date("Y-m-d");
					$time = date("H:i:s");
					$activity = "<b>$fullname</b> update profile picture at clinic portal";
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