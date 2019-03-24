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
	<script src="public/js/stats.js"></script>

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
