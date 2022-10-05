<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Archived Pets | Vets at Work Veterinary</title>
		<?php include('../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../../include/sidebar.php'); ?>
			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Archived Pets</h1>
							</div>
						</div>
					</div>
				</div>
				<section class="content">
					<div class="container-fluid">   				
						<div class="main-body">
							<div class="row">							
 								<div class="col-lg-12 col-12">
									<div class="card">
										<div class="card-body">
											<div class="table-responsive">
												<table id="archive_reviews" class="table table-striped table-hover table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Pet Name</th>
															<th class="py-1 px-2">Pet Breed</th>
															<th class="py-1 px-2 text-center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT archive.archive_id, pet_profile.pet_name, pet_profile.pet_breed FROM archive INNER JOIN pet_profile ON pet_profile.pet_id = archive.id WHERE archive.category = 'pets' AND archive.user_id = '$user'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
														<tr>
															<td class="py-1 px-2"><?php echo $row['pet_name']; ?></td>
															<td class="py-1 px-2"><?php echo $row['pet_breed']; ?></td>
															<td class="py-1 px-2 text-center">
																<a class="btn btn-info btn-sm recover-pet" id="<?php echo $row['archive_id']; ?>">
																	<i class="fas fa-trash-restore"></i>&nbsp; 
																	Recover
																</a>
																<a class="btn btn-danger btn-sm delete-pet" id="<?php echo $row['archive_id']; ?>">
																	<i class="fas fa-trash"></i>&nbsp; 
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
		<script src="<?php echo $web_root; ?>client/archived/pets/js/pet_archive.js"></script>	
	</body>
</html>
