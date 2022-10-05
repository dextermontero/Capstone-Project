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
$cost = verify($_POST['cost']);

$sql = $conn->prepare("UPDATE pet_treatment_records SET treatment = ?, f_procedure = ?, service_cost = ? WHERE treatment_id = ?");
$sql -> bind_param("ssss", $title, $f_procedure, $cost, $id);
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