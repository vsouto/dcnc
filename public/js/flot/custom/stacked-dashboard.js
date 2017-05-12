var $border_color = "#ccc";
var $grid_color = "#ccc";
var $default_black = "#666";

var $primary = "#005387";
var $info = "#87CEEB";
var $danger = "#F56B6B";
var $warning = "#F38733";
var $success = "#2ecc71";
var $yellow = "#fdd922";
var $facebook = "#3b5999";
var $twitter = "#00acee";
var $linkedin = "#1a85bd";
var $gplus = "#dc4937";

$(function () {
		
	var d1, d2, d3, data, chartOptions;

	var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 10434], [1270080000000, 21982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
	var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 1129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];
	var d3 = [[1262304000000, 10000], [1264982400000, 9010], [1267401600000, 21205], [1270080000000, 41129], [1272672000000, 32643], [1275350400000, 56055], [1277942400000, 32062], [1280620800000, 25197], [1283299200000, 17000], [1285891200000, 26000], [1288569600000, 15300], [1291161600000, 1000]];

	data = [{ 
		label: "Concluídas",
		data: d1
	}, {
		label: "Em andamento",
		data: d2
	}, {
		label: "Canceladas",
		data: d3
	}];
 
	chartOptions = {
		xaxis: {
			min: (new Date(2009, 11)).getTime(),
			max: (new Date(2010, 11)).getTime(),
			mode: "time",
			tickSize: [1, "month"],
			monthNames: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
			tickLength: 0
		},
		yaxis: {

		},
		series: {
			stack: true,
			lines: {
				show: true, 
				fill: 0.3,
				lineWidth: 1
			},
			points: {
				show: true,
				radius: 4,
				fill: true,
				fillColor: "#ffffff",
				lineWidth: 1.5
			}
		},
		grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 1,
      tickColor: "#eee",
      borderColor: "#eee",
    },
		legend: {
			show: true,
			position: 'nw'
		},
		shadowSize: 0,
		tooltip: true,
		tooltipOpts: {
		content: '%s: %y'
		},
		colors: [$primary, $warning, $gplus],
	};

	var holder = $('#stacked-area-chart');

	if (holder.length) {
		$.plot(holder, data, chartOptions );
	}
});