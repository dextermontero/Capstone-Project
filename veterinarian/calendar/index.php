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
		<title>Calendar | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/calendar/fullcalendar.min.css">
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
								<h1 class="m-0">Calendar</h1>
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
									<div class="card-body">
										<div id="calendar">
									</div>
								</div>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
			<div class="modal fade" id="modal-default">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Add Schedule Calendar</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12 col-12">
									<div class="form-group">
										<label>Pet Name: </label>
										<select name="pet_name" class="form-control" id="pet_name">
											<option value="" selected disabled>--SELECT PET TYPE HERE HERE--</option>
											<?php
												$sql = "SELECT pet_profile.pet_id, pet_profile.pet_name, user_profile.firstname, user_profile.lastname FROM pet_profile INNER JOIN user_profile ON user_profile.user_id = pet_profile.user_id ORDER BY pet_name";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
											?>
												<option value="<?php echo $row['pet_id']; ?>"><?php echo $row['pet_name']; ?> - <?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);?></option>
											<?php
													}
												}else{
											?>
												<option disabled selected>-- NO PET REGISTERED --</option>
											<?php
												}
											?>
										</select>
									</div>
								</div>
							</div>									
							<div class="row">
								<div class="col-lg-12 col-12">
									<div class="form-group">
										<label>Title</label>
										<textarea class="form-control" rows="2" placeholder="Enter ..." id="title-schedule"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="form-group">
										<label>Start Time</label>
										<input class="form-control" type="time" name="addstarttime" id="addstarttime">
									</div>								
								</div>
								<div class="col-lg-6 col-12">
									<div class="form-group">
										<label>End Time</label>
										<input class="form-control" type="time" name="addendtime" id="addendtime">
									</div>								
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-primary btn-block" id="AddSchedule">Add Schedule</button>
						</div>
					</div>
				</div>
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
		<script src="<?php echo web_root; ?>plugins/moment/moment.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/calendar/fullcalendar.min.js"></script>
		<script src="<?php echo web_root; ?>veterinarian/calendar/calendar.js"></script>
	</body>
</html>
