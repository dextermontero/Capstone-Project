$(document).ready(function() {
	$('#prescription tbody').on('click', '.recover-service', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_services.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Service",
					icon : "success",
					html: "<strong>Success! </strong>recover service.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Service",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover service.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});	

$(document).ready(function() {
	$('#prescription tbody').on('click', '.delete-service', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Service',
			html: "<b>Are you sure?</b> you want to delete this service?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete_services.php", {id:id})
				.done(function(data){
					if(data == "success"){
						Swal.fire({
							title : "Delete Service",
							icon : "success",
							html: "<strong>Success! </strong>delete service.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Delete Service",
							icon : "warning",
							html: "<strong>WARNING! </strong>Something wrong in delete service.",
							timer: 3000,
							showConfirmButton:false							
						});
						alert(data);
					}
				});
			}else {
				Swal.fire({
					title : "Delete Service",
					icon : "error",
					html: "<b>Failed!</b> delete service",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});
	});
});	