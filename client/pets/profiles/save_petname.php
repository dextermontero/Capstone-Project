<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

$id = $_POST['id'];
$petname = verify($_POST['petname']);

$sql = $conn->prepare("UPDATE pet_profile SET pet_name = ? WHERE pet_id = ?");
$sql->bind_param("ss", $petname, $id);
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