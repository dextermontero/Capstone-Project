// Vet Deletion
$(document).ready(function() {
	$('#veterinarian tbody').on('click', '.delete-vet', function (e) {
		e.preventDefault();
		var vet_id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Veterinarian',
			html: "<b>Are you sure?</b> you want to delete this veterinarian?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete_vet.php", {vet_id : vet_id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Delete Veterinarian",
							icon : "success",
							html: "Successfully deleted veterinarian information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Delete Veterinarian",
							icon : "error",
							html: "Failed delete veterinarian information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Delete Veterinarian",
							icon : "warning",
							text: "Something wrong in deleting veterinarian information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Delete Veterinarian",
					icon : "info",
					html: "Cancelling delete veterinarian information.",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});	
	});
});