<?php

	function validatePermission($permission){

		if(isset($permission[1])){

			if ($_SESSION['permission'] != $permission[0] && $_SESSION['permission'] != $permission[1]){
				header("Location: ".BASE_URL."system/main_system.php?msg=Você não tem permissão para ver essa página.");
				exit;
			}

		} else {

			if ($_SESSION['permission'] != $permission[0]){
				header("Location: ".BASE_URL."system/main_system.php?msg=Você não tem permissão para ver essa página.");
				exit;
			}

		}

	}