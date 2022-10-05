<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Reviews | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">Reviews</h1>
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
								<div class="small-box bg-info d-flex flex-column">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_review FROM reviews";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_reviews = number_format($row['all_review']);
										?>
										<h3><?php echo $count_reviews; ?></h3>
										<?php
											}
										?>	
										<p>Total Reviews</p>
									</div>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-4 col-6">
								<!-- small box -->
								<div class="small-box bg-success">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_publish FROM reviews WHERE status = '1'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_publish = number_format($row['all_publish']);
										?>
										<h3><?php echo $count_publish; ?></h3>
										<?php
											}
										?>	
										<p>Published Posts</p>
									</div>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-4 col-6">
								<!-- small box -->
								<div class="small-box bg-danger">
									<div class="inner">
										<?php
											$sql = "SELECT COUNT(*) as all_unpublish FROM reviews WHERE status = '0'";
											$result = $conn->query($sql);
											if($result -> num_rows > 0){
												$row = $result -> fetch_assoc();
												$count_unpublish = number_format($row['all_unpublish']);
										?>
										<h3><?php echo $count_unpublish; ?></h3>
										<?php
											}
										?>
										<p>Unpublished Posts</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header d-flex p-0">
										<ul class="nav nav-pills p-2">
											<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Review Lists</a></li>
											<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Published</a></li>
											<li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Unpublished</a></li>
										</ul>
									</div><!-- /.card-header -->
									<div class="card-body">
										<div class="tab-content">
											<div class="tab-pane active" id="tab_1">
												<table id="reviewlist" class="table table-striped table-hover table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Pet Owner</th>
															<th class="py-1 px-2">Service</th>
															<th class="py-1 px-2">Date</th>
															<th class="py-1 px-2">Review Description</th>
															<th class="py-1 px-2">Status</th>
															<th class="py-1 px-2">Action</th>
															
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT reviews.review_id, reviews.review_service, reviews.review_description, reviews.status, user_profile.firstname, user_profile.lastname, appointments.date FROM `reviews` INNER JOIN user_profile ON user_profile.user_id = reviews.user_id INNER JOIN appointments ON appointments.id = reviews.appointment_id";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
															<tr>
																<td class="py-1 px-2"><?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);?></td>
																<td class="py-1 px-2"><?php echo $row['review_service']; ?></td>
																<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																<td class="py-1 px-2"><?php echo $row['review_description']; ?></td>
																<td class="py-1 px-2">
																<?php 
																	if($row['status'] == '1'){
																?>
																	<span class="badge badge-success p-2"><i class="fas fa-eye"></i>&nbsp; Published</span>
																<?php		
																	}else{
																?>
																	<span class="badge badge-danger p-2"><i class="fas fa-eye-slash"></i>&nbsp; Unpublished</span>
																<?php			
																	}
																?>
																<?php
																	if($row['status'] == '1'){
																?>
																	<td class="py-1 px-2 w-25">
																		<a class="btn btn-info btn-sm view-review" id="<?php echo $row['review_id']; ?>" data-toggle="modal" data-target=".view-review-modal">
																			<i class="fas fa-eye"></i>&nbsp; 
																			View
																		</a>
																		<a class="btn btn-danger btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																			<i class="fas fa-eye-slash"></i>&nbsp; 
																			Unpublished
																		</a>																
																	</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2 w-25">
																		<a class="btn btn-info btn-sm view-review" id="<?php echo $row['review_id']; ?>" data-toggle="modal" data-target=".view-review-modal">
																			<i class="fas fa-eye"></i>&nbsp; 
																			View
																		</a>
																		<a class="btn btn-success btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																			<i class="fas fa-eye"></i>&nbsp; 
																			Published
																		</a>																
																	</td>
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
											</div><!-- /.tab-pane -->
											<div class="tab-pane" id="tab_2">
												<table id="reviewPublished" class="table table-striped table-hover table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Pet Owner</th>
															<th class="py-1 px-2">Service</th>
															<th class="py-1 px-2">Date</th>
															<th class="py-1 px-2">Review Description</th>
															<th class="py-1 px-2">Status</th>
															<th class="py-1 px-2">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT reviews.review_id, reviews.review_service, reviews.review_description, reviews.status, user_profile.firstname, user_profile.lastname, appointments.date FROM `reviews` INNER JOIN user_profile ON user_profile.user_id = reviews.user_id INNER JOIN appointments ON appointments.id = reviews.appointment_id WHERE reviews.status = '1'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
															<tr>
																<td class="py-1 px-2"><?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);?></td>
																<td class="py-1 px-2"><?php echo $row['review_service']; ?></td>
																<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																<td class="py-1 px-2"><?php echo $row['review_description']; ?></td>
																<td class="py-1 px-2">
																<?php 
																	if($row['status'] == '1'){
																?>
																	<span class="badge badge-success p-2"><i class="fas fa-eye"></i>&nbsp; Published</span>
																<?php		
																	}else{
																?>
																	<span class="badge badge-danger p-2"><i class="fas fa-eye-slash"></i>&nbsp; Unpublished</span>
																<?php			
																	}
																?>
																
																</td>
																<?php
																	if($row['status'] == '1'){
																?>
																	<td class="py-1 px-2 w-25">
																		<a class="btn btn-danger btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																			<i class="fas fa-eye-slash"></i>&nbsp; 
																			Unpublished
																		</a>																
																	</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2 w-25">
																		<a class="btn btn-success btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																			<i class="fas fa-eye"></i>&nbsp; 
																			Published
																		</a>																
																	</td>
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
											</div><!-- /.tab-pane -->
											<div class="tab-pane" id="tab_3">
												<table id="reviewUnpublished" class="table table-striped table-hover table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Pet Owner</th>
															<th class="py-1 px-2">Service</th>
															<th class="py-1 px-2">Date</th>
															<th class="py-1 px-2">Review Description</th>
															<th class="py-1 px-2">Status</th>
															<th class="py-1 px-2">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT reviews.review_id, reviews.review_service, reviews.review_description, reviews.status, user_profile.firstname, user_profile.lastname, appointments.date FROM `reviews` INNER JOIN user_profile ON user_profile.user_id = reviews.user_id INNER JOIN appointments ON appointments.id = reviews.appointment_id WHERE reviews.status = '0'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
															<tr>
																<td class="py-1 px-2"><?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);?></td>
																<td class="py-1 px-2"><?php echo $row['review_service']; ?></td>
																<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
																<td class="py-1 px-2"><?php echo $row['review_description']; ?></td>
																<td class="py-1 px-2">
																<?php 
																	if($row['status'] == '1'){
																?>
																	<span class="badge badge-success p-2"><i class="fas fa-eye"></i>&nbsp; Published</span>
																<?php		
																	}else{
																?>
																	<span class="badge badge-danger p-2"><i class="fas fa-eye-slash"></i>&nbsp; Unpublished</span>
																<?php			
																	}
																?>
																
																</td>
																<?php
																	if($row['status'] == '1'){
																?>
																	<td class="py-1 px-2 w-25">
																		<a class="btn btn-danger btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																			<i class="fas fa-eye-slash"></i>&nbsp; 
																			Unpublished
																		</a>																
																	</td>
																<?php
																	}else{
																?>
																	<td class="py-1 px-2 w-25">
																		<a class="btn btn-success btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																			<i class="fas fa-eye"></i>&nbsp; 
																			Published
																		</a>																
																	</td>
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
				</section>
			</div>
			<div class="modal fade view-review-modal" tabindex="-1" role="dialog" aria-labelledby="ViewReview" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="ViewReview">View Review</h5>
							<button type="button" class="close" id="view-review-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="view_review_modal"></div>
						</div>
					</div>
				</div>
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
		<script src="<?php echo web_root; ?>veterinarian/reviews/js/update_status.js"></script>		
	</body>
</html>
