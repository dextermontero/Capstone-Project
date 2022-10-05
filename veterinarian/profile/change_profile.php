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
	$sql = "SELECT vet_id, photo FROM vet_profile WHERE vet_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0) {
		while($row = $result -> fetch_assoc()){
			$output .= '
			<style type="text/css">
			#editIMG {
				height : 315px;
				width: 100%;
			}
			@media only screen and (max-width: 768px) { 
				#editIMG {
					height: 315px;
				}	
			}
			@media screen and (max-width: 800px) {
				#editIMG {
					height: 315px;
				}	
			}
			@media screen and (max-width: 1000px) {
				#editIMG {
					height: 315px;
				}
			}			
			</style>
			<form action="" method="POST">
				<div class="row no-gutters justify-content-md-center">
					<span id="edit_profile" hidden>'.$row['vet_id'].'</span>
					<div class="col-lg-12 col-12">
						<img src="'.web_root.'dist/img/profiles/'.$row['photo'].'" class="img-fluid w-100" id="editIMG">
						<input type="file" class="form-control-file pt-3" accept="image/*" id="preveditIMG">
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
			</script>
			';
		}
		echo $output;
	}	
	
}
?>


