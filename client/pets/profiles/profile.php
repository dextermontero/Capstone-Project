<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

if(isset($_GET['pet_id'])){
	$get = $_GET['pet_id'];
	$chkGet = "SELECT pet_id FROM pet_profile WHERE pet_id = '$get' AND user_id = '$user'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$id = $_GET['pet_id'];
	}else {
		header('location: '.web_root.'client/pets/');
	}
}	

if(isset($_GET['diagnose'])){
	$get = $_GET['diagnose'];
	$sql = "SELECT status FROM notification WHERE id = '$get' AND receiver = '$user'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		$status = $row['status'];
		if($status == '1'){
			$sql = $conn->prepare("UPDATE notification SET status = '0' WHERE id = ?");
			$sql -> bind_param("s", $get);
			if($sql->execute()){
				
			}
		}else{
			
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Pet Details | Vets at Work Veterinary</title>
		<?php include('../../include/header.php'); ?>	
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../../include/sidebar.php'); ?>
			
			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1 class="m-0">Pet Details</h1>
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
 							<div class="row">
								<div class="col-lg-4 col-12">
									<?php
										$sql = "SELECT pet_profile.pet_id, pet_profile.pet_name, pet_profile.pet_photo, pet_profile.pet_breed, pet_profile.pet_weight, pet_profile.pet_birthdate, pet_profile.pet_vaccination, pet_profile.pet_blood_type, pet_profile.pet_medical_status, user_profile.firstname, user_profile.lastname FROM pet_profile INNER JOIN user_profile ON pet_profile.user_id = user_profile.user_id WHERE pet_profile.pet_id = '$id'";
										$result = $conn->query($sql);
										if($result -> num_rows > 0){
											$row = $result -> fetch_assoc();
									?>								
									<div class="card">
										<div class="float-right mt-3 mr-3">
											<span class="float-right">
												<a href="#" class="h6 change-profile-view" id="<?php echo $row['pet_id']; ?>" data-toggle="modal" data-target=".change-profile-modal"><i class="fas fa-edit"></i> Change Profile</a>
											</span>
										</div>										
										<div class="card-body">
											<div class="d-flex flex-column align-items-center text-center">
												<img src="<?php echo web_root; ?>dist/img/pet_profile/<?php echo $row['pet_photo']; ?>" alt="<?php echo $row['pet_name']; ?>" class="rounded-circle" width="150">
												<div class="mt-3">
													<h4><?php echo $row['pet_name']; ?></h4>
													<p class="text-secondary mb-1"><?php echo $row['pet_breed']; ?></p>
												</div>												
											</div>
										</div>
									 </div>
									<?php
										}
									?>
									<div class="list-group" id="list-tab" role="tablist">
										<a class="list-group-item list-group-item-action <?php if(isset($_GET['diagnose'])){echo '';}elseif(isset($_GET['prescription'])){echo '';}else{echo 'active';} ?>" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Pet Informations</a>
										<a class="list-group-item list-group-item-action <?php if(!isset($_GET['diagnose'])){}else{echo 'active';}?>" id="list-diagnosis-list" data-toggle="list" href="#list-diagnosis" role="tab" aria-controls="diagnosis">Diagnosis Records</a>
										<a class="list-group-item list-group-item-action <?php if(!isset($_GET['prescription'])){}else{echo 'active';}?>" id="list-prescription-list" data-toggle="list" href="#list-prescription" role="tab" aria-controls="prescription">Prescription Records</a>
									</div>									
								</div>								
								<div class="col-lg-8 col-12">
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade <?php if(isset($_GET['diagnose'])){echo '';}elseif(isset($_GET['prescription'])){echo '';}else{echo 'show active';} ?>" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
											<div class="card-header">
												<div class="row mb-2">
													<div class="col-sm-8">
														<h5 class="m-0"> Pet Information</h5>
													</div><!-- /.col -->
												</div>							
											</div>									
											<div class="card-body">
												<?php
													$sql = "SELECT * FROM pet_profile WHERE pet_id = '$id'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
												?>
													<div class="row" id="hide_petname">
														<div class="col-sm-3 col-3">
															<h6 class="mb-0">Pet Name</h6>
														</div>
														<div class="col-sm-7 col-5 text-secondary font-weight-bold">
															<?php
																if($row['pet_name'] == null || $row['pet_name'] == ""){
															?>
																<i>Not Set</i>
															<?php
																}else{
															?>
																<?php echo ucfirst($row['pet_name']); ?>
															<?php
																}
															?>
														</div>
														<div class="col-sm-2 col-4">
															<a href="" id="c_pet_name">Change Pet Name</a>
														</div>
													</div>
													<div class="row" id="change_petname" hidden>
														<div class="col-sm-3">
															<span id="pet_id_name" hidden><?php echo $row['pet_id']; ?></span>
															<label for="new_petname" class="col-form-label font-weight-normal">Pet Name</label>
														</div>
														<div class="col-sm-9">
															<input type="text" class="form-control mb-1" id="new_petname" placeholder="Enter New Pet Name">
														</div>
														<div class="col-sm-3">
														</div>												
														<div class="col-sm-9">
															<span id="error" class="text-danger"></span>
														</div>		
														<div class="col-sm-3">
														</div>
														<div class="col-sm-9 mt-2">
															<button type="submit" class="btn btn-primary btn-sm" id="save-petname">Save Changes</button>
															<button type="submit" class="btn btn-default btn-sm" id="cancel-petname">Cancel</button>
														</div>			
													</div>											
													<hr>
													<div class="row">
														<div class="col-sm-3 col-3">
															<h6 class="mb-0">Pet Owner</h6>
														</div>
														<div class="col-sm-9 col-9 text-secondary font-weight-bold">
															<?php
																if($fullname == null || $fullname == ""){
															?>
																<i>Not Set</i>
															<?php
																}else{
															?>
																<?php echo $fullname; ?>
															<?php
																}
															?>
														</div>
													</div>
													<hr>
													<div class="row" id="hide_petbreed">
														<div class="col-sm-3 col-3">
															<h6 class="mb-0">Breed</h6>
														</div>
														<div class="col-sm-7 col-5 text-secondary font-weight-bold">
															<?php
																if($row['pet_breed'] == null || $row['pet_breed'] == ""){
															?>
																<i>Not Set</i>
															<?php
																}else{
															?>
																<?php echo ucfirst($row['pet_breed']); ?>
															<?php
																}
															?>
														</div>
														<div class="col-sm-2 col-4">
															<a href="" id="c_pet_breed">Change Pet Breed</a>
														</div>												
													</div>
													<div class="row" id="change_petbreed" hidden>
														<div class="col-sm-3">
															<span id="pet_id_breed" hidden><?php echo $row['pet_id']; ?></span>
															<label for="new_petbreed" class="col-form-label font-weight-normal">Breed</label>
														</div>
														<div class="col-sm-9">
															<input type="text" class="form-control mb-1" id="new_petbreed" placeholder="Enter Pet Breed">
														</div>
														<div class="col-sm-3">
														</div>												
														<div class="col-sm-9">
															<span id="error1" class="text-danger"></span>
														</div>		
														<div class="col-sm-3">
														</div>
														<div class="col-sm-9 mt-2">
															<button type="submit" class="btn btn-primary btn-sm" id="save-petbreed">Save Changes</button>
															<button type="submit" class="btn btn-default btn-sm" id="cancel-petbreed">Cancel</button>
														</div>			
													</div>											
													<hr>
													<div class="row">
														<div class="col-sm-3 col-3">
															<h6 class="mb-0">Birthdate </h6>
														</div>
														<div class="col-sm-9 col-9 text-secondary font-weight-bold">
															<?php
																if($row['pet_birthdate'] == null || $row['pet_birthdate'] == "" || $row['pet_birthdate'] == "0000-00-00"){
															?>
																<i>Not Set</i>
															<?php
																}else{
															?>
																<?php echo date("F d, Y", strtotime($row['pet_birthdate'])); ?>
															<?php
																}
															?>
														</div>
													</div>
													<hr>
													<div class="row">
														<div class="col-sm-3 col-3">
															<h6 class="mb-0">Age </h6>
														</div>
														<div class="col-sm-9 col-9 text-secondary font-weight-bold">
															<?php
																if($row['pet_birthdate'] == null || $row['pet_birthdate'] == "" || $row['pet_birthdate'] == "0000-00-00"){
															?>
																<i>Not Set</i>
															<?php
																}else{
																	$dob = date("Y-n-d", strtotime($row['pet_birthdate']));
																	$from = new DateTime($dob);
																	$to   = new DateTime('today');
																	$age =  $from->diff($to);
																	$ageHolder = $age->y;
																	if($ageHolder <= 0){
																		printf("%d month(s) old", $age->m);
																	}else{
																		printf("%d year(s) & %d month(s)", $age->y, $age->m);
																	}
																}
															?>
														</div>
													</div>
													<hr>
													<div class="row">
														<div class="col-sm-3 col-3">
															<h6 class="mb-0">Medical Status </h6>
														</div>
														<div class="col-sm-9 col-9 text-secondary font-weight-bold">
															<?php
																if($row['pet_medical_status'] == null || $row['pet_medical_status'] == ""){
															?>
																<i>Not Set</i>
															<?php
																}else{
															?>
																<?php echo $row['pet_medical_status']; ?>
															<?php
																}
															?>
														</div>
													</div>
													<hr>
												<?php
													}
												?>
											</div>
										</div>
										<div class="tab-pane fade <?php if(!isset($_GET['diagnose'])){}else{echo 'show active';}?>" id="list-diagnosis" role="tabpanel" aria-labelledby="list-diagnosis-list">
											<?php 
												if(!isset($_GET['diagnose'])){
											?>
											<div class="card-header">
												<div class="row mb-2">
													<div class="col-sm-8">
														<h5 class="m-0"> Medical Diagnosis List</h5>
													</div>
												</div>							
											</div>
											<?php
												$sql = "SELECT * FROM diagnosis_records WHERE user_id = '$user' AND pet_id = '$id' AND archive_status = '0'";
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
																		<a href="<?php echo web_root; ?>client/pets/profiles/profile.php?pet_id=<?php echo $id;?>&diagnose=<?php echo $row['id'];?>" class="card-link"><i class="fas fa-eye"></i>&nbsp; View Diagnose</a>
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
												}else{
											?>
											<div class="card-header">
												<div class="row mb-2">
													<div class="col-sm-8 d-flex">
														<a href="<?php echo web_root; ?>client/pets/profiles/profile.php?pet_id=<?php echo $id; ?>"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 20px;"></i></a>
														<h5 class="m-0"> Medical Diagnosis</h5>
													</div>
												</div>							
											</div>
											<div class="card-body">
												<form action="" method="POST">
													<div class="row">
														<?php
															$sql = "SELECT * FROM pet_profile LEFT JOIN diagnosis_records ON diagnosis_records.pet_id = pet_profile.pet_id WHERE pet_profile.pet_id = '$id' AND pet_profile.user_id = '$user' AND pet_profile.archive_status = '0'";
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
														<div class="col-md-6 .ml-auto">
															<div class="form-group">
																<label for="date_service">Date of Service <span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="date_service" value="<?php echo $row['date']; ?>" placeholder="Date of Service" disabled>
															</div>						
														</div>		
														
														<div class="col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
																<input type="text" class="form-control" id="diagnosis" value="<?php echo $row['diagnosis']; ?>" placeholder="Diagnosis" disabled>
															</div>						
														</div>	
														<div class="col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="addnotes">Additional Notes</label>
																<textarea class="form-control" id="addnotes" rows="3" disabled><?php echo $row['additional_notes']; ?></textarea>
															</div>						
														</div>	
														<?php
															}
														?>														
													</div>
												</form>
											</div>
											<?php
												}
											?>
										</div>
										<div class="tab-pane fade <?php if(!isset($_GET['prescription'])){}else{echo 'show active';}?>" id="list-prescription" role="tabpanel" aria-labelledby="list-prescription-list">
											<div class="card-header">
												<div class="row mb-2">
													<div class="col-sm-8">
														<h5 class="m-0">Prescription Records</h5>
													</div>
												</div>							
											</div>
											<?php
												$sql = "SELECT * FROM prescription_records WHERE user_id = '$user' AND pet_id = '$id' AND archive_status = '0'";
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
																	<h6 class="card-subtitle mb-2 text-muted">February 28, 2022</h6>
																	<p class="card-text"><?php echo $row['prescription_name']; ?></p>
																	<div class="row">
																		<div class="col-5 col-lg-6 col-md-6 col-sm-6 col-xs-6">
																			<a href="<?php echo web_root; ?>dist/img/pet_profile/prescription/<?php echo $row['filename']; ?>" target="_new" class="card-link"><i class="fas fa-eye"></i>&nbsp; View</a>
																		</div>
																		<div class="col-7 col-lg-6 col-md-6 col-sm-6 col-xs-6 text-nowrap text-right">
																			<a href="<?php echo web_root; ?>dist/img/pet_profile/prescription/<?php echo $row['filename']; ?>" class="card-link text-success" download><i class="fas fa-download"></i>&nbsp; Download</a>
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
												}else {
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
			<div class="modal fade change-profile-modal" tabindex="-1" role="dialog" aria-labelledby="ChangeProfile" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="ChangeProfile">Change Profile</h5>
							<button type="button" class="close" id="change-profile-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="view-change-profile"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary btn-block" id="change_profile">Change Profile</button>
						</div>
					</div>
				</div>
			</div>
			<footer class="main-footer">
				<strong>Copyright &copy; <?php echo date("Y");?> <a href="<?php echo web_root; ?>">Vets at Work Veterinary Clinic</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b></b>
				</div>
			</footer>
		</div>
		<?php include('../../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>client/pets/profiles/pet.js"></script>
	</body>
</html>
