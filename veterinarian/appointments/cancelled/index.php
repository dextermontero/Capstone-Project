<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];	
}else{
	header("location: ../../../");
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
		<title>Cancelled Schedule | Vets at Work Veterinary Clinic</title>
		<?php include('../../include/header.php'); ?>	
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
								<h1 class="m-0">Cancel Appointments</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-6">
							<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_schedulded FROM appointments WHERE status = 'scheduled' AND branch_id = '$getBranch'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_pending = number_format($row['all_schedulded']);
										?>
										<h3><?php echo $count_pending; ?></h3>
										<?php
											}
										?>
										<p>Total Appointment Schedule</p>
									</div>
									<!--<a href="<?php echo web_root; ?>veterinarian/appointments/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-warning">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_pending FROM appointments WHERE status = 'pending' AND branch_id = '$getBranch'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_pending = number_format($row['all_pending']);
										?>
										<h3><?php echo $count_pending; ?></h3>
										<?php
											}
										?>
										<p>Pending Schedules</p>
									</div>
									<!--<a href="<?php echo web_root; ?>veterinarian/appointments/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-danger">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_cancelled FROM appointments WHERE status = 'cancel' AND branch_id = '$getBranch'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_cancelled = number_format($row['all_cancelled']);
										?>
										<h3><?php echo $count_cancelled; ?></h3>
										<?php
											}
										?>
										<p>Cancel Schedules</p>
									</div>
									<!--<a href="<?php echo web_root; ?>veterinarian/appointments/cancelled" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<!-- small box -->
								<div class="small-box bg-primary">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_done FROM appointments WHERE status = 'done' AND branch_id = '$getBranch'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_done = number_format($row['all_done']);
										?>
										<h3><?php echo $count_done; ?></h3>
										<?php
											}
										?>
										<p>Done Schedule</p>
									</div>
									<a href="<?php echo web_root; ?>veterinarian/appointments/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Cancelled Information</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="appointment" class="table table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2 text-nowrap">Full Name</th>
														<th class="py-1 px-2">Service</th>
														<th class="py-1 px-2">Pet Name</th>
														<th class="py-1 px-2 text-nowrap">Appointment Date</th>
														<th class="py-1 px-2 text-nowrap">Appointment Time</th>
														<th class="py-1 px-2 text-nowrap">Branch</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT appointments.*, services.service_title, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.status = 'cancel' AND appointments.branch_id = '$getBranch'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
														<tr>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['c_fullname']; ?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['service_title']; ?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['pet_name']; ?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date']));?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['timeslot'];?></td>
															<?php
																if($row['name'] == '' || $row['name'] == null){
															?>
																	<td class="py-1 px-2 text-nowrap">Not set</td>
															<?php
																}else {
															?>
																	<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['name']); ?></td>
															<?php
																}
															?>
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
	</body>
</html>
