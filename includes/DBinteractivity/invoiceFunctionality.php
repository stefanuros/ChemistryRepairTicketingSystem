<?php
// Script to set the parts list
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
if(!$auth || !$isAdmin)
{
	// User is not authenticated
	//Send an error message that was created in authenticate.php
	echo $jsonMsg;
	exit();
}

include_once $path . '/includes/connect.php';

if(isset($_POST["func"]))
{
	//Add a new part
	if($_POST["func"] == "ADD")
	{
		// Prepare the select statement
		$stmt = $conn->prepare('INSERT INTO parts_list VALUES (NULL, :tick, DEFAULT, DEFAULT, DEFAULT);'); 
		// Execute it
		$stmt->execute(array(
			':tick' => $_POST['ticket_id']
		));

		// Prepare the select statement
		$stmt = $conn->prepare('SELECT MAX(part_id) max_id FROM parts_list WHERE ticket_id = :tick;'); 
		// Execute it
		$stmt->execute(array(
			':tick' => $_POST['ticket_id']
		));
		//Get the result from the query
		$resp = $stmt->fetch(PDO::FETCH_ASSOC);

		//return the id
		echo $resp["max_id"];
	}
	else if($_POST["func"] == "UPDATE")
	{
		$stmt = $conn->prepare('UPDATE parts_list SET item_description=:name, quantity=:quantity, price=:price WHERE part_id=:part_id AND ticket_id=:tick;'); 
		$stmt->execute(array(
			':tick' => $_POST['ticket_id'],
			':part_id' => $_POST['part_id'],
			':name' => $_POST['name'],
			':quantity' => $_POST['quantity'],
			':price' => $_POST['price']
		));
	}
	else if($_POST["func"] == "DELETE")
	{
		// Prepare the select statement
		$stmt = $conn->prepare('DELETE FROM parts_list WHERE ticket_id = :tick AND part_id = :part_id;'); 
		// Execute it
		$stmt->execute(array(
			':tick' => $_POST['ticket_id'],
			':part_id' => $_POST['part_id']
		));
	}
}
?>
