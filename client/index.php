<?php
require_once("../include/initialize.php");
session_start();
$redirect = "redirect";
if($_SESSION['roles'] == 'client'){
  	setcookie($redirect, "636c69656e74", time() + 30 * 60 * 1000, "/");
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Activity | Vets at Work Veterinary</title>
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
								<h1>Activities</h1>
							</div>
						</div>
					</div>
				</section>
				
				<section class="content">
					<div class="container-fluid">
						<div class="callout callout-info">
							
							<?php
								$date = date("Y-m-d");
								$sql = "SELECT appointments.c_fullname, services.service_title, appointments.timeslot FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.date = '$date' AND appointments.status = 'scheduled' AND appointments.user_id = '$user'";
								$result = $conn->query($sql);
								if($result -> num_rows > 0){
									$row = $result -> fetch_assoc();
							?>
								<h5>You have appointment today!</h5>
								<p class="h5">Service : <?php echo $row['service_title']; ?> <br>Time : <?php echo $row['timeslot']; ?></p>
							<?php
								}else{
							?>
								<h5>You don't have appointment this day!</h5>
							<?php
								}
							?>
							
						</div>
						<div class="row">
							<div class="col-lg-6 col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">
											Upcoming Appointments
										</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive" style="overflow-x: auto; height: 250px;">
											<table id="upcoming_client" class="table table-borderedless table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Service</th>
														<th class="py-1 px-2">Date</th>
														<th class="py-1 px-2">Time</th>
														<th class="py-1 px-2">Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT appointments.c_fullname, services.service_title, appointments.date, appointments.timeslot, appointments.status FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.status = 'scheduled' AND appointments.user_id = '$user' OR appointments.status = 'rescheduled' AND appointments.user_id = '$user' ORDER BY appointments.date ASC";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['service_title']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
													<?php
														if($row['status'] == 'scheduled'){
													?>
															<td class="py-1 px-2 text-nowrap text-success">Scheduled</td>
													<?php
														}else{
													?>
															<td class="py-1 px-2 text-nowrap text-purple">Rescheduled</td>
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
							<div class="col-lg-6 col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">
											Previous Appointments
										</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive" style="overflow-x: auto; height: 250px;">
											<table id="done_client" class="table table-borderedless table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Service</th>
														<th class="py-1 px-2">Date</th>
														<th class="py-1 px-2">Time</th>
														<th class="py-1 px-2">Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT appointments.c_fullname, services.service_title, appointments.date, appointments.timeslot, appointments.status FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.status = 'done' AND appointments.user_id = '$user' ORDER BY appointments.id ASC";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['service_title']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
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
						</div>
						<div class="row">
							<div class="col-lg-6 col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">
											Prescription Records
										</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive" style="overflow-x: auto; height: 250px;">
											<table id="prescription_client" class="table table-borderedless table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2 text-nowrap">Pet Name</th>
														<th class="py-1 px-2 text-nowrap">Filename</th>
														<th class="py-1 px-2 text-nowrap">Date</th>
														<th class="py-1 px-2 text-nowrap text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT prescription_records.pet_id, prescription_records.prescription_name, prescription_records.filename, prescription_records.veterinarian, prescription_records.date, pet_profile.pet_name FROM prescription_records INNER JOIN pet_profile ON pet_profile.pet_id = prescription_records.pet_id WHERE prescription_records.archive_status = '0' AND prescription_records.user_id = '$user' ORDER BY prescription_records.date ASC";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td class="py-1 px-2 text-nowrap"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2 text-nowrap"><?php echo $row['prescription_name']; ?></td>
														<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2 text-nowrap text-center">
															<a href="<?php echo web_root;?>dist/img/pet_profile/prescription/<?php echo $row['filename']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
																<i class="far fa-eye"></i>&nbsp;
																View
															</a>
															<a href="<?php echo web_root;?>dist/img/pet_profile/prescription/<?php echo $row['filename']; ?>" target="_blank" class="btn btn-outline-primary btn-sm" download>
																 <i class="fas fa-download"></i>&nbsp;
																Download
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
							<div class="col-lg-6 col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">
											Diagnosis Records
										</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive" style="overflow-x: auto; height: 250px;">
											<table id="treatment_client" class="table table-borderedless table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2 text-nowrap">Pet Name</th>
														<th class="py-1 px-2 text-nowrap">Diagnosis</th>
														<th class="py-1 px-2 text-nowrap">Date</th>
														<th class="py-1 px-2 text-nowrap text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT * FROM diagnosis_records LEFT JOIN pet_profile ON pet_profile.pet_id = diagnosis_records.pet_id WHERE diagnosis_records.user_id = '$user' AND diagnosis_records.archive_status = '0'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td class="py-1 px-2 text-nowrap"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2 text-nowrap"><?php echo $row['diagnosis']; ?></td>
														<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2 text-nowrap text-center">
															<a href="<?php echo web_root;?>client/pets/profiles/profile.php?pet_id=123&diagnose=<?php echo $row['id']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
																<i class="far fa-eye"></i>&nbsp;
																View
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
		<?php include('include/footer.php'); ?>
	</body>
</html>


