<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Add Pet | Vets at Work Veterinary</title>
		<?php include('../../include/header.php');?>
		<style type="text/css">
		#viewIMG {
			height : 215px;
			width: 216px;
		}
		@media only screen and (max-width: 768px) { 
			#viewIMG {
				height: 120px;
			}	
		}
		@media screen and (max-width: 800px) {
			#viewIMG {
				height: 120px;
			}	
		}
		@media screen and (max-width: 1000px) {
			#viewIMG {
				height: 120px;
			}
		}			
		</style>		
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			

			<!-- Main Sidebar Container -->
			<?php include('../../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
							<div class="col-sm-6">
								<h1 class="m-0">Add Pet</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
 							<div class="row">
								<div class="col-lg-4 col-12">
										<div class="card">
										<div class="card-body">
											<div class="d-flex flex-column align-items-center text-center">
												<img src="<?php echo web_root; ?>dist/img/pet_profile/default.png" class="img-fluid" alt="" width="150px" id="viewIMG">
												<div class="form-inline mt-3">
													<input type="file" class="form-control-file pt-3" accept="image/*" id="prevIMG"><span class="text-danger">*</span>
												</div>												
											</div>
										</div>
									 </div>
								</div> <!--col -->								
								<div class="col-lg-8 col-12">
									<div class="card-header">
										<div class="row mb-2">
											<div class="col-sm-8">
												<h5 class="m-0"> Pet Information</h5>
											</div><!-- /.col -->
										</div>							
									</div>									
									<div class="card-body">
										<form action="" method="POST">
											<div class="row">
												<div class="col-sm-3">
													<label for="pet_name" class="col-form-label font-weight-normal">Pet Name <span class="text-danger">*</span></label>
												</div>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="pet_name" placeholder="Enter Pet Name" >
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<label for="pet_type" class="col-form-label font-weight-normal">Pet Type <span class="text-danger">*</span></label>
												</div>
												<div class="col-sm-9">
													<select name="pet_type" class="form-control" id="pet_type">
														<option value="" selected disabled>--SELECT PET TYPE HERE HERE--</option>
														<option value="FELINE (Cat/Pusa)">FELINE (Cat/Pusa)</option>
														<option value="CANINE (Dog/Aso)">CANINE (Dog/Aso)</option>
													</select>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<label for="pet_breed" class="col-form-label font-weight-normal">Pet Breed <span class="text-danger">*</span></label>
												</div>
												<div class="col-sm-9">
													<input type="text" class="form-control" id="pet_breed" placeholder="Enter Pet Breed">
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<label for="pet_birthdate" class="col-form-label font-weight-normal">Pet Birthdate</label>
												</div>
												<div class="col-sm-9">
													<input type="date" class="form-control" id="pet_birthdate" onkeydown="return false" placeholder="Enter Pet Birthdate">
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-lg-6 col-12">
												
												</div>
												<div class="col-lg-6 col-12">
													<button type="submit" class="btn btn-success btn-block" id="add_pet">Add Pet</button>
												</div>												
											</div>											
										</form>
									</div>
								</div>
 							</div>
 						</div>
					</div>
				</section>
			</div>
			<footer class="main-footer">
				<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 3.2.0
				</div>
			</footer>
		</div>

		<?php include('../../include/footer.php');?>
		<script src="<?php echo $web_root;?>client/pets/add_pet/js/add_pet.js"></script>
	</body>
</html>
