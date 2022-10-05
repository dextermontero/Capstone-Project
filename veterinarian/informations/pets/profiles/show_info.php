<?php
require_once("../../../../include/initialize.php");
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}
?>
<?php
	$sql = "SELECT * FROM pet_profile WHERE pet_id = '$id'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
?>
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Pet Name</h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
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
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Pet Owner</h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
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
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Breed</h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
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
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Weight </h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
			<?php
				if($row['pet_weight'] == null || $row['pet_weight'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo ucfirst($row['pet_weight']); ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Birthdate </h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
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
		<div class="col-sm-3">
			<h6 class="mb-0">Vaccination </h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
			<?php
				if($row['pet_vaccination'] == null || $row['pet_vaccination'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo $row['pet_vaccination']; ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Blood Type </h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
			<?php
				if($row['pet_blood_type'] == null || $row['pet_blood_type'] == ""){
			?>
				<i>Not Set</i>
			<?php
				}else{
			?>
				<?php echo $row['pet_blood_type']; ?>
			<?php
				}
			?>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-3">
			<h6 class="mb-0">Medical Status </h6>
		</div>
		<div class="col-sm-9 text-secondary font-weight-bold">
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