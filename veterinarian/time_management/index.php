<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$branchKey = "";
$getBranch = "SELECT branch_id FROM vet_profile WHERE vet_id = '$user'";
$result = $conn->query($getBranch);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$branchKey = $row['branch_id']; 
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Time Scheduling | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Time Schedule</h1>
							</div>						
						</div>
					</div>
				</section>
				
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">	
								<div class="row">
									<div class="col-lg-5 col-12 p-4">
										<?php
											if(!isset($_GET['time_id'])){
										?>
											<form>
												<?php
													$sql = "SELECT vet_profile.branch_id, branch.name, branch.address FROM vet_profile LEFT JOIN branch ON branch.branch_id = vet_profile.branch_id WHERE vet_profile.vet_id = '$user'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
												<div class="form-group" hidden>
													<label for="branch_id">Branch ID</label>
													<input type="text" id="branch_id" class="form-control" value="<?php echo $row['branch_id']; ?>" placeholder="" disabled>
												</div>
												<div class="form-group">
													<label for="branch_time">Branch Name</label>
													<input type="text" id="branch_time" class="form-control" value="<?php echo $row['name']; ?>" placeholder="" disabled>
												</div>
												<div class="form-group">
													<label for="branch_address">Branch Address</label>
													<input type="text" id="branch_address" class="form-control" value="<?php echo $row['address']; ?>" placeholder="" disabled>
												</div>
												<?php
													}
												?>
												<div class="form-group">
													<label for="time_manage">Time Available</label>
													<input type="time" id="time_manage" class="form-control" placeholder="">
												</div>
												<button type="submit" class="btn btn-success btn-block" id="add_time">Add Schedule</button>
											</form>
										<?php
											}else{
										?>
											<form>
												<?php
													$sql = "SELECT vet_profile.branch_id, branch.name, branch.address FROM vet_profile LEFT JOIN branch ON branch.branch_id = vet_profile.branch_id WHERE vet_profile.vet_id = '$user'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
												<div class="form-group" hidden>
													<label for="branch_id">Branch ID</label>
													<input type="text" id="branch_id" class="form-control" value="<?php echo $row['branch_id']; ?>" placeholder="" disabled>
												</div>
												<div class="form-group">
													<label for="branch_time">Branch Name</label>
													<input type="text" id="branch_time" class="form-control" value="<?php echo $row['name']; ?>" placeholder="" disabled>
												</div>
												<div class="form-group">
													<label for="branch_address">Branch Address</label>
													<input type="text" id="branch_address" class="form-control" value="<?php echo $row['address']; ?>" placeholder="" disabled>
												</div>
												<?php
													}
												?>
												
												<?php
													$timeID = $_GET['time_id'];
													$sql = "SELECT time_id, time FROM time_schedule WHERE time_id = '$timeID'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
													<div class="form-group" hidden>
														<label for="new_time_id">Branch ID</label>
														<input type="text" id="new_time_id" class="form-control" value="<?php echo $row['time_id']; ?>" placeholder="" disabled>
													</div>
													<div class="form-group">
														<label for="new_time">Time Available</label>
														<input type="time" id="new_time" class="form-control" value="<?php echo $row['time']; ?>">
													</div>
												<?php
													}
												?>
												<div class="row">
													<div class="col-lg-6 col-6">
														<button type="submit" class="btn btn-success btn-block" id="update_time">Update Time</button>
													</div>
													<div class="col-lg-6 col-6">
														<button type="submit" class="btn btn-danger btn-block" id="delete_time">Delete</button>
													</div>
												</div>
											</form>
										<?php
											}
										?>
									</div>
									<div class="col-lg-7 col-12 p-4">
										<p class="h3">Available Time:</p>
										<div class="row">
											<?php
												$sql = "SELECT * FROM time_schedule WHERE branch_id = '$branchKey' AND archive_status = '0' ORDER BY time ASC";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
											?>
												<div class="col-lg-4 col-4 mb-2">
													<button type="button" class="btn btn-block bg-gradient-success btn-flat time_click btn-md" id="<?php echo $row['time_id']; ?>"><?php echo date("g:i A", strtotime($row['time'])); ?></button>
												</div>
											<?php
													}
												}else {
											?>
												<div class="col-lg-12 col-12 mb-2 text-secondary">
													<p class="h2 text-center">No Available Time</p>
												</div>
											<?php
												}
											?>
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
		<?php include('../include/footer.php'); ?>
		<script src=""></script>
		<script src="<?php echo web_root; ?>veterinarian/time_management/time_schedule.js"></script>
	</body>
</html>
