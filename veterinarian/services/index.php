<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$sql = "SELECT branch_id FROM vet_profile WHERE vet_id = '$user'";
$result = $conn->query($sql);
$getBranch = "";
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$getBranch = $row['branch_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Services | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Services</h1>
							</div>
							<div class="col-sm-6">
								<button type="button" name="add-service" id="add-service" class="btn btn-outline-success float-right" data-toggle="modal" data-target=".add-service-modal"><i class="fas fa-plus"></i> &nbsp;Add Service</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
									<div class="card">
							<div class="card-header">
								<h3 class="card-title text-uppercase"><b>Request Services</b></h3>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="vet_request" class="table table-borderedless table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Service Title</th>
												<th class="py-1 px-2">Service Description</th>
												<th class="py-1 px-2">Service Cost</th>
												<th class="py-1 px-2">Status</th>
												<th class="py-1 px-2 text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$sql = "SELECT service_id, service_title, service_description, service_cost, vet_request, status FROM services WHERE status = '0' AND archive_status = '0'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
														
											?>
												<tr>
													<td class="py-1 px-2"><?php echo $row['service_title']; ?></td>
													<td class="py-1 px-2 text-wrap"><?php echo $row['service_description']; ?></td>
													<td class="py-1 px-2">₱ <?php echo number_format($row['service_cost']); ?></td>
													<?php
														if($row['status'] == 0){
													?>
														<td class="py-1 px-2 text-info font-weight-bolder">Pending</td>
													<?php
														}
													?>
													
													<td class="py-1 px-2 text-center" style="width:15%">
														<a class="btn btn-primary btn-sm service-update" id="<?php echo $row['service_id']; ?>" data-toggle="modal" data-target=".edit-service-modal">
															<i class="fas fa-edit"></i>
															Edit
														</a>
														<a class="btn btn-danger btn-sm service-archive" id="<?php echo $row['service_id']; ?>">
															<i class="fas fa-archive"></i>
															Archive
														</a>
													</td>
												</tr>											
											<?php
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>		
						<div class="row">
							<?php
								$sql = "SELECT service_id, service_title, service_description, service_cost, service_photo FROM services WHERE status = '1' AND archive_status = '0' AND branch_id = '$getBranch' OR status = '1' AND archive_status = '0' AND branch_id = 'all'";
								$result = $conn->query($sql);
								if($result -> num_rows > 0) {
									while($row = $result -> fetch_assoc()){
										$title = strtoupper($row['service_title']);
										$photo = $row['service_photo'];
										$description = $row['service_description'];
										$cost = number_format($row['service_cost'], 2);

							?>
								<div class="col-lg-6 col-12">
									<div class="card">
										<div class="card-header">
											<h3 class="card-title"><b><?php echo $title; ?></b></h3>
											<div class="card-tools">
												<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
													<i class="fas fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-4 col-4">
													<img src="<?php echo web_root; ?>dist/img/services/<?php echo $photo; ?>" class="img-fluid w-100" alt="<?php echo $photo; ?>">
												</div>
												<div class="col-lg-8 col-8">
													<p class="h5"><?php echo substr($description, 0, 300); ?></p>
													<span class="h4">₱ <?php echo $cost; ?></span>
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
		
		
		<div class="modal fade add-service-modal" tabindex="-1" role="dialog" aria-labelledby="AddServiceVet" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AddServiceVet">Add Service</h5>
						<button type="button" class="close" id="add-service-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-4 col-4">
								<img src="<?php echo web_root; ?>dist/img/services/default.png" class="img-fluid w-100" id="viewIMG">
								<input type="file" class="form-control-file pt-3" accept="image/*" id="prevIMG">
							</div>
							<div class="col-lg-8 col-8">
								<div class="form-group">
									<label for="service_title">Service Title</label>
									<input type="text" class="form-control" id="service_title" placeholder="Enter Service Title">
								</div>							
								<div class="form-group">
									<label for="service_description">Service Description</label>
									<textarea class="form-control" id="service_description" rows="3" placeholder="Enter Service Description"></textarea>
								</div>
								<div class="form-group">
									<label for="service_cost">Service Cost</label>
									<input type="text" class="form-control" id="service_cost" placeholder="₱ 0">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="add_service">Add Service</button>
					</div>
				</div>
			</div>
		</div>	

		<div class="modal fade edit-service-modal" tabindex="-1" role="dialog" aria-labelledby="EditService" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="EditService">Edit Service</h5>
						<button type="button" class="close" id="edit-service-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="view-service-modal"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" id="edit_service">Edit Service</button>
					</div>
				</div>
			</div>
		</div>		

		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>veterinarian/services/services.js"></script>
	</body>
</html>
