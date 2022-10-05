<?php
require_once("../../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

if(isset($_GET['pet_id'])){
	
	$get = $_GET['pet_id'];
	$chkGet = "SELECT pet_id FROM pet_profile WHERE pet_id = '$get'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$id = $_GET['pet_id'];
	}else {
    	$actual_link = $_SERVER['REQUEST_URI'];
      	if (strpos($actual_link, '%27') !== false) {
        	$new_link = str_replace("%27","",$actual_link);
          	$host  = $_SERVER['HTTP_HOST'];
          	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
          	header("Location: $new_link");
          	exit;
     	}else{
			header("location: ../");
        }
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Pet Details | Vets at Work Veterinary Clinic</title>
		<?php include('../../../include/header.php'); ?>
		<style type="text/css">
		.file-upload {
			background-color: #ffffff;
			width: 	;
			margin: 0 auto;
			padding: 20px;
		}

		.file-upload-btn {
			width: 100%;
			margin: 0;
			color: #fff;
			background: #1FB264;
			border: none;
			padding: 10px;
			border-radius: 4px;
			border-bottom: 4px solid #15824B;
			transition: all .2s ease;
			outline: none;
			text-transform: uppercase;
			font-weight: 700;
		}

		.file-upload-btn:hover {
			background: #1AA059;
			color: #ffffff;
			transition: all .2s ease;
			cursor: pointer;
		}

		.file-upload-btn:active {
			border: 0;
			transition: all .2s ease;
		}

		.file-upload-content {
			display: none;
			text-align: center;
		}

		.file-upload-input {
			position: absolute;
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			outline: none;
			opacity: 0;
			cursor: pointer;
		}

		.image-upload-wrap {
			margin-top: 20px;
			border: 2px dashed #1FB264;
			position: relative;
		}

		.image-dropping, .image-upload-wrap:hover {
			background-color: #1FB264;
			border: 2px dashed #ffffff;
		}

		.image-title-wrap {
			padding: 0 15px 15px 15px;
			color: #222;
		}

		.drag-text {
			text-align: center;
		}

		.drag-text h4 {
			font-weight: 50;
			font-size: 18px;
			text-transform: uppercase;
			color: #15824B;
			padding: 60px 0;
		}

		.file-upload-image {
			max-height: 200px;
			max-width: 200px;
			margin: auto;
			padding: 20px;
		}

		.remove-image {
			width: auto;
			margin: 0;
			color: #fff;
			background: #cd4535;
			border: none;
			padding: 10px;
			border-radius: 4px;
			border-bottom: 4px solid #b02818;
			transition: all .2s ease;
			outline: none;
			text-transform: uppercase;
			font-weight: 300;
			font-size: 14px;
		}

		.remove-image:hover {
			background: #c13b2a;
			color: #ffffff;
			transition: all .2s ease;
			cursor: pointer;
		}

		.remove-image:active {
			border: 0;
			transition: all .2s ease;
		}		
		</style>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Main Sidebar Container -->
			<?php include('../../../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1 class="m-0">Pet Details</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
 							<div class="row">
								<div class="col-lg-4 col-12">
									<div class="card">
										<div class="card-body">
											<div class="d-flex flex-column align-items-center text-center">
												<?php
													$sql = "SELECT pet_profile.user_id, pet_profile.pet_name, pet_profile.pet_photo, pet_profile.pet_breed, pet_profile.pet_weight, pet_profile.pet_birthdate, pet_profile.pet_vaccination, pet_profile.pet_blood_type, pet_profile.pet_medical_status, user_profile.firstname, user_profile.lastname FROM pet_profile INNER JOIN user_profile ON pet_profile.user_id = user_profile.user_id WHERE pet_profile.pet_id = '$id'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
													<span id="pet_id_prescription" hidden><?php echo $id;?></span>
													<img src="<?php echo web_root; ?>dist/img/pet_profile/<?php echo $row['pet_photo']; ?>" alt="<?php echo $row['pet_name']; ?>" class="rounded-circle" width="150">
													<div class="mt-3">
														<h4><?php echo $row['pet_name']; ?></h4>
														<p class="text-secondary mb-1"><?php echo $row['pet_breed']; ?></p>
														<a class="btn btn-primary btn-xs" href="<?php echo web_root; ?>veterinarian/informations/clients/profiles/index.php?profile=<?php echo $row['user_id']; ?>">View Owner Info</a>
													</div>												
												<?php
													}
												?>
											</div>
										</div>
									</div>
									<div class="list-group" id="list-tab" role="tablist">
										<a class="list-group-item list-group-item-action <?php if(isset($_GET['diagnose'])){echo '';}elseif(isset($_GET['prescription'])){echo '';}elseif(isset($_GET['add_diagnosis'])){echo '';}else{echo 'active';} ?>" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Pet Informations</a>
										<a class="list-group-item list-group-item-action <?php if(isset($_GET['diagnose'])){echo 'active';}elseif(isset($_GET['add_diagnosis'])){echo 'active';}else{echo '';}?>" id="list-diagnosis-list" data-toggle="list" href="#list-diagnosis" role="tab" aria-controls="diagnosis">Diagnosis Records</a>
										<a class="list-group-item list-group-item-action <?php if(!isset($_GET['prescription'])){}else{echo 'active';}?>" id="list-prescription-list" data-toggle="list" href="#list-prescription" role="tab" aria-controls="prescription">Prescription Records</a>
									</div>
								</div> <!--col -->								
								<div class="col-lg-8 col-12">
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade <?php if(isset($_GET['diagnose'])){echo '';}elseif(isset($_GET['prescription'])){echo '';}elseif(isset($_GET['add_diagnosis'])){echo '';}else{echo 'show active';} ?>" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
											<div class="card-header">
												<div class="row mb-2">
													<div class="col-sm-8 col-6">
														<h5 class="m-0"> Pet Information</h5>
													</div><!-- /.col -->
													<div class="col-sm-4 col-6 text-right">
														<?php
															if(!isset($_COOKIE['edit-pet']) == 'edit-pet'){
														?>
															<button class="btn btn-info btn-sm edit-info">Edit Information</button>
														<?php
															}else{
														?>
															<button class="btn btn-danger btn-sm cancel-edit">Cancel</button>
														<?php
															}
														?>
													</div>
												</div>							
											</div>									
											<div class="card-body">
												<?php
													if(!isset($_COOKIE['edit-pet']) == 'edit-pet'){
														include("show_info.php");
													}else{
														include("edit_info.php");
													}										
												?>
												<?php
													if(isset($_COOKIE['edit-pet']) == 'edit-pet'){
												?>
												<div class="row">
													<div class="col-lg-12 col-12">
														<button type="submit" class="btn btn-outline-primary btn-md btn-block" id="save-changes">Save Changes</button>
													</div>
												</div>
												<?php
													}
												?>										
											</div>
										</div>
										<div class="tab-pane fade <?php if(isset($_GET['diagnose'])){echo 'show active';}elseif(isset($_GET['add_diagnosis'])){echo 'show active';}else{echo '';}?>" id="list-diagnosis" role="tabpanel" aria-labelledby="list-diagnosis-list">
											<?php
												if(isset($_GET['diagnose'])){
											?>
													<div class="card-header">
														<div class="row mb-2">
															<div class="col-sm-8 d-flex">
																<a href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $id; ?>"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 20px;"></i></a>
																<h5 class="m-0"> Medical Diagnosis</h5>
															</div>
															<div class="col-sm-4 col-6 text-right">
															<?php
																if(!isset($_COOKIE['edit-diagnosis']) == 'edit-diagnosis'){
															?>
																<button class="btn btn-info btn-sm edit-diagnosis">Edit Diagnosis</button>
															<?php
																}else{
															?>
																<button class="btn btn-danger btn-sm cancel-diagnosis">Cancel</button>
															<?php
																}
															?>
															</div>
														</div>							
													</div>
													<div class="card-body">
														<?php
															if(!isset($_COOKIE['edit-diagnosis']) == 'edit-diagnosis'){
																include("diagnosis_show.php");
															}else{
																include("diagnosis_edit.php");
															}										
														?>
														<?php
															if(isset($_COOKIE['edit-diagnosis']) == 'edit-diagnosis'){
														?>
														<div class="row">
															<div class="col-lg-12 col-12">
																<button type="submit" class="btn btn-outline-success btn-md btn-block" id="save-changes-diagnosis">Save Changes</button>
															</div>
														</div>
														<?php
															}
														?>
													</div>
											<?php
												}elseif(isset($_GET['add_diagnosis'])){
											?>
													<div class="card-header">
														<div class="row mb-2">
															<div class="col-sm-8 d-flex">
																<a href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $id; ?>"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 20px;"></i></a>
																<h5 class="m-0"> Medical Diagnosis Form</h5>
															</div>
														</div>							
													</div>									
													<div class="card-body">
														<form action="" method="POST">
															<div class="row">
																<?php
																	$sql = "SELECT * FROM pet_profile WHERE pet_id = '$id'";
																	$result = $conn->query($sql);
																	if($result -> num_rows > 0){
																		$row = $result -> fetch_assoc();
																?>
																<div class="col-md-6" hidden>
																	<div class="form-group">
																		<label for="petid_diagnose">Pet ID</label>
																		<input type="text" class="form-control" id="petid_diagnose" value="<?php echo ucfirst($row['pet_id']); ?>" placeholder="Pet Name" disabled>
																	</div>						
																</div>
																<div class="col-md-6" hidden>
																	<div class="form-group">
																		<label for="userid_diagnose">Pet Owner</label>
																		<input type="text" class="form-control" id="userid_diagnose" value="<?php echo ucfirst($row['user_id']); ?>" placeholder="Pet Name" disabled>
																	</div>						
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="petname_diagnose">Pet Name</label>
																		<input type="text" class="form-control" id="petname_diagnose" value="<?php echo ucfirst($row['pet_name']); ?>" placeholder="Pet Name" disabled>
																	</div>						
																</div>
																<div class="col-md-6 .ml-auto">
																	<div class="form-group">
																		<label for="petbreed_diagnose">Pet Breed</label>
																		<input type="text" class="form-control" id="petbreed_diagnose" value="<?php echo ucfirst($row['pet_breed']); ?>" placeholder="Breed" disabled>
																	</div>						
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="petbirth_diagnose">Pet Birthdate</label>
																		<?php
																			if($row['pet_birthdate'] == '' || $row['pet_birthdate'] == null){
																		?>
																			<input type="text" class="form-control" id="petbirth_diagnose" value="not set" placeholder="Pet Birthday" disabled>
																		<?php
																			}else{
																		?>
																			<input type="text" class="form-control" id="petbirth_diagnose" value="<?php echo $row['pet_birthdate']; ?>" placeholder="Pet Birthday" disabled>
																		<?php
																			}
																		?>
																	</div>						
																</div>
																<?php
																	}
																?>														
																<div class="col-md-6 .ml-auto">
																	<div class="form-group">
																		<label for="date_service">Date of Service <span class="text-danger">*</span></label>
																		<input type="date" class="form-control" id="date_service" placeholder="Date of Service">
																	</div>						
																</div>		
																
																<div class="col-lg-12 col-md-12 col-sm-12 col-12">
																	<div class="form-group">
																		<label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
																		<input type="text" class="form-control" id="diagnosis" placeholder="Diagnosis">
																	</div>						
																</div>	
																<div class="col-lg-12 col-md-12 col-sm-12 col-12">
																	<div class="form-group">
																		<label for="addnotes">Additional Notes</label>
																		<textarea class="form-control" id="addnotes" rows="3"></textarea>
																	</div>						
																</div>						
															</div>
															<button type="submit" class="btn btn-primary btn-block" id="send_diagnose">Send</button>
														</form>
													</div>
											<?php
												}else{
											?>
													<div class="card-header">
														<div class="row mb-2">
															<div class="col-sm-8">
																<h5 class="m-0"> Medical Diagnosis List</h5>
															</div>
															<div class="col-sm-4 col-6 text-right">
																<a href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $id; ?>&add_diagnosis" class="btn btn-info btn-sm">Add Diagnosis</a>
															</div>													
														</div>							
													</div>
													<?php
														$sql = "SELECT * FROM diagnosis_records WHERE pet_id = '$id' AND archive_status = '0'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0) {
													?>
													<div style="height:70vh;overflow: auto;">
														<div class="card-body">
															<div class="row">
																<?php
																	while($row = $result -> fetch_assoc()){
																?>
																<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4 col-6">
																	<div class="card">
																		<div class="card-body">
																			<h6 class="card-subtitle mb-2 text-muted"><?php echo date("F d, Y", strtotime($row['date'])); ?></h6>
																			<p class="card-text"><?php echo strtoupper($row['diagnosis']); ?></p>
																			<div class="text-center">
																				<a href="<?php echo web_root; ?>veterinarian/informations/pets/profiles/profile.php?pet_id=<?php echo $id;?>&diagnose=<?php echo $row['id'];?>" class="card-link"><i class="fas fa-eye"></i>&nbsp; View Diagnose</a>
																			</div>
																		</div>
																	</div>
																</div>
																<?php
																	}
																?>
															</div>
														</div>
													</div>	
													
													<?php
														}else{
													?>
													<div>
														<div class="card-body">
															<div class="row">											
																<div class="col-lg-12 col-12 text-center text-secondary">
																	<span class="h4">No medical diagnose data</span>
																</div>
															</div>
														</div>
													</div>
													<?php
														}
													?>
											<?php
												}
											?>
										</div>
										<div class="tab-pane fade <?php if(!isset($_GET['prescription'])){}else{echo 'show active';}?>" id="list-prescription" role="tabpanel" aria-labelledby="list-prescription-list">
											<div class="card-header">
												<div class="row mb-2">
													<div class="col-sm-8 col-6">
														<h5 class="m-0">Prescription Records</h5>
													</div>
													<div class="col-sm-4 col-6 text-right">
														<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_prescription_modal">Add Prescription</button>
													</div>
												</div>							
											</div>
											<?php
												$sql = "SELECT * FROM prescription_records WHERE pet_id = '$id' AND archive_status = '0'";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
											?>
											<div style="height:70vh;overflow: auto;">
												<div class="card-body">
													<div class="row">	
											<?php
													while($row = $result -> fetch_assoc()){
											?>
														<div class="col-sm-4 col-md-4 col-lg-4 col-xs-4 col-6">
															<div class="card">
																<div class="card-body">
																	<h6 class="card-subtitle mb-2 text-muted"><?php echo date("F d, Y", strtotime($row['date'])); ?></h6>
																	<p class="card-text"><?php echo $row['prescription_name']; ?></p>
																	<div class="row">
																		<div class="col-5 col-lg-6 col-md-6 col-sm-6 col-xs-6">
																			<a href="<?php echo web_root; ?>dist/img/pet_profile/prescription/<?php echo $row['filename']; ?>" target="_new" class="card-link"><i class="fas fa-eye"></i>&nbsp; View</a>
																		</div>
																		<div class="col-7 col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right text-nowrap">
																			<a href="#" class="card-link text-danger archive-prescription" id="<?php echo $row['prescription_id']; ?>"><i class="fas fa-archive"></i>&nbsp; Archive</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
											<?php
													}
											?>
													</div>
												</div>
											</div>	
											<?php
												}else{
											?>
											<div>
												<div class="card-body">
													<div class="row">											
														<div class="col-lg-12 col-12 text-center text-secondary">
															<span class="h4">No prescription data</span>
														</div>
													</div>
												</div>
											</div>												
											<?php
												}
											?>
										</div>
									</div>
								</div>
 							</div>
 						</div>
					</div>
				</section>
			</div>

			<div class="modal" id="add_prescription_modal" tabindex="-1" role="dialog" aria-labelledby="Add_Prescription_Label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="Add_Prescription_Label">Add Prescription</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="POST">
								<span id="pet_id" hidden><?php echo $_GET['pet_id']; ?></span>
								<div class="form-group">
									<label for="presname">Prescription Name : </label>
									<input type="text" class="form-control form-sm" id="presname" placeholder="Prescription Name">
								</div>
								<div class="image-upload-wrap">
									<input class="file-upload-input" type="file" id="fileUpload" name="fileUpload" onchange="readURL(this);" accept="image/*" />
									<div class="drag-text">
										<h4>Drag and drop a file or select add Image</h4>
									</div>
								</div>
								<div class="file-upload-content">
									<img class="file-upload-image" src="#" alt="your image" />
									<div class="image-title-wrap">
										<button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
									</div>
								</div>
								<button type="submit" class="btn btn-success btn-block mt-3" id="upload_prescription">Upload Prescription</button>
							</form>
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

		<?php include('../../../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>js/jquery.cookie.js"></script>
		<script src="<?php echo web_root; ?>veterinarian/informations/pets/profiles/pet_profile.js"></script>	
		<script src="<?php echo web_root; ?>veterinarian/informations/pets/profiles/treatment.js"></script>
		<script src="<?php echo web_root; ?>veterinarian/informations/pets/profiles/prescription.js"></script>
	</body>
</html>
