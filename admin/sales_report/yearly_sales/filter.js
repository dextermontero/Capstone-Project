$(document).ready(function() {
	$('#year').change(function(e) {
		var year = $('#year').val();
		if(year != ''){
			$.ajax({
				url : "index.php",
				method : "GET",
				data : {year : year},
				success:function(data){
					window.location.href = "index.php?year="+year;
				}
			});
		}else{
			Swal.fire({
				title : "Date Filter",
				icon : "info",
				html: "<b>Invalid! </b>Please Input valid year to filter.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});		
});