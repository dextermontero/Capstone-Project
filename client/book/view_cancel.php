<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$output = '';
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM appointments WHERE id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		while($row = $result -> fetch_assoc()){
			$output .= '
			<span id="can-id" hidden>'.$row['id'].'</span>
			<p>Cancelling may affect your scheduled appointment, do you agree with the terms and condition of cancelling your appointment?</p>			
			';
		}
		echo $output;
	}
}
?>