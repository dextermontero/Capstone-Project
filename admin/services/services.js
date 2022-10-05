$(document).ready(function() {
	$('#add-service-close').click(function() {
		location.reload();
	});	
	$('#edit-service-close').click(function() {
		location.reload();
	});	
});	
prevIMG.onchange = evt => {
	const[file] = prevIMG.files
	if(file) {
		viewIMG.src = URL.createObjectURL(file);
	}
}
$('#service_cost').keypress(function(e) {
	$(this).val($(this).val().replace(/[^\d].+/, ""));
	if ((event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
});

window.onload = () => {
	const myInput = document.getElementById("service_cost");
	myInput.onpaste = e => e.preventDefault();
}
//
$(document).ready(function() {
	$('.view-service').click(function(e) {
		var sid = $(this).attr('id');
		$.ajax({
			url : "view_services.php",
			method : "POST",
			data : {sid : sid},
			success:function(data){
				$('#view-service-modal').html(data);
			}
		});
	});
});
// Delete Services
$(document).ready(function() {
	$('.delete-service').click(function(e) {
		e.preventDefault();
		var sid = $(this).attr('id');
		Swal.fire({
			title: 'Delete Service',
			html: "<b>Are you sure?</b> you want to delete this service?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete_services.php", {sid : sid})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Delete Service",
							icon : "success",
							html: "<strong>Success! </strong>Deleting service.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Delete Service",
							icon : "error",
							html: "<b>Failed!</b> Deleting service",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Delete Service",
							icon : "warning",
							text: "Something wrong in deleting service.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Delete Service",
					icon : "error",
					html: "<b>Failed!</b> Deleting service",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});		
	});
});
// Update Services
$(document).ready(function() {
	$('#edit_service').click(function(e) {
		e.preventDefault();
		var file_data = $('#preveditIMG').prop('files')[0];
		var form_data = new FormData();
		var sid = $('#edit_service_id').html();
		var s_title = $('#service_title_edit').val();
		var s_description = $('#service_description_edit').val();
		var s_cost = $('#service_cost_edit').val();
		var branch = $('#branches').val();
		form_data.append('file', file_data);
		form_data.append('sid', sid);
		form_data.append('title', s_title);
		form_data.append('description', s_description);
		form_data.append('cost', s_cost);
		form_data.append('branch', branch);
		if(file_data != null && s_title != "" && s_description != "" && s_cost != "" && sid != "" && branch != null){
			$.ajax({
				url : "update_services.php",
				method : "POST",
				dataType : "text",
				cache : false,
				contentType : false,
				processData : false,
				data : form_data,
				success : function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Update Services",
							icon : "success",
							html: "<strong>Success! </strong>Updating services.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Update Service",
							icon : "error",
							html: "<b>Failed!</b> updating service",
							timer: 3000,
							showConfirmButton:false							
						});			
					}else {
						Swal.fire({
							title : "Update Services",
							icon : "success",
							html: "<strong>Success! </strong>Updating services.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}
				}
			});
		}else {
			$.post("update_service_nopic.php", {sid : sid, s_title : s_title, s_description : s_description, s_cost : s_cost, branch : branch})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Services",
						icon : "success",
						html: "<strong>Success! </strong>Updating services.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else{
					Swal.fire({
						title : "Update Service",
						icon : "error",
						text: "Something wrong in Updating services.",
						timer: 3000,
						showConfirmButton:false							
					});
				}				
			});
		}
	});
});
// Add Services
$(document).ready(function() {
	$('#add_service').click(function(e) {
		e.preventDefault();
		var file_data = $('#prevIMG').prop('files')[0];
		var form_data = new FormData();					
		var s_title = $('#service_title').val();
		var s_description = $('#service_description').val();
		var s_cost = $('#service_cost').val();
		var branch = $('#branches').val();
		form_data.append('file', file_data);
		form_data.append('title', s_title);
		form_data.append('description', s_description);
		form_data.append('cost', s_cost);
		form_data.append('branch', branch);
		if(file_data != null && s_title != "" && s_description != "" && s_cost != "" && branch != null){
			$.ajax({
				url : 'add_services.php',
				method : "POST",
				dataType : "text",
				cache : false,
				contentType : false,
				processData : false,
				data : form_data,
				success : function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Add Services",
							icon : "success",
							html: "<strong>Success! </strong>Adding services.",
							timer: 3000,
							showConfirmButton:false
						}).then(function() {
							location.reload();
						});
					}else {
						Swal.fire({
							title : "Add Service",
							icon : "error",
							text: "Something wrong in add services.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				}
			});
		}else {
			Swal.fire({
				title : "Add Service",
				icon : "info",
				html: "<b>Invalid! </b>add service photo and fill out all fields.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});
});
$(document).ready(function() {
	$('.recover-service').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_services.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Service",
					icon : "success",
					html: "<strong>Success! </strong>recover service.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Service",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover service.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});	
$(document).ready(function() {
	$('.delete-service').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("delete_services.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Delete Service",
					icon : "success",
					html: "<strong>Success! </strong>delete service.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Delete Service",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in delete service.",
					timer: 3000,
					showConfirmButton:false							
				});
			}
		});
	});
});$(document).ready(function() {	$('#approve_request').click(function(e) {		e.preventDefault();		var id = $('#request_id').html();		var title = $('#request_title').val();		$.post("approve_request.php", {id : id, title : title})		.done(function(data) {			if(data == "success"){				Swal.fire({					title : "Approve Request",					icon : "success",					html: "<strong>Success! </strong>approve request service.",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});			}else {				Swal.fire({					title : "Approve Request",					icon : "error",					html: "<b>Failed!</b> approve request service",					timer: 3000,					showConfirmButton:false											});			}		});	});});$(document).ready(function() {	$('.view_request').click(function(e) {		e.preventDefault();		var id = $(this).attr('id');		$.ajax({			url : "view_request.php",			method : "POST",			data : {id : id},			success:function(data){				$('#view_request_modal').html(data);			}		});	});});$(document).ready(function() {	$('.request-archive').click(function(e) {		e.preventDefault();		var id = $(this).attr('id');		Swal.fire({			title: 'Archive Request Service',			html: "<b>Are you sure?</b> you want to archive this request service?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("archive_services.php", {id : id})				.done(function(data) {					if(data == "success"){						Swal.fire({							title : "Archive Request Service",							icon : "success",							html: "<strong>Success! </strong>archive request service.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});					}else if(data == "failed"){						Swal.fire({							title : "Archive Request Service",							icon : "error",							html: "<b>Failed!</b> archive request service",							timer: 3000,							showConfirmButton:false													});					}else {						Swal.fire({							title : "Archive Request Service",							icon : "warning",							text: "Something wrong in archive request service.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Archive Request Service",					icon : "error",					html: "<b>Failed!</b> archive request service",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});						});});$(document).ready(function() {	$('.archive-service').click(function(e) {		e.preventDefault();		var id = $(this).attr('id');		Swal.fire({			title: 'Archive Service',			html: "<b>Are you sure?</b> you want to archive this service?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("archive_services.php", {id : id})				.done(function(data) {					if(data == "success"){						Swal.fire({							title : "Archive Service",							icon : "success",							html: "<strong>Success! </strong>archive service.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});					}else if(data == "failed"){						Swal.fire({							title : "Archive Service",							icon : "error",							html: "<b>Failed!</b> archive service",							timer: 3000,							showConfirmButton:false													});					}else {						Swal.fire({							title : "Archive Service",							icon : "warning",							text: "Something wrong in archive service.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Archive Service",					icon : "error",					html: "<b>Failed!</b> archive service",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});						});});	