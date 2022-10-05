$(document).ready(function() {
	$('#info_client tbody').on('click', '.archive-owner', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Pet Owner',
			html: "Are you sure you want to archive this pet owner information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_owners.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Pet Owner",
							icon : "success",
							html: "Successfully archive pet owner information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Pet Owner",
							icon : "error",
							html: "Failed archive pet owner information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Pet Owner",
							icon : "warning",
							text: "Something wrong in archive pet owner information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Pet Owner",
					icon : "info",
					html: "Cancelling archive pet owner information",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});		
	});
});