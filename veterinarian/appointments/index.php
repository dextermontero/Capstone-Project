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
		<title>Done Appointments | Vets at Work Veterinary Clinic</title>
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
								<h1 class="m-0">Done Appointment List</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Done</h3>
									</div>
									<div class="card-body">
										<table id="done" class="table table-striped table-hover table-sm">
											<thead>
												<tr>
													<th class="py-1 px-2 text-nowrap">Appointment ID</th>
													<th class="py-1 px-2 text-nowrap">Full Name</th>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Pet Name</th>
													<th class="py-1 px-2 text-nowrap">Appointment Date</th>
													<th class="py-1 px-2 text-nowrap">Appointment Time</th>
													<th class="py-1 px-2 text-nowrap">Payment Status</th>
													<th class="py-1 px-2">Status</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT * FROM appointments WHERE status = 'done'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
												<tr>
													<td class="py-1 px-2"><?php echo $row['id']; ?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo $row['c_fullname']; ?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo $row['service']; ?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo $row['pet_name']; ?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date']));?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo $row['timeslot'];?></td>
													<?php
														if($row['payment_status'] == 'paid'){
													?>
															<td class="py-1 px-2 text-nowrap text-success">Paid</td>
													<?php
														}else {
													?>
															<td class="py-1 px-2 text-nowrap text-danger">Unpaid</td>
													<?php
														}
													?>
													
													<?php
														if($row['status'] == 'scheduled'){
													?>
															<td class="py-1 px-2 text-nowrap text-success">Scheduled</td>
													<?php
														}elseif($row['status'] == 'pending'){
													?>
															<td class="py-1 px-2 text-nowrap text-warning">Pending</td>
													<?php
														}elseif($row['status'] == 'cancelled'){
													?>
															<td class="py-1 px-2 text-nowrap text-danger">Cancelled</td>
														
													<?php
														}elseif($row['status'] == 'rescheduled'){?>
															<td class="py-1 px-2 text-nowrap text-purple">Rescheduled</td>
													<?php
														}else{
													?>
															<td class="py-1 px-2 text-nowrap text-primary">Done</td>
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
					</div><!-- /.container-fluid -->
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->

			<footer class="main-footer">
				<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 3.2.0
				</div>
			</footer>
		</div>
		<!--<div class="modal fade edit-appointment-modal" tabindex="-1" role="dialog" aria-labelledby="EditAppointment" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="EditAppointment">Update Appointment</h5>
						<button type="button" class="close" id="edit-service-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="view-appointment-modal"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-block" id="edit_service">Edit Service</button>
					</div>
				</div>
			</div>
		</div>-->
		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>veterinarian/appointments/js/appointment.js"></script><!-- REVISE THIS-->	
	</body>
</html>
