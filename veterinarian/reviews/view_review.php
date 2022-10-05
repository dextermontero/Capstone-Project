<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}


$output = '';

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM reviews WHERE review_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		while($row = $result -> fetch_assoc()){
			$output .= '
			<form action="" method="POST">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">					
						<div class="form-group">
							<label for="review_title">Service</label>
							<input type="text" class="form-control" id="review_title" value="'.$row['review_service'].'" disabled>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="form-group">
							<label for="review_description">Description</label>
							<textarea rows="5" class="form-control" id="review_description" placeholder="Review Description" disabled>'.$row['review_description'].'</textarea>
						</div>
					</div>								
				</div>
			</form>			
			';
		}
		echo $output;
	}
}

?>