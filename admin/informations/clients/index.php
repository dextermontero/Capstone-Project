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
		<title>Pet Owner Informations | Vets at Work Veterinary Clinic</title>
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
								<h1>Pet Owner Management List</h1>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Pet Owner Lists</h3>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="info_client" class="table table-borderedless table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Customer ID</th>
												<th class="py-1 px-2">First Name</th>
												<th class="py-1 px-2">Last Name</th>
												<th class="py-1 px-2">Date Created</th>
												<th class="py-1 px-2">Status</th>
												<th class="py-1 px-2 text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$sql = "SELECT user_profile.user_id, user_profile.firstname, user_profile.lastname, user_profile.create_date, login_tbl.verification FROM user_profile INNER JOIN login_tbl ON login_tbl.uid = user_profile.user_id WHERE user_profile.archive_status = '0'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
											?>
												<tr>
													<td class="py-1 px-2"><?php echo $row['user_id']; ?></td>
													<td class="py-1 px-2"><?php echo ucfirst($row['firstname']); ?></td>
													<td class="py-1 px-2"><?php echo ucfirst($row['lastname']); ?></td>
													<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['create_date'])); ?></td>
													<?php
														if($row['verification'] == 'active'){
													?>
														<td class="py-1 px-2 text-success"><?php echo ucfirst($row['verification']); ?></td>
													<?php
														}else{
													?>
														<td class="py-1 px-2 text-danger"><?php echo ucfirst($row['verification']); ?></td>
													<?php
														}
													?>
													<td class="py-1 px-2 text-center" style="width:15%">
														<a class="btn btn-primary btn-sm" href="<?php echo web_root; ?>admin/informations/clients/profiles/index.php?profile=<?php echo $row['user_id']; ?>">
															<i class="fas fa-folder"></i>
															View
														</a>
														<a class="btn btn-danger btn-sm archive-owner" id="<?php echo $row['user_id'];?>">
															<i class="fas fa-archive"></i>
															Archived
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
		<script src="<?php echo web_root; ?>admin/informations/clients/js/pet_owner.js"></script>		
	</body>
</html>
