<?php
require_once('./include/initialize.php');
session_start();

$status = 'active';
$ipadd = getIpAddress();
$code = verify($_POST['code']);
$chk = "SELECT code FROM login_tbl WHERE code = '$code'";
$result = $conn->query($chk);
if($result -> num_rows > 0){
	$sql = $conn->prepare("UPDATE login_tbl SET verification = ? WHERE code = ?");
	$sql->bind_param("ss", $status, $code);
	if($sql->execute()){
		$aa = "SELECT uid, roles FROM login_tbl WHERE code = '$code'";
		$b = $conn->query($aa);
		if($b -> num_rows > 0){
			$c = $b -> fetch_assoc();
			if($c['roles'] == 'administrator' || $c['roles'] == 'superadmin'){
				$_SESSION['roles'] = $c['roles'];
				$_SESSION['login_id'] = $c['uid'];
				$i = $c['uid'];
				$a = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$i'";
				$ar = $conn->query($a);
				if($ar -> num_rows > 0){
					$arr = $ar -> fetch_assoc();
					$id = $arr['admin_id'];
					$fullname = ucfirst($arr['firstname']) .' '. ucfirst($arr['lastname']);
					$date = date("Y-m-d");
					$time = date("H:i:s");
					$activity = "Log on at administrator portal";
					$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
					$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
					if($ab->execute()){
						echo 'administrator';
						mysqli_query($conn, "DELETE FROM tbl_login_attempts WHERE ip_address = '$ipadd'");
					}else {
						echo 'failed';
						$ip = getIpAddress();
						$time = time();
						$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
						$result = $conn->query($sqlTempt);										
					}
				}
			}elseif($c['roles'] == 'veterinarian'){
				$_SESSION['login_id'] = $c['uid'];
				$_SESSION['roles'] = $c['roles'];
				$i = $c['uid'];
				$a = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$i'";
				$ar = $conn->query($a);
				if($ar -> num_rows > 0){
					$arr = $ar -> fetch_assoc();
					$id = $arr['vet_id'];
					$fullname = ucfirst($arr['firstname']) .' '. ucfirst($arr['lastname']);
					$date = date("Y-m-d");
					$time = date("H:i:s");
					$activity = "Log on at vet clinic portal";
					$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
					$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
					if($ab->execute()){
						echo 'veterinarian';
						mysqli_query($conn, "DELETE FROM tbl_login_attempts WHERE ip_address = '$ipadd'");
					}else {
						echo 'failed';
						$ip = getIpAddress();
						$time = time();
						$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
						$result = $conn->query($sqlTempt);					
					}
				}			
			}else{
				$_SESSION['login_id'] = $c['uid'];
				$_SESSION['roles'] = $c['roles'];
				$i = $c['uid'];
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
			}
		}else{
			echo 'failed';
		}
	}else{
		echo 'failed';
	}	
}else{
	echo 'invalid';
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