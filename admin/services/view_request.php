<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$output = '';

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM services WHERE service_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		while($row = $result -> fetch_assoc()){
			$output .= '
			<style type="text/css">
			#editIMG {
				height : 80%;
				width: 100%;
			}
			@media only screen and (max-width: 768px) { 
				#editIMG {
					height: 50%;
				}	
			}
			@media screen and (max-width: 800px) {
				#editIMG {
					height: 50%;
				}	
			}
			@media screen and (max-width: 1000px) {
				#editIMG {
					height: 50%;
				}
			}			
			</style>
			<form action="" method="POST">
				<div class="row">
					<span id="request_id" hidden>'.$row['service_id'].'</span>
					<div class="col-lg-4 col-4">
						<img src="'.web_root.'dist/img/services/'.$row['service_photo'].'" class="img-fluid w-100" id="viewIMG">
					</div>
					<div class="col-lg-8 col-8">
						<div class="form-group">
							<label for="request_title">Service Title</label>
							<input type="text" class="form-control" id="request_title" placeholder="'.$row['service_title'].'" value="'.$row['service_title'].'" disabled>
						</div>							
						<div class="form-group">
							<label for="request_description">Service Description</label>
							<textarea class="form-control" id="request_description" rows="3" placeholder="'.$row['service_description'].'" disabled>'.$row['service_description'].'</textarea>
						</div>
						<div class="form-group">
							<label for="request_cost">Service Cost</label>
							<input type="text" class="form-control" id="request_cost" placeholder="₱  '.$row['service_cost'].'" value="₱  '.number_format($row['service_cost']).'" disabled>
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