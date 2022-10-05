$(document).ready(function() {
	$('#archive_reviews tbody').on('click', '.delete-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Review',
			html: "Are you sure you want to delete this review information?",
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
							title : "Delete Review",
							icon : "success",
							html: "Successfully delete your review information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Delete Review",
							icon : "warning",
							html: "Something wrong in delete review information.",
							timer: 3000,
							showConfirmButton:false							
						});							
					}
				});
			}else {					
			}
		});
	});
	// RECOVER REVIEW
	$('#archive_reviews tbody').on('click', '.recover-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Review",
					icon : "success",
					html: "Successfully recover your review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Review",
					icon : "warning",
					html: "Something wrong in recover review information.",
					timer: 3000,
					showConfirmButton:false							
				});
			}
		});
	});
});