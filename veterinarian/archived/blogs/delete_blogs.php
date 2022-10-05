<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM archive WHERE archive_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		$blog_id = $row['id'];
		
		$query = "SELECT blog_photo FROM blogs WHERE blog_id = '$blog_id'";
		$result1 = $conn->query($query);
		if($result1 -> num_rows > 0) {
			$row1 = $result1 -> fetch_assoc();
			$specific = $row1['blog_photo'];
			unlink("../../../dist/img/blogs/$specific");
			
			$chk = $conn->prepare("DELETE FROM blogs WHERE blog_id = ?");
			$chk -> bind_param("s", $blog_id);
			$chk1 = $conn->prepare("DELETE FROM archive WHERE archive_id = ?");
			$chk1 -> bind_param("s", $id);
			if($chk->execute() && $chk1->execute()){
				echo 'success';
			}else{
				echo 'failed';
			}		
		}
	}else{
		echo 'failed';
	}		
}
?>