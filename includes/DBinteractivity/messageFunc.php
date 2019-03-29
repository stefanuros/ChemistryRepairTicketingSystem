<?php
// Script to do message stuff
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

if(isset($_POST["ticket_id"]))
{
	include_once $path . '/includes/connect.php';

	// Prepare the select statement
	$stmt = $conn->prepare('INSERT INTO messages_list VALUES (:t, NULL, :u, NULL, :m);'); 
	// Execute it
	$stmt->execute(array(
		':t' => $_POST['ticket_id'],
		':u' => $uid,
		':m' => $_POST['msg']
	));

	// Getting the name
	$stmt = $conn->prepare('SELECT concat(first_name, " ", last_name) as name FROM profile WHERE unique_id = :u'); 
	$stmt->execute(array(
		':u' => $uid
	));
	$name = $stmt->fetch(PDO::FETCH_ASSOC);

	echo $name['name'];

}

?>
