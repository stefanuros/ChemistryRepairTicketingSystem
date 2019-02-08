<?php
//TODO Strip html special chars
// Script to add a ticket to the database

// include('secure.php'); Implement this maybe???

//Call the config file to get access to the needed info
include('../config.php');

//Connect to the database
include('../connect.php');

//Check if all the needed information is set
if(isset($_GET['machine_name']) && 
	isset($_GET['room']) && 
	isset($_GET['comments']))
{

	//TODO Set who is currently logged in. Get this from session
	//Setting who is currently logged in
	$loggedIn = "1";

	try 
	{
		//Insert into these columns, these values
		$stmt = $conn->prepare("INSERT INTO tickets (machine_name, room, status, comment, requested_by) VALUES (:MID, :room, 'Unassigned', :comment, :requested);");
		$stmt->execute(
			array(
				':MID' => $_GET['machine_name'], //Machine ID
				':room' => $_GET['room'], //Room
				':comment' => $_GET['comments'], //Comments
				':requested' => $loggedIn //id of requester
			)
		);

		//After successful creation, redirect the page
		$newURL = "../../testPage.html";
		header('Location: '.$newURL);

	} 
	catch(Exception $e)
	{
		echo $e;
	}
}
?>