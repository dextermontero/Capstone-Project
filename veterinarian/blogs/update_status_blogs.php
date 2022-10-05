<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['sid'])){
	$id = $_POST['sid'];
	
	$sql = "SELECT status FROM blogs WHERE blog_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		if($row['status'] == 1){
			$chk = $conn->prepare("UPDATE blogs SET status = 0 WHERE blog_id = ?");
			$chk -> bind_param("s", $id);
			if($chk->execute()){
				echo 'unpublish';
			}else{
				echo 'failed';
			}
		}else{
			$chk = $conn->prepare("UPDATE blogs SET status = 1 WHERE blog_id = ?");
			$chk -> bind_param("s", $id);
			if($chk->execute()){
				echo 'publish';
			}else{
				echo 'failed';
			}			
		}
	}
}

?>