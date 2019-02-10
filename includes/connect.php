<?php
//NEED TO INCLUDE CONFIG BEFORE INCLUDING CONNECT
//Written by stefan

try {
	//Connect to DB
	$conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
	//Don't emulate prepared statements and instead use actual prepared statements
	$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo "Connected successfully";
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();

	//Return the failure response
	echo json_encode(
		array(
			"msg" => "503 Service Unavailable",
			"err" => "Connection failed: " . $e->getMessage()
		)
	);
}
?>