<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Account Profile | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Profile Informations</h1>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
							<div class="row">
 								<div class="col-lg-4 col-12">								
 									<div class="card">
										<?php
											$sql = "SELECT vet_id, photo, firstname, lastname, position FROM vet_profile WHERE vet_id = $user";
											$result = $conn->query($sql);
											if($result -> num_rows > 0) {
												while($row = $result -> fetch_assoc()){
													$id = $row['vet_id'];
													$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
													$position = ucfirst($row['position']);
													$photo = $row['photo'];
										?>									
										<div class="float-right mt-3 mr-3">
											<span class="float-right">
												<a href="#" class="h6 change-profile-view" id="<?php echo $id; ?>" data-toggle="modal" data-target=".change-profile-modal"><i class="fas fa-edit"></i> Change Profile</a>
											</span>
										</div>
                						<div class="card-body">
											<div class="d-flex flex-column align-items-center text-center">
												<img src="<?php echo web_root; ?>dist/img/profiles/<?php echo $photo; ?>" class="rounded-circle" width="150" alt="<?php echo $fullname; ?>">
												<div class="mt-3">
													<h4><?php echo $fullname; ?></h4>
													<?php 
														if($position == "Superadmin"){
													?>
														<p class="text-danger mb-1"><?php echo $position; ?></p>
													<?php
														}else {
													?>
														<p class="text-success mb-1"><?php echo $position; ?></p>
													<?php
														}
													?>
													
												</div>
											</div>
               					 		</div>
										<?php
												}
											}
										?>										
             						 </div>	
									<div class="card ">
										<div class="card-header">
											<h3 class="card-title">Other Informations</h3>
										</div>
										<div class="card-body">									
											<ul class="list-group list-group-flush">
												<?php
													$sql = "SELECT branch.name, branch.address FROM branch LEFT JOIN vet_profile on vet_profile.branch_id = branch.branch_id WHERE vet_profile.vet_id = $user";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
													<li class="list-group-item"><b>Branch:</b> <?php echo ucfirst($row['name']); ?></li>
													<li class="list-group-item"><b>Address:</b> <?php echo $row['address']; ?></li>
												<?php
													}else{
												?>
													<li class="list-group-item"><b>Branch:</b> <i>No branch data</i></li>
													<li class="list-group-item"><b>Address:</b> <i>No branch data</i></li>
												<?php
													}
												?>												
											</ul>
										</div>
									</div>									 
 								</div>							
 								<div class="col-lg-8 col-12">
 									<div class="card-header">
										<div class="row mb-2">
											<div class="col-sm-8">
												<h5 class="m-0"> Personal Information</h5>
											</div><!-- /.col -->
											<div class="col-sm-4 text-right">
												<?php
													if(!isset($_COOKIE['edit-profile-vet']) == 'edit-profile-vet'){
												?>
													<button class="btn btn-info btn-sm edit-info">Edit Information</button>
												<?php
													}else{
												?>
													<button class="btn btn-danger btn-sm cancel-edit">Cancel</button>
												<?php
													}
												?>
											</div>
										</div>							
                  					</div>
									<div class="card-body">
										<?php
											$sql = "SELECT * FROM vet_profile WHERE vet_id = '$user'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												if(!isset($_COOKIE['edit-profile-vet']) == 'edit-profile-vet'){
													include("show_info.php");
												}else{
													include("edit_info.php");
												}
											}
										?>
										<?php
											if(isset($_COOKIE['edit-profile-vet']) == 'edit-profile-vet'){
										?>
										<div class="row">
											<div class="col-lg-12 col-12">
												<button type="submit" class="btn btn-outline-primary btn-md btn-block" id="save-changes">Save Changes</button>
											</div>
										</div>
										<?php
											}
										?>										
									</div>
								</div>
 							</div>
						</div>					
					</div>
				</section>
			</div>
			
			<div class="modal fade change-profile-modal" tabindex="-1" role="dialog" aria-labelledby="ChangeProfile" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="ChangeProfile">Change Profile</h5>
							<button type="button" class="close" id="change-profile-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="view-change-profile"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary btn-block" id="change_profile">Change Profile</button>
						</div>
					</div>
				</div>
			</div>
		
			<footer class="main-footer">
				<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 3.2.0
				</div>
			</footer>
		</div>

		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>js/jquery.cookie.js"></script>
		<script src="<?php echo web_root; ?>veterinarian/profile/profile.js"></script>
	</body>
</html>
