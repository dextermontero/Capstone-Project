<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Reviews | Vets at Work Veterinary</title>
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
							</div>
							<div class="col-sm-6">
								<a href="#" class="btn btn-outline-success float-right" data-toggle="modal" data-target=".add-review-modal"><i class="fas fa-plus"></i> &nbsp;Add Review</a>
							</div>
						</div>
					</div>
				</div>
				
				<section class="content">
					<div class="container-fluid">
						
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
															<th class="py-1 px-2">Service</th>
															<th class="py-1 px-2">Review Description</th>
															<th class="py-1 px-2 text-center">Status</th>
															<th class="py-1 px-2 text-center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT * FROM reviews WHERE user_id = '$user' AND archive_status = '0'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
														<tr>
															<td class="py-1 px-2"><?php echo $row['review_service']; ?></td>
															<td class="py-1 px-2"><?php echo $row['review_description']; ?></td>
															<?php
																if($row['status'] == '1'){
															?>
																<td class="py-1 px-2 text-center text-success"><i class="fas fa-eye"></i>&nbsp; Published</td>
															<?php
																}else{
															?>
																<td class="py-1 px-2 text-center text-danger"><i class="fas fa-eye-slash"></i>&nbsp; Unpublished</td>
															<?php
																}
															?>
															
															<?php
																if($row['status'] == '1'){
															?>
																<td class="py-1 px-2 text-center">
																	<a class="btn btn-info btn-sm update-review" id="<?php echo $row['review_id']; ?>" data-toggle="modal" data-target=".edit-review-modal">
																		<i class="fas fa-edit"></i>&nbsp; 
																		Edit
																	</a>
																	<a class="btn btn-danger btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																		<i class="fas fa-eye-slash"></i>&nbsp; 
																		Unpublished
																	</a>
																	<a class="btn btn-primary btn-sm archive-status" id="<?php echo $row['review_id']; ?>">
																		<i class="fas fa-archive"></i>&nbsp; 
																		Archive
																	</a>															
																</td>
															<?php
																}else{
															?>
																<td class="py-1 px-2 text-center">
																	<a class="btn btn-info btn-sm update-review" id="<?php echo $row['review_id']; ?>" data-toggle="modal" data-target=".edit-review-modal">
																		<i class="fas fa-edit"></i>&nbsp; 
																		Edit
																	</a>
																	<a class="btn btn-success btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																		<i class="fas fa-eye"></i>&nbsp; 
																		Published
																	</a>
																	<a class="btn btn-primary btn-sm archive-status" id="<?php echo $row['review_id']; ?>">
																		<i class="fas fa-archive"></i>&nbsp; 
																		Archive
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

											<div class="tab-pane" id="tab_2">
												<table id="reviewPublish" class="table table-striped table-hover table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Service</th>
															<th class="py-1 px-2">Review Description</th>
															<th class="py-1 px-2 text-center">Status</th>
															<th class="py-1 px-2 text-center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT * FROM reviews WHERE status = '1' AND user_id = '$user' AND archive_status = '0'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
														<tr>
															<td class="py-1 px-2"><?php echo $row['review_service']; ?></td>
															<td class="py-1 px-2"><?php echo $row['review_description']; ?></td>
															<?php
																if($row['status'] == '1'){
															?>
																<td class="py-1 px-2 text-center text-success"><i class="fas fa-eye"></i>&nbsp; Published</td>
															<?php
																}else{
															?>
																<td class="py-1 px-2 text-center text-danger"><i class="fas fa-eye-slash"></i>&nbsp; Unpublished</td>
															<?php
																}
															?>
															<td class="py-1 px-2 text-center">
																<a class="btn btn-info btn-sm update-review" id="<?php echo $row['review_id']; ?>" data-toggle="modal" data-target=".edit-review-modal">
																	<i class="fas fa-edit"></i>&nbsp; 
																	Edit
																</a>
																<a class="btn btn-danger btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																	<i class="fas fa-eye-slash"></i>&nbsp; 
																	Unpublished
																</a>
																<a class="btn btn-primary btn-sm archive-status" id="<?php echo $row['review_id']; ?>">
																	<i class="fas fa-archive"></i>&nbsp; 
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

											<div class="tab-pane" id="tab_3">
												<table id="reviewUnpublish" class="table table-striped table-hover table-sm">
													<thead>
														<tr>
															<th class="py-1 px-2">Service</th>
															<th class="py-1 px-2">Review Description</th>
															<th class="py-1 px-2 text-center">Status</th>
															<th class="py-1 px-2 text-center">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$sql = "SELECT * FROM reviews WHERE status = '0' AND user_id = '$user' AND archive_status = '0'";
															$result = $conn->query($sql);
															if($result -> num_rows > 0){
																while($row = $result -> fetch_assoc()){
														?>
														<tr>
															<td class="py-1 px-2"><?php echo $row['review_service']; ?></td>
															<td class="py-1 px-2"><?php echo $row['review_description']; ?></td>
															<?php
																if($row['status'] == '1'){
															?>
																<td class="py-1 px-2 text-center text-success"><i class="fas fa-eye"></i>&nbsp; Published</td>
															<?php
																}else{
															?>
																<td class="py-1 px-2 text-center text-danger"><i class="fas fa-eye-slash"></i>&nbsp; Unpublished</td>
															<?php
																}
															?>
															<td class="py-1 px-2 text-center">
																<a class="btn btn-info btn-sm update-review" id="<?php echo $row['review_id']; ?>" data-toggle="modal" data-target=".edit-review-modal">
																	<i class="fas fa-edit"></i>&nbsp; 
																	Edit
																</a>
																<a class="btn btn-success btn-sm update-status" id="<?php echo $row['review_id']; ?>">
																	<i class="fas fa-eye"></i>&nbsp; 
																	Published
																</a>
																<a class="btn btn-primary btn-sm archive-status" id="<?php echo $row['review_id']; ?>">
																	<i class="fas fa-archive"></i>&nbsp; 
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
					</div>
				</section>
			</div>
			
			<div class="modal fade add-review-modal" tabindex="-1" role="dialog" aria-labelledby="addReview" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addReview">Add Review</h5>
							<button type="button" class="close" id="add-review-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="POST">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">					
										<div class="form-group">
											<label for="review_title">Service</label>
											<select name="review_title" class="form-control" id="review_title">
												<option value="" selected disabled>--SELECT FEEDBACK HERE--</option>
												<?php 
													$sql = "SELECT appointments.id, services.service_title FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.status = 'done' AND appointments.user_id = '$user' AND appointments.review = '0' AND appointments.archive_status = '0'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
														<option value="<?php echo $row['id']; ?>"><?php echo ucfirst(strtolower($row['service_title'])); ?></option>
												<?php
														}
													}else {
												?>
														<option selected disabled>No appointment's done</option>
												<?php
													}
												?>
												
											</select>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="form-group">
											<label for="review_description">Description</label><span class="text-danger">&nbsp;*</span>
											<textarea rows="5" class="form-control" id="review_description" placeholder="Review Description" disabled></textarea>
										</div>
									</div>								
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" id="add_feedback" disabled>Add Review</button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="modal fade edit-review-modal" tabindex="-1" role="dialog" aria-labelledby="UpdateReview" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="UpdateReview">Update Review</h5>
							<button type="button" class="close" id="update-review-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="update_review_modal"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" id="update_feedback">Update Review</button>
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
		<script src="<?php echo $web_root; ?>client/reviews/js/reviews.js"></script>
	</body>
</html>
