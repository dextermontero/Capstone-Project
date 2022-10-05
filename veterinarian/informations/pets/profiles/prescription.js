$(document).ready(function() {
	$('.archive-prescription').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Prescription',
			html: "<b>Are you sure?</b> you want to archive this prescription information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_prescription.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Prescription",
							icon : "success",
							html: "Successfully archive prescription information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Prescription",
							icon : "error",
							html: "Failed archive prescription information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Prescription",
							icon : "warning",
							text: "Something wrong in archive prescription information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Prescription",
					icon : "info",
					html: "Cancelling archive prescription information.",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});		
	});
});
$(document).ready(function() {