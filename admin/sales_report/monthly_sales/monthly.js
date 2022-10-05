$(document).ready(function() {
	var table = $('#monthly').DataTable({
		"responsive" : true,
		"lengthChange" : true,
		"autoWidth" : false,
		"ordering" : false,
		"info" : true,
		"searching": false,
		"paging" : true,
		"buttons": [
			{ 
				text: '<i class="fas fa-copy"></i>&nbsp; COPY',
				extend: 'copyHtml5', 
				footer: true, 
				className: "btn btn-outline-secondary mr-2",
			},
			{ 	
				text: '<i class="fas fa-lg fa-file-csv"></i>&nbsp; CSV',
				extend: 'csv', 
				footer: true, 
				className: "btn btn-outline-secondary mr-2" 
			},
			{ 
				extend: 'excel', 
				footer: true, 
				className: "btn btn-outline-secondary mr-2"
			},
			{
				text: '<i class="fa fa-lg fa-file-pdf"></i>&nbsp; PDF',
				extend: 'pdf', 
				footer: true, 
				className: "btn btn-outline-secondary mr-2",
				orientation: 'portrait',
			},
			{ 
				extend: 'print', 
				footer: true,
				className: "btn btn-outline-secondary mr-2",
				text: '<i class="fa fa-lg fa-print"></i>&nbsp; Print',
				title : 'Vets at Work Veterinary Clinic Weekly Reports',
				customize: function ( win ) {
					$(win.document.body)
					.css( 'font-size', '10pt' )
					.prepend(
						'<div style="margin: auto; width: 50%;"><table><tr><td><img src="http://vawvetclinic.info/dist/img/vaw-logo.jpg" style="width: 92px; height: 92px;"></td><td><h3 style="text-align:center">Vets at Work Veterinary Clinic</h3>Unit B/F Divino Amore Bldg., # 8 Holy Spirit Drive, Don Antonio Heights, Quezon City</p></td></tr></table></div><br><br><br>'
					);
					$( win.document.body )
					.find( 'table')
					.addClass( 'compact' )
					.css({
						color: '#000',
					});
				},
			},
		],
		"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			// Remove the formatting to get integer data for summation
			var intVal = function ( i ) {
				return typeof i === 'string' ?
					i.replace(/[\$,]/g, '')*1 :
					typeof i === 'number' ?
						i : 0;
			};
			// Total over this page
			pageTotal = api
				.column(6, { page: 'current'} )
				.data()
				.reduce( function (a, b) {
					return intVal(a) + intVal(b);
				}, 0);
			// Update footer
			$( api.column(6).footer() ).html(
				'₱ '+ new Intl.NumberFormat().format(pageTotal)
			);
		}
	});
	table.buttons().container().appendTo( '#monthly_wrapper .col-md-6:eq(0)' );
});