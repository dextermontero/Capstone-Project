$(document).ready(function() {
	$('#edit_service').click(function(e) {
		e.preventDefault();
		var id = $('#app_id').html();
		var branch_id = $('.branches').attr('id');
		var status = $('#client_status').val();
		$('#edit_service').attr('disabled', 'disabled');
		document.getElementById('msg').innerHTML = '<p class="text-center py-1 px-1 text-success">Updating Appointment... Please wait!</p>';
		if(status != null){
			$.post("update_appointment.php", {id : id, branch_id : branch_id, status : status})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Success",
						icon : "success",
						html: "Success to update appointment",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else {
					Swal.fire({
						title : "Failed",
						icon : "error",
						html: "Failed to update appointment",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						$('#edit_service').removeAttr('disabled', 'disabled');
						document.getElementById('msg').innerHTML = '';
					});
				}
			});
		}else {
			Swal.fire({
				title : "Information",
				icon : "info",
				html: "Appointment Schedule did<b>Information!</b> update appointment not changes!",
				timer: 3000,
				showConfirmButton:false							
			}).then(function() {
				$('.edit-appointment-modal').modal('hide');
				$('#edit_service').removeAttr('disabled', 'disabled');
			});			
		}
	});
});
	
$(document).ready(function() {
	$('#appointment tbody').on('click', '.edit_appointment', function (e) {
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
	$('#appointment tbody').on('click', '.cancel-appointment', function (e) {
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
							html: "Successfully to cancel appointment.",
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
					}
				});
			}
		});				
	});
});
$(document).ready(function() {
	$('#appointment tbody').on('click', '.send_invoice', function (e) {
		e.preventDefault();
		if (document.readyState === 'interactive' || document.readyState === 'loading') {
			document.getElementById("loading_details").innerHTML = '<img src="http://vawvetclinic.info/dist/img/loading-buffering.gif" class="mx-auto d-block h-25 w-25 p-4">';
			$('#send_invoice_btn').attr('disabled', 'disabled');
		}else if (document.readyState === 'complete') {
			$('#send_invoice_btn').removeAttr('disabled', 'disabled');
			var id = $(this).attr('id');
			$.ajax({
				url : "view_invoice.php",
				method : "POST",
				data : {id : id},
				success:function(data){
					$('#view-invoice-information').html(data);
				}
			});
		}
	});
	$('#send_invoice_btn').click(function(e) {
		e.preventDefault();
		var id = $('#invoice_id').html();
		var userID = $('#invoice_userid').html();
		var invoiceref = $('#invoice_ref').html();
		var fullname = $('#invoice_fullname').html();
		var petname = $('#invoice_petname').html();
		var service = $('#invoice_service').html();
		var branch = $('#invoice_branch').html();
		var date = $('#invoice_date').html();
		var time = $('#invoice_time').html();
		var cost = $('#invoice_cost').html();
		$('#send_invoice_btn').attr('disabled', 'disabled');
		document.getElementById('invoice_msg').innerHTML = '<p class="text-success text-center">Sending invoice...</p>';
		$.post("send_invoice.php", {id:id, userID:userID, invoiceref:invoiceref, fullname:fullname, petname:petname, service:service, branch:branch, date:date, time:time, cost:cost})
		.done(function(data) {
			if(data == "success"){
				Swal.fire({
					title : "Invoice",
					icon : "success",
					html: "Successfully to send invoice to the pet owner.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});
			}else if(data == "failed"){
				Swal.fire({
					title : "Invoice",
					icon : "error",
					html: "Failed to send invoice to the pet owner.",
					timer: 3000,
					showConfirmButton:false							
				});	
			}else{
				Swal.fire({
					title : "Invoice",
					icon : "warning",
					text: "Something wrong in send invoice.",
					timer: 3000,
					showConfirmButton:false							
				});
			}
		});
	});
});

$(document).ready(function() {
	$('.pay_appointment').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Pay Appointment',
			html: "",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancel',
			confirmButtonText: 'Pay now'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("pay_invoice.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Pay Appointment",
							icon : "success",
							html: "Successfully to paid appointment",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Pay Appointment",
							icon : "error",
							html: "Failed to pay appointment",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Pay Appointment",
							icon : "warning",
							text: "Something wrong in paying appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}
		});	
	});
});
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