<?php validatePermission(array(0, 1));
	$g_id = $_GET['id'];
	$sel_rentals = "SELECT * FROM rentals WHERE id='".$g_id."'";
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
	$sel_rentals_data = $sel_rentals_prepared->fetch();
	$table = "rentals";
	$data = array(
		'status' => '1'
	);
	$condition = "id=".$g_id;
	$upd_rentals = db_update($table, $data, $condition);
	if($upd_rentals){
		$title = "Sucesso";
		$message = "Relatório confirmado com sucesso.";
	}else{
		$title = "Erro";
		$message = "Erro na confirmação de relatório.";
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=rentals/&file=admin_view_rentals&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
