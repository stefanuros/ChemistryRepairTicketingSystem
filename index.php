<?php
//This script will be the first thing to run. It will check if someone is logged
// in already and will send them to the right page
//Written by stefan

include_once '../authenticate.php';

//If user is not authenticated
if(!$auth)
{
	//Send them to the login page
	//TODO redirect to the php version
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
		//TODO redirect to the proper page
		header("Location: login.html");
		die();
	}
	else
	{
		//Send them to the user home
		//TODO redirect to the proper page
		header("Location: login.html");
		die();
	}
}


?>
