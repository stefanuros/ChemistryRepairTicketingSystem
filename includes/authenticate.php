<?php
//Script to authenticate the currently logged in user
//Written by stefan

// required headers
header("Access-Control-Allow-Origin: http://localhost/chemTicket/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// files for decoding jwt will be here

//php-jwt related files
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once '../config.php';

//This is the error/success message created. It is not sent in this file in case
//this file is called by another php script. If it will be called by a js function,
// then that script should send the response code from in there. Look at createTicket.php
// for an example
$jsonMsg = "";

//This is information that the jwt gives
$uid = ""; //Unique user id
$isAdmin = ""; //whether the user is an admin or not
$auth = false; //Whether the authentication succeeded or not

//If the jwt cookie is set
if(isset($_COOKIE['jwt']))
{
	//Get the data from the cookie
	$data = $_COOKIE['jwt'];

	//If the cookie is empty
	if($data == "")
	{
		$jsonMsg = json_encode(
			array(
				"msg" => "401 Unauthorized",
				"err" => "Cookie Empty"
			)
		);
	}
	//If cookie is not empty
	else
	{
		try
		{
			//Get the jwt from the data
			$decoded = JWT::decode($data, $jwtkey, array('HS256'));

			//Return the success response
			//This will probably never be sent based on how I made the rest of the code
			//If this is true, other response messages are created related to where authenticate.php
			// is called. Only the error messages in this file will be sent
			$jsonMsg = json_encode(
				array(
					"msg" => "200 OK",
					"data" => json_encode(array($decoded->data)[0])
				)
			);
			// Get the results from the jwt
			$uid = array($decoded->data)[0]->uid;
			$isAdmin = array($decoded->data)[0]->isAdmin;

			$auth = true;
		}
		catch (Exception $e)
		{
			//If the decode fails
			$jsonMsg = json_encode(
				array(
					"msg" => "401 Unauthorized",
					"err" => "Token expired or was tampered with"
				)
			);
		}
	}
}
else
{
	//Return the failure response
	$jsonMsg = json_encode(
		array(
			"msg" => "400 Bad Request",
			"err" => "Cookie not set"
		)
	);
}

?>