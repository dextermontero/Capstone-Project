$(document).ready(function() {
	$('.archive-pet').click(function(e) {
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
				$.post("archive.php", {id:id})
				.done(function(data){
					if(data == "success"){
						Swal.fire({
							title : "Archive Pet",
							icon : "success",
							html: "Successfully archive your pet's information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Archive Pet",
							icon : "warning",
							html: "Something wrong in archive pet's information.",
							timer: 3000,
							showConfirmButton:false							
						});							
					}
				});
			}else {				
			}
		});
	});
});

// Scheduled
$(function() {
	$('#pet').DataTable({
		"responsive" : true,
		"lengthChange" : true,
		"autoWidth" : false,
		"ordering" : false,
		"info" : true,
		"searching": true,
		"paging" : true
	});
});

// Scheduled
$(function() {
	$('#pet_1').DataTable({
		"responsive" : true,
		"lengthChange" : true,
		"autoWidth" : false,
		"ordering" : false,
		"info" : true,
		"searching": true,
		"paging" : true
	});
});