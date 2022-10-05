// VIEW PROFILE
$(document).ready(function() {
	$('.change-profile-view').click(function(e) {
		var id = $(this).attr('id');
		$.ajax({
			url : "change_profile.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view-change-profile').html(data);
			}
		});
	});
});
// CHANGE PROFILE
$(document).ready(function() {
	$('#change_profile').click(function(e) {
		e.preventDefault();
		var id = $('#edit_profile').html();				
		var file_data = $('#preveditIMG').prop('files')[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		form_data.append('id', id);
		if(file_data != null){
			$.ajax({
				url : "update_photo.php",
				method : "POST",
				dataType : "text",
				cache : false,
				contentType : false,
				processData : false,
				data : form_data,
				success : function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Change Pet Profile",
							icon : "success",
							html: "Successfully edited your pet's information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Change Pet Profile",
							icon : "error",
							html: "Failed edited your pet's information.",
							timer: 3000,
							showConfirmButton:false							
						});						
					}else {
						Swal.fire({
							title : "Change Pet Profile",
							icon : "warning",
							html: "<strong>Invalid! </strong>Invalid Image Format JPG, JPEG, PNG Only.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				}
			});						
		}else{
			Swal.fire({
				title : "Change Profile",
				icon : "info",
				html: "<b>Invalid! </b>Select photo to change profile.",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});	
});
// EDIT PET INFO
$(document).ready(function() {
	$('#c_pet_name').click(function(e) {
		e.preventDefault();
		$('#hide_petname').attr("hidden", "hidden");
		$('#change_petname').removeAttr("hidden", "hidden");
	});
	$('#c_pet_breed').click(function(e) {
		e.preventDefault();
		$('#hide_petbreed').attr("hidden", "hidden");
		$('#change_petbreed').removeAttr("hidden", "hidden");
	});
});
// CANCEL EDIT PET INFO
$(document).ready(function() {
	$('#cancel-petname').click(function(e) {
		e.preventDefault();
		$('#hide_petname').removeAttr("hidden", "hidden");
		$('#change_petname').attr("hidden", "hidden");
	});	
	$('#cancel-petbreed').click(function(e) {
		e.preventDefault();
		$('#hide_petbreed').removeAttr("hidden", "hidden");
		$('#change_petbreed').attr("hidden", "hidden");
	});
});
// SAVE NEW PET NAME
$(document).ready(function() {
	$('#save-petname').click(function(e) {
		e.preventDefault();
		var id = $('#pet_id_name').html();
		var petname = $('#new_petname').val();
		$('#save-petname').attr("disabled", "disabled");
		$('#cancel-petname').attr("disabled", "disabled");
		if(petname != ''){
			$.post("save_petname.php", {id:id, petname : petname})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Change Pet Name",
						icon : "success",
						html: "Successfully edited your pet's information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});								
				}else{
					Swal.fire({
						title : "Change Pet Name",
						icon : "error",
						html: "Failed edited your pet's information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#save-petname').removeAttr("disabled", "disabled");
						$('#cancel-petname').removeAttr("disabled", "disabled");
					});
				}							
			});
		}else{
			document.getElementById("error").innerHTML = "Please input pet name.";
			$('#save-petname').removeAttr("disabled", "disabled");
			$('#cancel-petname').removeAttr("disabled", "disabled");						
		}
	});
});
// SAVE NEW PET BREED
$(document).ready(function() {
	$('#save-petbreed').click(function(e) {
		e.preventDefault();
		var id = $('#pet_id_breed').html();
		var petbreed = $('#new_petbreed').val();
		$('#save-petbreed').attr("disabled", "disabled");
		$('#cancel-petbreed').attr("disabled", "disabled");
		if(petbreed != ''){
			$.post("save_petbreed.php", {id:id, petbreed : petbreed})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Change Pet Breed",
						icon : "success",
						html: "Successfully edited your pet's information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});																	
				}else{
					Swal.fire({
						title : "Change Pet Breed",
						icon : "error",
						html: "Failed edited your pet's information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#save-petbreed').removeAttr("disabled", "disabled");
						$('#cancel-petbreed').removeAttr("disabled", "disabled");
					});
				}
			});
		}else{
			document.getElementById("error1").innerHTML = "Please input pet breed.";
			$('#save-petbreed').removeAttr("disabled", "disabled");
			$('#cancel-petbreed').removeAttr("disabled", "disabled");						
		}
	});
});