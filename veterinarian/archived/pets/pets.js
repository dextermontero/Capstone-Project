$(document).ready(function() {
	$('#prescription tbody').on('click', '.recover-pet', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_pets.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet",
					icon : "success",
					html: "<strong>Success! </strong>recover pet.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Pet",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover pet.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});	

$(document).ready(function() {
	$('#prescription tbody').on('click', '.delete-pet', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Delete Pet',			html: "<b>Are you sure?</b> you want to delete this pet?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_pets.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Pet",							icon : "success",							html: "<strong>Success! </strong>delete pet.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Pet",							icon : "warning",							html: "<strong>WARNING! </strong>Something wrong in delete pet.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Delete Pet",					icon : "error",					html: "<b>Failed!</b> Delete pet",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});		

	});
});	