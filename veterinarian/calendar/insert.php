<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$pet_name = $_POST['pet_name'];
$start_event = $_POST['start_time'];
$end_time = $_POST['end_time'];

$sql = "SELECT user_id, pet_name FROM pet_profile WHERE pet_id = '$pet_name'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$to = $row['user_id']; 
	$title = 'Pet : '.$row['pet_name'].' <br> Topic : '.$_POST['title'];
	$a = $conn->prepare("INSERT INTO calendar_events(to_client, title, start_event, end_event)VALUES(?, ?, ?, ?)");
	$a->bind_param("ssss", $to, $title, $start_event, $end_time);
	if($a->execute()){
		echo 'success';
	}else{
		echo '';
	}	
}else{
	echo 'failed';
}




?>