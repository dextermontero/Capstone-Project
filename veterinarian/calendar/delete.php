<?php

require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
//delete.php

if(isset($_POST["id"]))
{
	$id = $_POST['id'];
	$sql = $conn->prepare("DELETE from calendar_events WHERE id=?");
	$sql->bind_param("s", $id);
	if($sql->execute()){
		echo 'success';
	}else{
		echo 'failed';
	}
}

?>