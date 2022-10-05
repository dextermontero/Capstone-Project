$(document).ready(function() {
	$('.view-service-modal').click(function(e) {
		e.preventDefault();
		var sid = $(this).attr('id');
		$.ajax({
			url : "modal.php",
			method : "POST",
			data : {sid : sid},
			success:function(data){
				$('#view_modal_services').html(data);
			}
		});
	});
});