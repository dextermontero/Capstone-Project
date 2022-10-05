$(document).ready(function() {
	$('.recover-owner').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_owners.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "success",
					html: "Successfully Recovered pet owner information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});												
			}else{
				Swal.fire({
					title : "Recover Pet Owner",
					icon : "warning",
					html: "Something wrong in recover pet owner information.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});
$(document).ready(function() {
	$('.delete-owner').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
	});
});