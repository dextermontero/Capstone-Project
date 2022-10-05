<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Appointments List | Vets at Work Veterinary</title>
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
								<h1 class="m-0">Book Appointments</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
						<!-- Start of Banner Image -->
				<div class="carousel">
					<!-- Banner Images -->
					<div class="carousel-inner">
						<img class="user-banner w-100 image-fit" src="<?php echo web_root; ?>dist/img/bg.png" alt="Third Slide" height="300px"/>
					</div>
					<div class="carousel-caption banner-title-position user-carousel-caption text-left">
						<a href="" class="btn btn-primary request-appointment" id="<?php echo $user; ?>">
							Request Appointment
						</a>
					</div>
				</div>
	        	<!-- End of Banner Image/Carousel -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->
				<!-- Main content -->
				<span id="web_root" hidden><?php echo $web_root; ?></span>
				<!-- Calendar -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-header d-flex p-0">
								<ul class="nav nav-pills p-2">
									<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Appointment Lists</a></li>
									<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Pending</a></li>
									<li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Scheduled / Rescheduled</a></li>
									<li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Cancel</a></li>
									<li class="nav-item"><a class="nav-link" href="#tab_5" data-toggle="tab">Done</a></li>
								</ul>							
							</div>
							<div class="card-body">
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1">
										<table id="appointment" class="table table-borderedless table-striped table-hover table-sm">
											<thead>
												<tr>
													<th></th>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Pet Name</th>
													<th class="py-1 px-2">Book Date</th>
													<th class="py-1 px-2">Book Time</th>
													<th class="py-1 px-2">Branch</th>
													<th class="py-1 px-2">Status</th>
													<th class="py-1 px-2 text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT appointments.id, appointments.pet_name, appointments.date, appointments.timeslot, appointments.service, appointments.status, branch.name FROM appointments LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.user_id = '$user' AND appointments.status = 'scheduled' OR appointments.user_id = '$user' AND appointments.status = 'pending' OR appointments.user_id = '$user' AND appointments.status = 'rescheduled' ORDER BY appointments.id DESC";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
													<tr>
														<td class="py-1 px-3"></td>
														<td class="py-1 px-2"><?php echo $row['service']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
														<td class="py-1 px-2"><?php echo ucfirst($row['name']); ?></td>
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
														
														<td class="text-center w-25">
															<?php
																if($row['status'] == 'cancelled'){
															?>
																	<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																		<i class="fas fa-edit"></i>
																		Update
																	</a>
																	<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																		<i class="fas fa-times"></i>
																		Cancel
																	</a>															
															<?php
																}elseif($row['status'] == 'scheduled' || $row['status'] == 'rescheduled'){
															?>
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																	<i class="fas fa-edit"></i>
																	Update
																</a>
																<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>">
																	<i class="fas fa-times"></i>
																	Cancel
																</a>
															<?php
																}else{
																$setDate = $row['date'];
																	$first_date = strtotime($setDate);
																	$appointmentDate = strtotime('-3 days', $first_date);
															?>
																<?php
																	if(time() < $appointmentDate){
																?>
																	
																	<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>">
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
																		<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																			<i class="fas fa-edit"></i>
																			Update
																		</a>
																		<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																			<i class="fas fa-times"></i>
																			Cancel
																		</a>																	
																<?php
																	}
																	
																?>															
															<?php
																}
															?>
														
														</td>										
													</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>
									
									<div class="tab-pane" id="tab_2">
										<table id="pending" class="table table-borderedless table-striped table-hover table-sm">
											<thead>
												<tr>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Pet Name</th>
													<th class="py-1 px-2">Book Date</th>
													<th class="py-1 px-2">Book Time</th>
													<th class="py-1 px-2">Branch</th>
													<th class="py-1 px-2">Status</th>
													<th class="py-1 px-2 text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT appointments.id, appointments.pet_name, appointments.date, appointments.timeslot, appointments.service, appointments.status, branch.name FROM appointments LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.user_id = '$user' AND appointments.status = 'pending' ORDER BY appointments.id DESC";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['service']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
														<td class="py-1 px-2"><?php echo ucfirst($row['name']); ?></td>
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
														<td class="text-center w-25">
															<?php
																$setDate = $row['date'];
																$first_date = strtotime($setDate);
																$appointmentDate = strtotime('-3 days', $first_date);
																if(time() < $appointmentDate){
															?>
																
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>">
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
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																	<i class="fas fa-edit"></i>
																	Update
																</a>
																<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																	<i class="fas fa-times"></i>
																	Cancel
																</a>
															<?php
																}
																
															?>
														</td>										
													</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>

									<div class="tab-pane" id="tab_3">
										<table id="scheduled" class="table table-borderedless table-striped table-hover table-sm">
											<thead>
												<tr>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Pet Name</th>
													<th class="py-1 px-2">Book Date</th>
													<th class="py-1 px-2">Book Time</th>
													<th class="py-1 px-2">Branch</th>
													<th class="py-1 px-2">Status</th>
													<th class="py-1 px-2 text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT appointments.id, appointments.pet_name, appointments.date, appointments.timeslot, appointments.service, appointments.status, branch.name FROM appointments LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.status = 'scheduled' AND appointments.user_id = '$user' OR appointments.status = 'rescheduled' AND appointments.user_id = '$user' ORDER BY appointments.id DESC";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['service']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
														<td class="py-1 px-2"><?php echo ucfirst($row['name']); ?></td>
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
														<td class="text-center w-25">
															<?php
																$setDate = $row['date'];
																$first_date = strtotime($setDate);
																$appointmentDate = strtotime('-3 days', $first_date);
																if(time() < $appointmentDate){
															?>
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
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
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>client/book/appointment/edit.php?id=<?php echo $row['id']; ?>&date=<?php echo $row['date'];?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																	<i class="fas fa-edit"></i>
																	Update
																</a>
																<a class="btn btn-danger btn-sm cancel-appointment" id="<?php echo $row['id']; ?>" <?php echo 'style="pointer-events:none;background-color:grey;border:1px grey;"';?>>
																	<i class="fas fa-times"></i>
																	Cancel
																</a>
															<?php
																}
																
															?>
														</td>										
													</tr>
												<?php
														}
													}
												?>
											</tbody>
										</table>
									</div>

									<div class="tab-pane" id="tab_4">
										<table id="cancelled" class="table table-borderedless table-striped table-hover table-sm">
											<thead>
												<tr>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Pet Name</th>
													<th class="py-1 px-2">Book Date</th>
													<th class="py-1 px-2">Book Time</th>
													<th class="py-1 px-2">Branch</th>
													<th class="py-1 px-2">Status</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT appointments.id, appointments.pet_name, appointments.date, appointments.timeslot, appointments.service, appointments.status, branch.name FROM appointments LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.status = 'cancel' AND appointments.user_id = '$user' ORDER BY appointments.id DESC";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['service']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
														<td class="py-1 px-2"><?php echo ucfirst($row['name']); ?></td>
														<?php
															if($row['status'] == 'scheduled'){
														?>
																<td class="py-1 px-2 text-nowrap text-success">Scheduled</td>
														<?php
															}elseif($row['status'] == 'pending'){
														?>
																<td class="py-1 px-2 text-nowrap text-warning">Pending</td>
														<?php
															}elseif($row['status'] == 'cancel'){
														?>
																<td class="py-1 px-2 text-nowrap text-danger">Cancel</td>
															
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

									<div class="tab-pane" id="tab_5">
										<table id="done" class="table table-borderedless table-striped table-hover table-sm">
											<thead>
												<tr>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Pet Name</th>
													<th class="py-1 px-2">Book Date</th>
													<th class="py-1 px-2">Book Time</th>
													<th class="py-1 px-2">Branch</th>
													<th class="py-1 px-2">Status</th>
													<th class="py-1 px-2 text-center">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT appointments.id, appointments.pet_name, appointments.date, appointments.timeslot, appointments.service, appointments.status, appointments.review, branch.name FROM appointments LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.status = 'done' AND appointments.user_id = '$user' ORDER BY appointments.id DESC";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['service']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['timeslot']; ?></td>
														<td class="py-1 px-2"><?php echo $row['name']; ?></td>
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
														<td class="text-center w-25">
															<a class="btn btn-info btn-sm add-review" id="<?php echo $row['id']; ?>" data-toggle="modal" data-target=".add-review-modal" <?php if($row['review'] == "1"){ echo 'style="pointer-events:none;background-color:grey;border: 1px grey"';} ?>>
																<i class="fas fa-comments"></i>&nbsp;
																Review
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
				</section>
			</div>
			
			<div class="modal fade add-review-modal" tabindex="-1" role="dialog" aria-labelledby="addReview" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addReview">Add Review</h5>
							<button type="button" class="close" id="add-review-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="view_review_modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" id="add_feedback">Add Review</button>
						</div>
					</div>
				</div>
			</div>			
			
			<footer class="main-footer">
				<strong>Copyright &copy; <?php echo date("Y");?> <a href="<?php echo web_root; ?>">Vets at Work Veterinary Clinic</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b></b>
				</div>
			</footer>
		</div>
		<?php include('../include/footer.php');?>
		<script src="<?php echo web_root; ?>client/book/js/appointment.js"></script>
	</body>
</html>
