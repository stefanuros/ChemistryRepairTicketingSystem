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

$jsonMsg = "";
$uid = "";
$isAdmin = "";
$auth = false;

//If the jwt cookie is set
if(isset($_COOKIE['jwt']))
{
	//Get the data from the cookie
	$data = json_decode($_COOKIE['jwt']);

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
			$decoded = JWT::decode($jwt, $jwtkey, array('HS256'));

			//Return the success response
			$jsonMsg = json_encode(
				array(
					"msg" => "200 OK",
					"data" => $decoded->data
				)
			);
			// Get the results from the jwt
			$uid = $decoded->data['uid'];
			$isAdmin = $decoded->data['isAdmin'];

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