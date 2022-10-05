<?php
require_once("../../include/initialize.php");
session_start();
setlocale(LC_MONETARY, 'en_US');
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

if(isset($_POST['bid'])){
	$id = $_POST['bid'];
	$output = "";
	$sql = "SELECT * FROM branch WHERE branch_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		
		$output .= '
			<span id="branchID" hidden>'.$row['branch_id'].'</span>
			<div class="form-group">
				<label for="edit_branch_name">Branch Name</label>
				<input type="text" class="form-control" id="edit_branch_name" value="'.$row['name'].'">
			</div>							
			<div class="form-group">
				<label for="edit_branch_address">Branch Address</label>
				<textarea class="form-control" id="edit_branch_address" rows="3" placeholder="Enter Address">'.$row['address'].'</textarea>
			</div>
		';
		
		echo $output;
	}
}
?>