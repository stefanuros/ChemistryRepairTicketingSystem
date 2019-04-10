<!--By: Stefan Urosevic-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Queen's Chemistry Department's Repair Ticketing System">
	<meta name="author" content="">

	<title>QU Chemistry Repair</title>

	<script src="./public/js/popper.min.js"></script>

	<!--Bootstrap core CSS-->
	<link rel="stylesheet" type="text/css" href="./public/bootstrap-4.0.0-dist/css/bootstrap.min.css"> 

	<!--Bootstrap core JavaScript-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="./public/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>

	<!--FontAwesome stylesheet(s)-->
	<link rel="stylesheet" href="./public/font/fontawesome-5.7.1/css/all.css">

	<!--Custom stylesheet(s)-->
	<link href="public/css/style.css" rel="stylesheet">
	<link href="public/css/messagePage.css" rel="stylesheet">
	<link href="public/css/howTo.css" rel="stylesheet">



	<!--Custom javascript-->
	<script src="public/js/main.js"></script>
	<script src="public/js/messagesPage.js"></script>

	<!-- Jquery date -->
	<script src="public/js/jquery-dateformat.min.js"></script>

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
			$page = "Tickets";
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

		$ticket_id = htmlspecialchars($_GET['ticket_id']);
		include_once $path . '/includes/connect.php';

		// Check if the user is allowed to see this page
		$stmt = $conn->prepare('SELECT COUNT(*) c FROM tickets WHERE ticket_id=:t AND requested_by=:u;'); 
		// Execute it
		$stmt->execute(array(
			':t' => $ticket_id,
			':u' => $uid
		));

		// Get the result
		$resp = $stmt->fetch(PDO::FETCH_ASSOC);

		// If there are no rows where this user has this ticket, and theyre not an admin
		if($resp['c'] <= "0" && !$isAdmin)
		{
			// Redirect to login page
			header('Location: index.php');
		}
	?>

	<script>
		var ticket_id = <?php echo $ticket_id; ?>;
	</script>

	<hr>
	<div class="container bg-dark mx-auto rounded-top p-2 pb-4" id="msg-container" style="max-height: 800px; min-height: 200px; min-width: 678px; max-width: 1200px; overflow-y: auto;">

		<?php 

			// Get all of the messages
			$stmt = $conn->prepare('SELECT m.user_id as u, concat(first_name, " ", last_name) as name, timestamp, content, isInfo FROM (SELECT * FROM `messages_list` WHERE ticket_id=:t) m LEFT JOIN profile p ON m.user_id=p.unique_id ORDER BY timestamp ASC;'); 
			// Execute it
			$stmt->execute(array(
				':t' => $_GET['ticket_id']
			));
			// Get the result
			$m = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$prev = $m[0];

			// Loop through the data
			for($i = 0; $i < sizeof($m); $i++) 
			{
				// Set the date of the current message
				$date = date_create_from_format("Y-m-d H:i:s", $m[$i]['timestamp']);

				// Set when ticket was created
				if($i == 0)
				{
					?>

					<div class="row m-0 p-1">
						<div class="col-12 p-0 m-0">
							<div class="row p-0 m-0">
								<small class="col-12 text-muted text-center p-0">Ticket <b><i>Created</i></b> on <?php echo date_format($date, "M j, Y, g:i A") ?></small>
							</div>
						</div>
					</div>

					<?php 
				}

				// Checks if the message is a text message or an info message
				// Make the info message
				if($m[$i]['isInfo'] == "1")
				{
					// str.substring(4, str.length)

					// Invoice Link
					if(substr($m[$i]['content'], 0, 4) == "link")
					{
						?>

						<div class="row m-0 p-1">
							<div class="col-12 p-0 m-0">
								<div class="row p-0 m-0">
									<small class="col-12 text-muted text-center p-0">
										<button class="btn btn-link px-1 py-0" onclick="invoiceLink(`<?php echo substr($m[$i]['content'], 4) ?>`);"><small>
											Click here to view invoice sent by <?php echo htmlspecialchars($m[$i]['name']) ?> on <?php echo date_format($date, "M j, Y, g:i A") ?>
										</small></button>
									</small>
								</div>
							</div>
						</div>

						<?php 
					}
					// Info message
					else
					{
						?>

						<div class="row m-0 p-1">
							<div class="col-12 p-0 m-0">
								<div class="row p-0 m-0">
									<small class="col-12 text-muted text-center p-0">Ticket set to <b><i><?php echo htmlspecialchars($m[$i]['content']) ?></i></b> by <?php echo htmlspecialchars($m[$i]['name']) ?> on <?php echo date_format($date, "M j, Y, g:i A") ?></small>
								</div>
							</div>
						</div>

						<?php 
					}
				}
				// Make the regular message
				else
				{
					if($m[$i]['content'] != "")
					{
						// Get the date of the previous message
						$prevTime = date_create_from_format("Y-m-d H:i:s", $prev['timestamp']);
						
						// If the previous message was from the same person as the current message
						$skipName = ($prev['u'] == $m[$i]['u'] && $i != 0 && $date->diff($prevTime)->i < 10);
						$prev = $m[$i];

						// If the message is written by the current user
						if($m[$i]['u'] == $uid) { ?>
							<div class="row m-0 p-1">
								<div class="col-12 p-0 m-0">
									<?php if(!$skipName) { ?>
										<div class="row p-0 m-0">
											<small class="col-4 p-0"></small>
											<small class="col-4 text-muted text-center p-0"><?php echo date_format($date, "M j, Y, g:i A") ?></small>
											<small class="col-4 text-muted text-right p-0"><?php echo htmlspecialchars($m[$i]['name']) ?></small>
										</div>
									<?php } ?>
									<div class="row p-0 m-0 justify-content-end">
										<div class="d-flex bg-success rounded m-0 py-1 px-2" style="max-width: 65%;">
											<?php echo htmlspecialchars($m[$i]['content']) ?>
										</div>
									</div>
								</div>
							</div>
						<?php }	
						// Else, the message is written by someone else
						else { ?>
							<div class="row m-0 p-1">
								<div class="col-12 p-0 m-0">
									<?php if(!$skipName) { ?>
										<div class="row p-0 m-0">
											<small class="col-4 text-muted text-left p-0"><?php echo htmlspecialchars($m[$i]['name']) ?></small>
											<small class="col-4 text-muted text-center p-0"><?php echo date_format($date, "M j, Y, g:i A") ?></small>
											<small class="col-4 p-0"></small>
										</div>
									<?php } ?>
									<div class="row p-0 m-0">
										<div class="d-flex bg-secondary rounded m-0 py-1 px-2" style="max-width: 65%;">
											<?php echo htmlspecialchars($m[$i]['content']) ?>
										</div>
									</div>
								</div>
							</div>
						<?php }
					}
				}
			}
		?>

		<div id="message-marker"></div>

	</div>
	<div class="row p-0 m-0 mx-auto" style="min-width: 750px; max-width: 1200px;">
		<div class="input-group">
			<textarea class="form-control border-right-0 border-left-0 border-bottom-0 border-secondary border-top" id="enter-message" rows="2" placeholder="Enter a message..." style="overflow-y: auto; resize: none; border-top-left-radius: 0px; max-height: 105px;"></textarea>
			<div class="input-group-append bg-dark">
				<button class="btn btn-outline-success" type="button" onclick="sendMsg()" id="send-message" style="border-top-right-radius: 0px; z-index: 1111;">Send</button>
			</div>
		</div>
	</div>
		
	<?php
		include_once 'footer.php';
	?>

</body>
</html>
