$(document).ready(function() {
	$('#pet_treatment tbody').on('click', '.recover-treatment', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_treatment.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet Treatment",
					icon : "success",
					html: "<strong>Success! </strong>recover pet treatment.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Pet Treatment",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover pet treatment.",
					timer: 3000,
					showConfirmButton:false							
				});					
			}
		});
	});
});
$(document).ready(function() {
	$('#pet_treatment tbody').on('click', '.delete-treatment', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Delete Pet Treatment',			html: "<b>Are you sure?</b> you want to delete this pet treatment?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_treatment.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Pet Treatment",							icon : "success",							html: "<strong>Success! </strong>delete pet treatment.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Pet Treatment",							icon : "warning",							html: "<strong>WARNING! </strong>Something wrong in delete pet treatment.",							timer: 3000,							showConfirmButton:false													});												}				});			}else {				Swal.fire({					title : "Delete Pet Treatment",					icon : "error",					html: "<b>Failed!</b> delete pet treatment",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});		
	});
});