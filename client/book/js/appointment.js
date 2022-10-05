// FORCE TO ADD PET BEFORE REQUEST APPOINTMENT
$(document).ready(function() {
	var web_root = $('#web_root').html();
	$('.request-appointment').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("view_pet.php", {id : id})
		.done(function(data) {
			if(data == "success"){
				window.location = web_root+"client/book/appointment/"; 
			}else{
				Swal.fire({
					title: 'Create Pet Profile',
					html: "To schedule an appointment, you must first create a profile for your pet.Do you want to add a pet to your account?",
					icon: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					cancelButtonText: 'No',
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location = web_root+"client/pets/add_pet/";
					}else {
					
					}
				});                          
			}
		})
	});
});
// ALL APPOINTMENT LISt
$(document).ready(function() {
	$('#appointment tbody').on('click', '.cancel-appointment', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Cancel Appointment',
			html: "Are you sure you want to cancel this appointment?",
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
							html: "Your appointment has been canceled.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Cancel Appointment",
							icon : "error",
							html: "Failed to cancel appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Cancel Appointment",
							icon : "warning",
							text: "Something wrong in cancel appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
					
			}
		});
	});

	// PENDING
	$('#pending tbody').on('click', '.cancel-appointment', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Cancel Appointment',
			html: "Are you sure you want to cancel this appointment?",
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
							html: "Your appointment has been canceled.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Cancel Appointment",
							icon : "error",
							html: "Failed to cancel appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Cancel Appointment",
							icon : "warning",
							text: "Something wrong in cancelled appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
						
			}
		});
	});
	
	// SCHEDULED
	$('#scheduled tbody').on('click', '.cancel-appointment', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Cancel Appointment',
			html: "Are you sure you want to cancel this appointment?",
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
							html: "Your appointment has been canceled.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Cancel Appointment",
							icon : "error",
							html: "Failed to cancel appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Cancel Appointment",
							icon : "warning",
							text: "Something wrong in cancelled appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				
			}
		});
	});
});

// View Cancel
$(document).ready(function() {
	$('#appointment tbody').on('click', '.view_cancel', function (e) {	
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_cancel.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view_cancel_modal').html(data);
			}
		});
	});
		// PENDING
	$('#pending tbody').on('click', '.view_cancel', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_cancel.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view_cancel_modal').html(data);
			}
		});
	});
		// SCHEDULED
	$('#scheduled tbody').on('click', '.view_cancel', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_cancel.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view_cancel_modal').html(data);
			}
		});
	});
});

$(document).ready(function() {
	$("#agree_cancel").click(function(e) {
		if ($(this).is(":checked")) {
			$("#cancel_appointment").removeAttr("disabled"); //enable input
		} else {
			$("#cancel_appointment").attr("disabled", true); //disable input
		}
	});
});

// ADD REVIEW
$(document).ready(function() {
	$('#done tbody').on('click', '.add-review', function (e) {	
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

// ADD FEEDBACK
$(document).ready(function() {
	$('#add_feedback').click(function(e) {
		e.preventDefault();
		
		var id = $('#review_id').html();
		var title = $('#review_title').val();
		var description = $('#review_description').val();
		if(description != ''){
			$.post("add_review.php", {id : id, title : title, description : description})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Add Review",
						icon : "success",
						html: "Successfully to add review.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});								
				}else{
					Swal.fire({
						title : "Add Review",
						icon : "warning",
						html: "Something wrong in add review.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Add Review",
				icon : "info",
				html: "Please fill out all fields.",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});
});

$(document).ready(function() {
	$('#cancel_appointment').click(function(e) {
		e.preventDefault();
		$('#cancel_appointment').attr('disabled', 'disabled');
		$('#agree_cancel').attr('disabled', 'disabled');
		$('#close_appointment').attr('disabled', 'disabled');
		document.getElementById('msg').innerHTML = '<p class="text-center text-success">Cancelling of appointment... Please wait!<p>';
		var id = $('#can-id').html();
		$.post("cancel_appointment.php", {id:id})
		.done(function(data) {
			if(data == "success"){
				Swal.fire({
					title : "Cancel Appointment",
					icon : "success",
					html: "Your appointment has been canceled.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});							
			}else if(data == "failed"){
				Swal.fire({
					title : "Cancel Appointment",
					icon : "error",
					html: "Failed to cancel appointment.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}else{
				Swal.fire({
					title : "Cancel Appointment",
					icon : "warning",
					text: "Something wrong in cancel appointment.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});

$(document).ready(function() {
	$('.refund_btn').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Refund Reservation',
			html: "some description here with percentage deduction",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancel',
			confirmButtonText: 'Refund'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("refund_reservation.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Success",
							icon : "success",
							html: "Successfully to refund reservation.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Failed",
							icon : "error",
							html: "Failed to request refund reservation.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Info",
							icon : "warning",
							text: "Something wrong in request refund reservation.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}
		});
	});
});