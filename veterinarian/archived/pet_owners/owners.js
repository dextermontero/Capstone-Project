$(document).ready(function() {
	$('#prescription tbody').on('click', '.recover-owner', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_owners.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "success",
					html: "<strong>Success! </strong>recover pet owner.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});													
			}else{
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover pet owner.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});
$(document).ready(function() {
	$('#prescription tbody').on('click', '.delete-owner', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({			title: 'Delete Pet Owner',			html: "<b>Are you sure?</b> you want to delete this pet owner?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_owners.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Pet Owner",							icon : "success",							html: "<strong>Success! </strong>delete pet owner.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Pet Owner",							icon : "warning",							html: "<strong>WARNING! </strong>Something wrong in delete pet owner.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Delete Pet Owner",					icon : "error",					html: "<b>Failed!</b> delete pet owner",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});
	});
});