<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$current = encrypteCTR($_POST['current']);
$newpass = newPassENCRYPTE($_POST['newpass']);

$chk = "SELECT password FROM login_tbl WHERE password = '$current' AND uid = '$user'";
$result = $conn->query($chk);
if($result -> num_rows > 0){
	$sql = $conn->prepare("UPDATE login_tbl SET password = ? WHERE uid = ?");
	$sql -> bind_param("ss", $newpass, $user);
	if($sql->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}else{
	echo 'invalid';
}


function encrypteCTR($data) {
	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;	
	$encryption_iv = '1234567891011121';
	$encryption_key = "+ObRG)moziZfrceSKxqs!T#BkMhavJ&gjpF%CY(N*DEPLAWdwVI@uUQl^yHtX_n";
	$encryption = openssl_encrypt($_POST['current'], $ciphering, $encryption_key, $options, $encryption_iv);
	$data = $encryption;
	return $data;
}

function newPassENCRYPTE($data) {
	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;	
	$encryption_iv = '1234567891011121';
	$encryption_key = "+ObRG)moziZfrceSKxqs!T#BkMhavJ&gjpF%CY(N*DEPLAWdwVI@uUQl^yHtX_n";
	$encryption = openssl_encrypt($_POST['newpass'], $ciphering, $encryption_key, $options, $encryption_iv);
	$data = $encryption;
	return $data;
}
?>