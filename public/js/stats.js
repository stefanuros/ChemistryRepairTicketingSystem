// Made by Stefan

//Javascript functionality for the stats page charts


// SELECT count(*) num, assigned_tech FROM `tickets` where assigned_tech != "NULL" GROUP BY assigned_tech ORDER BY num DESC
$(function () {
	var chart = new CanvasJS.Chart("numTicketsCompleted", {
		animationEnabled: true,
		theme: "dark1",
		data: [{
			type: "column",
			legendMarkerColor: "grey",
			dataPoints: [
				{ y: 7, label: "Ben" },
				{ y: 6, label: "Ed" },
				{ y: 2, label: "Other"}
			]
		}]
	});
	
	chart.render();

	$(document).ready(function(){
		chart.render();
	});
});

// SELECT COUNT(*) num, status FROM `tickets` where status != "Closed" GROUP BY status
$(function () {
	var chart = new CanvasJS.Chart("numTicketsAssigned", {
		animationEnabled: true,
		theme: "dark1",
		data: [{
			type: "pie",
			startAngle: 240,
			yValueFormatString: "##0\"%\"",
			indexLabel: "{label} {y}",
			dataPoints: [
				{y: 35, label: "Assigned"},
				{y: 65, label: "Unassigned"}
			]
		}]
	});

	chart.render();

	$(document).ready(function(){
		chart.render();
	});
});

$(function () {
	var chart = new CanvasJS.Chart("ticketHistoryMonth", {
	// $("#ticketHistoryMonth").CanvasJSChart({
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
				yValueFormatString: "#",
				dataPoints: [
					{ x: new Date(2018,5), y: 24 },
					{ x: new Date(2018,6), y: 25 },
					{ x: new Date(2018,7), y: 31 },
					{ x: new Date(2018,8), y: 29 },
					{ x: new Date(2018,9), y: 29 },
					{ x: new Date(2018,10), y: 31 },
					{ x: new Date(2018,11), y: 29 },
					{ x: new Date(2019,0), y: 38 },
					{ x: new Date(2019,1), y: 33 },
					{ x: new Date(2019,2), y: 40 }
				]
			},
			{
				name: "Closed",
				showInLegend: true,
				type: "spline",
				yValueFormatString: "#",
				dataPoints: [
					{ x: new Date(2018,5), y: 35 },
					{ x: new Date(2018,6), y: 23 },
					{ x: new Date(2018,7), y: 12 },
					{ x: new Date(2018,8), y: 24 },
					{ x: new Date(2018,9), y: 31 },
					{ x: new Date(2018,10), y: 32 },
					{ x: new Date(2018,11), y: 25 },
					{ x: new Date(2019,0), y: 36 },
					{ x: new Date(2019,1), y: 24 },
					{ x: new Date(2019,2), y: 19 }
				]
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


// Opened
// SELECT WEEK(created_time) week, COUNT(*) as opened FROM tickets where created_time >= (curdate() - interval 10 week) group by week
// SELECT STR_TO_DATE(CONCAT(YEARWEEK(created_time),' Monday'), '%X%V %W') y, WEEK(created_time) week, COUNT(*) as opened FROM tickets where created_time >= (curdate() - interval 10 week) group by week

// Closed
// SELECT WEEK(closed_time) week, COUNT(*) as closed FROM tickets where closed_time >= (curdate() - interval 10 week) group by week
// SELECT STR_TO_DATE(CONCAT(YEARWEEK(closed_time),' Monday'), '%X%V %W') y, WEEK(closed_time) week, COUNT(*) as opened FROM tickets where closed_time >= (curdate() - interval 10 week) group by week

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
				yValueFormatString: "#",
				dataPoints: [
					{ x: new Date(2018,11, 27), y: 26 },
					{ x: new Date(2019,0, 3), y: 27 },
					{ x: new Date(2019,0, 10), y: 24 },
					{ x: new Date(2019,0, 17), y: 25 },
					{ x: new Date(2019,0, 24), y: 31 },
					{ x: new Date(2019,1, 1), y: 29 },
					{ x: new Date(2019,1, 8), y: 29 },
					{ x: new Date(2019,1, 15), y: 31 },
					{ x: new Date(2019,1, 22), y: 29 },
					{ x: new Date(2019,1, 29), y: 38 },
					{ x: new Date(2019,2, 7), y: 33 },
					{ x: new Date(2019,2, 14), y: 40 }
				]
			},
			{
				name: "Closed",
				showInLegend: true,
				type: "spline",
				yValueFormatString: "#",
				dataPoints: [
					{ x: new Date(2018,11, 27), y: 32 },
					{ x: new Date(2019,0, 3), y: 31 },
					{ x: new Date(2019,0, 10), y: 35 },
					{ x: new Date(2019,0, 17), y: 23 },
					{ x: new Date(2019,0, 24), y: 12 },
					{ x: new Date(2019,1, 1), y: 24 },
					{ x: new Date(2019,1, 8), y: 31 },
					{ x: new Date(2019,1, 15), y: 32 },
					{ x: new Date(2019,1, 22), y: 25 },
					{ x: new Date(2019,1, 29), y: 36 },
					{ x: new Date(2019,2, 7), y: 24 },
					{ x: new Date(2019,2, 14), y: 19 }
				]
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
			dataPoints: [
				{ y: 35, label: "Machine A" },
				{ y: 25, label: "Machine B" },
				{ y: 24, label: "Machine C" },
				{ y: 19, label: "Machine D" },
				{ y: 13, label: "Machine E"}
			]
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
			dataPoints: [
				{ y: 45, label: "Room A" },
				{ y: 13, label: "Room B" },
				{ y: 12, label: "Room C" },
				{ y: 10, label: "Room D" },
				{ y: 3, label: "Room E"}
			]
		}]
	});

	chart.render();

	$(document).ready(function(){
		chart.render();
	});
});
