<?php
// Script to add a ticket to the database
//Written by stefan

// include('secure.php'); Implement this maybe???
include_once '../authenticate.php';

//Call the config file to get access to the needed info
//This is already called in authenticate but it shouldnt be an issue cause of the include_once
include_once '../config.php';

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
include_once '../connect.php';

//Check if all the needed information is set
if(isset($_GET['machine_name']) && 
	isset($_GET['room']) && 
	isset($_GET['comments']))
{
	//Setting who is currently logged in from the jwt in the cookie
	//$uid comes from authenticate.php
	$loggedIn = $uid;

	try 
	{
		//Making the strings safe for html
		$machine_id = htmlspecialchars($_GET['machine_name']);
		$room = htmlspecialchars($_GET['room']);
		$comments = htmlspecialchars($_GET['comments']);

		//Insert into these columns, these values
		$stmt = $conn->prepare("INSERT INTO tickets (machine_name, room, status, comment, requested_by) VALUES (:MID, :room, 'Unassigned', :comment, :requested);");
		$stmt->execute(
			array(
				':MID' => $machine_id, //Machine ID
				':room' => $room, //Room
				':comment' => $comments, //Comments
				':requested' => $loggedIn //id of requester
			)
		);

		//After successful creation, redirect the page
		//Return the success response
		echo json_encode(
			array(
				"msg" => "200 OK"
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
