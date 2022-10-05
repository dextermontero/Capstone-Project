<?php
require_once("../../../../include/initialize.php");
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}
if(isset($_GET['diagnose'])){
	$get = $_GET['diagnose'];
	$chkGet = "SELECT id FROM diagnosis_records WHERE id = '$get'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$diagnosis = $_GET['diagnose'];
	}else {
		header('location: '.web_root.'veterinarian/informations/pets/');
	}
}
?>
<form action="" method="POST">
	<div class="row">
		<?php
			$sql = "SELECT * FROM pet_profile LEFT JOIN diagnosis_records ON diagnosis_records.pet_id = pet_profile.pet_id WHERE diagnosis_records.id = '$diagnosis' AND pet_profile.pet_id = '$id' AND pet_profile.archive_status = '0'";
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