$(document).ready(function() {
	$('#start_date').change(function(e) {
		var from_date = $('#start_date').val();
		var to_date = $('#end_date').val();
		if(from_date != '' && to_date != ''){
			$.ajax({
				url : "index.php",
				method : "GET",
				data : {from_date : from_date, to_date : to_date},
				success:function(data){
					window.location.href = "index.php?from_date="+from_date+"&to_date="+to_date;
				}
			});
		}else{
			Swal.fire({
				title : "Date Filter",
				icon : "info",
				html: "<b>Invalid! </b>Please Input valid start date to filter.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});
	$('#end_date').change(function(e) {
		var from_date = $('#start_date').val();
		var to_date = $('#end_date').val();
		if(from_date != '' && to_date != ''){
			$.ajax({
				url : "index.php",
				method : "GET",
				data : {from_date : from_date, to_date : to_date},
				success:function(data){
					window.location.href = "index.php?from_date="+from_date+"&to_date="+to_date;
				}
			});
		}else{
			Swal.fire({
				title : "Date Filter",
				icon : "info",
				html: "<b>Invalid! </b>Please Input valid start date to filter.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});			
});