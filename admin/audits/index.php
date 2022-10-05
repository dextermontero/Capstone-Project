<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Audit Trails | Vets at Work Veterinary Clinic</title>
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
								<h1>Audit Trails</h1>
							</div>
						</div>
					</div>
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Review Logs</h3>
							</div>
							<div class="card-body">
								<table id="audit" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th class="py-1 px-2 text-center">#</th>
											<th class="py-1 px-2 w-25">Date - Time</th>
											<th class="py-1 px-2 w-25">Name</th>
											<th class="py-1 px-2 w-50">Action Made</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT id, name, date, time, activity FROM audit_logs ORDER BY id DESC";
											$result = $conn->query($sql);
											if($result -> num_rows > 0) {
												while($row = $result -> fetch_assoc()) {
										?>
										<tr>
											<td class="py-1 px-2 text-center"><?php echo $row['id']; ?></td>
											<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])).' - '. date("g:i A", strtotime($row['time']));?></td>
											<td class="py-1 px-2"><?php echo $row['name']; ?></td>
											<td class="py-1 px-2"><?php echo $row['activity']; ?></td>
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
	</body>
</html>
