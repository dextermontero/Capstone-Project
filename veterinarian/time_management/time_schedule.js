$(document).ready(function() {
	$('#delete_time').click(function(e) {
		e.preventDefault();
		var newId = $('#new_time_id').val();
		if(newId != ''){
			$.post("delete_time.php", {newId:newId})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Delete Time",
						icon : "success",
						html: "Successfully delete time schedule",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						window.location = "./"
					});
				}else if(data == "failed"){
					Swal.fire({
						title : "Delete Time",
						icon : "error",
						html: "Failed delete time schedule.",
						timer: 3000,
						showConfirmButton:false							
					});
				}else{
					Swal.fire({
						title : "Delete Time",
						icon : "warning",
						html: "Something wrong in delete scheduling.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Delete Time",
				icon : "info",
				html: "Cancelling delete time schedule.",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});
});

$(document).ready(function() {
	$('#update_time').click(function(e) {
		e.preventDefault();
		var newId = $('#new_time_id').val();
		var time = $('#new_time').val();
		if(time != ''){
			$.post("update_time.php", {newId:newId, time:time})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Time",
						icon : "success",
						html: "Successfully update time schedule",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else if(data == "failed"){
					Swal.fire({
						title : "Update Time",
						icon : "error",
						html: "Failed update time schedule.",
						timer: 3000,
						showConfirmButton:false							
					});
				}else{
					Swal.fire({
						title : "Update Time",
						icon : "warning",
						html: "Something wrong in update scheduling.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Update Time",
				icon : "info",
				html: "Time available cannot be empty! Please try again.",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});
});

$(document).ready(function() {
	$('.time_click').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : './?time_id='+id,
			method : "POST",
			success: function(data) {
				window.location = './?time_id='+id;
			}
		});
	});
});

$(document).ready(function() {
	$('#add_time').click(function(e) {
		e.preventDefault();
		var branchID = $('#branch_id').val();
		var time_manage = $('#time_manage').val();
		if(time_manage != ''){
			$.post("add_time.php", {branchID:branchID, time_manage:time_manage})
			.done(function(data){
				if(data == "success"){
					Swal.fire({
						title : "Set Time",
						icon : "success",
						html: "Successfully add time schedule",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else if(data == "failed"){
					Swal.fire({
						title : "Set Time",
						icon : "error",
						html: "Failed add time schedule.",
						timer: 3000,
						showConfirmButton:false							
					});								
				}else{
					Swal.fire({
						title : "Set Time",
						icon : "warning",
						html: "Something wrong in time scheduling.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Set Time",
				icon : "info",
				html: "Time available cannot be empty! Please try again.",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});
});