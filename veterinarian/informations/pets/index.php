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
		<title>Pet Informations | Vets at Work Veterinary Clinic</title>
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
								<h1 class="m-0">Pet Management</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4 col-6">
							<!-- small box -->
								<div class="small-box bg-info">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_pet FROM pet_profile WHERE archive_status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_pet = number_format($row['all_pet']);
										?>
										<h3><?php echo $count_pet; ?></h3>
										<?php
											}
										?>
										<p>Total Registered Pets</p>
									</div>
								</div>
							</div>
							<!--
							<div class="col-lg-4 col-6">
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
							<div class="col-lg-4 col-6">
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
							</div>-->
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Pet Informations (Canine / Dog)</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="pet_list" class="table table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Pet Name</th>
														<th class="py-1 px-2">Pet Type</th>
														<th class="py-1 px-2">Breed</th>
														<th class="py-1 px-2">Medical Status</th>
														<th class="py-1 px-2 text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT * FROM pet_profile WHERE archive_status = '0' AND pet_type = 'CANINE (Dog/Aso)'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_type']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_breed']; ?></td>
														<?php
															if($row['pet_medical_status'] == null || $row['pet_medical_status'] == ""){
														?>
															<td class="py-1 px-2">Not set</td>
														<?php
															}else{
														?>
															<td class="py-1 px-2"><?php echo $row['pet_medical_status']; ?></td>
														<?php
															}
														?>
														<td class="py-1 px-2 text-center">
															<a class="btn btn-info btn-sm" href="./profiles/profile.php?pet_id=<?php echo $row['pet_id']; ?>">
																<i class="fas fa-folder"></i>
																View
															</a>
                                                         	 <a class="btn btn-primary btn-sm archive-pet" id="<?php echo $row['pet_id']; ?>">
																<i class="fas fa-archive"></i>
																Archive
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
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Pet Informations (Feline / Cat)</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="pet_list1" class="table table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Pet Name</th>
														<th class="py-1 px-2">Pet Type</th>
														<th class="py-1 px-2">Breed</th>
														<th class="py-1 px-2">Medical Status</th>
														<th class="py-1 px-2 text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$sql = "SELECT * FROM pet_profile WHERE archive_status = '0' AND pet_type = 'FELINE (Cat/Pusa)'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_type']; ?></td>
														<td class="py-1 px-2"><?php echo $row['pet_breed']; ?></td>
														<?php
															if($row['pet_medical_status'] == null || $row['pet_medical_status'] == ""){
														?>
															<td class="py-1 px-2">Not set</td>
														<?php
															}else{
														?>
															<td class="py-1 px-2"><?php echo $row['pet_medical_status']; ?></td>
														<?php
															}
														?>
														<td class="py-1 px-2 text-center">
															<a class="btn btn-info btn-sm" href="./profiles/profile.php?pet_id=<?php echo $row['pet_id']; ?>">
																<i class="fas fa-folder"></i>
																View
															</a>
                                                         	 <a class="btn btn-primary btn-sm archive-pet" id="<?php echo $row['pet_id']; ?>">
																<i class="fas fa-archive"></i>
																Archive
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
		<script src="<?php echo web_root; ?>veterinarian/informations/pets/js/archive_pet.js"></script>		
	</body>
</html>
