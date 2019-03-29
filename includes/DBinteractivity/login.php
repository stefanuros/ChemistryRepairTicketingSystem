<?php
// Script to login using active directory
//Once login is authenticated, open a cookie
//Written by Stefan

// Getting the path to the folder
$topLayer = str_replace($_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", $topLayer)[1];

//php-jwt related files
// include_once '../libs/php-jwt-master/src/BeforeValidException.php';
// include_once '../libs/php-jwt-master/src/ExpiredException.php';
// include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
// include_once '../libs/php-jwt-master/src/JWT.php';
// use \Firebase\JWT\JWT;

// include_once '../config.php';
// include_once '../connect.php';

include_once $path . '/includes/libs/php-jwt-master/src/BeforeValidException.php';
include_once $path . '/includes/libs/php-jwt-master/src/ExpiredException.php';
include_once $path . '/includes/libs/php-jwt-master/src/SignatureInvalidException.php';
include_once $path . '/includes/libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once $path . '/includes/config.php';
include_once $path . '/includes/connect.php';

//Check if the username and password are set
if (isset($_POST['username']) && isset($_POST['password']))
{
	//Get the username and password from the form
	$username = $_POST['username'];
	$password = $_POST['password'];

	//Check the credentials
	//Define who you are looking for in the server
	$ldap_dn = "uid=" . $username . "," . $dc;
	
	//Connect to active directory
	$ldap_con = ldap_connect($adurl);
	ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
	
	//Bind to the active directory
	// @ suppesses the invalid credentials message
	$correctCred = @ldap_bind($ldap_con, $ldap_dn, $password);


	//Checking if cookies are enabled
	setcookie("test_cookie", "test", time() + 3600, '/');
	if(count($_COOKIE) > 0)
	{
		//If cookies are enabled, delete the test cookie
		setcookie("test_cookie", "", time() - 3600);

		//If the credentials are correct
		if($correctCred)
		{

			//Check if they already exist in our db
			$user = getUser($conn, $username);

			
			//If $user is empty, the user is new, so create a row for them
			if(!$user)
			{
				//Get the user info from active directory
				//Set the filter
				$filter = "(uid=$username)";
				//Set the scope and search
				$result = ldap_search($ldap_con, $dc, $filter) or exit("Unable to search");
				$entries = ldap_get_entries($ldap_con, $result);
				
				//Create unique user id with no prefix and extra entropy
				$uid = uniqid('', true);

				//Create the user in the database
				createUser($conn, $entries[0], $username, $uid);
				
				//If a new user is created, theyre not an admin by default
				$isAdmin = false;
			}
			else
			{
				//Is the user an admin
				$isAdmin = $user['admin'];
				$uid = $user['unique_id'];
			
				//Get the user info from active directory
				//Set the filter
				$filter = "(uid=$username)";
				//Set the scope and search
				$result = ldap_search($ldap_con, $dc, $filter) or exit("Unable to search");
				$entries = ldap_get_entries($ldap_con, $result);

				// update the user info
				updateUser($conn, $entries[0], $username);
			}

			//Create an authentication token
			$iat = time(); //Isued at
			$jti = uniqid(); //Unique token id
			$iss = 'chemRepair'; //Token issuer
			$nbf = $iat; //not before time
			$exp = $nbf + (60*60*24*30); // expires after 30 days

			//Creating the token array
			$token = array(
				"iss" => $iss,
				"iat" => $iat,
				"nbf" => $nbf,
				"jti" => $jti,
				"exp" => $exp,
				"data" => array(
					"uid" => $uid, //User ID
					"isAdmin" => $isAdmin //boolean on whether user is an admin
				)
			);

			//Generate the jwt
			$jwt = JWT::encode($token, $jwtkey);

			//put the jwt into a cookie
			//Cookie expires in 31 days
			//TODO make the cookie httponly when https is set up
			// ^ this prevents XSS attacks on the jwt
			setcookie("jwt", $jwt, time() + (60*60*24*31), '/');

			//Return the success response
			echo json_encode(
				array(
					"msg" => "200 OK",
					"isAdmin" => $isAdmin
				)
			);
		}
		else
		{
			//Return the failure response
			echo json_encode(
				array(
					"msg" => "401 Unauthorized",
					"err" => "Incorrect username or password"
				)
			);
		}	
	}
	else
	{
		//Cookies are not enabled
		echo json_encode(
			array(
				"msg" => "403 Forbidden",
				"err" => "Cookies not enabled"
			)
		);
	}
}
else
{
	//Return the failure response
	echo json_encode(
		array(
			"msg" => "400 Bad Request",
			"err" => "Username or Password not available"
		)
	);
}

//Function to check if the user exists in the database
//Returns the user info
function getUser($conn, $username)
{
	// Get the row back for the user
	$stmt = $conn->prepare("SELECT * FROM profile WHERE username=:username LIMIT 1;");
	$stmt->execute(
		array(
			':username' => $username
		)
	);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	return $user;
}


//Function for creating a user in the database
//Takes a response from active directory
function createUser($conn, $result, $username, $uid)
{
	//Get the first name
	$fn = ( isset($result["cn"]) ? explode(' ', $result['cn'][0])[0] : ' ' );

	//Get the last name
	$sn = ( isset($result["sn"]) ? $result["sn"][0] : ' ' );

	//Get the mail
	$mail = ( isset($result["mail"]) ? $result["mail"][0] : ' ' );

	//Create new user row
	$stmt = $conn->prepare("INSERT INTO profile (username, email, admin, first_name, last_name, unique_id) VALUES (:username, :email, 0, :fname, :lname, :uid);");
	$stmt->execute(
		array(
			':username' => $username,
			':email' => $mail,
			':fname' => $fn,
			':lname' => $sn,
			':uid' => $uid,
		)
	);
}

// Function to update the info of the user when they log in
function updateUser($conn, $result, $username)
{
	//Get the first name
	$fn = ( isset($result["cn"]) ? explode(' ', $result['cn'][0])[0] : ' ' );

	//Get the last name
	$sn = ( isset($result["sn"]) ? $result["sn"][0] : ' ' );

	//Get the mail
	$mail = ( isset($result["mail"]) ? $result["mail"][0] : ' ' );

	//Create new user row
	$stmt = $conn->prepare("UPDATE profile SET email=:email, first_name=:fname, last_name=:lname WHERE username = :username;");
	$stmt->execute(
		array(
			':username' => $username,
			':email' => $mail,
			':fname' => $fn,
			':lname' => $sn
		)
	);
}

?>
