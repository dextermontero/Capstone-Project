<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Archived Services | Vets at Work Veterinary Clinic</title>
		<?php include('../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../../include/sidebar.php'); ?>
			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Archived Services</h1>
							</div>
						</div>
					</div>
				</div>
				
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4 col-12">
								<div class="d-flex flex-column flex-grow-1">
									<div class="small-box bg-info">
										<div class="inner">
											<?php
												$sql = "SELECT COUNT(*) as all_services FROM archive WHERE category = 'services' AND user_id = '$user'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													$row = $result -> fetch_assoc();
													$count_services = number_format($row['all_services']);
											?>
											<h3><?php echo $count_services; ?></h3>
											<?php
												}
											?>
											<p>Archived Services</p>
										</div>
									</div>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">								
									<div class="card-body">
										<div class="table-responsive">
											<table id="prescription" class="table table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Service Title</th>
														<th class="py-1 px-2">Service Description</th>
														<th class="py-1 px-2 text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
															$sql = "SELECT archive.archive_id, services.service_title, services.service_description FROM archive INNER JOIN services ON services.service_id = archive.id WHERE archive.category = 'services' AND archive.user_id = '$user';";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
															<tr>
																<td class="py-1 px-2"><?php echo ucfirst($row['service_title']); ?></td>
																<td class="py-1 px-2"><?php echo ucfirst($row['service_description']); ?></td>
																<td class="py-1 px-2 text-center">
																	<a class="btn btn-info btn-sm recover-service" href="" id="<?php echo $row['archive_id']; ?>">
																		<i class="fas fa-trash-restore"></i>
																		Recover
																	</a>																		
																	<a class="btn btn-danger btn-sm delete-service" href="" id="<?php echo $row['archive_id']; ?>">
																		<i class="fas fa-archive"></i>
																		Delete
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

		<?php include('../../include/footer.php'); ?>
		<script src="<?php echo web_root;?>admin/archived/services/services.js"></script>
	</body>
</html>
