<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Profile Informations | Vets at Work Veterinary</title>
		<?php include('../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			

			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Profile Details</h1>
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
										<?php
											$sql = "SELECT * FROM user_profile WHERE user_id = '$user'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0) {
												$row = $result -> fetch_assoc();
												$id = $row['user_id'];
												$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
												$photo = $row['photo'];
										?>									
										<div class="float-right mt-3 mr-3">
											<span class="float-right">
												<a href="#" class="h6 change-profile-view" id="<?php echo $id; ?>" data-toggle="modal" data-target=".change-profile-modal"><i class="fas fa-edit"></i> Change Profile</a>
											</span>
										</div>									
                						<div class="card-body">
                			  				<div class="d-flex flex-column align-items-center text-center">
												<img src="<?php echo web_root; ?>dist/img/profiles/<?php echo $photo; ?>" alt="<?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname'])?>" class="rounded-circle" width="150">
												<div class="mt-3">
													<h4><?php echo $fullname; ?></h4>
													<button class="btn btn-outline-primary" hidden>Message</button>
												</div>
                 					 		</div>
               					 		</div>
										<?php
											}
										?>										
             						 </div>
									<div class="card ">								
										<div class="card-body">
											<div class="float-right">
												<a href="<?php echo web_root; ?>client/pets/add_pet/" class="btn btn-primary btn-sm float-right" ><i class="fas fa-plus"></i> Add Pet</a>
											</div>
											<br><br>										
											<div class="direct-chat-messages">
												<table id="pet" class="table table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Pet Name</th>
															<th class="py-1 px-2">Pet Breed</th>
															<th class="py-1 px-2 text-center">Action</th>
														</tr>
													</thead>												
													<tbody>
														<?php
															$sql = "SELECT * FROM pet_profile WHERE user_id = '$user' AND archive_status = '0'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
														<tr>
															<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
															<td class="py-1 px-2"><?php echo $row['pet_breed']; ?></td>
															<td class="py-1 px-2 text-center">
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/pets/profiles/profile.php?pet_id=<?php echo $row['pet_id'];?>">
																	<i class="fas fa-folder"></i>
																	View Pet Info
																</a>
															</td>
														</tr>
														<?php
																}
															}
														?>	
														<?php if($result->num_rows <=0): ?>
															<tr>
																<th class="text-center" colspan="3">No Pet Records.</th>
															</tr>
														<?php endif; ?>														
													</tbody>
												</table>
											</div>
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
													if(!isset($_COOKIE['edit-profile']) == 'edit-profile'){
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
											$sql = "SELECT * FROM user_profile WHERE user_id = '$user'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												
												if(!isset($_COOKIE['edit-profile']) == 'edit-profile'){
													include("show_info.php");
												}else{
													include("edit_info.php");
												}
											}
										?>
										<?php
											if(isset($_COOKIE['edit-profile']) == 'edit-profile'){
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
			<footer class="main-footer">
				<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 3.2.0
				</div>
			</footer>
			
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
		</div>
		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>js/jquery.cookie.js"></script>
		<script src="<?php echo web_root; ?>client/profile/profile.js"></script>		
	</body>
</html>
