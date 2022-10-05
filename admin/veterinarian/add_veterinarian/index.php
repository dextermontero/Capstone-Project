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
		<title>Add Veterinarian	| Vets at Work Veterinary Clinic</title>
		<?php include('../../include/header.php'); ?>
		<style type="text/css">
		#viewIMG {
			height : 120px;
			width: 150px;
		}
		@media only screen and (max-width: 768px) { 
			#viewIMG {
				height: 120px;
			}	
		}
		@media screen and (max-width: 800px) {
			#viewIMG {
				height: 120px;
			}	
		}
		@media screen and (max-width: 1000px) {
			#viewIMG {
				height: 120px;
			}
		}			
		</style>
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
							<a href="../"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
							<div class="col-sm-6">
								<h1>Create Veterinarian</h1>
							</div>
						</div>
					</div><!-- /.container-fluid -->
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
							<div class="row">
 								<div class="col-lg-4 col-12">
 									<div class="card">
                						<div class="card-body">
											<div class="d-flex flex-column align-items-center text-center">
												<img src="<?php echo web_root; ?>dist/img/profiles/default.png" class="rounded-circle" alt="" width="150px" id="viewIMG">
												<div class="mt-3">
													<input type="file" class="form-control-file pt-3" accept="image/*" id="prevIMG">
													<span class="text-danger">*</span>
												</div>
											</div>
               					 		</div>
             						 </div>									 
 								</div>							
 								<div class="col-lg-8 col-12">
 									<div class="card-header">
										<div class="row mb-2">
											<div class="col-sm-4">
												<h5 class="m-0"> Personal Information</h5>
											</div>
											<div class="col-sm-8">
												<span class="text-danger">Note : Once the account is created the password will be sent later through the email address</span>
											</div>											
										</div>							
                  					</div>
									<div class="card-body">
										<form action="" method="POST">
											<div class="form-group">
												<div class="row">
													<div class="col-sm-3">
														<label for="firstname" class="col-form-label font-weight-normal">First Name <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="add_firstname" placeholder="Enter First Name">
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="middlename" class="col-form-label font-weight-normal">Middle Name</label>
													</div>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="add_middlename" placeholder="Enter Middle Name">
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="lastname" class="col-form-label font-weight-normal">Last Name <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="add_lastname" placeholder="Enter Last Name">
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="email" class="col-form-label font-weight-normal">Email <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="add_email" placeholder="Enter Email Address">
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="address" class="col-form-label font-weight-normal" >Address</label>
													</div>
													<div class="col-sm-9">
														<textarea class="form-control" id="add_address" rows="2" placeholder="Enter Address"></textarea>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="place_birth" class="col-form-label font-weight-normal">Place of Birth</label>
													</div>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="add_place_birth" placeholder="Enter Place of Birth">
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="gender" class="col-form-label font-weight-normal">Gender <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<select class="form-control form-control" id="add_gender">
															<option>Male</option>
															<option>Female</option>
														</select>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="birthday" class="col-form-label font-weight-normal">Birth Date <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<input type="date" class="form-control" id="add_birthdate" value="">
													</div>
												</div>
												<hr>										
												<div class="row">
													<div class="col-sm-3">
														<label for="contact_number" class="col-form-label font-weight-normal">Contact Number <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="add_contact_number" placeholder="Enter Phone Number ex. 09123456789">
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-sm-3">
														<label for="branches" class="col-form-label font-weight-normal">Branch <span class="text-danger">*</span></label>
													</div>
													<div class="col-sm-9">
														<select class="form-control" id="branches">
															<option selected disabled>-- SELECT BRANCH --</option>
															<?php
																$sql = "SELECT * FROM branch WHERE status = '1' AND archive_status = '0'";
																$result = $conn->query($sql);
																if($result -> num_rows > 0){
																	while($row = $result -> fetch_assoc()){
															?>
																<option value="<?php echo $row['branch_id']; ?>"><?php echo ucfirst($row['name']); ?></option>
															<?php
																	}
																}else{
															?>
																<option selected disabled>-- No Branch data --</option>
															<?php
																}
															?>
														</select>
													</div>
												</div>
												<hr>										
											</div>
											<div class="row">
												<div class="col-lg-6 col-12">
												
												</div>
												<div class="col-lg-6 col-12">
													<button type="submit" class="btn btn-success btn-block" id="add_vet">Add Veterinarian</button>
												</div>												
											</div>
										</form>
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
		<script type="text/javascript">
			$(document).ready(function() {
				$('#add_firstname').keydown(function (e) {
					if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
						return false;
					}
				});
				$('#add_middlename').keydown(function (e) {
					if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
						return false;
					}
				});
				$('#add_lastname').keydown(function (e) {
					if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
						return false;
					}
				});				
			});
		</script>		
		<script>
			$('#add_contact_number').keypress(function(e) {
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if ((event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
			});

			window.onload = () => {
				const myInput = document.getElementById("add_contact_number");
				myInput.onpaste = e => e.preventDefault();
			}		
		</script>
		<script>
			$(document).ready(function() {
				$('#add_vet').click(function(e) {
					e.preventDefault();
					$('#add_vet').attr('disabled','disabled');
					var file_data = $('#prevIMG').prop('files')[0];
					var form_data = new FormData();
					var firstname = $('#add_firstname').val();
					var middlename = $('#add_middlename').val();
					var lastname = $('#add_lastname').val();
					var email = $('#add_email').val();
					var address = $('#add_address').val();
					var birthplace = $('#add_place_birth').val();
					var gender = $('#add_gender').val();
					var birthdate = $('#add_birthdate').val();
					var phone = $('#add_contact_number').val();
					var branch = $('#branches').val();
					form_data.append('file', file_data);
					form_data.append('firstname', firstname);
					form_data.append('middlename', middlename);
					form_data.append('lastname', lastname);
					form_data.append('email', email);
					form_data.append('address', address);
					form_data.append('birthplace', birthplace);
					form_data.append('gender', gender);
					form_data.append('birthdate', birthdate);
					form_data.append('phone', phone);
					form_data.append('branch', branch);
					
					if(file_data != null && firstname != '' && lastname != '' && email != '' && gender != '' && birthdate != '' && phone != '' && branch != null){
						$.ajax({
							url : 'add_veterinarian.php',
							method : "POST",
							dataType : "text",
							cache : false,
							contentType : false,
							processData : false,
							data : form_data,
							success : function(data) {
								if(data == "success"){
									Swal.fire({
										title : "Add Veterinarian",
										icon : "success",
										html: "Successfully created veterinarian information",
										timer: 3000,
										showConfirmButton:false							
									}).then(function() {
										window.location.href = "../";
									});
								}else if(data == "exist"){
									Swal.fire({
										title : "Add Veterinarian",
										icon : "warning",
										text: "Email Address is already exist!",
										timer: 3000,
										showConfirmButton:false							
									}).then(function() {
										$('#add_vet').removeAttr('disabled','disabled');
									});
								}else {
									Swal.fire({
										title : "Add Veterinarian",
										icon : "error",
										text: "Something wrong in creation veterinarian.",
										timer: 3000,
										showConfirmButton:false							
									}).then(function() {
										$('#add_vet').removeAttr('disabled','disabled');
									});
								}
							}
						});						
					}else{
						Swal.fire({
							title : "Add Veterinarian",
							icon : "info",
							html: "<b>Note! </b>add veterinarian photo or fill out all fields.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							$('#add_vet').removeAttr('disabled','disabled');
						});						
					}
					
				});
			});
		</script>
		<script>
			prevIMG.onchange = evt => {
				const[file] = prevIMG.files
				if(file) {
					viewIMG.src = URL.createObjectURL(file);
				}
			}		
		</script>
	</body>
</html>
