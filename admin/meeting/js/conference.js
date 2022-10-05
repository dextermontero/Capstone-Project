$(document).ready(function() {
	$('#create_meeting').click(function(e) {
		e.preventDefault();
		var id = $('#client_avail').html();
		var topic = $('#topic_meeting').val();
		var date = $('#date_meeting').val();
		var start = $('#start_meeting').val();
		$('#create_meeting').attr('disabled', 'disabled');
		if(id != null && topic != '' && date != '' && start != ''){
			$.post("create-meeting.php", {id : id, topic : topic, date : date, start : start})
			.done(function(data) {
				if(data == 'success'){
					Swal.fire({
						title : "Create Meeting",
						icon : "success",
						html: "Successfully to create a conference meeting link.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});		
				}else{
					Swal.fire({
						title : "Create Meeting",
						icon : "warning",
						text: "Something wrong in creating conference meeting link.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
				alert(data);
			});
		}else {
			Swal.fire({
				title : "Create Meeting",
				icon : "info",
				html: "You need to fill up all required fields",
				timer: 3000,
				showConfirmButton:false							
			});	
		}
	});
});

$(document).ready(function() {
	$('.delete-meeting').click(function(e) {
		e.preventDefault();
		var meeting_id = $(this).attr('id');
		Swal.fire({
			title: 'Delete Meeting',
			html: "<b>Are you sure?</b> you want to delete this meeting?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("delete-meeting.php", {meeting_id : meeting_id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Delete Meeting",
							icon : "success",
							html: "Successfully to delete conference meeting link.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Delete Meeting",
							icon : "error",
							html: "Failed to delete conference meeting link",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Delete Meeting",
							icon : "warning",
							text: "Something wrong in deleting conference meeting link.",
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
	$('.view-meeting').click(function(e) {
		var id = $(this).attr('id');
		$.ajax({
			url : "view-meeting.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#view-meeting-modal').html(data);
			}
		});
	});
});

$(document).ready(function() {
	$('#update_meeting').click(function(e) {
		e.preventDefault();
		var meeting_id = $('#edit_meetingID').val();
		var topic = $('#edit_topic').val();
		var date = $('#edit_date').val();
		var time = $('#edit_time').val();
		var pass = $('#edit_meetingPASSWORD').val();
		$.post("update-meeting.php", {meeting_id : meeting_id, topic : topic, date : date, time : time, pass : pass})
		.done(function(data){
			if(data == "success"){
				Swal.fire({
					title : "Update Meeting",
					icon : "success",
					html: "Successfully to update conference meeting.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});							
			}else{
				Swal.fire({
					title : "Update Meeting",
					icon : "warning",
					text: "Something wrong in updating conference meeting.",
					timer: 3000,
					showConfirmButton:false							
				});
			}
		});
	});
});