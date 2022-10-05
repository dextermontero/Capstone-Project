$(document).ready(function() {
	$('#prescription tbody').on('click', '.recover-owner', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_owners.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "success",
					html: "<strong>Success! </strong>recover pet owner.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});													
			}else{
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in recover pet owner.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});
$(document).ready(function() {
	$('#prescription tbody').on('click', '.delete-owner', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
	});
});