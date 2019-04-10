<?php header('Access-Control-Allow-Origin: *'); ?>

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
	<link href="public/css/invoice.css" rel="stylesheet">


	<!--Custom javascript-->
	<script src="public/js/main.js"></script>
	<script src="public/js/invoice.js"></script>

	<!--favicon image-->
	<link rel="shortcut icon" href="public/images/favicon.ico">
</head>

<body>
	<script>
		var ticket_id = <?php echo htmlspecialchars($_GET['ticket_id']); ?>;
	</script>
	<?php
	
		$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
		$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];
		
		include_once $path . '/includes/authenticate.php';

		// If user is authenticated, display headers
		if($auth)
		{
			$page = "Tickets";
			// Display correct header
			if($isAdmin)
			{
				include_once 'headerAdmin.php';
			}
			else
			{
				// Redirect to login page
				header('Location: index.php');
			}
		}
		else
		{
			// Redirect to login page
			header('Location: index.php');
		}
	?>

	<hr>
	<div class="containter m-sm-0 m-md-5">
		<div id="alertMarker" class="mb-3 mx-auto" style="height: 50px; min-width: 678px; max-width: 1200px;"></div>

		<div class="card mx-auto mb-3 border-0" style="min-width: 750px; max-width: 1200px; background: transparent;">
			<div class="card-body p-0">
				<button type="button" class="btn btn-primary float-right" onclick="generatePDF()"><i class="far fa-save"></i>&nbspSave Invoice</button>
				<button type="button" class="btn btn-primary float-left" onclick="sendInvoice()"><i class="far fa-paper-plane"></i>&nbspSend Invoice to User</button>
			</div>
		</div>

		<div class="modal" id="del-confirmation" tabindex="-1" role="dialog" style="min-width: 750px;">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-dark">Really delete this part?</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body row">
						<div class="col-7">
							<input type="text" class="form-control" id="modal-name" value="h" readonly>
						</div>
						<div class="col-2">
							<input type="number" class="form-control" id="modal-quantity" value="" readonly>
						</div>
						<div class="col-3 input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">$</span>
							</div>
							<input type="number" class="form-control" id="modal-price" step="0.01" value="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-danger" onclick="deleteRow('', false)">Delete Part</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card text-white bg-dark m-auto" style="min-width: 750px; max-width: 1200px;">
			<div class="card-body">

			<div class="row p-0 mx-auto mb-1 border-bottom border-secondary">
				<h5 class="col-xl-6 col-sm-3 text-center">Item</h5>
				<h5 class="col-xl-2 col-sm-3 text-center">Quantity</h5>
				<h5 class="col-xl-2 col-sm-2 text-center">Price</h5>
				<h5 class="col-xl-1 col-sm-2"></h5>
				<h5 class="col-xl-1 col-sm-2"></h5>
			</div>

			<?php

				$ticket_id = htmlspecialchars($_GET['ticket_id']);

				include_once $path . '/includes/connect.php';

				// Prepare the select statement for the first chart
				$stmt = $conn->prepare('SELECT * FROM parts_list WHERE ticket_id = :ticket_id;'); 
				// Execute it
				$stmt->execute(array(
					':ticket_id' => $ticket_id
				));
				//Get the result from the query
				$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

				// Get supervisor name and code
				$stmt = $conn->prepare('SELECT supervisor_name AS sn, supervisor_code AS sc FROM tickets WHERE ticket_id = :ticket_id;'); 
				$stmt->execute(array(
					':ticket_id' => $ticket_id
				));
				$super = $stmt->fetch(PDO::FETCH_ASSOC);
			?>

			<script>
				var superName = "SUPERVISOR: <?php echo htmlspecialchars($super['sn']) ?>";
				var superCode = "PROJECT CODE: <?php echo htmlspecialchars($super['sc']) ?>";
			</script>

			<?php for($i = 0; $i < sizeof($parts); $i++) { ?>
				<div class="row p-1" id="row-<?php echo $parts[$i]['part_id'] ?>">
					<div class="col-xl-6 col-sm-4 pr-1">
						<input type="text" class="form-control item-general" id="name-<?php echo $parts[$i]['part_id'] ?>" placeholder="Enter item name or description" value="<?php echo htmlspecialchars($parts[$i]['item_description']) ?>">
					</div>
					<div class="col-xl-2 col-sm-1 px-1">
						<input type="number" class="form-control quantity-general" oninput="calcTotal()" id="quantity-<?php echo $parts[$i]['part_id'] ?>" value="<?php echo htmlspecialchars($parts[$i]['quantity']) ?>">
					</div>
					<div class="col-xl-2 col-sm-3 px-1 input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">$</span>
						</div>
						<input type="number" class="form-control price-general" oninput="calcTotal()" id="price-<?php echo $parts[$i]['part_id'] ?>" step="0.01" value="<?php echo htmlspecialchars(number_format((float)$parts[$i]['price'], 2, '.', '')); ?>">
					</div>
					<div class="col-xl-1 col-sm-2 px-1">
							<button type="button" class="price-update btn btn-outline-success btn-block px-1" onclick="saveRow('<?php echo $parts[$i]['part_id'] ?>')">Save</button>
					</div>
					<div class="col-xl-1 col-sm-2 pl-1">
							<button type="button" class="price-update btn btn-outline-danger btn-block px-1" onclick="deleteRow('<?php echo $parts[$i]['part_id'] ?>', true)">Delete</button>
					</div>
				</div>
			<?php } ?>

			<div id="row-marker"></div>

			<div class="row p-1 row justify-content-between mt-3">
				<div class="col-xl-2 col-sm-3">
					<button type="button" id="add-item" class="btn btn-block btn-primary">Add Item</button>
				</div>
				<div class="col-xl-4 col-sm-1"></div>
				<div class="col-xl-4 col-sm-6 pl-1 row justify-content-end">
					<h5 class="col-xl-4 col-sm-4 my-auto mr-0 p-0 text-right">Total</h5>
					<div class="col-xl-7 col-sm-8 pl-4 pr-1 input-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-dark text-white">$</span>
						</div>
						<input type="text" id="total-price" class="form-control bg-dark text-white" aria-label="Dollar amount (with dot and two decimal places)" value="0.00" readonly>
					</div>
				</div>
				<div class="col-xl-2"></div>
			</div>
		</div>
	</div>

	<?php
		include_once 'footer.php';
	?>

</body>
</html>
