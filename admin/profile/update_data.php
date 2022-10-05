<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$firstname = verify($_POST['firstname']);
$middlename = verify($_POST['middlename']);
$lastname = verify($_POST['lastname']);
$email = verify($_POST['email']);
$address = verify($_POST['address']);
$place_birth = verify($_POST['place_birth']);
$gender = verify($_POST['gender']);
$birthday = verify($_POST['birthday']);
$phone = verify($_POST['phone']);

$sql = $conn->prepare("UPDATE admin_profile SET firstname = ?, middlename = ?, lastname = ?, email = ?, contact_number = ?, address = ?, gender = ?, birthdate = ?, place_bday = ? WHERE admin_id = ?");
$sql->bind_param("ssssssssss", $firstname, $middlename, $lastname, $email, $phone, $address, $gender, $birthday, $place_birth, $user);
if($sql->execute()){
	$a = $conn->prepare("UPDATE login_tbl SET email = ? WHERE uid = ?");
	$a -> bind_param("ss", $email, $user);
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