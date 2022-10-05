<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$output = '';

if(isset($_POST['sid'])){
	$sid = $_POST['sid'];
	$sql = "SELECT * FROM blogs WHERE blog_id = '$sid'";
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
					<span id="edit_blog_id" hidden>'.$row['blog_id'].'</span>
					<div class="col-lg-4 col-4">
						<img src="'.web_root.'dist/img/blogs/'.$row['blog_photo'].'" class="img-fluid w-100" id="editIMG">
						<input type="file" class="form-control-file pt-3" accept="image/*" id="preveditIMG">
					</div>
					<div class="col-lg-8 col-8">
						<div class="form-group">
							<label for="blog_title_edit">Blog Title</label>
							<input type="text" class="form-control" id="blog_title_edit" placeholder="Enter Blog Title" value="'.$row['blog_title'].'">
						</div>							
						<div class="form-group">
							<label for="blog_description_edit">Blog Description</label>
							<textarea class="form-control" id="blog_description_edit" rows="7" placeholder="Enter Blog Description">'.$row['blog_description'].'</textarea>
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
			</script>
			';
		}
		echo $output;
	}
}

?>