<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

if(!isset($_GET['view'])){
	
}else{
	$actual_link = $_SERVER['REQUEST_URI'];
	if (strpos($actual_link, '%27') !== false) {
		$new_link = str_replace("%27","",$actual_link);
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: $new_link");
		exit;
	}
}
$viewID = $_GET['view'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Invoice Information | Vets at Work Veterinary</title>
		<?php include('../../../include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../../../include/sidebar.php'); ?>

			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-4 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1 class="m-0">Invoice Information</h1>
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<form action="" method="POST">
									<div class="invoice p-3 mb-3">
										<div class="row">
											<div class="col-12">
												<h4>
													<?php
														$sql = "SELECT invoice_ref FROM invoice WHERE appointment_id = '$viewID'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															$row = $result -> fetch_assoc();
														?>
															<label>Invoice #<?php echo $row['invoice_ref']; ?></label>
														<?php
														}
													?>
													<small class="float-right">Date: <?php echo date("m/d/Y");?></small>
												</h4>
											</div>
										</div>
										<div class="row invoice-info">
											<div class="col-sm-4 invoice-col">
												From
												<address>
													<strong>Vets at Work Veterinary</strong><br>  
													Unit B/F Divino Amore Bldg.,# 8 Holy Spirit Drive,<br>
													Don Antonio Heights, Quezon City<br>
													Phone: (+63) 920 973 9069<br>
													Email: vawvetclinic.not.official1@gmail.com
												</address>
											</div>
											<div class="col-sm-4 invoice-col">
												To
												<address>
													<?php
														$sql = "SELECT firstname, lastname, address, contact_number, email FROM user_profile WHERE user_id = '$user'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															$row = $result -> fetch_assoc();
													?>
													<strong><?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);?></strong><br>
													<?php 
														if($row['address'] == null || $row['address'] == '' ){
														?>
															<i>not set</i><br>
														<?php
														}else{
														?>
															<?php echo $row['address']; ?><br>
														<?php
														}
														?>
														Email: <?php echo $row['email']; ?>
													<?php
														}
													?>
													
												</address>
											</div>
										</div>
										<?php
											$sql = "SELECT * FROM invoice WHERE appointment_id = '$viewID'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
										?>
										<div class="row">
											<div class="col-12 table-responsive">
												<table class="table table-striped">
													<thead>
														<tr>
															<th>Pet Name</th>
															<th>Service</th>
															<th>Branch</th>
															<th>Date</th>
															<th>Time</th>
															<th>Subtotal</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="text-nowrap"><?php echo ucfirst($row['petname']); ?></td>
															<td class="text-nowrap"><?php echo ucfirst($row['service_title']); ?></td>
															<td class="text-nowrap"><?php echo $row['branch_name']; ?></td>
															<td class="text-nowrap"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
															<td class="text-nowrap"><?php echo date("g:i A", strtotime($row['time'])); ?></td>
															<td class="text-nowrap">₱ <?php echo number_format($row['service_cost']); ?></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="row">
											<div class="col-6">
											</div>
											<div class="col-6">
												<div class="table-responsive d-flex flex-row-reverse">
													<table class="table w-75">
														<tr>
															<th>Total:</th>
															<td>₱ <?php echo number_format($row['service_cost']); ?></td>
														</tr>
													</table>
												</div>
											</div>
										</div>
										<div class="row no-print" <?php if($row['payment_status'] == 'paid'){ echo 'hidden';}?>>
											<div class="col-12">
												<button type="submit" class="btn btn-success float-right pay_now" id="<?php echo $row['appointment_id']; ?>"><i class="far fa-credit-card"></i> 
													Pay now
												</button>
											</div>
										</div>
										<?php
											}
										?>
									</div>								
								</form>
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
		<?php include('../../../include/footer.php'); ?>
		<script>
			$(document).ready(function() {
				$('.pay_now').click(function(e) {
					e.preventDefault();
					var id = $(this).attr('id');
					var data = {
						'id' : id,
					}
					$.ajax({
						url: "pay.php",
						type: "POST",
						// This is the important part
						xhrFields: {
							withCredentials: true
						},
						// This is the important part
						data: data,
						success: function (data) {
							if(data == "api"){
								Swal.fire({
									title : "Service Fee",
									icon : "info",
									html: "Something wrong on api. Please contact the administrator",
									timer: 5000,
									showConfirmButton:false							
								});
							}else if(data == "failed"){
								Swal.fire({
									title : "Service Fee",
									icon : "error",
									html: "Failed to pay service appointment.",
									timer: 5000,
									showConfirmButton:false							
								});					
							}else{
								Swal.fire({
									title : "Service Fee",
									icon : "info",
									html: "Please wait, while you are redirected to the service payment gateway<br><br>Please do not refresh the page or click the <br><b>Back</b> or <b>Close</b> button of your browser",
									timer: 5000,
									allowOutsideClick: false,
									showConfirmButton:false							
								}).then(function() {
									window.location.href = data;
								});
							}
						}
					});
				});
			});
		</script>
	</body>
</html>
