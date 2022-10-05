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
					<span id="edit_service_id" hidden>'.$row['service_id'].'</span>
					<div class="col-lg-4 col-4">
						<img src="'.web_root.'dist/img/services/'.$row['service_photo'].'" class="img-fluid w-100" id="editIMG">
						<input type="file" class="form-control-file pt-3" accept="image/*" id="preveditIMG">
					</div>
					<div class="col-lg-8 col-8">
						<div class="form-group">
							<label for="service_title_edit">Service Title</label>
							<input type="text" class="form-control" id="service_title_edit" placeholder="Enter Service Title" value="'.$row['service_title'].'">
						</div>							
						<div class="form-group">
							<label for="service_description_edit">Service Description</label>
							<textarea class="form-control" id="service_description_edit" rows="3" placeholder="Enter Service Description">'.$row['service_description'].'</textarea>
						</div>
						<div class="form-group">
							<label for="service_cost_edit">Service Cost</label>
							<input type="text" class="form-control" id="service_cost_edit" placeholder="₱ 0" value="'.$row['service_cost'].'">
						</div>
					</div>
				</div>
			</form>
			<script>
				preveditIMG.onchange = evt => {
					const[file] = preveditIMG.files
					if(file) {
						editIMG.src = URL.createObjectURL(file);
					}
				}
				$("#service_cost_edit").keypress(function(e) {
					$(this).val($(this).val().replace(/[^\d].+/, ""));
					if ((event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});	

				var myInput = document.getElementById("service_cost_edit");
				myInput.onpaste = e => e.preventDefault();				
			</script>
			';
		}
		echo $output;
	}
}

?>