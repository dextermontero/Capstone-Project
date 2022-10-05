$(document).ready(function() {
	$('.update-status').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("update_status.php", {id:id})
		.done(function(data){
			if(data == "publish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "<strong>Success! </strong>publish review.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});								
			}else if(data == "unpublish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "<strong>Success! </strong>unpublish review.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});															
			}else{
				Swal.fire({
					title : "Review Status",
					icon : "warning",
					html: "<strong>WARNING! </strong>Something wrong in update status.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});
$(document).ready(function() {
	$('.view-review').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_review.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view_review_modal').html(data);
			}
		});
	});
});