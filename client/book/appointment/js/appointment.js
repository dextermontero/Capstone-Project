$(document).ready(function() {
	$('#book_btn').click(function(e) {
		e.preventDefault();
		var date = $('#book_date').val();
		var fullname = $('#book_fullname').val();
		var pet_name = $('#pet_name').val();
		var branch = $('.branches').attr('id');
		var service = $('#book_service').val();
		var timeSelected = $('.selectedTime').val();
		var data = {
			'date' : date,
			'fullname' : fullname,
			'pet_name' : pet_name,
			'branch' : branch,
			'service' : service,
			'time' : timeSelected
		}
		$('#book_btn').attr('disabled', 'disabled');
		if(service != null && pet_name != null && branch != ""){
			Swal.fire({
				title: 'Schedule Appointment',
				html: "Are you sure you want to schedule an appointment on "+ date +" and "+ timeSelected +" ?",
				icon: 'info',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'No',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					$("#book_btn").attr("disabled", "disabled");
					$("#pet_name").attr("disabled", "disabled");
					$("#branches").attr("disabled", "disabled");
					$("#book_service").attr("disabled", "disabled");
					$(".btnClick").attr("disabled", "disabled");
					document.getElementById('msg_request').innerHTML = '<p class="text-center text-success h6 mt-2">Requesting appointment. Please wait!</p>';
					$.ajax({
						url: "request_appointment.php",
						type: "POST",
						// This is the important part
						xhrFields: {
							withCredentials: true
						},
						// This is the important part
						data: data,
						success: function (data) {
							if(data == "api"){
								Swal.fire({
									title : "Schedule Appointment",
									icon : "info",
									html: "Something wrong on api. Please contact the administrator",
									timer: 5000,
									showConfirmButton:false							
								});
							}else if(data == "failed"){
								Swal.fire({
									title : "Schedule Appointment",
									icon : "error",
									html: "Failed to schedule appointment.",
									timer: 5000,
									showConfirmButton:false							
								});
							}else if(data == "exist"){
								Swal.fire({
									title : "Schedule Appointment",
									icon : "error",
									html: "The appointment schedule is already unavailable",
									timer: 5000,
									showConfirmButton:false							
								});						
							}else{
								Swal.fire({
									title : "Reservation Fee",
									icon : "info",
									html: "Please wait,  while you are redirected to the reservation payment gateway<br><br>Please do not refresh the page or click the <br><b>Back</b> or <b>Close</b> button of your browser",
									timer: 5000,
									allowOutsideClick: false,
									showConfirmButton:false							
								}).then(function() {
									window.location.href = data;
								});
							}
						}
					});					
				}else{
					$("#book_btn").removeAttr("disabled", "disabled");
				}
			});
		}else{
			Swal.fire({
				title : "Schedule Appointment",
				icon : "info",
				html: "Select one of the services or pet type or branch!.",
				timer: 5000,
				showConfirmButton:false							
			});		
		}		
	});
});

// SELECT BRANCH DROPDOWN
$(document).ready(function() {
	$('#preferred_branch').change(function(e) {
		e.preventDefault()
		var branchId = $(this).val();
		window.location.href= "?branchID="+branchId;
	});
});
// ENABLE SERVICES
$(document).ready(function() {
	$('#pet_name').change(function(e) {
		e.preventDefault();
		var id = $('.branches').attr('id');
		var date = $('#book_date').val();
		if(id != null){
			document.getElementById('hide_services_disabled').style.display="none";
			$.ajax({
				url : "view_services.php",
				method : "POST",
				data : {id : id, date:date},
				success:function(data){
					$('#display_services').html(data);
					$("#book_btn").attr("disabled", "disabled");
				}
			});						
		}
	});
});

// FOR BRANCH DROPDOWN WITH SUBTITLE 
$(function(){
    $(".select2").select2({
        matcher: matchCustom,
		minimumResultsForSearch: -1,
		width: '100%',
        templateResult: formatCustom
    });
})

function stringMatch(term, candidate) {
    return candidate && candidate.toLowerCase().indexOf(term.toLowerCase()) >= 0;
}

function matchCustom(params, data) {
    if ($.trim(params.term) === '') {
        return data;
    }
    if (typeof data.text === 'undefined') {
        return null;
    }
    if (stringMatch(params.term, data.text)) {
        return data;
    }
    if (stringMatch(params.term, $(data.element).attr('data-foo'))) {
        return data;
    }
    return null;
}

function formatCustom(state) {
    return $('<div><div>' + state.text + '</div><div class="foo">'+ $(state.element).attr('data-foo')+ '</div></div>');
}
			
/*
$(document).ready(function() {
	$('#branches').change(function(e) {
		e.preventDefault();
		var id = $(this).val();
		var date = $('#book_date').val();
		if(id != null){
			document.getElementById('hide_services_disabled').style.display="none";
			$.ajax({
				url : "view_services.php",
				method : "POST",
				data : {id : id, date:date},
				success:function(data){
					$('#display_services').html(data);
					$("#book_btn").attr("disabled", "disabled");
				}
			});						
		}
	});
});*/