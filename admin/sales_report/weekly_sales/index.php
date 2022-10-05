<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Weekly Reports | Vets at Work Veterinary Clinic</title>
		<?php include('../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../../include/sidebar.php'); ?>
			<div class="content-wrapper">
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Weekly Sale</h1>
							</div>
						</div>
					</div>
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">
								<form action="" method="GET">
									<div class="row">
										<div class="col-lg-2">
											<div class="form-group">
												<label for="start_date">Start Date</label>
												<?php
													if(!isset($_GET['from_date'])){
													?>
														<input type="date" class="form-control" id="start_date" value="<?php echo date("Y-m-d", strtotime("-7 days"))?>">
													<?php
													}else{
													?>
													<input type="date" class="form-control" id="start_date" value="<?php echo $_GET['from_date']?>">
													<?php
													}
												?>
												
											</div>										
										</div>

										<div class="col-lg-2">
											<div class="form-group">
												<label for="end_date">End Date</label>
												<?php
													if(!isset($_GET['to_date'])){
													?>
														<input type="date" class="form-control" id="end_date" value="<?php echo date("Y-m-d")?>">
													<?php
													}else{
													?>
													<input type="date" class="form-control" id="end_date" value="<?php echo $_GET['to_date']?>">
													<?php
													}
												?>
											</div>											
										</div>
									</div>
								</form>						
								<div class="table-responsive">
									<div id="weekly_table">
										<table id="weekly" class="table table-borderedless table-striped table-hover table-sm">
											<thead>
												<tr>
													<!--<th class="py-1 px-2">Reference ID</th>-->
													<th class="py-1 px-2">Full Name</th>
													<th class="py-1 px-2">Date</th>
													<th class="py-1 px-2">Time</th>
													<th class="py-1 px-2">Service</th>
													<th class="py-1 px-2">Description</th>
													<th class="py-1 px-2">Mode of Payment</th>
													<th class="py-1 px-2">Amount</th>
												</tr>
											</thead>
											<tbody>									
												<?php
													if(isset($_GET['from_date']) && isset($_GET['to_date'])){
														$from_date = $_GET['from_date'];
														$to_date = $_GET['to_date'];
												?>
													<?php
														$sql = "SELECT billing.ukayra_id, billing.fullname, billing.date, billing.time, billing.amount, billing.status, billing.description, billing.mode_of_payment, services.service_title FROM billing INNER JOIN services ON services.service_id = billing.services WHERE billing.archive_status = '0' AND billing.category = 'service' AND billing.status = 'paid' AND billing.date BETWEEN '$from_date' AND '$to_date'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>						
													<tr>
														<!--<td class="py-1 px-2"><?php echo $row['ukayra_id']; ?></td>-->
														<td class="py-1 px-2"><?php echo $row['fullname']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo date("g:i A", strtotime($row['time'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['service_title']; ?></td>
														<td class="py-1 px-2"><?php echo $row['description']; ?></td>
														<td class="py-1 px-2"><?php echo $row['mode_of_payment']; ?></td>
														<td class="py-1 px-2"><?php echo number_format($row['amount']); ?></td>
													</tr>
													<?php
															}
														}
													?>												
												<?php
													}else{
												?>
													<?php
														$sql = "SELECT billing.ukayra_id, billing.fullname, billing.date, billing.time, billing.amount, billing.status, billing.description, billing.mode_of_payment, services.service_title FROM billing INNER JOIN services ON services.service_id = billing.services WHERE billing.archive_status = '0' AND billing.status = 'paid' AND billing.category = 'service'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>						
													<tr>
														<!--<td class="py-1 px-2"><?php echo $row['ukayra_id']; ?></td>-->
														<td class="py-1 px-2"><?php echo $row['fullname']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo date("g:i A", strtotime($row['time'])); ?></td>
														<td class="py-1 px-2"><?php echo $row['service_title']; ?></td>
														<td class="py-1 px-2"><?php echo $row['description']; ?></td>
														<td class="py-1 px-2"><?php echo $row['mode_of_payment']; ?></td>
														<td class="py-1 px-2"><?php echo number_format($row['amount']); ?></td>
													</tr>
													<?php
															}
														}
													?>												
												<?php
													}
												?>
											</tbody>
											<tfoot>
												<tr>
													<!--<th class="py-1 px-2"></th>-->
													<th class="py-1 px-2"></th>
													<th class="py-1 px-2"></th>
													<th class="py-1 px-2"></th>
													<th class="py-1 px-2"></th>
													<th class="py-1 px-2"></th>
													<th class="py-1 px-2 text-right">Total : </th>
													<th class="py-1 px-2"></th>
												</tr>
											</tfoot>
										</table>										
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
		<script src="<?php echo web_root; ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/datatables-buttons/js/buttons.flash.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/pdfmake/pdfmake.min.js"></script>
		<script src="<?php echo web_root; ?>plugins/pdfmake/vfs_fonts.js"></script>
		<script src="<?php echo web_root;?>admin/sales_report/weekly_sales/filter.js"></script>
		<script src="<?php echo web_root;?>admin/sales_report/weekly_sales/weekly.js"></script>
	</body>
</html>
