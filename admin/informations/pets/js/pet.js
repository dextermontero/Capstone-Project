$(document).ready(function() {
	$('#info_pet tbody').on('click', '.archive-pet', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Pet',
			html: "Are you sure you want to archive this pet information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_pet.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Pet",
							icon : "success",
							html: "Successfully archive pet information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Pet",
							icon : "error",
							html: "Failed archive pet information",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Pet",
							icon : "warning",
							text: "Something wrong in archive pet information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Pet",
					icon : "info",
					html: "Cancelling archive pet information",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});		
	});
});