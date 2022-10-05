$(document).ready(function() {
	$('#prescription tbody').on('click', '.recover-blog', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_blogs.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Blog",
					icon : "success",
					html: "<strong>Success! </strong>recover blog post.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Blog",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover blog post.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});
$(document).ready(function() {
	$('#prescription tbody').on('click', '.delete-blog', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Delete Blog',			html: "<b>Are you sure?</b> you want to delete this blog?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_blogs.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Delete Blog",							icon : "success",							html: "<strong>Success! </strong>delete blog post.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Delete Blog",							icon : "warning",							html: "<strong>WARNING! </strong>Something wrong in delete blog post.",							timer: 3000,							showConfirmButton:false													});												}				});			}else {				Swal.fire({					title : "Delete Blog",					icon : "error",					html: "<b>Failed!</b> delete blog",					timer: 3000,					showConfirmButton:false											}).then(function() {					location.reload();				});									}		});		
	});
});