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
		var id = $(this).attr('id');
	});
});