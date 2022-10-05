<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

$id = $_POST['id'];
$title = verify($_POST['title']);
$f_procedure = verify($_POST['f_procedure']);
$treatment_cost = verify($_POST['treatment_cost']);

$chk = "SELECT user_id FROM pet_profile WHERE pet_id = '$id'";
$result = $conn->query($chk);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$user_id = $row['user_id'];
	$date = date("Y-m-d");
	$a = $conn->prepare("INSERT INTO pet_treatment_records(pet_id, user_id, date, treatment, f_procedure, service_cost)VALUES(?, ?, ?, ?, ?, ?)");
	$a -> bind_param("ssssss", $id, $user_id, $date, $title, $f_procedure, $treatment_cost);
	if($a->execute()){
		echo 'success';
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