<?php
//This script will be the first thing to run. It will check if someone is logged
// in already and will send them to the right page
//Written by stefan

$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];

include_once $path . '/includes/authenticate.php';

//If user is not authenticated
if(!$auth)
{
	//Send them to the login page
	header("Location: login.html");
	//idk what die() does but its suggested
	die();
}
else
{
	//Check if theyre an admin
	if($isAdmin)
	{
		//Send them to the admin home
		header("Location: showTicketsPage.php");

		die();
	}
	else
	{
		//Send them to the user home
		header("Location: createTicketPage.php");
		die();
	}
}


?>
