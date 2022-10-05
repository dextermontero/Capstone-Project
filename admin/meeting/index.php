<?php
require_once("../../include/initialize.php");
require_once('../../include/zoom-config.php');

session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
$url = "https://zoom.us/oauth/authorize?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URI;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Video Conference | Vets at Work Veterinary Clinic</title>
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
								<h1 class="m-0">Meeting List</h1>
							</div>
							<div class="col-sm-6">
								<button type="button" name="add-service" id="add-service" class="btn btn-outline-success float-right" data-toggle="modal" data-target=".add-meeting-modal"><i class="fas fa-plus"></i> &nbsp;Create Meeting</button>
								<a href="<?php echo $url;?>" id="request-token" class="btn btn-outline-primary float-right mr-2">
									<i class="fas fa-info-circle"></i> &nbsp;Request Token</a>
							</div>							
						</div>
					</div>
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="meeting" class="table table-borderedless table-striped table-hover table-sm">
										<thead>
											<tr>
												<th class="py-1 px-2">Meeting ID</th>
												<th class="py-1 px-2">Customer Name</th>
												<th class="py-1 px-2">Topic</th>
												<th class="py-1 px-2">Meeting Link</th>
												<th class="py-1 px-2">Meeting Password</th>
												<th class="py-1 px-2">Date</th>
												<th class="py-1 px-2">Time</th>
												<th class="py-1 px-2 text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$sql = "SELECT zoom_meeting.meeting_id, zoom_meeting.topic, zoom_meeting.link, zoom_meeting.password, zoom_meeting.date, zoom_meeting.time, user_profile.firstname, user_profile.lastname FROM zoom_meeting INNER JOIN user_profile ON zoom_meeting.to_client = user_profile.user_id";
												$result = $conn->query($sql);
												if($result -> num_rows > 0){
													while($row = $result -> fetch_assoc()){
														$fullname = ucfirst($row['firstname']).' '. ucfirst($row['lastname']);
											?>
											<tr>
												<td class="py-1 px-2"><?php echo $row['meeting_id']; ?></td>
												<td class="py-1 px-2"><?php echo $fullname; ?></td>
												<td class="py-1 px-2"><?php echo $row['topic']; ?></td>
												<td class="py-1 px-2"><a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['link']; ?></a></td>
												<td class="py-1 px-2"><?php echo $row['password']; ?></td>
												<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
												<td class="py-1 px-2"><?php echo date("g:i A", strtotime($row['time'])); ?></td>
												<td class="py-1 px-2 text-center">
													<a class="btn btn-primary btn-sm view-meeting" href="" id="<?php echo $row['meeting_id']; ?>" data-toggle="modal" data-target=".add-view-modal">
														<i class="fas fa-edit"></i>
														Edit
													</a>
													<a class="btn btn-danger btn-sm delete-meeting" href="" id="<?php echo $row['meeting_id']; ?>">
														<i class="fas fa-trash"></i>
														Delete
													</a>
												</td>
											</tr>
											<?php
													}
												}
											?>
											<?php if($result->num_rows <=0): ?>
												<tr>
													<th class="text-center" colspan="8">No Meeting Appointments to display.</th>
												</tr>
											<?php endif; ?>
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
		<div class="modal fade add-meeting-modal" tabindex="-1" role="dialog" aria-labelledby="addMeeting" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addMeeting">Create Meeting</h5>
						<button type="button" class="close" id="add-meeting-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-12">
								<div class="form-group">
									<label for="client_avail_show">Client <span class="text-danger">*</span></label>
									<select class="form-control" id="client_avail">
										<option selected disabled>-- SELECT PET OWNER HERE --</option>
									<?php 
										$sql = "SELECT pet_profile.pet_id, pet_profile.user_id, user_profile.firstname, user_profile.lastname FROM pet_profile LEFT JOIN user_profile ON user_profile.user_id = pet_profile.user_id WHERE pet_profile.archive_status = '0' GROUP BY pet_profile.user_id ORDER BY user_profile.lastname ASC";
										$result = $conn->query($sql);
										if($result -> num_rows > 0){
											while($row = $result -> fetch_assoc()){
									?>
											<option value="<?php echo $row['user_id']; ?>"><?php echo ucfirst($row['firstname']) .' '. $row['lastname']; ?></option>
									<?php
											}
										}else{
                                     ?>
                                          <option disabled selected>-- NO PET OWNER --</option>
                                     <?php  
                                      	}
									?>
									</select>
								</div>							
							</div>
						</div>
						<form id="forms" action="" method="POST">
							<div class="row">
								<div class="col-lg-12 col-12">
									<div class="form-group">
										<label for="topic_meeting_show">Topic Meeting <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="topic_meeting" placeholder="Enter Topic Meeting">
									</div>
								</div>
								<div class="col-lg-6 col-6">
									<div class="form-group">
										<label for="date_meeting_show">Date Meeting <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="date_meeting" min="<?php echo date("Y-m-d"); ?>" placeholder="Enter Topic Meeting">
									</div>							
								</div>
								<div class="col-lg-6 col-6">
									<div class="form-group">
										<label for="start_meeting_show">Start Meeting <span class="text-danger">*</span></label>
										<input type="time" class="form-control" id="start_meeting" placeholder="Enter Topic Meeting">
									</div>							
								</div>							
							
							</div>
						</form>
						<div class="col-lg-12 col-12">
							<button type="submit" class="btn btn-primary btn-block" id="create_meeting">Create Meeting</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade add-view-modal" tabindex="-1" role="dialog" aria-labelledby="ViewMeeting" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="ViewMeeting">Update Meeting</h5>
						<button type="button" class="close" id="view-meeting-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="view-meeting-modal"></div>
						<div class="row">
							<div class="col-lg-12 col-12">
								<button type="submit" class="btn btn-outline-success btn-block" id="update_meeting">Update Meeting</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
		
		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>admin/meeting/js/conference1.js"></script>
		<script>
$(document).ready(function() {
	$('#create_meeting').click(function(e) {
		e.preventDefault();
		var id = $('#client_avail').html();
		var topic = $('#topic_meeting').val();
		var date = $('#date_meeting').val();
		var start = $('#start_meeting').val();
		$('#create_meeting').attr('disabled', 'disabled');
		if(id != null && topic != '' && date != '' && start != ''){
			$.post("create-meeting.php", {id : id, topic : topic, date : date, start : start})
			.done(function(data) {
				if(data == 'success'){
					Swal.fire({
						title : "Create Meeting",
						icon : "success",
						html: "Successfully to create a conference meeting link.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});		
				}else{
					Swal.fire({
						title : "Create Meeting",
						icon : "warning",
						text: "Something wrong in creating conference meeting link.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
				alert(data);
			});
		}else {
			Swal.fire({
				title : "Create Meeting",
				icon : "info",
				html: "You need to fill up all required fields",
				timer: 3000,
				showConfirmButton:false							
			});	
		}
	});
});

$(document).ready(function() {
	$('.delete-meeting').click(function(e) {
		e.preventDefault();
		var meeting_id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Meeting',
			html: "<b>Are you sure?</b> you want to delete this meeting?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete-meeting.php", {meeting_id : meeting_id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Delete Meeting",
							icon : "success",
							html: "Successfully to delete conference meeting link.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Delete Meeting",
							icon : "error",
							html: "Failed to delete conference meeting link",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Delete Meeting",
							icon : "warning",
							text: "Something wrong in deleting conference meeting link.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}
		});					
	});
});

$(document).ready(function() {
	$('.view-meeting').click(function(e) {
		var id = $(this).attr('id');
		$.ajax({
			url : "view-meeting.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view-meeting-modal').html(data);
			}
		});
	});
});

$(document).ready(function() {
	$('#update_meeting').click(function(e) {
		e.preventDefault();
		var meeting_id = $('#edit_meetingID').val();
		var topic = $('#edit_topic').val();
		var date = $('#edit_date').val();
		var time = $('#edit_time').val();
		var pass = $('#edit_meetingPASSWORD').val();
		$.post("update-meeting.php", {meeting_id : meeting_id, topic : topic, date : date, time : time, pass : pass})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Update Meeting",
					icon : "success",
					html: "Successfully to update conference meeting.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});							
			}else{
				Swal.fire({
					title : "Update Meeting",
					icon : "warning",
					text: "Something wrong in updating conference meeting.",
					timer: 3000,
					showConfirmButton:false							
				});
			}
		});
	});
});		
		</script>
	</body>
</html>
