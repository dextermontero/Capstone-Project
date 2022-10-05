<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

$pet_id = $_POST['pet_id'];
$pet_breed = verify($_POST['pet_breed']);
$pet_weight = verify($_POST['pet_weight']);
$pet_birthdate = $_POST['birthdate'];
$pet_vaccination = verify($_POST['pet_vaccination']);
$pet_blood_type = verify($_POST['pet_blood_type']);
$pet_medical_status = verify($_POST['pet_medical_status']);

$sql = $conn->prepare("UPDATE pet_profile SET pet_breed = ?, pet_weight = ?, pet_birthdate = ?, pet_vaccination = ?, pet_blood_type = ?, pet_medical_status = ? WHERE pet_id = ?");
$sql->bind_param("sssssss", $pet_breed, $pet_weight, $pet_birthdate, $pet_vaccination, $pet_blood_type, $pet_medical_status, $pet_id);
if($sql->execute()){
	echo 'success';
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