$(document).ready(function() {
	$('#archive_reviews tbody').on('click', '.delete-pet', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Pet',
			html: "Are you sure you want to delete this pet information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete.php", {id:id})
				.done(function(data){
					if(data == "success"){
						Swal.fire({
							title : "Delete Pet",
							icon : "success",
							html: "Successfully delete your pet's information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Delete Pet",
							icon : "warning",
							html: "Something wrong in delete pet's information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {					
			}
		});
	});
	// RECOVER PET
	$('#archive_reviews tbody').on('click', '.recover-pet', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet",
					icon : "success",
					html: "Successfully recover your pet's information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Pet",
					icon : "warning",
					html: "Something wrong in recover pet's information",
					timer: 3000,
					showConfirmButton:false							
				});
			}
		});
	});
});