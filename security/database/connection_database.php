<?php

	include "configuration_database.php";

	try{
		$db_connection = new PDO("mysql:host=".$server.";dbname=".$db.";charset=utf8", $user, $password);
	} catch (PDOexception $e) {
		die ("Erro ao conectar com o banco de dados: ".$e->getMessage());
	}
