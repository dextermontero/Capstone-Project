<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
$shows = 0;

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$getVet = "SELECT firstname, lastname FROM vet_profile WHERE vet_id = '$user'";
	$getResult = $conn->query($getVet);
	if($getResult -> num_rows > 0){
		$getRow = $getResult -> fetch_assoc();
		$name = 'Dr. '. $getRow['firstname'].' '. $getRow['lastname'];
		$sql = $conn->prepare("UPDATE appointments SET veterinarian = ?, shows = ?, status = 'cancel' WHERE id = ?");
		$sql->bind_param("sss", $name, $shows, $id);
		if($sql->execute()){
			echo 'success';
		}else{
			echo 'failed';
		}		
	}
}
?>