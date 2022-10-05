<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
	
	$sql = "SELECT * FROM reviews WHERE review_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		if($row['status'] == '1'){
			$chk = $conn->prepare("UPDATE reviews SET status = 0 WHERE review_id = ?");
			$chk -> bind_param("s", $id);
			if($chk->execute()){
				echo 'unpublish';
			}else{
				echo 'failed';
			}
		}else{
			$chk = $conn->prepare("UPDATE reviews SET status = 1 WHERE review_id = ?");
			$chk -> bind_param("s", $id);
			if($chk->execute()){
				echo 'publish';
			}else{
				echo 'failed';
			}			
		}
	}else{
		echo 'invalid';
	}
}

?>