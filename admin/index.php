<?php
require_once("../include/initialize.php");
session_start();
$redirect = "redirect";
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
  	setcookie($redirect, "61646d696e", time() + 30 * 60 * 1000, "/");
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Dashboard | Vets at Work Veterinary Clinic</title>
		<?php include('include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('include/sidebar.php'); ?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Dashboard</h1>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_customer FROM user_profile";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_client = number_format($row['all_customer']);
										?>
										<h3><?php echo $count_client; ?></h3>
										<?php
											}
										?>
										<p>Total Pet Owners</p>
									</div>
									<a href="<?php echo web_root?>admin/informations/clients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_pet FROM pet_profile";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_pet = number_format($row['all_pet']);
										?>
										<h3><?php echo $count_pet; ?></h3>
										<?php
											}
										?>
										<p>Total Pets</p>
									</div>
									<a href="<?php echo web_root?>admin/informations/pets" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_vet FROM vet_profile WHERE position = 'veterinarian'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_vet = number_format($row['all_vet']);
										?>
										<h3><?php echo $count_vet; ?></h3>
										<?php
											}
										?>
										<p>Total Veterinarians</p>
									</div>
									<a href="<?php echo web_root?>admin/veterinarian" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_admin FROM admin_profile WHERE position = 'administrator' OR position = 'superadmin'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_admin = number_format($row['all_admin']);
										?>
										<h3><?php echo $count_admin; ?></h3>
										<?php
											}
										?>
										<p>Total Administrators</p>
									</div>
									<a href="<?php echo web_root?>admin/administrator" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>				
						</div>
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-6 col-12">
								<div class="card">
									<div class="card-body">
										<canvas id="graphCanvas"></canvas>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-12">
								<div class="card">
									<div class="card-body">
										<canvas id="pie-chartcanvas-1"></canvas>
									</div>									
								</div>
							</div>
						</div>
                     	<!--<div class="row">
                        	<div class="col-lg-6 col-12">
                          		<div class="card">
									<div class="card-body">
										<canvas id="line-chart"></canvas>
									</div>									
								</div>
                          	</div>
                      	</div>-->
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

		<?php include('include/footer.php'); ?>
		<script src="<?php echo web_root; ?>js/Chart.min.js"></script>
		<script src="<?php echo web_root; ?>admin/js/graph.js"></script>		
	</body>
</html>
