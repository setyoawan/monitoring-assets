"use strict";


var draw = Chart.controllers.line.prototype.draw;
Chart.controllers.lineShadow = Chart.controllers.line.extend({
	draw: function () {
		draw.apply(this, arguments);
		var ctx = this.chart.chart.ctx;
		var _stroke = ctx.stroke;
		ctx.stroke = function () {
			ctx.save();
			ctx.shadowColor = '#00000075';
			ctx.shadowBlur = 10;
			ctx.shadowOffsetX = 8;
			ctx.shadowOffsetY = 8;
			_stroke.apply(this, arguments)
			ctx.restore();
		}
	}
});


var ctx = document.getElementById("line-chart");
if (ctx) {
	ctx.height = 150;
	var myChart = new Chart(ctx, {
		type: 'lineShadow',
		data: {
			labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016"],
			type: 'line',
			defaultFontFamily: 'Poppins',
			datasets: [{
				label: "Foods",
				data: [
					0
					,0
					,944015
					,982511
					,939567
					,921945
					,943258
					,832564
					,821030
					,793282
					,787062
					,789353
					,794423
					,799729
					,804243
					,807790
					,811105
					,815914
					,818453
					,827316
					,831239
					,833643
					,835567
					,837108
					,839381
					,841847
					,844588
					,847252
					,851513
					,854805
					,857157
					,857602
					,858313
					,858458
					,858741
					,860048
					,860543
					,862462
					,861834
					,862740
					,865177
					,856000
					,863797
					,869070
					,871963
					,873690
					,875086
					,876277
					,877659
				],
				backgroundColor: 'transparent',
				borderColor: '#222222',
				borderWidth: 2,
				pointStyle: 'circle',
				pointRadius: 3,
				pointBorderColor: 'transparent',
				pointBackgroundColor: '#222222',
			}, {
				label: "Electronics",
				data: [
					
				],
				backgroundColor: 'transparent',
				borderColor: '#f96332',
				borderWidth: 2,
				pointStyle: 'circle',
				pointRadius: 3,
				pointBorderColor: 'transparent',
				pointBackgroundColor: '#f96332',
			}]
		},
		options: {
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				titleFontFamily: 'Poppins',
				bodyFontFamily: 'Poppins',
				cornerRadius: 3,
				intersect: false,
			},
			legend: {
				display: false,
				labels: {
					usePointStyle: true,
					fontFamily: 'Poppins',
				},
			},
			scales: {
				xAxes: [{
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month'
					},
					ticks: {
						fontFamily: "Poppins",
						fontColor: "#9aa0ac", // Font Color
					}
				}],
				yAxes: [{
					display: true,
					gridLines: {
						display: false,
						drawBorder: false
					},
					scaleLabel: {
						display: true,
						labelString: 'Value',
						fontFamily: "Poppins"

					},
					ticks: {
						fontFamily: "Poppins",
						fontColor: "#9aa0ac", // Font Color
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
}




