<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Payments | Vets at Work Veterinary</title>
		<?php include('../include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../include/sidebar.php'); ?>

			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Payments</h1>
							</div>
							<?php
								$chk = "SELECT count(*) as total_pending FROM invoice WHERE user_id = '$user' AND payment_status = 'pending'";
								$res = $conn->query($chk);
								if($res -> num_rows > 0){
									$ro = $res -> fetch_assoc();
									if($ro['total_pending'] > 0){
										echo '
										<div class="col-sm-6">
											<a href="'.web_root.'client/payments/invoice" class="btn btn-warning float-right"><i class="fas fa-file-invoice"></i> &nbsp;Invoice <span class="badge badge-danger">'.$ro['total_pending'].'</span></a>
										</div>';
									}
								}
							?>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										<div class="table-responsive">
											<table id="paymentList" class="table table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Reference ID</th>
														<th class="py-1 px-2">Service</th>
														<th class="py-1 px-2">Date</th>
														<th class="py-1 px-2">Time</th>
														<th class="py-1 px-2">Description</th>
														<th class="py-1 px-2">Amount</th>
														<th class="py-1 px-2">Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT billing.ukayra_id, billing.date, billing.time, billing.description, billing.amount, billing.status, services.service_title FROM billing INNER JOIN services ON services.service_id = billing.services WHERE billing.user_id = '$user' AND billing.archive_status = '0' ORDER BY bill_id DESC";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
														<tr>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['ukayra_id'];?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['service_title'];?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date']));?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo date("g:i A", strtotime($row['time']));?></td>
															<td class="py-1 px-2 text-nowrap"><?php echo $row['description'];?></td>
															<td class="py-1 px-2 text-nowrap">₱ <?php echo number_format($row['amount']);?></td>
															<?php
																if($row['status'] == 'paid'){
															?>
																	<td class="py-1 px-2 text-nowrap text-success"><?php echo ucfirst($row['status']);?></td>
															<?php
																}else{
															?>
																	<td class="py-1 px-2 text-nowrap text-danger"><?php echo ucfirst($row['status']);?></td>
															<?php
																}
															?>
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
