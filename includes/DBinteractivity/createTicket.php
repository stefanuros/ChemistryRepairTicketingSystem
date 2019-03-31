<?php
// Script to add a ticket to the database
//Written by stefan

// Getting the path to the folder
$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];

include_once $path . '/includes/authenticate.php';

//Call the config file to get access to the needed info
//This is already called in authenticate but it shouldnt be an issue cause of the include_once
include_once $path . '/includes/config.php';

//Check if the user is authenticated
//$auth is a variable from authenticate.php
if(!$auth)
{
	// User is not authenticated
	//Send an error message that was created in authenticate.php
	echo $jsonMsg;
	exit();
}

// User is authenticated so create the ticket
//Connect to the database
include_once $path . '/includes/connect.php';

//Check if all the needed information is set
if(isset($_GET['machine_name']) && 
	isset($_GET['room']) && 
	isset($_GET['description']) &&
	isset($_GET['super_code']) &&
	isset($_GET['super_name']) &&
	isset($_GET['comments'])
)
{
	//Setting who is currently logged in from the jwt in the cookie
	//$uid comes from authenticate.php
	$loggedIn = $uid;

	try 
	{
		//Making the strings safe for html
		$machine_id = htmlspecialchars($_GET['machine_name']);
		$room = htmlspecialchars($_GET['room']);
		$description = htmlspecialchars($_GET['description']);
		$super_name = htmlspecialchars($_GET['super_code']);
		$super_code = htmlspecialchars($_GET['super_name']);
		$comments = htmlspecialchars($_GET['comments']);

		//Insert into these columns, these values
		$stmt = $conn->prepare("INSERT INTO tickets (machine_name, room, status, comment, requested_by, supervisor_name, supervisor_code, other_comments) VALUES (:MID, :room, 'Unassigned', :description, :requested, :super_name, :super_code, :comments);");
		$stmt->execute(
			array(
				':MID' => $machine_id, //Machine ID
				':room' => $room, //Room
				':description' => $description, //problem description
				':requested' => $loggedIn, //id of requester
				':super_name' => $super_name, //Supervisor code
				':super_code' => $super_code, //Supervisor name
				':comments' => $comments //other comments
			)
		);

		// Get the new ticket id
		$stmt = $conn->prepare("SELECT MAX(ticket_id) t FROM tickets;");
		$stmt->execute(array());
		$tickets = $stmt->fetch(PDO::FETCH_ASSOC);
		$ticketCount = $tickets['t'];


		// Also insert new message using comment and description
		$stmt = $conn->prepare("INSERT INTO messages_list VALUES (:t, NULL, :u, NULL, :d);");
		$stmt->execute(
			array(
				':t' => $ticketCount,
				':u' => $loggedIn, //id of requester
				':d' => $description //problem description
			)
		);

		if($comments != "")
		{
			$stmt = $conn->prepare("INSERT INTO messages_list VALUES (:t, NULL, :u, NULL, :c);");
			$stmt->execute(
				array(
					':t' => $ticketCount,
					':u' => $loggedIn, //id of requester
					':c' => $comments //problem description
				)
			);
		}

		//After successful creation, redirect the page
		//Return the success response
		echo json_encode(
			array(
				"msg" => "200 OK",
				"ticket_id" => $ticketCount
			)
		);

	} 
	catch(Exception $e)
	{
		//Send an error message
		echo json_encode(
			array(
				"msg" => "400 Bad Request",
				"err" => "Something went wrong with the sql query"
			)
		);
	}
}
else
{
	//Send an error message
	echo json_encode(
		array(
			"msg" => "400 Bad Request",
			"err" => "Missing information needed"
		)
	);
}
?>
