<?php
require_once("../../include/initialize.php");
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>

<?php
$sql = "SELECT * FROM user_profile WHERE user_id = '$user'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
?>
	<div class="row">
		<div class="col-sm-3">
			<label for="firstname" class="col-form-label font-weight-normal">First Name <span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="firstname" value="<?php echo $row['firstname']; ?>">
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="middlename" class="col-form-label font-weight-normal">Middle Name</label>
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="middlename" value="<?php echo $row['middlename']; ?>" placeholder="Enter Middle Name">
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="lastname" class="col-form-label font-weight-normal">Last Name <span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="lastname" value="<?php echo $row['lastname']; ?>">
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="email" class="col-form-label font-weight-normal">Email <span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="email" value="<?php echo $row['email']; ?>">
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="address" class="col-form-label font-weight-normal">Address</label>
		</div>
		<div class="col-sm-9">
			<textarea class="form-control" id="address" rows="2" placeholder="Enter Primary Address"><?php echo $row['address']; ?></textarea>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="place_birth" class="col-form-label font-weight-normal">Place of Birth</label>
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="place_birth" value="<?php echo $row['place_bday']; ?>" placeholder="Enter Place of Birth">
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="gender" class="col-form-label font-weight-normal">Gender <span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-9">
			<select class="form-control form-control" id="gender">
				<?php 
					if($row['gender'] == '' || $row['gender'] == null){
				?>
					<option selected disabled>-- Select Gender --</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				<?php
					}elseif($row['gender'] == 'male'){
				?>
					<option value="male" selected>Male</option>
					<option value="female">Female</option>				
				<?php
					}else{
				?>
					<option value="male">Male</option>
					<option value="female" selected>Female</option>
				<?php
					}
				?>
			</select>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="birthday" class="col-form-label font-weight-normal">Birth Date <span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-9">
			<input type="date" class="form-control" id="birthday" value="<?php echo $row['birthdate']; ?>">
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<label for="contact_number" class="col-form-label font-weight-normal">Contact Number <span class="text-danger">*</span></label>
		</div>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="contact_number" value="<?php echo $row['contact_number']; ?>" maxlength="12" placeholder="Enter Phone Number">
		</div>
	</div>
	<hr>	
<?php
}
?>							