<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

if(isset($_GET['profile'])){
	
	$get = $_GET['profile'];
	$chkGet = "SELECT admin_id FROM admin_profile WHERE admin_id = '$get'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$adm_id = $_GET['profile'];
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
		<title>Account Profile | Vets at Work Veterinary Clinic</title>
		<?php include('../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../../include/sidebar.php'); ?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1>Profile Informations</h1>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
							<div class="row">
 								<div class="col-lg-4 col-12">
 									<div class="card">
                						<div class="card-body">
											<?php
												$sql = "SELECT photo, firstname, lastname, position FROM admin_profile WHERE admin_id = $adm_id";
												$result = $conn->query($sql);
												if($result -> num_rows > 0) {
													while($row = $result -> fetch_assoc()){
														$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
														$position = ucfirst($row['position']);
														$photo = $row['photo'];
											?>
												<div class="d-flex flex-column align-items-center text-center">
													<img src="<?php echo web_root; ?>dist/img/profiles/<?php echo $photo; ?>" class="rounded-circle" width="150" alt="<?php echo $fullname; ?>">
													<div class="mt-3">
														<h4><?php echo $fullname; ?></h4>
														<?php 
															if($position == "Superadmin"){
														?>
															<p class="text-danger mb-1"><?php echo $position; ?></p>
														<?php
															}else {
														?>
															<p class="text-success mb-1"><?php echo $position; ?></p>
														<?php
															}
														?>
														
													</div>
												</div>										
											<?php
													}
												}
											?>
               					 		</div>
             						</div>	
									<div class="card ">
										<div class="card-header">
											<h3 class="card-title">Other Informations</h3>
										</div>
										<div class="card-body">

										</div>
									</div>									 
 								</div>							
 								<div class="col-lg-8 col-12">
 									<div class="card-header">
										<div class="row mb-2">
											<div class="col-sm-8">
												<h5 class="m-0"> Personal Information</h5>
											</div><!-- /.col -->
											<?php
												/*$sql = "SELECT privilege FROM login_tbl WHERE uid = '$user'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													$row = $result -> fetch_assoc();
													if($row['privilege'] == 1){
														$msg = '
														<div class="col-sm-4 text-right">
															<a class="btn btn-info btn-sm" href="'.web_root.'admin/account_management/administrator/profiles/edit.php?edit='.$_GET['profile'].'">
																<i class="fas fa-user-edit"></i>
																Edit Profile
															</a>
														</div>';
													}else {
														
													}
												}*/
											?>
											<?php
												/*if(isset($msg)){
													echo $msg;
												}*/
											?>											
										</div>							
                  					</div>
									<div class="card-body">
										<?php
											$sql = "SELECT * FROM admin_profile WHERE admin_id = '$adm_id'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
										?>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Admin ID</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php echo $row['admin_id']; ?>
												</div>
											</div>
											<hr>
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
														<?php echo $row['gender']; ?>
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
		<script src="<?php echo web_root; ?>admin/administrator/account_management.js"></script>
	</body>
</html>
