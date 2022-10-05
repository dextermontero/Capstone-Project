<?php
require_once("../../../../include/initialize.php");
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
		header('location: '.web_root.'veterinarian/informations/pets/');
	}
}
?>
<?php
$sql = "SELECT pet_profile.pet_id, pet_profile.pet_name, pet_profile.pet_breed, pet_profile.pet_weight, pet_profile.pet_birthdate, pet_profile.pet_vaccination, pet_profile.pet_blood_type, pet_profile.pet_medical_status, user_profile.firstname, user_profile.lastname FROM pet_profile INNER JOIN user_profile ON user_profile.user_id = pet_profile.user_id WHERE pet_profile.pet_id = '$id'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
?>
	<span id="pet_id" hidden><?php echo $row['pet_id']; ?></span>	<div class="row">		<div class="col-sm-3">			<label for="pet_name" class="col-form-label font-weight-normal">Pet Name</label>		</div>		<div class="col-sm-9">			<input type="text" class="form-control" id="pet_name" value="<?php echo $row['pet_name']; ?>" disabled>		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="pet_owners" class="col-form-label font-weight-normal">Pet Owner</label>		</div>		<div class="col-sm-9">			<input type="text" class="form-control" id="pet_owners" value="<?php echo $fullname; ?>" disabled>		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="pet_breed" class="col-form-label font-weight-normal">Breed <span class="text-danger">*</span></label>		</div>		<div class="col-sm-9">			<input type="text" class="form-control" id="pet_breed" value="<?php echo $row['pet_breed']; ?>">		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="pet_weight" class="col-form-label font-weight-normal">Weight <span class="text-danger">*</span></label>		</div>		<div class="col-sm-9">			<input type="text" class="form-control" id="pet_weight" value="<?php echo $row['pet_weight']; ?>" placeholder="Enter Pet Weight">		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="birthdate" class="col-form-label font-weight-normal">Birthdate <span class="text-danger">*</span></label>		</div>		<div class="col-sm-9">			<input type="date" class="form-control" id="birthdate" value="<?php echo $row['pet_birthdate']; ?>">		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="pet_vaccination" class="col-form-label font-weight-normal">Vaccination</label>		</div>		<div class="col-sm-9">			<input type="text" class="form-control" id="pet_vaccination" value="<?php echo $row['pet_vaccination']; ?>" placeholder="Enter Vaccination Type">		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="pet_blood_type" class="col-form-label font-weight-normal">Blood Type</label>		</div>		<div class="col-sm-9">			<input type="text" class="form-control" id="pet_blood_type" value="<?php echo $row['pet_blood_type']; ?>" placeholder="Enter Blood Type">		</div>	</div>	<hr>	<div class="row">		<div class="col-sm-3">			<label for="pet_medical_status" class="col-form-label font-weight-normal">Medical Status</label>		</div>		<div class="col-sm-9">			<select class="form-control form-control" id="pet_medical_status">				<?php 					if($row['pet_medical_status'] == '' || $row['pet_medical_status'] == null){				?>					<option selected disabled>-- Select Medical Status --</option>					<option value="ongoing">Ongoing</option>					<option value="done">Done</option>				<?php					}elseif($row['gender'] == 'male'){				?>					<option value="ongoing" selected>Ongoing</option>					<option value="done">Done</option>								<?php					}else{				?>					<option value="ongoing">Ongoing</option>					<option value="done" selected>Done</option>				<?php					}				?>			</select>		</div>	</div>			<hr>
<?php
}
?>							