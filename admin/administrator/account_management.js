// Admin Deletion
$(document).ready(function() {
	$('#administrator tbody').on('click', '.delete-admin', function (e) {
		e.preventDefault();
		var adm_id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Administrator',
			html: "<b>Are you sure?</b> you want to delete this administrator information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete_admin.php", {adm_id : adm_id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Delete Administrator",
							icon : "success",
							html: "Successfully deleted administrator information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Delete Administrator",
							icon : "error",
							html: "Failed deleted administrator information",
							timer: 3000,
							showConfirmButton:false							
						});
					}else if(data == "superadmin"){
						Swal.fire({
							title : "Delete Administrator",
							icon : "error",
							html: "Failed cannot delete this super administrator information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else if(data == "cannot"){
						Swal.fire({
							title : "Delete Administrator",
							icon : "error",
							html: "Failed cannot delete your own information.",
							timer: 3000,
							showConfirmButton:false							
						});		
					}else {
						Swal.fire({
							title : "Delete Administrator",
							icon : "warning",
							text: "Something wrong in deleting administrator.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Delete Administrator",
					icon : "info",
					html: "Cancelling delete administrator information.",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});
	});
});