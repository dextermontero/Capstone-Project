<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['adm_id'])){
	$id = $_POST['adm_id'];
	if($id == $user){
		$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
		$r = $conn->query($s);
		if($r -> num_rows > 0){
			$rr = $r -> fetch_assoc();
			$id = $rr['admin_id'];
			$fullname = ucfirst($rr['firstname']) .' '. ucfirst($rr['lastname']);
			$date = date("Y-m-d");
			$time = date("H:i:s");
			$activity = "<b>$fullname</b> trying to delete own account.";
			$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
			$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
			if($ss->execute()){
				echo 'cannot';
			}else {
				echo 'failed';
			}
		}else{
			echo 'invalid';
		}
	}else{
		$date = date("Y-m-d");
		$time = date("H:i:s");
		// SELECT ADMIN DATA TO DELETE
		$ss = "SELECT admin_profile.admin_id, admin_profile.firstname, admin_profile.lastname, login_tbl.privilege FROM admin_profile INNER JOIN login_tbl ON admin_profile.admin_id = login_tbl.uid WHERE admin_profile.admin_id = '$id'";
		$result = $conn->query($ss);
		if($result -> num_rows > 0){
			$row = $result -> fetch_assoc();
			if($row['privilege'] == 1){
				$to_delete = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
				$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
				$r = $conn->query($s);
				if($r -> num_rows > 0){
					$rr = $r -> fetch_assoc();
					$id = $rr['admin_id'];
					$fullname = ucfirst($rr['firstname']) .' '. ucfirst($rr['lastname']);
					$activity = "<b>$fullname</b> failed to delete administrator name [$to_delete] because of superadmin role.";
					$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
					$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
					if($ss->execute()){
						echo 'superadmin';
					}else {
						echo 'failed';
					}						
				}else {
					echo 'invalid';
				}
			}else{
				$a = "SELECT firstname, lastname, photo FROM admin_profile WHERE admin_id = '$id'";
				$b = $conn->query($a);
				if($b -> num_rows > 0){
					$c = $b -> fetch_assoc();
					$to_delete = ucfirst($c['firstname']) .' '. ucfirst($c['lastname']);
					$specific = $c['photo'];
					$sql = "DELETE FROM login_tbl WHERE uid = '$id'";
					$sql1 = "DELETE FROM admin_profile WHERE admin_id = '$id'";
					$res = $conn->query($sql);
					$res1 = $conn->query($sql1);	
					if ($res && $res1) {
						$s = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$user'";
						$r = $conn->query($s);
						if($r -> num_rows > 0){
							$rr = $r -> fetch_assoc();
							$id = $rr['admin_id'];
							$fullname = ucfirst($rr['firstname']) .' '. ucfirst($rr['lastname']);					
							$activity = "<b>$fullname</b> successfuly to delete administrator name [$to_delete]";	
							$ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
							$ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
							if($ss->execute()){
								unlink("../../dist/img/profiles/$specific");
								echo 'success';
							}else {
								echo 'failed';
							}						
						}else{
							echo 'invalid';
						}									
					}else {
						echo 'invalid';
					}					
				}else{
					echo 'invalid';
				}
			}
		}else {
			echo 'invalid';
		}			
	}
}else{
	echo 'invalid';
}
?>