<?php
	
	if (!isSet($_SESSION['session_id'])){
		header("Location: ".BASE_URL."security/authentication/logout_authentication.php");
		exit;
	} else if ($_SESSION['session_id'] != session_id()){
		header("Location: ".BASE_URL."security/authentication/logout_authentication.php");
		exit;
	}