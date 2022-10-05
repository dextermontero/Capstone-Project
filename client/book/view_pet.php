<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$id = $_POST['id'];

$sql = "SELECT * FROM pet_profile WHERE user_id = '$id' AND archive_status = '0'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	echo 'success';
}else{
	echo 'failed';
}
?>