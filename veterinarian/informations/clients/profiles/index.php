<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

if(isset($_GET['profile'])){
	
	$get = $_GET['profile'];
	$chkGet = "SELECT user_id FROM user_profile WHERE user_id = '$get'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$profile_id = $_GET['profile'];
	}else {
    	$actual_link = $_SERVER['REQUEST_URI'];
      	if (strpos($actual_link, '%27') !== false) {
        	$new_link = str_replace("%27","",$actual_link);
          	$host  = $_SERVER['HTTP_HOST'];
          	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          	header("Location: $new_link");
          	exit;
     	}else{
			header("location: ../");
        }
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Profile Details | Vets at Work Veterinary Clinic</title>
		<?php include('../../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../../../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
							<div class="col-sm-6">
								<h1 class="m-0">Profile Details</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">   				
						<div class="main-body">
							<div class="row">
 								<div class="col-lg-4 col-12">
 									<div class="card">
                						<div class="card-body">
											<?php
												$sql = "SELECT photo, firstname, lastname, position FROM user_profile WHERE user_id = $profile_id";
												$result = $conn->query($sql);
												if($result -> num_rows > 0) {
													while($row = $result -> fetch_assoc()){
														$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
														$position = ucfirst($row['position']);
														$photo = $row['photo'];
											?>										
                			  				<div class="d-flex flex-column align-items-center text-center">
                    							<img src="<?php echo web_root; ?>dist/img/profiles/<?php echo $photo; ?>" alt="<?php echo $fullname; ?>" class="rounded-circle" width="150">
                   				 				<div class="mt-3">
                      							<h4><?php echo $fullname; ?></h4>
                      							<p class="text-secondary mb-2">Pet Owner</p>
                      							<!--<p class="text-muted font-size-sm">Elitech Corp.</p>-->
                      							<button class="btn btn-outline-primary">Message</button>
                    							</div>
                 					 		</div>
											<?php
													}
												}
											?>											
										</div>										
									</div>
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Pet Owner Name</h3>
										</div>
										<div class="card-body">
											<div class="direct-chat-messages">
												<table id="pet" class="table table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Pet ID</th>
															<th class="py-1 px-2">Pet Name</th>
															<th class="py-1 px-2 text-center">Action</th>
														</tr>
													</thead>												
													<tbody>
														<?php
															$sql = "SELECT * FROM pet_profile WHERE user_id = '$profile_id'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
														<tr>
															<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
															<td class="py-1 px-2"><?php echo $row['pet_breed']; ?></td>
															<td class="py-1 px-2 text-center">
																<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $row['pet_id'];?>">
																	<i class="fas fa-folder"></i>
																	View Pet Info
																</a>
															</td>
														</tr>
														<?php
																}
															}
														?>	
														<?php if($result->num_rows <=0): ?>
															<tr>
																<th class="text-center" colspan="3">No Pet Records.</th>
															</tr>
														<?php endif; ?>												
													</tbody>
												</table>
											</div>
										</div>
									</div>								 
 								</div>							
 								<div class="col-lg-8 col-12">
 									<div class="card-header">
										<div class="row mb-2">
											<div class="col-sm-8">
												<h5 class="m-0"> Personal Information</h5>
											</div><!-- /.col -->
										</div>							
                  					</div>
									<div class="card-body">
										<?php
											$sql = "SELECT * FROM user_profile WHERE user_id = '$profile_id'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
										?>
											<div class="row" hidden>
												<div class="col-sm-3">
													<h6 class="mb-0">Profile ID</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo $row['user_id']; ?>
												</div>
											</div>
											<hr hidden>	
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">First Name</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo ucfirst($row['firstname']); ?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Middle Name</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['middlename'] == null || $row['middlename'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo ucfirst($row['middlename']); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Last Name</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo ucfirst($row['lastname']); ?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Age</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['birthdate'] == null || $row['birthdate'] == ""){
													?>
														<i>Not Set Birthday</i>
													<?php
														}else{
															$dob = date("Y-n-d", strtotime($row['birthdate']));
															$from = new DateTime($dob);
															$to   = new DateTime('today');
															$age =  $from->diff($to)->y;															
													?>
														<?php echo $age; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Email</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo $row['email']; ?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Address</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['address'] == null || $row['address'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $row['address']; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Place of Birth</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['place_bday'] == null || $row['place_bday'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $row['place_bday']; ?>
													<?php
														}
													?>												
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Gender</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['gender'] == null || $row['gender'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo ucfirst($row['gender']); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Birth Date</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['birthdate'] == null || $row['birthdate'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo date("F d, Y", strtotime($row['birthdate'])); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Contact Number</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['contact_number'] == null || $row['contact_number'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $row['contact_number']; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>											
										<?php
												
											}
										?>
									</div>
								</div>
 							</div>
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="card-header">
										<h5> User Tracking Details</h5>
									</div>
									<div class="card-body">
										<?php
											$sql = "SELECT * FROM appointments WHERE user_id = '$profile_id' ORDER BY id DESC";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
										?>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Last Appointment</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo date("F d, Y", strtotime($row['date'])) .' - '. date("g:i A", strtotime($row['timeslot'])); ?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Pet</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo ucfirst($row['pet_name']); ?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Service</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo $row['service']; ?>
												</div>
											</div>	
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Veterinarian</h6>
												</div>
												<?php
													if($row['veterinarian'] == '' || $row['veterinarian'] == null){
												?>
													<div class="col-sm-9 text-secondary font-weight-bold">
														<i>Not set</i>
													</div>
												<?php
													}else{
												?>
													<div class="col-sm-9 text-secondary font-weight-bold">
														<?php echo ucfirst($row['veterinarian']); ?>
													</div>
												<?php
													}
												?>
											</div>	
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Status</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo ucfirst($row['status']); ?>
												</div>
											</div>
											<hr>
										<?php
											}else {
										?>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Last Appointment</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<i>No Data</i>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Pet</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<i>No Data</i>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Service</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<i>No Data</i>
												</div>
											</div>	
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Veterinarian</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<i>No Data</i>
												</div>
											</div>	
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Status</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<i>No Data</i>
												</div>
											</div>
											<hr>										
										<?php
											}
										?>
									</div>
								</div>
								<!--<div class="col-lg-6 col-12">
									<div class="card-header">
										<h5> Other Data Information </h5>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-sm-3">
												<h6 class="mb-0">User ID</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												PID 1
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-sm-3">
												<h6 class="mb-0">Upload File</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												None
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-sm-3">
												<h6 class="mb-0">File Documents</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												None
											</div>
										</div>
										<hr>
									</div>
								</div>-->
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

		<?php include('../../../include/footer.php'); ?>
	</body>
</html>
