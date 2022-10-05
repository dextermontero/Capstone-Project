<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
	
}else{
	header("location: ../../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Appointment Lists | Vets at Work Veterinary Clinic</title>
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
							<div class="col-sm-6">
								<h1 class="m-0">Appointment Lists</h1>
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
											$sql = "SELECT COUNT(*) as all_schedulded FROM appointments WHERE status = 'scheduled'";
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
											$sql = "SELECT COUNT(*) as all_pending FROM appointments WHERE status = 'pending'";
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
											$sql = "SELECT COUNT(*) as all_cancelled FROM appointments WHERE status = 'cancel'";
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
											$sql = "SELECT COUNT(*) as all_done FROM appointments WHERE status = 'done'";
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
										<h3 class="card-title">Appointment Information</h3>
										<!--<div class="card-tools">
											<div class="card-tools">
												<a class="btn btn-info float-right mb-2" href="<?php echo web_root; ?>veterinarian/appointments/scheduled/booking/"> Add Appointment</a>
											</div>
										</div>-->										
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<div class="row">
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-12">
													<div class="form-group">
														<label for="month">Month</label>
														<select class="form-control" id="month">
															<?php
																if(isset($_GET['month'])){
															?>
																<option value="January" 	<?php if($_GET['month'] == 'January'){ echo 'selected';} ?>>January</option>
																<option value="February" 	<?php if($_GET['month'] == 'February'){ echo 'selected';} ?>>February</option>
																<option value="March" 		<?php if($_GET['month'] == 'March'){ echo 'selected';} ?>>March</option>
																<option value="April" 		<?php if($_GET['month'] == 'April'){ echo 'selected';} ?>>April</option>
																<option value="May" 		<?php if($_GET['month'] == 'May'){ echo 'selected';} ?>>May</option>
																<option value="June" 		<?php if($_GET['month'] == 'June'){ echo 'selected';} ?>>June</option>
																<option value="July" 		<?php if($_GET['month'] == 'July'){ echo 'selected';} ?>>July</option>
																<option value="August" 		<?php if($_GET['month'] == 'August'){ echo 'selected';} ?>>August</option>
																<option value="September" 	<?php if($_GET['month'] == 'September'){ echo 'selected';} ?>>September</option>
																<option value="October" 	<?php if($_GET['month'] == 'October'){ echo 'selected';} ?>>October</option>
																<option value="November" 	<?php if($_GET['month'] == 'November'){ echo 'selected';} ?>>November</option>
																<option value="December" 	<?php if($_GET['month'] == 'December'){ echo 'selected';} ?>>December</option>													
															<?php
																}else{
															?>
																<option value="<?php echo date("F"); ?>" selected disabled><?php echo date("F"); ?></option>
																<option value="January">January</option>
																<option value="February">February</option>
																<option value="March">March</option>
																<option value="April">April</option>
																<option value="May">May</option>
																<option value="June">June</option>
																<option value="July">July</option>
																<option value="August">August</option>
																<option value="September">September</option>
																<option value="October">October</option>
																<option value="November">November</option>
																<option value="December">December</option>
															<?php
																}
															?>
														</select>
													</div>
												</div>
											</div>
											<table id="appointment" class="table table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2 text-nowrap">Date</th>
														<th class="py-1 px-2 text-nowrap">Full Name</th>
														<th class="py-1 px-2">Service</th>
														<th class="py-1 px-2">Pet Name</th>
														<th class="py-1 px-2 text-nowrap">Time</th>
														<th class="py-1 px-2 text-nowrap">Branch</th>
														<th class="py-1 px-2 text-nowrap">Payment Status</th>
														<th class="py-1 px-2">Status</th>
														<th class="py-1 px-2 text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														if(isset($_GET['month'])){
															$monNum = $_GET['month'];
															if($monNum == 'January'){
																$month = 1;
															}elseif($monNum == 'February'){
																$month = 2;
															}elseif($monNum == 'March'){
																$month = 3;
															}elseif($monNum == 'April'){
																$month = 4;
															}elseif($monNum == 'May'){
																$month = 5;
															}elseif($monNum == 'June'){
																$month = 6;
															}elseif($monNum == 'July'){
																$month = 7;
															}elseif($monNum == 'August'){
																$month = 8;
															}elseif($monNum == 'September'){
																$month = 9;
															}elseif($monNum == 'October'){
																$month = 10;
															}elseif($monNum == 'November'){
																$month = 11;
															}elseif($monNum == 'December'){
																$month = 12;
															}else{
																$month = date("n");
															}
														?>
															<?php
																$sql = "SELECT appointments.*, services.service_title, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.status = 'pending' AND month(date) = '$month' OR appointments.status = 'rescheduled' AND month(date) = '$month' OR appointments.status = 'scheduled' AND month(date) = '$month' ORDER BY appointments.id ASC";
																$result = $conn->query($sql);
																if($result -> num_rows > 0){
																	while($row = $result -> fetch_assoc()){
															?>
																<tr>
																	<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date']));?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['c_fullname']; ?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['service_title']; ?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['pet_name']; ?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['timeslot'];?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['name']); ?></td>
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
																	
																	<td class="text-center">
																	<?php
																		if($row['date'] == date("Y-m-d")){
																			if($row['status'] == 'scheduled' || $row['status'] == 'rescheduled'){
																			?>
																				<a class="btn btn-primary btn-sm send_invoice" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".send_invoice_modal">
																					<i class="fas fa-file-invoice"></i>
																					Invoice
																				</a>
																				<a class="btn btn-success btn-sm pay_appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-money-bill"></i>
																					Paid
																				</a>
																			<?php
																			}else{
																			?>
																				<a class="btn btn-primary btn-sm edit_appointment" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".edit-appointment-modal">
																					<i class="fas fa-edit"></i>
																					Update
																				</a>
																				<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-times"></i>
																					Cancel
																				</a>
																			<?php
																			}
																		}else{
																			if($row['status'] == 'pending'){
																			?>
																				<a class="btn btn-primary btn-sm edit_appointment" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".edit-appointment-modal">
																					<i class="fas fa-edit"></i>
																					Update
																				</a>
																				<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-times"></i>
																					Cancel
																				</a>
																			<?php
																			}else{
																			?>
																				<a class="btn btn-primary btn-sm" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																					<i class="fas fa-edit"></i>
																					Update
																				</a>
																				<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-times"></i>
																					Cancel
																				</a>
																			<?php
																			}
																		}
																	?>
																	</td>
																</tr>													
															<?php
																	}
																}
															?>														
														<?php
														}else{
														?>
															<?php
																$sql = "SELECT appointments.*, services.service_title, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.status = 'pending' OR appointments.status = 'rescheduled' OR appointments.status = 'scheduled' ORDER BY appointments.id DESC";
																$result = $conn->query($sql);
																if($result -> num_rows > 0){
																	while($row = $result -> fetch_assoc()){
															?>
																<tr>
																	<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date']));?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['c_fullname']; ?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['service_title']; ?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['pet_name']; ?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo $row['timeslot'];?></td>
																	<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['name']); ?></td>
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
																	
																	<td class="text-center">
																	<?php
																		if($row['date'] == date("Y-m-d")){
																			if($row['status'] == 'scheduled' || $row['status'] == 'rescheduled'){
																			?>
																				<a class="btn btn-primary btn-sm send_invoice" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".send_invoice_modal">
																					<i class="fas fa-file-invoice"></i>
																					Invoice
																				</a>
																				<a class="btn btn-success btn-sm pay_appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-money-bill"></i>
																					Paid
																				</a>
																			<?php
																			}else{
																			?>
																				<a class="btn btn-primary btn-sm edit_appointment" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".edit-appointment-modal">
																					<i class="fas fa-edit"></i>
																					Update
																				</a>
																				<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-times"></i>
																					Cancel
																				</a>
																			<?php
																			}
																		}else{
																			if($row['status'] == 'pending'){
																			?>
																				<a class="btn btn-primary btn-sm edit_appointment" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".edit-appointment-modal">
																					<i class="fas fa-edit"></i>
																					Update
																				</a>
																				<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-times"></i>
																					Cancel
																				</a>
																			<?php
																			}else{
																			?>
																				<a class="btn btn-primary btn-sm" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																					<i class="fas fa-edit"></i>
																					Update
																				</a>
																				<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																					<i class="fas fa-times"></i>
																					Cancel
																				</a>
																			<?php
																			}
																		}
																	?>
																	</td>
																</tr>													
															<?php
																	}
																}
															?>												
														<?php
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
		<div class="modal fade edit-appointment-modal" tabindex="-1" role="dialog" aria-labelledby="EditAppointment" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
						<button type="submit" class="btn btn-primary btn-block" id="edit_service">Update Appointment</button>
					</div>
					<span id="msg"></span>
				</div>
			</div>
		</div>
		
		<div class="modal fade send_invoice_modal" tabindex="-1" role="dialog" aria-labelledby="EditAppointment" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="EditAppointment">Invoice Details</h5>
						<button type="button" class="close" id="edit-service-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<span id="loading_details"></span>
						<div id="view-invoice-information"></div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-block" id="send_invoice_btn">Send Invoice</button>
					</div>
					<span id="invoice_msg"></span>
				</div>
			</div>
		</div>
		<?php include('../../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>veterinarian/appointments/scheduled/js/appointment.js"></script>
	</body>
</html>
