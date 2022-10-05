<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Pet Treatments | Vets at Work Veterinary Clinic</title>
		<?php include('../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Pet Treatments</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-6 col-6">
								<!-- small box -->
								<div class="small-box bg-warning">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_treatment FROM pet_treatment_records WHERE status = 'ongoing' AND archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_treatment = number_format($row['all_treatment']);
										?>
										<h3><?php echo $count_treatment; ?></h3>
										<?php
											}
										?>
										<p>Ongoing Treatments</p>
									</div>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-6 col-6">
								<!-- small box -->
								<div class="small-box bg-success">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_done FROM pet_treatment_records WHERE status = 'done' AND archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_done = number_format($row['all_done']);
										?>
										<h3><?php echo $count_done; ?></h3>
										<?php
											}
										?>
										<p>Successful Treatments</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Pet Treatments</h3>
									</div>
									<div class="card-header d-flex p-0">
										<ul class="nav nav-pills p-2">
											<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Ongoing Treatments</a></li>
											<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Done Treatments</a></li>
										</ul>							
									</div>									
									<div class="card-body">
										<div class="table-responsive">
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1">
													<table id="pet_treatment" class="table table-striped table-hover table-sm">
														<thead>
															<tr>
																<th class="py-1 px-2">Date</th>
																<th class="py-1 px-2">Pet Name</th>
																<th class="py-1 px-2">Treatment</th>
																<th class="py-1 px-2">First Procedure</th>
																<th class="py-1 px-2">Next Procedure</th>
																<th class="py-1 px-2">Medical Status</th>
																<th class="py-1 px-2 text-center">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$sql = "SELECT pet_treatment_records.pet_id, pet_treatment_records.date, pet_treatment_records.treatment, pet_treatment_records.f_procedure, pet_treatment_records.n_procedure, pet_treatment_records.status, pet_profile.pet_name FROM pet_treatment_records INNER JOIN pet_profile ON pet_profile.pet_id = pet_treatment_records.pet_id WHERE pet_treatment_records.status = 'ongoing'  AND pet_treatment_records.archive_status = '0'";
																$result = $conn->query($sql);
																if($result -> num_rows > 0){
																	while($row = $result -> fetch_assoc()){
															?>
															<tr>
																<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																<td class="py-1 px-2"><?php echo ucfirst($row['pet_name']); ?></td>
																<td class="py-1 px-2"><?php echo ucfirst($row['treatment']); ?></td>
																<?php
																	if($row['f_procedure'] == null || $row['f_procedure'] == ""){
																?>
																	<td class="py-1 px-2">Not set</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2"><?php echo ucfirst($row['f_procedure']); ?></td>
																<?php
																	}
																?>	
																<?php
																	if($row['n_procedure'] == null || $row['n_procedure'] == ""){
																?>
																	<td class="py-1 px-2">Not set</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2"><?php echo ucfirst($row['n_procedure']); ?></td>
																<?php
																	}
																?>
																<?php
																	if($row['status'] == null || $row['status'] == ""){
																?>
																	<td class="py-1 px-2">Not set</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2 text-success"><?php echo ucfirst($row['status']); ?></td>
																<?php
																	}
																?>
																<td class="py-1 px-2 text-center">
																	<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $row['pet_id']; ?>">
																		<i class="fas fa-folder"></i>
																		View
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
													<table id="pet_treatment_done" class="table table-striped table-hover table-sm">
														<thead>
															<tr>
																<th class="py-1 px-2">Date</th>
																<th class="py-1 px-2">Pet Name</th>
																<th class="py-1 px-2">Treatment</th>
																<th class="py-1 px-2">First Procedure</th>
																<th class="py-1 px-2">Next Procedure</th>
																<th class="py-1 px-2">Medical Status</th>
																<th class="py-1 px-2 text-center">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$sql = "SELECT pet_treatment_records.pet_id, pet_treatment_records.date, pet_treatment_records.treatment, pet_treatment_records.f_procedure, pet_treatment_records.n_procedure, pet_treatment_records.status, pet_profile.pet_name FROM pet_treatment_records INNER JOIN pet_profile ON pet_profile.pet_id = pet_treatment_records.pet_id WHERE pet_treatment_records.status = 'done' AND pet_treatment_records.archive_status = '0'";
																$result = $conn->query($sql);
																if($result -> num_rows > 0){
																	while($row = $result -> fetch_assoc()){
															?>
															<tr>
																<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																<td class="py-1 px-2"><?php echo ucfirst($row['pet_name']); ?></td>
																<td class="py-1 px-2"><?php echo ucfirst($row['treatment']); ?></td>
																<?php
																	if($row['f_procedure'] == null || $row['f_procedure'] == ""){
																?>
																	<td class="py-1 px-2">Not set</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2"><?php echo ucfirst($row['f_procedure']); ?></td>
																<?php
																	}
																?>	
																<?php
																	if($row['n_procedure'] == null || $row['n_procedure'] == ""){
																?>
																	<td class="py-1 px-2">Not set</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2"><?php echo ucfirst($row['n_procedure']); ?></td>
																<?php
																	}
																?>
																<?php
																	if($row['status'] == null || $row['status'] == ""){
																?>
																	<td class="py-1 px-2">Not set</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2 text-success"><?php echo ucfirst($row['status']); ?></td>
																<?php
																	}
																?>
																<td class="py-1 px-2 text-center">
																	<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $row['pet_id']; ?>">
																		<i class="fas fa-folder"></i>
																		View
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

		<?php include('../../include/footer.php'); ?>			
	</body>
</html>
