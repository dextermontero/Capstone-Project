$(document).ready(function() {
	$('.recover-pet').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("recover_pets.php", {id:id})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Recover Pet",
					icon : "success",
					html: "Successfully Recovered pet information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});														
			}else{
				Swal.fire({
					title : "Recover Pet",
					icon : "warning",
					html: "Something wrong in recover pet information.",
					timer: 3000,
					showConfirmButton:false							
				});
			}			
		});
	});
});	
$(document).ready(function() {
	$('.delete-pet').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
	});
});	