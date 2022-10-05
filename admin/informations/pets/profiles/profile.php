<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}
if(isset($_GET['pet_id'])){
	
	$get = $_GET['pet_id'];
	$chkGet = "SELECT pet_id FROM pet_profile WHERE pet_id = '$get'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$id = $_GET['pet_id'];
	}else {
    	$actual_link = $_SERVER['REQUEST_URI'];
      	if (strpos($actual_link, '%27') !== false) {
        	$new_link = str_replace("%27","",$actual_link);
          	$host  = $_SERVER['HTTP_HOST'];
          	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          	header("Location: $new_link");
          	exit;
     	}else{
			header("location: ../");
        }
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Pet Details | Vets at Work Veterinary Clinic</title>
		<?php include('../../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../../../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1 class="m-0">Pet Details</h1>
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
 							<div class="row">
								<div class="col-lg-4 col-12">
										<div class="card">
										<div class="card-body">
											<div class="d-flex flex-column align-items-center text-center">
												<?php
													$sql = "SELECT pet_profile.user_id, pet_profile.pet_name, pet_profile.pet_photo, pet_profile.pet_breed, pet_profile.pet_weight, pet_profile.pet_birthdate, pet_profile.pet_vaccination, pet_profile.pet_blood_type, pet_profile.pet_medical_status, user_profile.firstname, user_profile.lastname FROM pet_profile INNER JOIN user_profile ON pet_profile.user_id = user_profile.user_id WHERE pet_profile.pet_id = '$id'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
													<img src="<?php echo web_root; ?>dist/img/pet_profile/<?php echo $row['pet_photo']; ?>" alt="<?php echo $row['pet_name']; ?>" class="rounded-circle" width="150">
													<div class="mt-3">
														<h4><?php echo $row['pet_name']; ?></h4>
														<p class="text-secondary mb-1"><?php echo $row['pet_breed']; ?></p>
														<a class="btn btn-primary btn-xs" href="<?php echo web_root; ?>admin/informations/clients/profiles/index.php?profile=<?php echo $row['user_id']; ?>">View Owner Info</a>
													</div>												
												<?php
													}
												?>
											</div>
										</div>
									 </div>
								</div> <!--col -->								
								<div class="col-lg-8 col-12">
									<div class="card-header">
										<div class="row mb-2">
											<div class="col-sm-8">
												<h5 class="m-0"> Pet Information</h5>
											</div>
										</div>							
									</div>									
									<div class="card-body">
										<?php
											$sql = "SELECT * FROM pet_profile WHERE pet_id = '$id'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
										?>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Pet Name</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_name'] == null || $row['pet_name'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo ucfirst($row['pet_name']); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Pet Owner</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($fullname == null || $fullname == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $fullname; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Breed</h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_breed'] == null || $row['pet_breed'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo ucfirst($row['pet_breed']); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Weight </h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_weight'] == null || $row['pet_weight'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo ucfirst($row['pet_weight']); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Birthdate </h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_birthdate'] == null || $row['pet_birthdate'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo date("F d, Y", strtotime($row['pet_birthdate'])); ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Vaccination </h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_vaccination'] == null || $row['pet_vaccination'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $row['pet_vaccination']; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Blood Type </h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_blood_type'] == null || $row['pet_blood_type'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $row['pet_blood_type']; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
											<div class="row">
												<div class="col-sm-3">
													<h6 class="mb-0">Medical Status </h6>
												</div>
												<div class="col-sm-9 text-secondary font-weight-bold">
													<?php
														if($row['pet_medical_status'] == null || $row['pet_medical_status'] == ""){
													?>
														<i>Not Set</i>
													<?php
														}else{
													?>
														<?php echo $row['pet_medical_status']; ?>
													<?php
														}
													?>
												</div>
											</div>
											<hr>
										<?php
											}
										?>
									</div>
								</div>
 							</div>
							<div class="row">
								<div class="col-lg-12 col-12">
									<div class="card">
										<div class="card-header d-flex p-0">
											<ul class="nav nav-pills p-2">
												<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Prescription Records</a></li>
												<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Treatment Records</a></li>
											</ul>							
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<div class="tab-content">
													<div class="tab-pane active" id="tab_1">
														<table id="prescription" class="table table-borderedless table-striped table-hover table-sm">
															<thead>
																<tr>
																	<th class="py-1 px-2">Date Uploaded</th>
																	<th class="py-1 px-2">View Prescription</th>
																	<th class="py-1 px-2">Download Prescription</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$sql = "SELECT * FROM prescription_records WHERE pet_id = '$id' AND archive_status = '0' ORDER BY prescription_id DESC";
																	$result = $conn->query($sql);
																	if($result -> num_rows > 0){
																		while($row = $result -> fetch_assoc()){
																?>
																	<tr>
																		<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																		<td class="py-1 px-2">
																			<a href="<?php echo web_root;?>dist/img/prescriptions/<?php echo $row['filename']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">
																				<i class="far fa-eye"></i> &nbsp;
																				<?php echo $row['filename']; ?>
																			</a>
																		</td>
																		<td class="py-1 px-2">
																			<a href="<?php echo web_root;?>dist/img/prescriptions/<?php echo $row['filename']; ?>" target="_blank" class="btn btn-outline-primary btn-sm" download>
																				 <i class="fas fa-download"></i> &nbsp;
																				<?php echo $row['filename']; ?>
																			</a>
																		</td>
																	</tr>
																<?php
																		}
																	}
																?>
															</tbody>
														</table>
													</div>
													<div class="tab-pane" id="tab_2">
														<table id="treatment" class="table table-borderedless table-striped table-hover table-sm">
															<thead>
																<tr>
																	<th class="py-1 px-2">Date</th>
																	<th class="py-1 px-2">Treatment</th>
																	<th class="py-1 px-2 text-nowrap">First Procedure</th>
																	<th class="py-1 px-2 text-nowrap">Next Procedure</th>
																	<th class="py-1 px-2 text-nowrap">Service Cost</th>
																	<th class="py-1 px-2">Payment</th>
																	<th class="py-1 px-2">Balance</th>
																	<th class="py-1 px-2">Status</th>
																</tr>
															</thead>
															<tbody>
																<?php
																	$sql = "SELECT * FROM pet_treatment_records WHERE pet_id = '$id' AND archive_status = '0' ORDER BY treatment_id DESC";
																	$result = $conn->query($sql);
																	if($result -> num_rows > 0){
																		while($row = $result -> fetch_assoc()){
																?>
																	<tr>
																		<td class="py-1 px-2 text-nowrap"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																		<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['treatment']); ?></td>
																		<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['f_procedure']); ?></td>
																		<td class="py-1 px-2 text-nowrap">
																		<?php
																			if($row['n_procedure'] == '' || $row['n_procedure'] == null){
																				echo 'No next procedure';
																			}else{
																				echo ucfirst($row['n_procedure']);
																			}
																		?>
																		</td>
																		<td class="py-1 px-2">₱ <?php echo number_format($row['service_cost']); ?></td>
																		<td class="py-1 px-2">₱ <?php echo number_format($row['payment']); ?></td>
																		<td class="py-1 px-2">₱ <?php echo number_format($row['balance']); ?></td>
																		<?php
																			if($row['status'] == 'ongoing'){
																		?>
																			<td class="py-1 px-2 text-warning"><?php echo ucfirst($row['status']); ?></td>
																		<?php
																			}else{
																		?>
																			<td class="py-1 px-2 text-success"><?php echo ucfirst($row['status']); ?></td>
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
	</body>
</html>
