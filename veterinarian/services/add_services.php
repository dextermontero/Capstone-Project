<?php
require_once("../../include/initialize.php");
include("../../include/ImageResize.php");
use \Gumlet\ImageResize;
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

//$save_location = web_root.'dist/img/services/';
$save_location = '../../dist/img/services/';
$title = $_POST['title'];
$description = $_POST['description'];
$cost = $_POST['cost'];

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
		$s = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
		$r = $conn->query($s);
		if($r -> num_rows > 0){
			$ro = $r -> fetch_assoc();
			$id = $ro['vet_id'];
			$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
			$date = date("Y-m-d");
			$time = date("H:i:s");		
			$activity = "<b>$fullname</b> adding new services information at [service title : $title]";
			
			$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
			$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
			
			$sql = $conn->prepare("INSERT INTO services(service_title, service_description, service_cost, service_photo, vet_request)VALUES(?, ?, ?, ?, ?)");
			$sql -> bind_param("sssss", $title, $description, $cost, $file, $fullname);			
			if($ss->execute() && $sql->execute()){
				echo 'success';
			}
		}			
	}
}else {
	echo 'format';
}
?>