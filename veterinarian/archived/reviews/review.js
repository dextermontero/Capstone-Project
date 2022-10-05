$(document).ready(function() {
	$('#archive_reviews tbody').on('click', '.recover-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Review",
					icon : "success",
					html: "<strong>Success! </strong>recover review.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Review",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover review.",
					timer: 3000,
					showConfirmButton:false							
				});
				alert(data);
			}
		});
	});
});

$(document).ready(function() {
	$('#archive_reviews tbody').on('click', '.delete-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Review',
			html: "<b>Are you sure?</b> you want to delete this review?",
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
							html: "<strong>Success! </strong>delete review.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Delete Review",
							icon : "warning",
							html: "<strong>WARNING! </strong>Something wrong in delete review.",
							timer: 3000,
							showConfirmButton:false							
						});							
					}
				});
			}else {
				Swal.fire({
					title : "Delete Review",
					icon : "error",
					html: "<b>Failed!</b> delete review",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});		
	});
});