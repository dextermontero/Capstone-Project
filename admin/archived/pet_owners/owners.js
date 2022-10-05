$(document).ready(function() {
	$('.recover-owner').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_owners.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "success",
					html: "Successfully Recovered pet owner information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});												
			}else{
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "warning",
					html: "Something wrong in recover pet owner information.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});
$(document).ready(function() {
	$('.delete-owner').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Delete Pet Owner',			html: "Are you sure you want to delete this pet owner information?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_owners.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Pet Owner",							icon : "success",							html: "Successfully deleted pet owner information.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Pet Owner",							icon : "warning",							html: ">Something wrong in delete pet owner information.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Delete Pet Owner",					icon : "info",					html: "Cancelling delete pet owner information",					timer: 3000,					showConfirmButton:false											});									}		});
	});
});