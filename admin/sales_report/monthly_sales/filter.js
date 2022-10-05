$(document).ready(function() {
	$('#month').change(function(e) {
		var month = $('#month').val();
		if(month != ''){
			$.ajax({
				url : "index.php",
				method : "GET",
				data : {month : month},
				success:function(data){
					window.location.href = "index.php?month="+month;
				}
			});
		}else{
			Swal.fire({
				title : "Date Filter",
				icon : "info",
				html: "<b>Invalid! </b>Please Input valid month to filter.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});		
});