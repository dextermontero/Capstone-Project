<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$id = $_POST['id'];
$payment = $_POST['payment'];
$status = $_POST['status'];

if(!empty($payment) && !empty($status)){
	$sql = $conn->prepare("UPDATE appointments SET payment_status = ?, status = ? WHERE id = ?");
	$sql->bind_param("sss", $payment, $status, $id);
	if($sql->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}elseif($payment == null && !empty($status)){
	$sql = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
	$sql->bind_param("ss", $status, $id);
	if($sql->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}elseif(!empty($payment) && $status == null){
	$sql = $conn->prepare("UPDATE appointments SET payment_status = ? WHERE id = ?");
	$sql->bind_param("ss", $payment, $id);
	if($sql->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}else{
	echo 'invalid';
}

?>