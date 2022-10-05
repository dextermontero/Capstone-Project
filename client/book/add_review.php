<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
$id = $_POST['id'];
$title = $_POST['title'];
$description = verify($_POST['description']);
$status = 1;
$sql = $conn->prepare("INSERT INTO reviews(user_id, appointment_id, review_service, review_description, status)VALUES(?, ?, ?, ?, ?)");
$sql->bind_param("sssss", $user, $id, $title, $description, $status);
if($sql->execute()){
	$a = $conn->prepare("UPDATE appointments SET review = 1 WHERE id = ?");
	$a -> bind_param("s", $id);
	if($a->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}else{
	echo 'failed';
}
function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>