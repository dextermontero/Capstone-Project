$(document).ready(function() {
	$('.recover-pet').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_pets.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet",
					icon : "success",
					html: "Successfully Recovered pet information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Pet",
					icon : "warning",
					html: "Something wrong in recover pet information.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});	
$(document).ready(function() {
	$('.delete-pet').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Delete Pet',			html: "Are you sure you want to delete this pet information?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_pets.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Pet",							icon : "success",							html: "Successfully deleted pet information.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Pet",							icon : "warning",							html: ">Something wrong in delete pet information.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Delete Pet",					icon : "error",					html: "Cancelling delete pet information",					timer: 3000,					showConfirmButton:false											});									}		});		
	});
});	