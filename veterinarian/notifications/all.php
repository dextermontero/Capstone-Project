<?php
require_once("../../include/initialize.php");
require_once("../../include/calendar.php");
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
		<title>Notification | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
		<link rel="stylesheet" href="<?php echo web_root; ?>css/calendar.css"/>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../include/sidebar.php'); ?>

			<div class="content-wrapper">

				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
							<div class="col-sm-6">
								<h1 class="m-0">All Notifications</h1>
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card" style="overflow-x: auto; height: 750px;">
									<div class="card-body">
										<div class="row justify-content-center">
											<div class="col-lg-8 col-12">										
												<?php
													$sql = "SELECT * FROM notification WHERE archive_status = '0' ORDER BY notify_id DESC";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
															$time = strtotime($row['date'] .' '. $row['time']);
												?>
			
														<a href="<?php echo $row['url']; ?>" class="dropdown-item">
															<div class="row">
																<div class="col-lg-1 col-2">
																	<i class="fa <?php echo $row['icon']; ?> mr-2 mt-2 text-center" style="font-size:30px;"></i>
																</div>
																<div class="col-lg-8 col-8">
																	<?php echo $row['title']; ?><br>
																	<span class="text-muted text-sm"><?php echo $row['activity']; ?></span><br>
																</div>
																<div class="col-lg-1 col-2 align-self-center">
																	<span class="text-muted text-sm"><?php echo humanTiming($time); ?></span>
																</div>
																<div class="col-lg-2 col-2 align-self-center">
																	<?php 
																		if($row['status'] == '1'){
																	?>
																		<span style="font-size:7px;color:rgba(44, 105, 201);"><i class="fa fa-circle"></i></span>&nbsp;&nbsp;&nbsp;
																	<?php
																		}else{
																	?>
																		
																	<?php
																		}
																	?>
																</div>
															</div>
														</a>
														<div class="dropdown-divider"></div>
												<?php
														}
													}
													
													function humanTiming ($time){
														$time = time() - $time; // to get the time since that moment
														$time = ($time<1)? 1 : $time;
														$tokens = array (
															31536000 => 'year',
															2592000 => 'month',
															604800 => 'week',
															86400 => 'day',
															3600 => 'hour',
															60 => 'minute',
															1 => 'second'
														);

														foreach ($tokens as $unit => $text) {
															if ($time < $unit) continue;
															$numberOfUnits = floor($time / $unit);
															return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s ago':'');
														}
													}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>

			<footer class="main-footer">
				<strong>Copyright &copy; <?php echo date("Y");?> <a href="<?php echo web_root; ?>">Vets at Work Veterinary Clinic</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b></b>
				</div>
			</footer>
		</div>
		<?php include('../include/footer.php'); ?>
		<script>
			$(document).ready(function() {
				$('#update-appointment').click(function(e) {
					e.preventDefault();
					var id = $('#reference_id').val();
					var fullname = $('#fullname').val();
					var service = $('#service').val();
					var date = $('#date').val();
					var time = $('#time').val();
					var status = $('#status').val();
					$('#update-appointment').attr('disabled', 'disabled');
					document.getElementById('msg').innerHTML = "<p class='text-center py-1 px-1 text-success'>Updating appointments... Please wait!</p>";
					if(status != null){
						$.post("update_appointment.php", {id:id, fullname:fullname, service:service, date:date, time:time, status:status})
						.done(function(data) {
							if(data == "success"){
								Swal.fire({
									title : "Appointment Updated",
									icon : "success",
									html: "The appointment was successfully moved to the "+ status +" status!",
									timer: 3000,
									showConfirmButton:false							
								}).then(function() {
									location.reload();
								});									
							}else if(data == "failed"){
								Swal.fire({
									title : "Appointment Updated",
									icon : "error",
									html: "<b>Failed</b> to update the appointment!",
									timer: 3000,
									showConfirmButton:false							
								}).then(function() {
									document.getElementById('msg').innerHTML = "";
									$('#update-appointment').removeAttr('disabled', 'disabled');
								});									
							}else{
								Swal.fire({
									title : "Appointment Updated",
									icon : "warning",
									text: "Something wrong in update the appointment.",
									timer: 3000,
									showConfirmButton:false							
								}).then(function() {
									document.getElementById('msg').innerHTML = "";
									$('#update-appointment').removeAttr('disabled', 'disabled');
								});								
							}
						});
					}else{
						Swal.fire({
							title : "Appointment Updated",
							icon : "info",
							html: "<b>Failed</b> to update the appointment!",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							document.getElementById('msg').innerHTML = "";
							$('#update-appointment').removeAttr('disabled', 'disabled');
						});								
					}
				});
			});
		</script>
	</body>
</html>
