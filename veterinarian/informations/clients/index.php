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
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Pet Owner Management</h1>
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
												$sql = "SELECT COUNT(*) as all_customer FROM user_profile WHERE archive_status = '0'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													$row = $result -> fetch_assoc();
													$count_client = number_format($row['all_customer']);
											?>
											<h3><?php echo $count_client; ?></h3>
											<?php
												}
											?>
											<p>Total Registered Pet Owner</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Pet Owner Informations</h3>
									</div>
									<div class="card-body">
										<table id="pet_owner" class="table table-striped table-hover">
											<thead>
												<tr>
													<th class="py-1 px-2">Profile ID</th>
													<th class="py-1 px-2">First Name</th>
													<th class="py-1 px-2">Last Name</th>
													<th class="py-1 px-2">Date Created</th>
													<th class="py-1 px-2 text-center" style="width: 15%;">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sql = "SELECT user_id, firstname, lastname, create_date FROM user_profile WHERE archive_status = '0'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>											
												<tr>
													<td class="py-1 px-2"><?php echo $row['user_id']; ?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['firstname']); ?></td>
													<td class="py-1 px-2 text-nowrap"><?php echo ucfirst($row['lastname']); ?></td>
													<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['create_date'])); ?></td>
													<td class="py-1 px-2 text-center">
														<a class="btn btn-info btn-sm" href="<?php echo web_root; ?>veterinarian/informations/clients/profiles/index.php?profile=<?php echo $row['user_id']; ?>">
															<i class="fas fa-folder"></i>
															View
														</a>
														<a class="btn btn-primary btn-sm archive-owner" id="<?php echo $row['user_id']; ?>">
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
		<script src="<?php echo web_root;?>veterinarian/informations/clients/js/archive_owner.js"></script>		
	</body>
</html>
