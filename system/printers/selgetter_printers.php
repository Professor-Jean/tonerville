<?php
	include "../../security/database/connection_database.php";

	$g_id = $_GET['id'];
	$sel_model = "SELECT * FROM models WHERE brands_id=".$g_id;
	$sel_model_prepared = $db_connection->prepare($sel_model);
	$sel_model_prepared->execute();

	echo "<option value=''>Selecione...</option>";

	while($sel_model_data = $sel_model_prepared->fetch()){
		echo "<option value='".$sel_model_data['id']."'>".$sel_model_data['name']."</option>";
	}