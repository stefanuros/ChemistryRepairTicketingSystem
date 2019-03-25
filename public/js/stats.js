// Made by Stefan

//Javascript functionality for the stats page charts

//Getting the stats from the database using php
$.post("./includes/DBinteractivity/getStats.php", {}, function(data){
	data = JSON.parse(data);

	//Adjusting the dates for the time graphs
	for(var i = 0; i < data["ticketHistoryMonthOpened"].length; i++)
	{
		d = data["ticketHistoryMonthOpened"][i].x;
		d = d.replace(/-/g, " ");
		data["ticketHistoryMonthOpened"][i].x = new Date(d)
	}

	for(var i = 0; i < data["ticketHistoryMonthClosed"].length; i++)
	{
		d = data["ticketHistoryMonthClosed"][i].x;
		d = d.replace(/-/g, " ");
		data["ticketHistoryMonthClosed"][i].x = new Date(d)
	}

	for(var i = 0; i < data["ticketHistoryWeekOpened"].length; i++)
	{
		d = data["ticketHistoryWeekOpened"][i].x;
		d = d.replace(/-/g, " ");
		data["ticketHistoryWeekOpened"][i].x = new Date(d)
	}

	for(var i = 0; i < data["ticketHistoryWeekClosed"].length; i++)
	{
		d = data["ticketHistoryWeekClosed"][i].x;
		d = d.replace(/-/g, " ");
		data["ticketHistoryWeekClosed"][i].x = new Date(d)
	}

	//Creating all of the graphs
	$(function () {
		var chart = new CanvasJS.Chart("numTicketsAssignedTech", {
			animationEnabled: true,
			theme: "dark1",
			data: [{
				type: "column",
				legendMarkerColor: "grey",
				dataPoints: data["numTicketsAssignedTech"]
			}]
		});
		
		chart.render();

		$(document).ready(function(){
			chart.render();
		});
	});

	$(function () {
		var chart = new CanvasJS.Chart("numTicketsAssigned", {
			animationEnabled: true,
			theme: "dark1",
			toolTip:{
				content: "{label}: {y}, {num} tickets" ,
			},
			data: [{
				type: "pie",
				startAngle: 240,
				yValueFormatString: "##0\"%\"",
				indexLabel: "{label}: {y}",
				dataPoints: data["numTicketsAssigned"]
			}]
		});

		chart.render();

		$(document).ready(function(){
			chart.render();
		});
	});

	$(function () {
		var chart = new CanvasJS.Chart("ticketHistoryMonth", {
			animationEnabled: true,
			axisX: {
				valueFormatString: "MMM, YY"
			},
			axisY: {
				title: "# of Tickets",
				includeZero: false
			},
			legend:{
				cursor: "pointer",
				fontSize: 16,
				itemclick: toggleDataSeries
			},
			toolTip: {
				shared: true,
				valueFormatString: "MMM, YY"
			},
			theme: "dark1",
			data: [
				{
					name: "Opened",
					showInLegend: true,
					type: "spline",
					yValueFormatString: "0",
					dataPoints: data["ticketHistoryMonthOpened"]
				},
				{
					name: "Closed",
					showInLegend: true,
					type: "spline",
					yValueFormatString: "0",
					dataPoints: data["ticketHistoryMonthClosed"]
				}
			]
		});

		chart.render();

		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}

		$(document).ready(function(){
			chart.render();
		});
	});

	$(function () {
		var chart = new CanvasJS.Chart("ticketHistoryWeek", {
			animationEnabled: true,
			axisX: {
				valueFormatString: "DD MMM, YY"
			},
			axisY: {
				title: "# of Tickets",
				includeZero: false
			},
			legend:{
				cursor: "pointer",
				fontSize: 16,
				itemclick: toggleDataSeries
			},
			toolTip: {
				shared: true,
				valueFormatString: "MMM, YY"
			},
			theme: "dark1",
			data: [
				{
					name: "Opened",
					showInLegend: true, 
					type: "spline",
					yValueFormatString: "0",
					dataPoints: data["ticketHistoryWeekOpened"]
				},
				{
					name: "Closed",
					showInLegend: true,
					type: "spline",
					yValueFormatString: "0",
					dataPoints: data["ticketHistoryWeekClosed"]
				}
			]
		});

		chart.render();

		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}

		$(document).ready(function(){
			chart.render();
		});
	});

	$(function () {
		var chart = new CanvasJS.Chart("mostTicketsMachines", {
			animationEnabled: true,
			theme: "dark1",
			data: [{
				type: "column",
				legendMarkerColor: "grey",
				dataPoints: data["mostTicketsMachines"]
			}]
		});
		
		chart.render();

		$(document).ready(function(){
			chart.render();
		});
	});


	$(function () {
		var chart = new CanvasJS.Chart("mostTicketsRooms", {
			animationEnabled: true,
			theme: "dark1",
			data: [{
				type: "column",
				legendMarkerColor: "grey",
				dataPoints: data["mostTicketsRooms"]
			}]
		});

		chart.render();

		$(document).ready(function(){
			chart.render();
		});
	});
});
