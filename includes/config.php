<?php
//DATABASE INFO
//The name of the server
$servername = "localhost";
//The username for the server
$username = "root";
//The server password
$password = "";
//The database name
$dbName = "repairticketsystem";

//The active directory domain
$dc = "dc=example,dc=com";
//The active directory url
$adurl = "ldap.forumsys.com";

//The key for the JWT
$jwtkey = "B1A81966AD5E4724A649D3F227875";

// Email info
$eUser = "queenschemistryrepair";
$ePass = "chemistry2019";

// Whether email notifications should be enabled
$activateEmail = true;

// Whether errors should be displayed
$showErrors = false;
if($showErrors)
{
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
}
else
{
	error_reporting(0);
}

?>
