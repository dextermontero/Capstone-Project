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
$f_procedure = $_POST['f_procedure'];
$n_procedure = verify($_POST['n_procedure']);
$cost = verify($_POST['cost']);
$status = verify($_POST['status']);

$chk = "SELECT user_id, pet_id, n_procedure FROM pet_treatment_records WHERE treatment_id = '$id'";
$result = $conn->query($chk);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$user_id = $row['user_id'];
	$pet_id = $row['pet_id'];
	$past_p = $row['n_procedure'];
	$date = date("Y-m-d");
	$sql = $conn->prepare("INSERT INTO pet_treatment_records(pet_id, user_id, date, treatment, f_procedure, service_cost)VALUES(?, ?, ?, ?, ?, ?)");
	$sql -> bind_param("ssssss", $pet_id, $user_id, $date, $title, $n_procedure, $cost);
	if($sql->execute()){
		$a = $conn->prepare("UPDATE pet_treatment_records SET n_procedure = ?, status = ? WHERE treatment_id = ?");
		$a -> bind_param("sss", $n_procedure, $status, $id);
		if($a->execute()){
			echo 'success';
		}else{
			echo 'failed';
		}			
	}
}


function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>