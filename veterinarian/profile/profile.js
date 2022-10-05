// CHANGE PROFILE
$(document).ready(function() {
	$('#change_profile').click(function(e) {
		e.preventDefault();
		var file_data = $('#preveditIMG').prop('files')[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
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
							title : "Change Profile",
							icon : "success",
							html: "<strong>Success! </strong>Change Profile.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Change Profile",
							icon : "error",
							html: "<b>Failed! </b>Change Profile",
							timer: 3000,
							showConfirmButton:false							
						});						
					}else {
						Swal.fire({
							title : "Change Profile",
							icon : "warning",
							html: "<strong>Invalid! </strong>Invalid Image Format JPG, JPEG, PNG Only.",
							timer: 3000,
							showConfirmButton:false							
						});
						alert(data);
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

// SAVE EDIT INFO
$(document).ready(function() {
	$('#save-changes').click(function(e) {
		e.preventDefault();
		var firstname = $('#firstname').val();
		var middlename = $('#middlename').val();
		var lastname = $('#lastname').val();
		var email = $('#email').val();
		var address = $('#address').val();
		var place_birth = $('#place_birth').val();
		var gender = $('#gender').val();
		var birthday = $('#birthday').val();
		var phone = $('#contact_number').val();
		if(firstname != '' && lastname != '' && email != '' && gender != null && birthday != '' && phone != ''){
			$.post("update_data.php", {firstname : firstname, middlename : middlename, lastname : lastname, email : email, address : address, place_birth : place_birth, gender : gender, birthday : birthday, phone : phone})
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
					alert(data);
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
});
// CHANGE PASSWORD
$(document).ready(function() {
	$('#password').click(function(e) {
		e.preventDefault();
		$('#hidepass').attr("hidden", "hidden");
		$('#changepass').removeAttr("hidden", "hidden");
	});	
	$('#cancel-pass').click(function(e) {
		e.preventDefault();
		$('#hidepass').removeAttr("hidden", "hidden");
		$('#changepass').attr("hidden", "hidden");
	});				
});
// NEW PASSWORD
$(document).ready(function() {
	$('#save-pass').click(function(e) {
		e.preventDefault();
		var current = $('#current_pass').val();
		var newpass = $('#new_pass').val();
		var confirmpass = $('#confirm_pass').val();
		$('#save-pass').attr("disabled", "disabled");
		$('#cancel-pass').attr("disabled", "disabled");
		if(current != '' && newpass != '' && confirmpass != ''){
			if(newpass == confirmpass){
				$.post("save_password.php", {current : current, newpass : newpass, confirmpass : confirmpass})
				.done(function(data) {
					if(data == "success"){
						document.getElementById("error").innerHTML = "";
						Swal.fire({
							title : "Change Password",
							icon : "success",
							html: "<strong>Success! </strong>Change Password.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});									
					}else if(data == "failed"){
						Swal.fire({
							title : "Change Password",
							icon : "error",
							html: "<strong>Failed! </strong>Change Password.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							$('#save-pass').removeAttr("disabled", "disabled");
							$('#cancel-pass').removeAttr("disabled", "disabled");
						});									
					}else{
						document.getElementById("error").innerHTML = "Current Password do not match! Please input again.";
						$('#save-pass').removeAttr("disabled", "disabled");
						$('#cancel-pass').removeAttr("disabled", "disabled");
					}
				});
			}else{
				document.getElementById("error").innerHTML = "Password do not match! Please input again.";
				$('#save-pass').removeAttr("disabled", "disabled");
				$('#cancel-pass').removeAttr("disabled", "disabled");
			}
		}else{
			Swal.fire({
				title : "Change Password",
				icon : "info",
				html: "<b>Invalid! </b>Fill out all fields.",
				timer: 3000,
				showConfirmButton:false							
			}).then(function() {
				$('#save-pass').removeAttr("disabled", "disabled");
				$('#cancel-pass').removeAttr("disabled", "disabled");
			});							
		}
	});
});
// EDIT PROFILE
$(document).ready(function() {
  $('.edit-info').click(function(e){
    e.preventDefault();
    location.reload();
    $.cookie("edit-profile-vet", "edit-profile-vet");
  });
});
// CANCEL EDIT
$(document).ready(function(){
  $('.cancel-edit').click(function(e){
    e.preventDefault();
    $.removeCookie("edit-profile");
    location.reload();
  });
});		
// DELETE COOKIES
$(window).on('beforeunload', function(e) {
  $.removeCookie("edit-profile-vet");
});	