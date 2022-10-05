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
		<title>Archived Pet Treatment | Vets at Work Veterinary Clinic</title>
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
								<h1 class="m-0">Archived Pet Treatment</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4 col-12">
								<div class="d-flex flex-column flex-grow-1">
								<!-- small box -->
									<div class="small-box bg-info">
										<div class="inner">
											<?php
												$sql = "SELECT COUNT(*) as all_prescription FROM archive WHERE category = 'prescription' AND user_id = '$user'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													$row = $result -> fetch_assoc();
													$count_prescription = number_format($row['all_prescription']);
											?>
											<h3><?php echo $count_prescription; ?></h3>
											<?php
												}
											?>
											<p>Archived Pet Prescription</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-12">
								<div class="d-flex flex-column flex-grow-1">
								<!-- small box -->
									<div class="small-box bg-primary">
										<div class="inner">
											<?php
												$sql = "SELECT COUNT(*) as all_treatment FROM archive WHERE category = 'treatment' AND user_id = '$user'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													$row = $result -> fetch_assoc();
													$count_treatment = number_format($row['all_treatment']);
											?>
											<h3><?php echo $count_treatment; ?></h3>
											<?php
												}
											?>
											<p>Archived Pet Treatment</p>
										</div>
									</div>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header d-flex p-0">
										<ul class="nav nav-pills p-2">
											<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Prescription Archived</a></li>
											<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Treatment Archived</a></li>
										</ul>							
									</div>									
									<div class="card-body">
										<div class="table-responsive">
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1">
													<table id="prescription" class="table table-striped table-hover table-sm">
														<thead>
															<tr>
																<th class="py-1 px-2">Date Uploaded</th>
																<th class="py-1 px-2">View Prescription</th>
																<th class="py-1 px-2">Download Prescription</th>
																<th class="py-1 px-2 text-center">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php
																	$sql = "SELECT archive.archive_id, prescription_records.date, prescription_records.filename FROM archive INNER JOIN prescription_records ON prescription_records.prescription_id = archive.id WHERE archive.category = 'prescription' AND archive.user_id = '$user'";
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
																		<td class="py-1 px-2 text-center">
																			<a class="btn btn-info btn-sm recover-prescription" href="" id="<?php echo $row['archive_id']; ?>">
																				<i class="fas fa-trash-restore"></i>
																				Recover
																			</a>																		
																			<a class="btn btn-danger btn-sm delete-prescription" href="" id="<?php echo $row['archive_id']; ?>">
																				<i class="fas fa-archive"></i>
																				Delete
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
													<table id="pet_treatment" class="table table-striped table-hover table-sm">
														<thead>
															<tr>
																<th class="py-1 px-2">Date</th>
																<th class="py-1 px-2">Treatment</th>
																<th class="py-1 px-2 text-nowrap">First Procedure</th>
																<th class="py-1 px-2 text-nowrap">Next Procedure</th>
																<th class="py-1 px-2 text-center" style="width: 15%;">Action</th>
															</tr>
														</thead>
														<tbody>
															<?php
																$sql = "SELECT archive.archive_id, pet_treatment_records.date, pet_treatment_records.treatment, pet_treatment_records.f_procedure, pet_treatment_records.n_procedure FROM archive INNER JOIN pet_treatment_records ON pet_treatment_records.treatment_id = archive.id WHERE archive.category = 'treatment' AND archive.user_id = '$user'";
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
																	<td class="py-1 px-2 text-center text-nowrap">
																		<a class="btn btn-info btn-sm recover-treatment" href="" id="<?php echo $row['archive_id']; ?>">
																			<i class="fas fa-trash-restore"></i>
																			Recover
																		</a>																		
																		<a class="btn btn-danger btn-sm delete-treatment" href="" id="<?php echo $row['archive_id']; ?>">
																			<i class="fas fa-trash"></i>
																			Delete
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
		<script src="<?php echo web_root;?>veterinarian/archived/treatments/treatment.js"></script>
		<script src="<?php echo web_root;?>veterinarian/archived/treatments/prescription.js"></script>
	</body>
</html>
