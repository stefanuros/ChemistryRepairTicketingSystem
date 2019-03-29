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

	<!--FontAwesome stylesheet(s)-->
	<link rel="stylesheet" href="./public/font/fontawesome-5.7.1/css/all.css">

	<!--Custom stylesheet(s)-->
	<link href="public/css/style.css" rel="stylesheet">
	<link href="public/css/howTo.css" rel="stylesheet">


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
			$page = "Create Ticket";
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
			header('Location: index.php');
		}
	?>

	<hr>
	<div class="containter m-sm-0 m-md-2">
		<div id="alertMarker"></div>
		<div class="card text-white bg-dark m-auto" style="min-width: 678px; max-width: 1200px;">
			<h3 class="card-header">Create New Ticket </h3>
			<form class="create-ticket-form card-body">
				<!-- Row 1 -->
				<div class="form-row m-auto">
					<div class="form-group col-md-6 pl-0">
						<label for="inputMachineName">Machine Name</label>
						<input type="text" class="form-control" maxlength="256" id="inputMachineName" name="machine_name">
						<div class="invalid-feedback">
							Please enter a valid machine name
						</div>
						<div class="valid-feedback">
							Looks good
						</div>
					</div>
					<div class="form-group col-md-6 pr-0">
						<label for="inputRoom">Room</label>
						<input type="text" class="form-control" maxlength="256" id="inputRoom" name="room">
						<div class="invalid-feedback">
							Please enter a valid room
						</div>
						<div class="valid-feedback">
							Looks good
						</div>
					</div>
				</div>
				<!-- Row 2 -->
				<div class="form-group m-auto">
					<label for="problemDescription">Problem Description</label>
					<textarea class="form-control" id="problemDescription" name="description" rows="5"></textarea>
					<div class="invalid-feedback">
						Please enter a description of the problem
					</div>
					<div class="valid-feedback">
						Looks good
					</div>
				</div>
				<!-- Row 3 -->
				<div class="form-row m-auto pt-3">
					<div class="form-group col-md-6 pl-0">
						<label for="inputSuperCode">Supervisor Code</label>
						<input type="text" class="form-control" maxlength="256" id="inputSuperCode" name="super_code">
						<div class="invalid-feedback">
							Please enter a valid code
						</div>
						<div class="valid-feedback">
							Looks good
						</div>
					</div>
					<div class="form-group col-md-6 pr-0">
						<label for="inputSuperName">Supervisor Name</label>
						<input type="text" class="form-control" maxlength="256" id="inputSuperName" name="super_name">
						<div class="invalid-feedback">
							Please enter a valid name
						</div>
						<div class="valid-feedback">
							Looks good
						</div>
					</div>
				</div>
				<!-- Row 4 -->
				<div class="form-group m-auto">
					<label for="inputComments">Other Comments</label>
					<textarea class="form-control" id="inputComments" name="comments" rows="5"></textarea>
				</div>
				<!-- Row 5 -->
				<!-- <div class="form-group w-75 m-auto pt-3"> -->
				<button type="submit" class="btn btn-success mt-3">Submit Ticket</button>
				<!-- </div> -->
			</form>
		</div>
	</div>

	<?php
		include_once 'footer.php';
	?>

</body>
</html>
