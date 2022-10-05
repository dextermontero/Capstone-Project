<?php
require_once("../../include/initialize.php");
session_start();
setlocale(LC_MONETARY, 'en_US');
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Branches | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
			<style type="text/css">
			#viewIMG {
				height : 80%;
				width: 100%;
			}
			@media only screen and (max-width: 768px) { 
				#viewIMG {
					height: 50%;
				}	
			}
			@media screen and (max-width: 800px) {
				#viewIMG {
					height: 50%;
				}	
			}
			@media screen and (max-width: 1000px) {
				#viewIMG {
					height: 50%;
				}
			}			
			</style>		
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Branches</h1>
							</div>
							<div class="col-sm-6">
								<button type="button" name="add-branch" id="add-branch" class="btn btn-outline-success float-right" data-toggle="modal" data-target=".add-branch-modal"><i class="fas fa-code-branch"></i> &nbsp;Add Branch</button>
							</div>							
						</div>
					</div>
				</section>
				
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<?php
								$sql = "SELECT * FROM branch WHERE archive_status = '0'";
								$result = $conn->query($sql);
								if($result -> num_rows > 0) {
									while($row = $result -> fetch_assoc()){
										$bid = $row['branch_id'];
										$title = ucfirst($row['name']);
										$address = $row['address'];

							?>
								<div class="col-lg-3 col-12">
									<div class="card">
										<div class="card-header">
											<h3 class="card-title"><?php if($row['status'] == '1'){ echo '<span class="text-success">[Active]</span>';}else{ echo '<span class="text-danger">[Inactive]</span>';}?>&nbsp;<b><?php echo $title; ?></b></h3>
											<div class="card-tools">
												<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
													<i class="fas fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-8 col-8">
													<span class="text-secondary">Branch Name</span>
													<p class="h5"><?php echo ucfirst($title); ?></p>
													<span class="text-secondary">Branch Address</span>
													<p class="h5"><?php echo ucfirst($address); ?></p>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="row">
												<div class="col-lg-6 col-6">
													<a class="btn btn-primary btn-sm float-left view-branch" href="#" id="<?php echo $bid; ?>" data-toggle="modal" data-target=".edit-branch-modal">
														<i class="fas fa-edit"></i>
														Edit
													</a>
												</div>
												<div class="col-lg-6 col-6">
													<a class="btn btn-danger btn-sm float-right archive-branch" href="#" id="<?php echo $bid; ?>">
														<i class="fas fa-archive"></i>
														Archive
													</a>										
												</div>
											</div>
										</div>
									</div>						
								</div>						
							<?php
									}
								}
							?>						
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
		
		<div class="modal fade edit-branch-modal" tabindex="-1" role="dialog" aria-labelledby="EditService" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="EditService">Edit Branch</h5>
						<button type="button" class="close" id="edit-branch-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-12">
								<div id="view_branch_modal"></div>
								<button type="submit" class="btn btn-success btn-block" id="edit_branch">Update Branch</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade add-branch-modal" tabindex="-1" role="dialog" aria-labelledby="AddService" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AddService">Add Branch</h5>
						<button type="button" class="close" id="add-branch-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="" method="POST">
							<div id="view_branch"></div>
							<div class="row">
								<div class="col-lg-12 col-12">
									<div class="form-group">
										<label for="branch_name">Branch Name</label>
										<input type="text" class="form-control" id="branch_name" placeholder="Enter Branch Name">
									</div>							
									<div class="form-group">
										<label for="branch_address">Branch Address</label>
										<textarea class="form-control" id="branch_address" rows="3" placeholder="Enter Address"></textarea>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-outline-success btn-block" id="add_branch">Save Branch</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root;?>admin/branches/branch.js"></script>
	</body>
</html>
