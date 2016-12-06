<?php
	
	$server_name = $_SERVER['SERVER_NAME'];
	$project_name = "projetointegrador";
	define("BASE_URL", "http://".$server_name.DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR);
	include "authentication/session_authentication.php";
	include "authentication/permission_authentication.php";