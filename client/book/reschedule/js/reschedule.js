$(function() {
	var $btn = $(".btnClick").click(function() {
		$btn.not(this).removeClass("selectedTime");
		// removing `active` class from images except clicked
		$(this).toggleClass("selectedTime");
		$("#book_btn").removeAttr("disabled", "disabled");
	});
});	

$(document).ready(function() {
	$('#book_btn').click(function(e) {
		e.preventDefault();
		var id = $('#id').html();
		var date = $('#book_date').val();
		var time = $('.selectedTime').val();
		var branch = $('.branches').attr('id');
		var service = $('.service').attr('id');
		Swal.fire({
			title: 'Reschedule Appointment',
			html: "Are you sure you want to reschedule an update on "+ date +" and "+ time +" ?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$("#book_btn").attr("disabled", "disabled");
				$("#book_date").attr("disabled", "disabled");
				$(".btnClick").attr("disabled", "disabled");
				document.getElementById('msg_request').innerHTML = '<p class="text-center text-success h6 mt-2">Rescheduling appointment. Please wait!</p>';
				$.post("reschedule_appointment.php", {id:id, date:date, time:time, branch:branch, service:service})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Reschedule Appointment",
							icon : "success",
							html: "Successfully to reschedule appointment.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							window.location.href = '../';
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Reschedule Appointment",
							icon : "error",
							html: "Failed to reschedule appointment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}else if(data == "exist"){
						Swal.fire({
							title : "Reschedule Appointment",
							icon : "error",
							html: "The appointment reschedule is already unavailable",
							timer: 3000,
							showConfirmButton:false							
						});						
					}else{
						Swal.fire({
							title : "Reschedule Appointment",
							icon : "info",
							html: "Something wrong on appointment reschedule. Please contact the administrator",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}
		});		
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