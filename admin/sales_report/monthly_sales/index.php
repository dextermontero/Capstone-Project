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
		<title>Monthly Reports | Vets at Work Veterinary Clinic</title>
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
								<h1>Monthly Sale</h1>
							</div>
						</div>
					</div>
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">
								<form action="" method="POST">
									<div class="row">
										<div class="col-lg-2">
											<div class="form-group">
												<label for="month">Month</label>
												<select class="form-control" id="month">
													<?php
														if(isset($_GET['month'])){
													?>
														<option value="<?php echo $_GET['month']?>" selected disabled><?php echo $_GET['month']?></option>
														<option value="January">January</option>
														<option value="February">February</option>
														<option value="March">March</option>
														<option value="April">April</option>
														<option value="May">May</option>
														<option value="June">June</option>
														<option value="July">July</option>
														<option value="August">August</option>
														<option value="September">September</option>
														<option value="October">October</option>
														<option value="November">November</option>
														<option value="December">December</option>													
													<?php
														}else{
													?>
														<option value="January" <?php if(date("F") == 'January'){ echo 'selected';} ?>>January</option>
														<option value="February" <?php if(date("F") == 'February'){ echo 'selected';} ?>>February</option>
														<option value="March" <?php if(date("F") == 'March'){ echo 'selected';} ?>>March</option>
														<option value="April" <?php if(date("F") == 'April'){ echo 'selected';} ?>>April</option>
														<option value="May" <?php if(date("F") == 'May'){ echo 'selected';} ?>>May</option>
														<option value="June" <?php if(date("F") == 'June'){ echo 'selected';} ?>>June</option>
														<option value="July" <?php if(date("F") == 'July'){ echo 'selected';} ?>>July</option>
														<option value="August" <?php if(date("F") == 'August'){ echo 'selected';} ?>>August</option>
														<option value="September" <?php if(date("F") == 'September'){ echo 'selected';} ?>>September</option>
														<option value="October" <?php if(date("F") == 'October'){ echo 'selected';} ?>>October</option>
														<option value="November" <?php if(date("F") == 'November'){ echo 'selected';} ?>>November</option>
														<option value="December" <?php if(date("F") == 'December'){ echo 'selected';} ?>>December</option>
													<?php
														}
													?>
												</select>
											</div>										
										</div>
									</div>
								</form>						
								<div class="table-responsive">
									<div id="monthly_table">
										<table id="monthly" class="table table-borderedless table-striped table-hover table-sm">
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
											if(isset($_GET['month'])){
												$month = date("n", strtotime($_GET['month']));
												$year = date('Y');
										?>	
											<?php
												$sql = "SELECT billing.ukayra_id, billing.fullname, billing.date, billing.time, billing.amount, billing.status, billing.description, billing.mode_of_payment, services.service_title FROM billing INNER JOIN services ON services.service_id = billing.services WHERE billing.archive_status = '0' AND billing.status = 'paid' AND billing.category = 'service' AND month(billing.date) = '$month' AND year(billing.date) = '$year'";
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
												$year = date('Y');
										?>
											<?php
												$sql = "SELECT billing.ukayra_id, billing.fullname, billing.date, billing.time, billing.amount, billing.status, billing.description, billing.mode_of_payment, services.service_title FROM billing INNER JOIN services ON services.service_id = billing.services WHERE billing.archive_status = '0' AND billing.status = 'paid' AND billing.category = 'service' AND year(billing.date) = '$year'";
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
		<script src="<?php echo web_root;?>admin/sales_report/monthly_sales/filter.js"></script>
		<script src="<?php echo web_root;?>admin/sales_report/monthly_sales/monthly.js"></script>
	</body>
</html>
