<?php
require_once("../include/initialize.php");
session_start();
$redirect = "redirect";
if($_SESSION['roles'] == 'veterinarian'){
  	setcookie($redirect, "7665746572696e617269616e", time() + 30 * 60 * 1000, "/");
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
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Dashboard</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<!-- Small boxes (Stat box) -->
												<div class="row">
							<div class="col-lg-3 col-6">
							<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
										<?php
											$date = date("Y-m-d");
											$sql = "SELECT COUNT(*) as all_schedulded FROM appointments WHERE date = '$date' AND status = 'scheduled' AND archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_scheduled = number_format($row['all_schedulded']);
										?>
										<h3><?php echo $count_scheduled; ?></h3>
										<?php
											}
										?>									
										<p>Appointments Today</p>
									</div>
									<!--<a href="<?php echo web_root?>veterinarian/appointments/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-warning">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_client FROM user_profile WHERE archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_client = number_format($row['all_client']);
										?>
										<h3><?php echo $count_client; ?></h3>
										<?php
											}
										?>	
										<p>Pet Owner Informations</p>
									</div>
									<!--<a href="<?php echo web_root?>veterinarian/informations/clients/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_pet FROM pet_profile WHERE archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_pet = number_format($row['all_pet']);
										?>
										<h3><?php echo $count_pet; ?></h3>
										<?php
											}
										?>
										<p>Pet Informations</p>
									</div>
									<!--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-primary">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_done FROM appointments WHERE status = 'done' AND archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_done = number_format($row['all_done']);
										?>
										<h3><?php echo $count_done; ?></h3>
										<?php
											}
										?>
										<p>Done Appointments</p>
									</div>
									<!--<a href="<?php echo web_root?>veterinarian/appointments/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>							
						</div>					
						<div class="row">
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Appointment Today List</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive" style="overflow-x: auto; height: 388px;">
											<table class="table table-borderedless table-hover table-sm">
												<thead>
													<tr>
														<th>Full Name</th>
														<th>Service</th>
														<th>Service</th>
														<th>Date - Time</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$date = date("Y-m-d");
														$sql = "SELECT appointments.c_fullname, services.service_title, appointments.status, appointments.date, appointments.timeslot FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.date = '$date' AND appointments.status = 'scheduled' OR appointments.date = '$date' AND appointments.status = 'rescheduled' ORDER BY appointments.timeslot ASC";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td><?php echo $row['c_fullname']; ?></td>
														<td><?php echo $row['service_title']; ?></td>
														
														<?php
															if($row['status'] == 'scheduled'){
														?>
															<td class="text-success"><?php echo ucfirst($row['status']); ?></td>
														<?php
															}else{
														?>
															<td class="text-purple"><?php echo ucfirst($row['status']); ?></td>
														<?php
															}
														?>
														<td><?php echo date("F d, Y", strtotime($row['date'])) .' - '.$row['timeslot']; ?></td>
													</tr>
													<?php
															}
														}
													?>
													<?php if($result->num_rows <=0): ?>
														<tr>
															<th class="text-center" colspan="4">No Appointment Today.</th>
														</tr>
													<?php endif; ?>														
												</tbody>	
											</table>
										</div>
									</div>
								</div>								
							</div>
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<div class="card-title">
											Services Pie Chart
										</div>
									</div>
									<div class="card-body">
										<canvas id="pie-chartcanvas-1"></canvas>
									</div>									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Registered Pet Owner Account</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-borderedless table-hover table-striped table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Last Name</th>
														<th class="py-1 px-2">First Name</th>
														<th class="py-1 px-2">Date Create</th>
														<th class="py-1 px-2">Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
                                                  		$date = date("Y-m-d");
														$sql = "SELECT user_profile.lastname, user_profile.firstname, user_profile.create_date, login_tbl.verification FROM user_profile LEFT JOIN login_tbl ON login_tbl.uid = user_profile.user_id WHERE user_profile.create_date = '$date'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
														<tr>
															<td class="py-1 px-2"><?php echo ucfirst($row['lastname']); ?></td>
															<td class="py-1 px-2"><?php echo ucfirst($row['firstname']); ?></td>
															<td class="py-1 px-2"><?php echo ucfirst($row['create_date']); ?></td>
															<?php
																if($row['verification'] == 'active'){
															?>
																<td class="py-1 px-2 text-success"><?php echo ucfirst($row['verification']); ?></td>
															<?php
																}else{
															?>
																<td class="py-1 px-2 text-danger"><?php echo ucfirst($row['verification']); ?></td>
															<?php
																}
															?>
															
														</tr>
													<?php
															}
														}
													?>
													<?php if($result->num_rows <=0): ?>
														<tr>
															<th class="text-center" colspan="4">NO REGISTER TODAY.</th>
														</tr>
													<?php endif; ?>														
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

		<?php include('include/footer.php'); ?>
		<script src="<?php echo web_root; ?>js/Chart.min.js"></script>
		<script src="<?php echo web_root; ?>veterinarian/js/pie_chart.js"></script>
	</body>
</html>
