<?php
session_start();
require_once('./include/initialize.php');
$email = verify($_POST['email']);
$pass = encrypteCTR($_POST['pass']);


if(!empty($email) && !empty($pass)){
	$counter = time() - 60;
	$ipadd = getIpAddress();
	$chk_login_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT count(*) AS counter FROM tbl_login_attempts WHERE counter > $counter AND ip_address = '$ipadd'"));
	$total_count = $chk_login_row['counter'];
	if($total_count == 5){
		echo 'attempt';
	}else{
		$sql = "SELECT uid, email, password, roles, verification, archive_status FROM login_tbl WHERE email = '$email' AND password = '$pass'";
		$result = $conn->query($sql);
		if($result -> num_rows > 0){
			$row = $result->fetch_assoc();
			if($row['archive_status'] == '0'){
				if($row['roles'] == 'client' && $row['verification'] == 'active'){
					$_SESSION['roles'] = $row['roles'];
					$_SESSION['login_id'] = $row['uid'];
					$i = $row['uid'];
					$a = "SELECT user_id, firstname, lastname FROM user_profile WHERE user_id = '$i'";
					$ar = $conn->query($a);
					if($ar -> num_rows > 0){
						$arr = $ar -> fetch_assoc();
						$id = $arr['user_id'];
						$fullname = ucfirst($arr['firstname']) .' '. ucfirst($arr['lastname']);
						$date = date("Y-m-d");
						$time = date("H:i:s");
						$activity = "Log on at client portal";
						$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
						$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
						if($ab->execute()){
							echo 'client';
							mysqli_query($conn, "DELETE FROM tbl_login_attempts WHERE ip_address = '$ipadd'");
						}else {
							echo 'failed';
							$ip = getIpAddress();
							$time = time();
							$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
							$result = $conn->query($sqlTempt);						
						}
					}
				}elseif($row['roles'] == 'administrator' && $row['verification'] == 'active' || $row['roles'] == 'superadmin' && $row['verification'] == 'active' || $row['roles'] == 'veterinarian' && $row['verification'] == 'active'){
					echo 'error';
				}else{
					echo 'verify';		
				}				
			}else{
				echo 'archive';
			}
		}else {
			echo 'no_account';
			$ip = getIpAddress();
			$time = time();
			$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
			$result = $conn->query($sqlTempt);			
		}		
	}
}

function encrypteCTR($data) {
	$ciphering = "AES-128-CTR";
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options = 0;	
	$encryption_iv = '1234567891011121';
	$encryption_key = "+ObRG)moziZfrceSKxqs!T#BkMhavJ&gjpF%CY(N*DEPLAWdwVI@uUQl^yHtX_n";
	$encryption = openssl_encrypt($_POST['pass'], $ciphering, $encryption_key, $options, $encryption_iv);
	$data = $encryption;
	return $data;
}

function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getIpAddress(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ipAddr = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ipAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else {
		$ipAddr = $_SERVER['REMOTE_ADDR'];
	}
	return $ipAddr;
}
?>