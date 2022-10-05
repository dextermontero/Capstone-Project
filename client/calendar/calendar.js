$(document).ready(function() {
	var calendar = $('#calendar').fullCalendar({
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
		selectable : false,
		selectHelper : true,
		displayEventTime: true,
		displayEventEnd : true,
		validRange: function(nowDate){
			return {start: $.fullCalendar.moment().subtract(1, 'days')}
		}
	});
});