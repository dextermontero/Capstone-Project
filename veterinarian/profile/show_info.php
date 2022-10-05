<?php
require_once("../../include/initialize.php");
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>

<?php
$sql = "SELECT * FROM vet_profile WHERE vet_id = '$user'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
?>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">First Name</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php echo $row['firstname']; ?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Middle Name</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php
				if($row['middlename'] == null || $row['middlename'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo ucfirst($row['middlename']); ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Last Name</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php echo ucfirst($row['lastname']); ?>
		</div>
	</div>	
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Age</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php
				if($row['birthdate'] == null || $row['birthdate'] == ""){
			?>
				<i>Not Set Birthday</i>
			<?php
				}else{
					$dob = date("Y-n-d", strtotime($row['birthdate']));
					$from = new DateTime($dob);
					$to   = new DateTime('today');
					$age =  $from->diff($to)->y;															
			?>
				<?php echo $age; ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row" id="hidepass"> 
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Password</h6>
		</div>
		<div class="col-sm-7 col-4 text-secondary font-weight-bold">
			*************
		</div>
		<div class="col-sm-2 col-4">
			<a href="" id="password">Change Password</a>
		</div>
	</div>
	<div class="row" id="changepass" hidden>
		<div class="col-sm-3">
			<label for="current_pass" class="col-form-label font-weight-normal">Current Password</label>
		</div>
		<div class="col-sm-9">
			<input type="password" class="form-control mb-1" id="current_pass" placeholder="Enter Current Password">
		</div>
		<div class="col-sm-3">
			<label for="new_pass" class="col-form-label font-weight-normal">New Password</label>
		</div>
		<div class="col-sm-9">
			<input type="password" class="form-control mb-1" id="new_pass" placeholder="Enter New Password">
		</div>
		<div class="col-sm-3">
			<label for="confirm_pass" class="col-form-label font-weight-normal">Confirm Password</label>
		</div>
		<div class="col-sm-9">
			<input type="password" class="form-control mb-1" id="confirm_pass" placeholder="Enter Confirm Password">
		</div>
		<div class="col-sm-3">
		</div>
		<div class="col-sm-9">
			<span id="error" class="text-danger"></span>
		</div>		
		<div class="col-sm-3">
		</div>
		<div class="col-sm-9 mt-2">
			<button type="submit" class="btn btn-primary btn-sm" id="save-pass">Save Changes</button>
			<button type="submit" class="btn btn-default btn-sm" id="cancel-pass">Cancel</button>
		</div>			
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Email</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php echo $row['email']; ?>
		</div>
	</div>	
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Address</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary">
			<?php
				if($row['address'] == null || $row['address'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo $row['address']; ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Place of Birth</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php
				if($row['place_bday'] == null || $row['place_bday'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo $row['place_bday']; ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Gender</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php
				if($row['gender'] == null || $row['gender'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo ucfirst($row['gender']); ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Birth Date</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php
				if($row['birthdate'] == null || $row['birthdate'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo date("F d, Y", strtotime($row['birthdate'])); ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3 col-4">
			<h6 class="mb-0">Contact Number</h6>
		</div>
		<div class="col-sm-9 col-8 text-secondary font-weight-bold">
			<?php
				if($row['contact_number'] == null || $row['contact_number'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo $row['contact_number']; ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
<?php
}
?>							