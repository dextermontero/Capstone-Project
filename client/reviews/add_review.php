<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
$title_id  = $_POST['title'];
$description = verify(ucfirst(strtolower($_POST['description'])));
$status = 1;


$sql = "SELECT appointments.id, services.service_title FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.id = '$title_id'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$service = ucfirst(strtolower($row['service_title']));
	$insert = $conn->prepare("INSERT INTO reviews(user_id, appointment_id, review_service, review_description, status)VALUES(?, ?, ?, ?, ?)");
	$insert->bind_param("sssss", $user, $title_id, $service, $description, $status);
	if($insert->execute()){
		$a = $conn->prepare("UPDATE appointments SET review = '1' WHERE id = ?");
		$a -> bind_param("s", $title_id);
		if($a->execute()){
			echo 'success';
		}else{
			echo 'failed';
		}
	}else{
		echo 'invalid';
	}

}

function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>