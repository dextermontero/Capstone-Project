$(document).ready(function() {
	var calendar = $('#calendar').fullCalendar({
		editable : true,
		header : {
			left : 'prev, next today',
			center : 'title',
			right : 'month, agendaWeek, agendaDay'
		},
		timeFormat: 'h(:mm) A', // uppercase H for 24-hour clock
		events : 'data.php',
		eventRender: function(event,$el) {
			return $('<p>' + event.title + '<br>Start Time : '+ event.start.format('LTS') +'<br>End Time : ' + moment(event.end).format('LTS') +'</p>');
		},
		selectable : true,
		selectHelper : true,
		displayEventTime: true,
		displayEventEnd : true,
		select: function(start, end) {
			var start = $.fullCalendar.formatDate(start, "Y-MM-DD");		
			$('#modal-default').modal('show');
			$('#AddSchedule').click(function(e) {
				e.preventDefault();
				var pet_name = $('#pet_name').val();
				var title = $('#title-schedule').val();
				var stime =$('#addstarttime').val();
				var etime =$('#addendtime').val();
				var start_time = start + ' ' + stime;
				var end_time = start + ' ' + etime;
				if(title != '' && stime != '' && etime != ''){
					$.post("insert.php", {title:title, start_time:start_time, end_time:end_time, pet_name:pet_name})
					.done(function(data){
						if(data == "success"){
							$('#modal-default').modal('hide');
							Swal.fire({
								title : "Calendar Schedule",
								icon : "success",
								html: "Successfully to add calendar schedule",
								timer: 3000,
								showConfirmButton:false							
							}).then(function() {
								calendar.fullCalendar('refetchEvents');
									location.reload();
							});							
						}else{
							Swal.fire({
								title : "Calendar Schedule",
								icon : "error",
								html: "Failed to add calendar schedule",
								timer: 3000,
								showConfirmButton:false							
							});							
						}
					});
				}
			});
		},
		validRange: function(nowDate){
			return {start: $.fullCalendar.moment().subtract(1, 'days')}
		},
		// SET DATE
		editable:true,
		// DROP
		eventDrop : function(event) {
			var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
			var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
			var title = event.title;
			var id = event.id;
			$.post("update.php", {title:title, start:start, end:end, id:id}) 
			.done(function(data){
				Swal.fire({
					title : "Update Calendar Schedule",
					icon : "success",
					html: "Succesfully to update calendar schedule",
					timer: 1000,
					showConfirmButton:false							
				}).then(function() {
					calendar.fullCalendar('refetchEvents');
					location.reload();
				});				
			});
		},
		// DELETE
		eventClick : function(event) {
			var id = event.id;
			Swal.fire({
				title: 'Delete Calendar Schedule',
				html: "Are you sure you want to delete this schedule?",
				icon: 'info',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'No',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					$.post("delete.php", {id : id})
					.done(function(data) {
						Swal.fire({
							title : "Delete Calendar Schedule",
							icon : "success",
							html: "Succes to delete calendar schedule.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							calendar.fullCalendar('refetchEvents');
							location.reload();
						});	
					});
				}
			})				
		}
	});
});