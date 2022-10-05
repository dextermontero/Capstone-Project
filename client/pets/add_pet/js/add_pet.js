$(document).ready(function() {
	$('#add_pet').click(function(e) {
		e.preventDefault();
		$('#add_pet').attr('disabled', 'disabled');
		var file_data = $('#prevIMG').prop('files')[0];
		var form_data = new FormData();	
		var pet_name = $('#pet_name').val();
		var pet_type = $('#pet_type').val();
		var pet_breed = $('#pet_breed').val();
		var pet_birthdate = $('#pet_birthdate').val();
		form_data.append('file', file_data);
		form_data.append('pet_name', pet_name);
		form_data.append('pet_type', pet_type);
		form_data.append('pet_breed', pet_breed);
		form_data.append('pet_birthdate', pet_birthdate);
		if(file_data != null && pet_type != null && pet_name != '' && pet_breed != ''){
			$.ajax({
				url : 'add_pet.php',
				method : "POST",
				dataType : "text",
				cache : false,
				contentType : false,
				processData : false,
				data : form_data,
				success : function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Success",
							icon : "success",
							html: "You have successfully added your pet's information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							window.location = "../"
						});									
					}else{
						Swal.fire({
							title : "Failed",
							icon : "error",
							text: "Something wrong in add pet's information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							$('#add_pet').removeAttr('disabled', 'disabled');
						});
					}
				}
			});
		}else{
			Swal.fire({
				title : "Try Again",
				icon : "info",
				html: "Please complete all required fields or upload a photo of your pet.",
				timer: 5000,
				showConfirmButton:false							
			}).then(function() {
			  $('#add_pet').removeAttr('disabled', 'disabled');
			});
		}
	});
});

prevIMG.onchange = evt => {
	const[file] = prevIMG.files
	if(file) {
		viewIMG.src = URL.createObjectURL(file);
	}
}
$(document).ready(function() {
	$('#pet_name').keydown(function (e) {
		if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
			return false;
		}
	});	
	$('#pet_breed').keydown(function (e) {
		if (!((e.keyCode == 8) || (e.keyCode == 32) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 190)) {
			return false;
		}
	});				
});

$(function(){
	var dtToday = new Date();
	var month = dtToday.getMonth() + 1;
	var day = dtToday.getDate();
	var year = dtToday.getFullYear();
	if(month < 10)
		month = '0' + month.toString();
	if(day < 10)
		day = '0' + day.toString();
	var maxDate = year + '-' + month + '-' + day;
	$('#pet_birthdate').attr('max', maxDate);
});