<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] !== 'client' || empty($_SESSION['login_id'])){
	header("location: ../../");
}else{
	$user = $_SESSION['login_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Calendar | Vets at Work Veterinary</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/calendar/fullcalendar.min.css">
		<?php include('../include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>

			<div class="content-wrapper">
				
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Medical Informations</h1>
							</div>
						</div>
					</div>
				</div>
				<!-- Calendar -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
                                    	<div id="calendar"></div>
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
		<script src="<?php echo web_root; ?>plugins/moment/moment.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/calendar/fullcalendar.min.js"></script>
		<script src="<?php echo web_root; ?>client/calendar/calendar.js"></script>
	</body>
</html>
