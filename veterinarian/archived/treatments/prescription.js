$(document).ready(function() {
	$('#prescription tbody').on('click', '.recover-prescription', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_prescription.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Prescription",
					icon : "success",
					html: "<strong>Success! </strong>recover prescription.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});											
			}else{
				Swal.fire({
					title : "Recover Prescription",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover prescription.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});
$(document).ready(function() {
	$('#prescription tbody').on('click', '.delete-prescription', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Archive Pet Prescription',			html: "<b>Are you sure?</b> you want to delete this pet prescription?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_prescription.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Prescription",							icon : "success",							html: "<strong>Success! </strong>delete prescription.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Prescription",							icon : "warning",							html: "<strong>WARNING! </strong>Something wrong in delete prescription.",							timer: 3000,							showConfirmButton:false													});												}				});			}else {				Swal.fire({					title : "Archive Pet Prescription",					icon : "error",					html: "<b>Failed!</b> delete pet prescription",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});		
	});
});