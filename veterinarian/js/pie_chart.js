$(document).ready(function() {		
	$.post("services_graph.php", function(data) {
		var data = JSON.parse(data);
		
		var service = [];
		var counts = [];
		for (var i in data) {
			service.push(data[i].service_title);
			counts.push(data[i].count_service);
		}
		var data = {
			labels : service,
			datasets: [
				{
					label: "TeamA Score",
					data: counts,
					backgroundColor: [
						"#DEB887",
						"#A9A9A9",
						"#DC143C",
						"#F4A460",
						"#2E8B57",
						"#686de0",
						"#22a6b3"
					],
					borderColor: [
						"#CDA776",
						"#989898",
						"#CB252B",
						"#E39371",
						"#1D7A46",
						"#686de0",
						"#22a6b3"
					],
					borderWidth: [1, 1, 1, 1, 1, 1, 1]
				}
			]
		};

		var ctx1 = $("#pie-chartcanvas-1");
		var chart1 = new Chart(ctx1, {
			type: "pie",
			data: data,
			
			options: {
				legend:{
					position: 'right',
					labels:{
						fontColor: "black"
					}
				}
			}
		});					
	})
});

Chart.plugins.register({
  afterDraw: function(chart) {
	  if (chart.data.datasets[0].data.every(item => item === 0)) {
		  let ctx = chart.chart.ctx;
		  let width = chart.chart.width;
		  let height = chart.chart.height;

		  chart.clear();
		  ctx.save();
		  ctx.textAlign = 'center';
		  ctx.textBaseline = 'middle';
		  ctx.fillText('No data to display', width / 2, height / 2);
		  ctx.restore();
	  }
  }
});