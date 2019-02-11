<?php
// Script to logout of the application
//Written by Stefan

//Make the cookie empty
//TODO make this httponly
setcookie("jwt", "", time() - 3600);

//Redirect them to the login page
header("Location:./index.php");

?>
