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

//$save_location = web_root.'dist/img/services/';
$save_location = '../../dist/img/services/';
$title = $_POST['title'];
$description = nl2br($_POST['description']);
$branch = $_POST['branch'];
$cost = $_POST['cost'];
$status = '1';

$file = $title.'_'.$_FILES['file']['name'];
$path = $save_location.$file;
$file_extension = pathinfo($path, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);	
$valid_ext = array("jpeg","jpg","png");
$resizeImage = $path;
if(in_array($file_extension, $valid_ext)){
	if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
		$image = new ImageResize($path);
		$image->resize(500,500);
		$image->save($resizeImage);
		$sql = $conn->prepare("INSERT INTO services(branch_id, service_title, service_description, service_cost, service_photo, status)VALUES(?, ?, ?, ?, ?, ?)");
		$sql -> bind_param("ssssss", $branch, $title, $description, $cost, $file, $status);
		if($sql->execute()){
			$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
			$r = $conn->query($s);
			if($r -> num_rows > 0){
				$ro = $r -> fetch_assoc();
				$id = $ro['admin_id'];
				$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
				$date = date("Y-m-d");
				$time = date("H:i:s");
				$activity = "<b>$fullname</b> adding new services information at [service title : $title]";
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
}else {
	echo 'invalid';
}
?>