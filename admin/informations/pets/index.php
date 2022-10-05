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
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1>Pet Management Lists</h1>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Pet Lists</h3>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="info_pet" class="table table-borderedless table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Pet Name</th>
												<th class="py-1 px-2">Pet Type</th>
												<th class="py-1 px-2">Breed</th>
												<th class="py-1 px-2">Weight</th>
												<th class="py-1 px-2">Birthdate</th>
												<th class="py-1 px-2">Vaccination</th>
												<th class="py-1 px-2">Blood Type</th>
												<th class="py-1 px-2">Medical Status</th>
												<th class="py-1 px-2 text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$sql = "SELECT * FROM pet_profile WHERE archive_status = '0'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
											?>
											<tr>
												<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
												<td class="py-1 px-2"><?php echo $row['pet_type']; ?></td>
												<td class="py-1 px-2"><?php echo $row['pet_breed']; ?></td>
												<?php
													if($row['pet_weight'] == null || $row['pet_weight'] == ""){
												?>
													<td class="py-1 px-2">Not set</td>
												<?php
													}else{
												?>
													<td class="py-1 px-2"><?php echo $row['pet_weight']; ?></td>
												<?php
													}
												?>														
												<?php
													if($row['pet_birthdate'] == null || $row['pet_birthdate'] == ""){
												?>
													<td class="py-1 px-2">Not Set</td>
												<?php
													}else{
												?>
													<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['pet_birthdate'])); ?></td>
												<?php
													}
												?>
												
												<?php
													if($row['pet_vaccination'] == null || $row['pet_vaccination'] == ""){
												?>
													<td class="py-1 px-2">Not set</td>
												<?php
													}else{
												?>
													<td class="py-1 px-2"><?php echo $row['pet_vaccination']; ?></td>
												<?php
													}
												?>
												
												<?php
													if($row['pet_blood_type'] == null || $row['pet_blood_type'] == ""){
												?>
													<td class="py-1 px-2">Not set</td>
												<?php
													}else{
												?>
													<td class="py-1 px-2"><?php echo $row['pet_blood_type']; ?></td>
												<?php
													}
												?>
												
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
													<a class="btn btn-danger btn-sm archive-pet" id="<?php echo $row['pet_id']; ?>">
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
		<script src="<?php echo web_root; ?>admin/informations/pets/js/pet.js"></script>	
	</body>
</html>
