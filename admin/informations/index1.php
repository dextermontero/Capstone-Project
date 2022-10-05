<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Informations | Punzalan Vet Administrator</title>
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
								<h1>Customer Managements</h1>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-6">
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
										<p>Total Customer</p>
									</div>
									<div class="icon">
										<i class="ion ion-bag"></i>
									</div>
									<a href="<?php echo web_root?>admin/informations/clients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3>0</h3>
										<p>Total Pet</p>
									</div>
									<div class="icon">
										<i class="ion ion-stats-bars"></i>
									</div>
									<a href="<?php echo web_root?>admin/informations/pets" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>				
						</div>						
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Customer Lists</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="info_client" class="table table-borderedless table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Customer ID</th>
												<th class="py-1 px-2">First Name</th>
												<th class="py-1 px-2">Last Name</th>
												<th class="py-1 px-2">Date Created</th>
												<th class="py-1 px-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$sql = "SELECT user_id, firstname, lastname, create_date FROM user_profile";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
											?>
												<tr>
													<td class="py-1 px-2"><?php echo $row['user_id']; ?></td>
													<td class="py-1 px-2"><?php echo ucfirst($row['firstname']); ?></td>
													<td class="py-1 px-2"><?php echo ucfirst($row['lastname']); ?></td>
													<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['create_date'])); ?></td>
													<td class="py-1 px-2">Secret</td>
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
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Pet Lists</h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="info_pet" class="table table-borderedless table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Pet ID</th>
												<th class="py-1 px-2">Pet Name</th>
												<th class="py-1 px-2">Breed</th>
												<th class="py-1 px-2">Age</th>
												<th class="py-1 px-2">Status</th>
												<th class="py-1 px-2">Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="py-1 px-2">1</td>
												<td class="py-1 px-2">D</td>
												<td class="py-1 px-2">M</td>
												<td class="py-1 px-2">Today</td>
												<td class="py-1 px-2">Active</td>
												<td class="py-1 px-2">Secret</td>
											</tr>
										</tbody>
									</table>
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

		<?php include('../include/footer.php'); ?>	
	</body>
</html>
