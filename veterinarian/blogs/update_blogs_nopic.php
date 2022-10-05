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


if(isset($_POST['id'])){
	$id = $_POST['id'];
	$title = verify($_POST['title']);
	$description = verify($_POST['description']);

	$sql = $conn->prepare("UPDATE blogs SET blog_title = ?, blog_description = ? WHERE blog_id = ?");
	$sql->bind_param("sss", $title, $description, $id);
	if($sql->execute()){
		$s = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
		$r = $conn->query($s);
		if($r -> num_rows > 0){
			$ro = $r -> fetch_assoc();
			$id = $ro['vet_id'];
			$fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
			$date = date("Y-m-d");
			$time = date("H:i:s");
			$activity = "<b>$fullname</b> update blog information at [blog title : $title]";
			$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
			$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
			if($ss->execute()){
				echo 'success';
			}
		}else{
			echo 'failed';
		}						
	}else{
		echo 'failed';
	}
}

function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>