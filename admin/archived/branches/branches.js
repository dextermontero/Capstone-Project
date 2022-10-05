$(document).ready(function() {
	$('#branch tbody').on('click', '.recover-branch', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_branch.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Branch",
					icon : "success",
					html: "Successfully recovered branch information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Service",
					icon : "warning",
					html: "Something wrong in recover branch information.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});	
$(document).ready(function() {
	$('#branch tbody').on('click', '.delete-branch', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');		Swal.fire({			title: 'Branch Delete',			html: "Are you sure you want to delete this branch information?",			icon: 'info',			showCancelButton: true,			confirmButtonColor: '#3085d6',			cancelButtonColor: '#d33',			cancelButtonText: 'No',			confirmButtonText: 'Yes'		}).then((result) => {			if (result.isConfirmed) {				$.post("delete_branch.php", {id:id})				.done(function(data){					if(data == "success"){						Swal.fire({							title : "Branch Delete",							icon : "success",							html: "Successfully deleted branch information.",							timer: 3000,							showConfirmButton:false													}).then(function() {							location.reload();						});																			}else{						Swal.fire({							title : "Branch Delete",							icon : "warning",							html: "Something wrong in delete branch information.",							timer: 3000,							showConfirmButton:false													});					}				});			}else {				Swal.fire({					title : "Branch Delete",					icon : "info",					html: "Cancelling delete branch information",					timer: 3000,					showConfirmButton:false											});									}		});
	});
});