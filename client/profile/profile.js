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
							html: "Information successfully changed.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Change Profile",
							icon : "error",
							html: "Information failed changed.",
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
							html: "Password successfully changed.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});									
					}else if(data == "failed"){
						Swal.fire({
							title : "Change Password",
							icon : "error",
							html: "Password failed changed.",
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

// ADD PET
$(document).ready(function() {
	$('#add_pet').click(function(e) {
		e.preventDefault();
		var name = $('#pet_name').val();
		var type = $('#pet_type').val();
		var breed = $('#pet_breed').val();
		var date = $('#pet_birthday').val();
		if(name != '' && type != null && breed != '' && date != ''){
			$.post('add_pet.php', {name : name, type : type, breed : breed, date : date})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Add Pet",
						icon : "success",
						html: "Successfully added your pet's information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else{
					Swal.fire({
						title : "Add Pet",
						icon : "error",
						html: "Failed added your pet's information.",
						timer: 3000,
						showConfirmButton:false							
					});	
				}
			});
		}else{
			Swal.fire({
				title : "Add Pet",
				icon : "info",
				html: "<b>Invalid! </b>Fill out all fields pet information.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
		
	});
});

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

// DELETE COOKIES
$(window).on('beforeunload', function(e) {
	$.removeCookie("edit-profile");
});

$(document).ready(function(){
	$('.cancel-edit').click(function(e){
		e.preventDefault();
		$.removeCookie("edit-profile");
		location.reload();
	});
});

// EDIT PROFILE
$(document).ready(function() {
	$('.edit-info').click(function(e){
		e.preventDefault();
		location.reload();
		$.cookie("edit-profile", "edit-profile");
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
						html: "Information successfully changed.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else{
					Swal.fire({
						title : "Save Information",
						icon : "error",
						html: "Information failed changed.",
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

$(document).ready(function() {
	$('#firstname').keydown(function (e) {
		if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
			return false;
		}
	});	
	$('#middlename').keydown(function (e) {
		if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
			return false;
		}
	});
	$('#lastname').keydown(function (e) {
		if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
			return false;
		}
	});
	$('#email').change(function(e) {
		if(validateEmail(this.value)){
			document.getElementById('err_email').innerHTML = "<span class='text-success'></span>";
			document.getElementById("email").style.color  = "green";
		}else{
			document.getElementById('err_email').innerHTML = "<span class='text-danger'>Email Address is invalid</span>";
			document.getElementById("email").style.color  = "red";
		}
	});
	$('#place_birth').keydown(function (e) {
		if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
			return false;
		}
	});	
	const isNumericInput = (event) => {
		const key = event.keyCode;
		return ((key >= 48 && key <= 57) || // Allow number line
			(key >= 96 && key <= 105) // Allow number pad
		);
	};

	const isModifierKey = (event) => {
		const key = event.keyCode;
		return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
			(key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
			(key > 36 && key < 41) || // Allow left, up, right, down
			(
				// Allow Ctrl/Command + A,C,V,X,Z
				(event.ctrlKey === true || event.metaKey === true) &&
				(key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
			)
	};
	
	$('#contact_number').keydown(function(e) {
		if(!isNumericInput(event) && !isModifierKey(event)){
			event.preventDefault();
		}
	});				
	function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test(email );
	}				
});