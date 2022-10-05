$(document).ready(function() {
	$.post("site_graph.php", function(data) {
		var data = JSON.parse(data);
		
		var date = [];
		var visitors = [];
		for (var i in data) {
			date.push(data[i].date);
			visitors.push(data[i].visitor);
		}
		var data = {
			labels : date,
			datasets: [
				{
					label: 'Visitors',
					data: visitors,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}
			]
		};
		
		var ctx = document.getElementById('graphCanvas').getContext('2d');
		var chart = new Chart(ctx, {
			type: "bar",
			data: data,
			options: {
				scales: {
					yAxes: [{
						ticks: {
							stepSize: 1,
							beginAtZero: true
						}
					}]
				},						
				legend:{
					position: 'right',
					labels:{
						fontColor: "black"
					}
				},
				title: {
					display: true,
					fontSize: 18,
					text: 'Daily Site Visitors'
				}
			}
		});				
	});
});
// SERVICE GRAPH
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
				},
				title: {
					display: true,
					fontSize: 18,
					text: 'Services Pie Chart'
				}
			}
		});					
	})
});
// SALES GRAPH
/*
$(document).ready(function() {
	$.post("sales_graph.php", function(data) {
		var data = JSON.parse(data);

		var amount = [];
		var months = [];
		for (var i in data) {
			months.push(data[i].months);
			amount.push(data[i].amounts);
		}
		var data = {
			labels: months,
			datasets: [
				{
					label: "Sales",
					data: amount,
					backgroundColor: "blue",
					borderColor: "lightblue",
					fill: false,
					lineTension: 0,
					radius: 5
				}
			]
		};
		
		var ctx = $("#line-chart");
		var chart1 = new Chart(ctx, {
			type: "line",
			data: data,
			
			options: {
				display: false,
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				},
				title: {
					display: true,
					position: "top",
					text: "Sales Report Graph",
					fontSize: 18,
					fontColor: "#111"
				},
				tooltips: {
					callbacks: {
						label: function(t, d) {
							var xLabel = d.datasets[t.datasetIndex].label;
							var yLabel = t.yLabel >= 1000 ? '₱' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : '$' + t.yLabel;
							return xLabel + ': ' + yLabel;
						}
					}
				},							
				scales: {
					yAxes: [{
						ticks: {
							callback: function(value, index, values) {
								if (parseInt(value) >= 1000) {
									return '₱' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
								} else {
									return '₱' + value;
								}
							}
						}
					}]
				}                          
			}
		});					
	});
});*/
// CHART Plugin
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