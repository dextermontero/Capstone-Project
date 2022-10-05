<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$name = verify($_POST['name']);
$type = verify($_POST['type']);
$breed = verify($_POST['breed']);
$birthday = $_POST['date'];


$sql = $conn->prepare("INSERT INTO pet_profile(user_id, pet_name, pet_type, pet_breed, pet_birthdate)VALUES(?, ?, ?, ?, ?)");
$sql->bind_param("sssss", $user, $name, $type, $breed, $birthday);
if($sql->execute()){
	echo 'success';
}else {
	echo 'failed';
}

function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>