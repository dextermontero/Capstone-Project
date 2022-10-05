$(document).ready(function() {
	$('.archive-prescription').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Prescription',
			html: "<b>Are you sure?</b> you want to archive this prescription information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_prescription.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Prescription",
							icon : "success",
							html: "Successfully archive prescription information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Prescription",
							icon : "error",
							html: "Failed archive prescription information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Prescription",
							icon : "warning",
							text: "Something wrong in archive prescription information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Prescription",
					icon : "info",
					html: "Cancelling archive prescription information.",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});		
	});
});function readURL(input) {	if (input.files && input.files[0]) {		var reader = new FileReader();		reader.onload = function(e) {			$('.image-upload-wrap').hide();			$('.file-upload-image').attr('src', e.target.result);			$('.file-upload-content').show();			$('.image-title').html(input.files[0].name);		};		reader.readAsDataURL(input.files[0]);	} else {		removeUpload();	}}function removeUpload() {	$('.file-upload-input').replaceWith('<input class="file-upload-input" type="file" id="fileUpload" name="fileUpload" onchange="readURL(this);" accept="image/*" />');	$('.file-upload-content').hide();	$('.image-upload-wrap').show();}$('.image-upload-wrap').bind('dragover', function () {	$('.image-upload-wrap').addClass('image-dropping');});$('.image-upload-wrap').bind('dragleave', function () {	$('.image-upload-wrap').removeClass('image-dropping');});
$(document).ready(function() {	$('#upload_prescription').click(function(e) {		e.preventDefault();		var file_data = $('#fileUpload').prop('files')[0];		var form_data = new FormData();		var pet_id = $('#pet_id').html();		var prescription_name = $('#presname').val();		form_data.append("file",file_data);			form_data.append("pet_id", pet_id);		form_data.append("pres_name", prescription_name);		if(file_data != null && prescription_name != ''){			$.ajax({				url : "upload_prescription.php",				method : "POST",				dataType : 'text',				cache : false,				contentType : false,				processData : false,				data : form_data,				success : function(data) {					if(data == "success") {						Swal.fire({							title : "Upload Prescription",							icon : "success",							html: "Successfully upload prescription file.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});					}else if(data == "failed") {						Swal.fire({							title : "Upload Prescription",							icon : "error",							html: "Failed upload prescription file.",							timer: 3000,							showConfirmButton:false						});					}else {						Swal.fire({							title : "Upload Prescription",							icon : "warning",							text: "Something wrong in upload prescription file.",							timer: 3000,							showConfirmButton:false													});					}				}										});		}else {			Swal.fire({				title : "Upload Prescription",				icon : "info",				text: "Upload prescription name and file cannot be empty! Please try again.",				timer: 3000,				showConfirmButton:false			});								}	});});