<?php
require_once("include/initialize.php");
$output = '';
if(isset($_POST['sid'])){
	$sid = $_POST['sid'];
	$sql = "SELECT * FROM services WHERE service_id = '$sid'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		while($row = $result -> fetch_assoc()){
			$output .= '
				<style type="text/css">
				#editIMG {
					height : 100%;
					width: 90%;
				}
				@media only screen and (max-width: 768px) { 
					#editIMG {
						height: 100%;
						width: 80%;
					}	
				}
				@media screen and (max-width: 800px) {
					#editIMG {
						height: 100%;
						width: 80%;
					}	
				}
				@media screen and (max-width: 1000px) {
					#editIMG {
						height: 100%;
						width: 80%;
					}
				}
				</style>			
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="title_service">'.ucwords($row['service_title']).'</h5>
						<button type="button" class="btn-close" id="btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form action="" method="POST">
							<div class="row">
								<div class="col-lg-4 col-12" style="height:200px;margin-bottom:2%;">
									<img src="'.web_root.'dist/img/services/'.$row['service_photo'].'" class="img-fluid mx-auto d-block w-100" id="editIMG">
								</div>
								<div class="col-lg-8 col-12">
									<p>'.$row['service_description'].'</p>
									<span class="h4">₱ '.number_format($row['service_cost']).'</span>
								</div>
							</div>
						</form>
					</div>
				</div>
				';
		}
		echo $output;
	}
}
?>
