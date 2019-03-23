<!--By: Stefan Urosevic-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Queen's Chemistry Department's Repair Ticketing System">
	<meta name="author" content="">

	<title>QU Chemistry Repair</title>

	<!--Bootstrap core CSS-->
	<link rel="stylesheet" type="text/css" href="./public/bootstrap-4.0.0-dist/css/bootstrap.min.css"> 

	<!--Bootstrap core JavaScript-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="./public/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>

	<!-- canvasJS Script -->
	<script src=".\public\canvasjs\jquery.canvasjs.min.js"></script>

	<!--FontAwesome stylesheet(s)-->
	<link rel="stylesheet" href="./public/font/fontawesome-5.7.1/css/all.css">

	<!--Custom stylesheet(s)-->
	<link href="public/css/style.css" rel="stylesheet">
	<link href="public/css/stats.css" rel="stylesheet">


	<!--Custom javascript-->
	<script src="public/js/main.js"></script>

	<!--favicon image-->
	<link rel="shortcut icon" href="public/images/favicon.ico">
</head>

<body>
	<?php
		$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
		$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];
		
		include_once $path . '/includes/authenticate.php';

		// If user is authenticated, display headers
		if($auth)
		{
			// Display correct header
			if($isAdmin)
			{
				include_once 'headerAdmin.php';
			}
			else
			{
				include_once 'headerUser.php';
			}
		}
		else
		{
			// Redirect to login page
			header('Location: login.html');
		}
	?>

	<script type="text/javascript">
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

	</script>

	<div class="containter m-5">
		<div class="card-deck row">
			<!-- Tickets Completed Chart -->
			<div class="p-0 m-0 mb-4 col-md-12 col-lg-6 col-xl-4">
				<div class="card bg-dark text-whitepx-0">
					<h4 class="card-header">Tickets Completed</h4>
					<div class="card-body py-1 px-2">
						<div id="numTicketsCompleted" style="height: 420px;"></div>
					</div>
				</div>
			</div>
			<!-- Assigned Tickets Chart -->
			<div class="p-0 m-0 mb-4 col-md-12 col-lg-6 col-xl-4">
				<div class="card bg-dark text-whitepx-0">
					<h4 class="card-header">Assigned Tickets</h4>
					<div class="card-body py-1 px-2">
						<div id="numTicketsAssigned" style="height: 420px;"></div>
					</div>
				</div>
			</div>
			<!-- Assigned Tickets Chart -->
			<div class="p-0 m-0 mb-4 col-md-12 col-lg-6 col-xl-4">
				<div class="card bg-dark text-white px-0">
					<h4 class="card-header">Ticket History (Month)</h4>
					<div class="card-body py-1 px-2">
						<div id="ticketHistoryMonth" style="height: 420px;"></div>
					</div>
				</div>
			</div>

			<!-- Tickets Completed Chart -->
			<div class="p-0 m-0 mb-4 col-md-12 col-lg-6 col-xl-4">
				<div class="card bg-dark text-white px-0">
					<h4 class="card-header">Ticket History (Week)</h4>
					<div class="card-body py-1 px-2">
						<div id="ticketHistoryWeek" style="height: 420px;"></div>
					</div>
				</div>
			</div>
			<!-- Assigned Tickets Chart -->
			<div class="p-0 m-0 mb-4 col-md-12 col-lg-6 col-xl-4">
				<div class="card bg-dark text-white px-0">
					<h4 class="card-header">Most Tickets (Machines)</h4>
					<div class="card-body py-1 px-2">
						<div id="mostTicketsMachines" style="height: 420px;"></div>
					</div>
				</div>
			</div>
			<!-- Assigned Tickets Chart -->
			<div class="p-0 m-0 mb-4 col-md-12 col-lg-6 col-xl-4">
				<div class="card bg-dark text-white px-0">
					<h4 class="card-header">Most Tickets (Rooms)</h4>
					<div class="card-body py-1 px-2">
						<div id="mostTicketsRooms" style="height: 420px;"></div>
					</div>
				</div>
			</div>
		</div>
		
	</div>

	<?php
		include_once 'footer.php';
	?>

</body>
</html>
