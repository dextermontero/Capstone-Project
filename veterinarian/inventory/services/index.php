<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	header("location: ../../../");
}else{
	$user = $_SESSION['login_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Services Inventory | Punzalan Vet Clinic</title>

		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/fontawesome-free/css/all.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Tempusdominus Bootstrap 4 -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<!-- JQVMap -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/jqvmap/jqvmap.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo web_root; ?>dist/css/adminlte.min.css">
		<!-- overlayScrollbars -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/daterangepicker/daterangepicker.css">
		<!-- summernote -->
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/summernote/summernote-bs4.min.css">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo web_root; ?>dist/img/icons/logo.ico" />	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
				</ul>

				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">
					<!-- Messages Dropdown Menu -->
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<i class="far fa-comments"></i>
							<span class="badge badge-danger navbar-badge">3</span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<a href="#" class="dropdown-item">
								<!-- Message Start -->
								<div class="media">
									<img src="<?php echo web_root; ?>dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
									<div class="media-body">
										<h3 class="dropdown-item-title">
											Brad Diesel
										<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
										</h3>
										<p class="text-sm">Call me whenever you can...</p>
										<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
									</div>
								</div>
								<!-- Message End -->
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<!-- Message Start -->
								<div class="media">
									<img src="<?php echo web_root; ?>dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
									<div class="media-body">
										<h3 class="dropdown-item-title">
											John Pierce
											<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
										</h3>
										<p class="text-sm">I got your message bro</p>
										<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
									</div>
								</div>
								<!-- Message End -->
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<!-- Message Start -->
								<div class="media">
									<img src="<?php echo web_root; ?>dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
									<div class="media-body">
										<h3 class="dropdown-item-title">
											Nora Silvester
											<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
										</h3>
										<p class="text-sm">The subject goes here</p>
										<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
									</div>
								</div>
								<!-- Message End -->
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
						</div>
					</li>
					<!-- Notifications Dropdown Menu -->
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<i class="far fa-bell"></i>
							<span class="badge badge-warning navbar-badge">15</span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<span class="dropdown-item dropdown-header">15 Notifications</span>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-envelope mr-2"></i> 4 new messages
								<span class="float-right text-muted text-sm">3 mins</span>
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-users mr-2"></i> 8 friend requests
								<span class="float-right text-muted text-sm">12 hours</span>
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-file mr-2"></i> 3 new reports
								<span class="float-right text-muted text-sm">2 days</span>
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
						</div>
					</li>
					<!-- Logout Down -->
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown" href="#">
							<i class="fas fa-caret-down"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<!--<span class="dropdown-item dropdown-header"></span>
							<div class="dropdown-divider"></div>-->
							<a href="#" class="dropdown-item">
								<i class="far fa-id-card mr-2"></i> Profile
								<span class="float-right text-muted text-sm"><i class="fas fa-caret-right"></i></span>
							</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item">
								<i class="fas fa-power-off mr-2"></i> Logout
							</a>
						</div>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->

			<!-- Main Sidebar Container -->
			<?php include('../../include/sidebar.php'); ?>
				<!-- Brand Logo -->
				<a href="<?php echo web_root; ?>dashboard" class="brand-link">
					<img src="<?php echo web_root; ?>dist/img/logo.png" alt="Punzalan Vet Clinic Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
					<span class="brand-text font-weight-light">Punzalan Vet Clinic</span>
				</a>

				<!-- Sidebar -->
				<div class="sidebar">
					<!-- Sidebar user panel (optional) -->
					<div class="user-panel mt-3 pb-3 mb-3 d-flex">
						<div class="image">
							<img src="<?php echo web_root; ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="Administrator Profile">
						</div>
						<div class="info">
							<a href="#" class="d-block">Administrator</a>
						</div>
					</div>

					<!-- SidebarSearch Form -->
					<div class="form-inline">
						<div class="input-group" data-widget="sidebar-search">
							<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
							<div class="input-group-append">
								<button class="btn btn-sidebar">
									<i class="fas fa-search fa-fw"></i>
								</button>
							</div>
						</div>
					</div>

					<!-- Sidebar Menu -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
							<li class="nav-item">
								<a href="<?php echo web_root; ?>dashboard" class="nav-link">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>
										Dashboard
										<!--<span class="right badge badge-danger">New</span>-->
									</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo web_root; ?>appointments" class="nav-link">
									<i class="nav-icon fas fa-copy"></i>
									<p>
										Appointments
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?php echo web_root; ?>appointments/scheduled" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Schedule / Reservation</p>
										</a>
									</li>
								</ul>
							</li>							
							<li class="nav-item">
								<a href="<?php echo web_root; ?>informations" class="nav-link">
									<i class="nav-icon fas fa-copy"></i>
									<p>
										Information
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?php echo web_root; ?>informations/clients" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Client Information</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo web_root; ?>informations/pets" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Pet Information</p>
										</a>
									</li>									
								</ul>
							</li>
							<li class="nav-item">
								<a href="<?php echo web_root; ?>products_and_services" class="nav-link">
									<i class="nav-icon fas fa-copy"></i>
									<p>
										Products and Services
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?php echo web_root; ?>products_and_services/weekly_sales" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Sales this week</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo web_root; ?>products_and_services/monthly_sales" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Sales this month</p>
										</a>
									</li>									
								</ul>
							</li>							
							<li class="nav-item">
								<a href="<?php echo web_root; ?>cancelled" class="nav-link">
									<i class="nav-icon far fa-calendar-alt"></i>
									<p>
										Cancelled Schedule
									</p>
								</a>
							</li>							
							<li class="nav-item">
								<a href="<?php echo web_root; ?>calendar" class="nav-link">
									<i class="nav-icon far fa-calendar-alt"></i>
									<p>
										Calendar
										<!--<span class="right badge badge-danger">New</span>-->
									</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo web_root; ?>gallery" class="nav-link">
									<i class="nav-icon far fa-image"></i>
									<p>
										Gallery
										<!--<span class="right badge badge-danger">New</span>-->
									</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo web_root; ?>reviews" class="nav-link">
									<i class="nav-icon far fa-image"></i>
									<p>
										Reviews
										<!--<span class="right badge badge-danger">New</span>-->
									</p>
								</a>
							</li>	
							<li class="nav-item">
								<a href="<?php echo web_root; ?>inventory" class="nav-link">
									<i class="nav-icon fas fa-copy"></i>
									<p>
										Inventory
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?php echo web_root; ?>inventory/products" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Product</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo web_root; ?>inventory/services" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Services</p>
										</a>
									</li>									
								</ul>
							</li>
							<li class="nav-item">
								<a href="<?php echo web_root; ?>employee" class="nav-link">
									<i class="nav-icon far fa-image"></i>
									<p>
										Employee
										<!--<span class="right badge badge-danger">New</span>-->
									</p>
								</a>
							</li>							
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Dashboard</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">

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
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside><!-- /.control-sidebar -->
		</div><!-- ./wrapper -->

		<!-- jQuery -->
		<script src="<?php echo web_root; ?>plugins/jquery/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?php echo web_root; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
		  $.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Bootstrap 4 -->
		<script src="<?php echo web_root; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- ChartJS -->
		<script src="<?php echo web_root; ?>plugins/chart.js/Chart.min.js"></script>
		<!-- Sparkline -->
		<script src="<?php echo web_root; ?>plugins/sparklines/sparkline.js"></script>
		<!-- JQVMap -->
		<script src="<?php echo web_root; ?>plugins/jqvmap/jquery.vmap.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?php echo web_root; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
		<!-- daterangepicker -->
		<script src="<?php echo web_root; ?>plugins/moment/moment.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/daterangepicker/daterangepicker.js"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?php echo web_root; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
		<!-- Summernote -->
		<script src="<?php echo web_root; ?>plugins/summernote/summernote-bs4.min.js"></script>
		<!-- overlayScrollbars -->
		<script src="<?php echo web_root; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?php echo web_root; ?>dist/js/adminlte.js"></script>
	</body>
</html>
