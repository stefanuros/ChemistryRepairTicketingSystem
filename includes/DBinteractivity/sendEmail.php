<?php

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

// If emails are not activated, exit
if(!$activateEmail)
{
	echo "Emails deactived. Check the config file";
	exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $path . '/includes/libs/PHPMailer/src/Exception.php';
require $path . '/includes/libs/PHPMailer/src/PHPMailer.php';
require $path . '/includes/libs/PHPMailer/src/SMTP.php';

$mail = new PHPMailer();

if(	isset($_GET['r']) &&
	isset($_GET['s']) &&
	isset($_GET['b']))
{
	try
	{
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth = true;
		$mail->Username = $eUser . "@gmail.com";
		$mail->Password = $ePass;
		$mail->SMTPSecure = "ssl";
		$mail->Port = "465";
		
		$recipient = $_GET['r'];
		$subject = $_GET['s'];
		$body = $_GET['b'];
		
		// Recipents
		$mail->SetFrom('no-reply@QueensChemistryRepair.com');
		$mail->AddAddress($recipient);
		
		// Content
		$mail->isHTML();
		$mail->Subject = $subject;
		$mail->Body = $body;
		
		$mail->Send();

		echo "200 OK";
	}
	catch(Exception $e)
	{
		echo "Error: " . $e;
	}
}
else
{
	echo "Error: Missing expected GET";
}

?>
