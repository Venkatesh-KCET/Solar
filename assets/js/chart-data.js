function newDate(days) {
	return moment().add(days, 'd').format('D MMM');
}

function newDateString(days) {
	return moment().add(days, 'd').format();
}


var options = {
	maintainAspectRatio: false,
	elements: {
		line: {
			tension: 0.000001
		}
	},
	legend: {
		display: false
	},
	tooltips: {
		mode: 'nearest',
		callbacks: {
			label: function(tooltipItem, data) {
				var label = data.datasets[tooltipItem.datasetIndex].label || '';

				if (label) {
				label += ': ';
				}
				label += Math.round(tooltipItem.yLabel * 100) / 100;
				label = '$' + label;
				return label;
			},
			labelColor: function(tooltipItem, chart) {
				console.log(tooltipItem.datasetIndex);
				console.log(chart);
				return {
					borderColor: 'rgba('+ app.color.white + ', .75)',
					backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].color
				};
			},
			labelTextColor: function(tooltipItem, chart) {
				return app.color.white;
			}
		}
	}
};

var chart3;

var handleRenderChart = function() {
	Chart.defaults.color = 'rgba('+ app.color.componentColorRgb + ', .65)';
	Chart.defaults.font.family = app.font.family;
	Chart.defaults.font.weight = 600;
	Chart.defaults.scale.grid.color = 'rgba('+ app.color.componentColorRgb + ', .15)';
	Chart.defaults.scale.ticks.backdropColor = 'rgba('+ app.color.componentColorRgb + ', 0)';
	Chart.defaults.scale.beginAtZero = true;
	Chart.defaults.plugins.tooltip.padding = 8;
	Chart.defaults.plugins.tooltip.backgroundColor = 'rgba('+ app.color.gray900Rgb +', .95)';
	Chart.defaults.plugins.tooltip.titleFont.family = app.font.family;
	Chart.defaults.plugins.tooltip.titleFont.weight = 600;
	Chart.defaults.plugins.tooltip.footerFont.family = app.font.family;
	Chart.defaults.plugins.legend.display = false;
	
	// #chart3
	options.scales = {
		yAxes: {
			ticks: {
				beginAtZero: true,
				min: 0,
				max: 30,
				stepSize: 10
			}
		}
	};
	var ctx3 = document.getElementById('chart3').getContext('2d');
	chart3 = new Chart(ctx3, {
		type: 'line',
		data: {
			labels: ['', '4am', '8am', '12pm', '4pm', '8pm', newDate(1)],
				datasets: [{
					color: app.color.indigo,
					backgroundColor: 'transparent',
					borderColor: app.color.indigo,
					borderWidth: 2,
					pointBackgroundColor: app.color.componentBg,
					pointBorderWidth: 2,
					pointRadius: 4,
					pointHoverBackgroundColor: app.color.componentBg,
					pointHoverBorderColor: app.color.indigo,
					pointHoverRadius: 6,
					pointHoverBorderWidth: 2,
					data: [0, 0, 5, 18, 9]
				},{
					color: app.color.teal,
					backgroundColor: 'rgba('+ app.color.teal + ', .2)',
					borderColor: app.color.teal,
					borderWidth: 2,
					pointBackgroundColor: app.color.componentBg,
					pointBorderWidth: 2,
					pointRadius: 4,
					pointHoverBackgroundColor: app.color.componentBg,
					pointHoverBorderColor: app.color.teal,
					pointHoverRadius: 6,
					pointHoverBorderWidth: 2,
					data: [0, 0, 10, 26, 13]
				}]
		}, options
	});
}

/* Controller
------------------------------------------------ */
$(document).ready(function() {
	handleRenderChart();
	
	$(document).on('theme-change', function() {
		chart3.destroy();
		
		handleRenderChart();
	});
});