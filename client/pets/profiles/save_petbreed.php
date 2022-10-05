<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

$id = $_POST['id'];
$petbreed = verify($_POST['petbreed']);

$sql = $conn->prepare("UPDATE pet_profile SET pet_breed = ? WHERE pet_id = ?");
$sql->bind_param("ss", $petbreed, $id);
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