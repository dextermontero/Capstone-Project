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
		<title>Veterinarian Informations | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1>Veterinarian Managements</h1>
							</div>
							<div class="col-sm-6">
								<a href="<?php echo web_root; ?>admin/veterinarian/add_veterinarian" name="add-vet" id="add-vet" class="btn btn-outline-success float-right"><i class="fas fa-user-plus"></i> &nbsp;Add Veterinarian</a>
							</div>								
						</div>
					</div>
				</section>

				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title"><b>Veterinarian Informations</b></h3>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="veterinarian" class="table table-bordered table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Vet ID</th>
												<th class="py-1 px-2">First Name</th>
												<th class="py-1 px-2">Last Name</th>
												<th class="py-1 px-2">Position</th>
												<th class="py-1 px-2">Branch</th>
												<th class="py-1 px-2">Status</th>
												<th class="py-1 px-2 text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$c = "SELECT vet_profile.vet_id, vet_profile.firstname, vet_profile.lastname, vet_profile.position, branch.name, vet_profile.create_date, login_tbl.verification FROM vet_profile INNER JOIN login_tbl ON login_tbl.uid = vet_profile.vet_id INNER JOIN branch ON branch.branch_id = vet_profile.branch_id WHERE vet_profile.position = 'veterinarian'";
												$cresult = $conn->query($c);
												if($cresult -> num_rows > 0) {
													while($crow = $cresult -> fetch_assoc()){
											?>
											<tr>
												<td class="py-1 px-2"><?php echo $crow['vet_id'];?></td>
												<td class="py-1 px-2"><?php echo ucfirst($crow['firstname']);?></td>
												<td class="py-1 px-2"><?php echo ucfirst($crow['lastname']);?></td>
												<td class="py-1 px-2"><?php echo ucfirst($crow['position']);?></td>
												<td class="py-1 px-2"><?php echo ucfirst($crow['name']);?></td>
												<?php
													if($crow['verification'] == 'active'){
												?>
													<td class="py-1 px-2 text-success"><?php echo ucfirst($crow['verification']);?></td>
												<?php
													}else{
												?>
													<td class="py-1 px-2 text-danger"><?php echo ucfirst($crow['verification']);?></td>
												<?php
													}
												?>
												<td class="py-1 px-2 text-center" style="width:15%">
													<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>admin/veterinarian/profiles/index.php?profile=<?php echo $crow['vet_id']; ?>">
														<i class="fas fa-folder"></i>
														View
													</a>
													<a class="btn btn-danger btn-sm delete-vet" href="#" id="<?php echo $crow['vet_id'];?>">
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
		<script src="<?php echo web_root; ?>admin/veterinarian/account_management.js"></script>
	</body>
</html>
