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
					html: "Successfully Recovered service information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Service",
					icon : "warning",
					html: "Failed Recovered service information.",
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
		var id = $(this).attr('id');		Swal.fire({			title: 'Delete Service',			html: "Are you sure you want to delete this service information?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_services.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Service",							icon : "success",							html: "Successfully deleted service information.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Service",							icon : "warning",							html: "Failed deleted service information.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Delete service",					icon : "error",					html: "Cancelling delete service information.",					timer: 3000,					showConfirmButton:false											});									}		});
	});
});