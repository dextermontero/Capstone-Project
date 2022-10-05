$(document).ready(function() {
	$('#edit_service').click(function(e) {
		e.preventDefault();
		var id = $('#app_id').html();
		var payment = $('#client_payment').val();
		var status = $('#client_status').val();
		if(payment != null && status != null){
			$.post("update_appointment.php", {id : id, payment : payment, status : status})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Appointment",
						icon : "success",
						html: "<strong>Success! </strong>updating appointment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else {
					Swal.fire({
						title : "Update Appointment",
						icon : "error",
						html: "<b>Failed!</b> update appointment",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else if(payment == null && status != null){
			$.post("update_appointment.php", {id : id, payment : payment, status : status})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Appointment",
						icon : "success",
						html: "<strong>Success! </strong>updating appointment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else {
					Swal.fire({
						title : "Update Appointment",
						icon : "error",
						html: "<b>Failed!</b> update appointment",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else if(payment != null && status == null){
			$.post("update_appointment.php", {id : id, payment : payment, status : status})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Appointment",
						icon : "success",
						html: "<strong>Success! </strong>updating appointment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else {
					Swal.fire({
						title : "Update Appointment",
						icon : "error",
						html: "<b>Failed!</b> update appointment",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else {
			Swal.fire({
				title : "Update Appointment",
				icon : "info",
				html: "<b>Information!</b> update appointment not changes!",
				timer: 3000,
				showConfirmButton:false							
			}).then(function() {
				location.reload();
			});
		}
	});
});

$(document).ready(function() {
	$('.edit_appointment').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_appointment.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view-appointment-modal').html(data);
			}
		});
	});
});

$(document).ready(function(){
	$('#scheduled tbody').on('click', '.cancel-appointment', function (e) {
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Cancel Appointment',
			html: "<b>Are you sure?</b> you want to cancel this appointment?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("cancel_appointment.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Cancel Appointment",
							icon : "success",
							html: "<strong>Success! </strong>canceling appointment.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else {
						Swal.fire({
							title : "Cancel Appointment",
							icon : "warning",
							text: "Something wrong in canceling appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
						alert(data);
					}
				});
			}else {
				Swal.fire({
					title : "Cancel Appointment",
					icon : "info",
					html: "<b>Failed!</b> cancel appointment",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});				
	});
	
	$('#pending tbody').on('click', '.cancel-appointment', function (e) {
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Cancel Appointment',
			html: "<b>Are you sure?</b> you want to cancel this appointment?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("cancel_appointment.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Cancel Appointment",
							icon : "success",
							html: "<strong>Success! </strong>canceling appointment.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else {
						Swal.fire({
							title : "Cancel Appointment",
							icon : "warning",
							text: "Something wrong in canceling appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
						alert(data);
					}
				});
			}else {
				Swal.fire({
					title : "Cancel Appointment",
					icon : "info",
					html: "<b>Failed!</b> cancel appointment",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});				
	});
});