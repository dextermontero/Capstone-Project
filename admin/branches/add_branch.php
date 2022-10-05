<?php
require_once("../../include/initialize.php");
session_start();
setlocale(LC_MONETARY, 'en_US');
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$name = verify($_POST['name']);
$address = verify($_POST['address']);
$status = "1";

$sql = $conn->prepare("INSERT INTO branch(name, address, status)VALUES(?, ?, ?)");
$sql -> bind_param("sss", $name, $address, $status);
if($sql->execute()){
	echo 'success';
}else{
	echo 'error';
}


function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>