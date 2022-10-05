// EDIT PROFILE
$(document).ready(function() {
	$('.edit-info').click(function(e){
		e.preventDefault();
		location.reload();
		$.cookie("edit-pet", "edit-pet");
	});
});
// CANCEL EDIT
$(document).ready(function(){
	$('.cancel-edit').click(function(e){
		e.preventDefault();
		$.removeCookie("edit-pet");
		location.reload();
	});
});
// DELETE COOKIES
$(window).on('beforeunload', function(e) {	$.removeCookie("edit-diagnosis");
	$.removeCookie("edit-pet");
});
// SAVE EDIT INFO
$(document).ready(function() {
	$('#save-changes').click(function(e) {
		e.preventDefault();
		var pet_id = $('#pet_id').html();
		var pet_breed = $('#pet_breed').val();
		var pet_weight = $('#pet_weight').val();
		var birthdate = $('#birthdate').val();
		var pet_vaccination = $('#pet_vaccination').val();
		var pet_blood_type = $('#pet_blood_type').val();
		var pet_medical_status = $('#pet_medical_status').val();
		if(pet_breed != '' && pet_weight != '' && birthdate != ''){
			$.post("update_data.php", {pet_id : pet_id, pet_breed : pet_breed, pet_weight : pet_weight, birthdate : birthdate, pet_vaccination : pet_vaccination, pet_blood_type : pet_blood_type, pet_medical_status : pet_medical_status})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Save Information",
						icon : "success",
						html: "<strong>Success! </strong>to change information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else{
					Swal.fire({
						title : "Save Information",
						icon : "error",
						html: "<strong>Failed! </strong>to change information.",
						timer: 3000,
						showConfirmButton:false							
					});
				}							
			});
		}else{
			Swal.fire({
				title : "Save Information",
				icon : "info",
				html: "<b>Invalid! </b>Fill out all fields basic information.",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});
});// UPDATE DIAGNOSIS
$(document).ready(function() {
	$('#save-changes-diagnosis').click(function(e) {
		e.preventDefault();
		var diagnoseID = $('#diagnoseID_update').val();
		var date_service = $('#date_service_update').val();
		var diagnosis = $('#diagnosis_update').val();
		var notes = $('#addnotes_update').val();
		$('#save-changes-diagnosis').attr('disabled', 'disabled');
		if(date_service != '' && diagnosis != ''){
			$.post("update_diagnosis.php", {diagnoseID:diagnoseID, date_service:date_service, diagnosis:diagnosis, notes:notes})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Medical Diagnosis",
						icon : "success",
						html: "Successfully update medical diagnosis information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else if(data == "failed"){
					Swal.fire({
						title : "Medical Diagnosis",
						icon : "error",
						html: "Failed to update medical diagnosis information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#save-changes-diagnosis').removeAttr('disabled', 'disabled');
					});	
				}else{
					Swal.fire({
						title : "Medical Diagnosis",
						icon : "warning",
						text: "Something wrong in update medical diagnosis information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#save-changes-diagnosis').removeAttr('disabled', 'disabled');
					});								
				}
			});
		}else{
			Swal.fire({
				title : "Medical Diagnosis",
				icon : "info",
				html: "Medical Diagnosis Form cannot be empty the required fields.",
				timer: 3000,
				showConfirmButton:false
			}).then(function() {
				$('#save-changes-diagnosis').removeAttr('disabled', 'disabled');
			});	
		}
	});
});
//INSERT DIAGNOSIS
$(document).ready(function() {
	$('#send_diagnose').click(function(e) {
		e.preventDefault();
		var petid = $('#petid_diagnose').val();
		var userid = $('#userid_diagnose').val();
		var date = $('#date_service').val();
		var diagnose = $('#diagnosis').val();
		var addnotes = $('#addnotes').val();
		$('#send_diagnose').attr('disabled', 'disabled');
		if(date != '' && diagnose != ''){
			$.post("add_diagnosis.php", {petid:petid, userid:userid, date:date, diagnose:diagnose, addnotes:addnotes})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Medical Diagnosis",
						icon : "success",
						html: "Successfully add medical diagnosis information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						window.location = "./profile.php?pet_id="+petid;
					});
				}else if(data == "failed"){
					Swal.fire({
						title : "Medical Diagnosis",
						icon : "error",
						html: "Failed to add medical diagnosis information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#send_diagnose').removeAttr('disabled', 'disabled');
					});	
				}else{
					Swal.fire({
						title : "Medical Diagnosis",
						icon : "warning",
						text: "Something wrong in add medical diagnosis information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#send_diagnose').removeAttr('disabled', 'disabled');
					});								
				}
			});
		}else {
			Swal.fire({
				title : "Medical Diagnosis",
				icon : "info",
				html: "Medical Diagnosis Form cannot be empty the required fields.",
				timer: 3000,
				showConfirmButton:false
			}).then(function() {
				$('#send_diagnose').removeAttr('disabled', 'disabled');
			});							
		}
	});
});
// ENABLE EDIT
$(document).ready(function() {
	$('.edit-diagnosis').click(function(e){
		e.preventDefault();
		location.reload();
		$.cookie("edit-diagnosis", "edit-diagnosis");
	});
});
// CANCEL EDIT
$(document).ready(function(){
	$('.cancel-diagnosis').click(function(e){
		e.preventDefault();
		$.removeCookie("edit-diagnosis");
		location.reload();
	});
});
