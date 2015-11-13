<?php

	require_once("../configglobal.php");
	require_once("User.class.php");
	$database = "if15_rimo";
	session_start();
	//AB ühenduse
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	//uus instants klassist user
	$User = new User($mysqli);
	
?>