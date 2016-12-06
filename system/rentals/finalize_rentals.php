<?php
	validatePermission(array(0, 1));

	$g_id = $_GET['id'];

	$sel_rentals = "SELECT rentals.status, printers.mlt FROM rentals INNER JOIN rentals_has_printers ON rentals_has_printers.rentals_id = rentals.id INNER JOIN printers ON rentals_has_printers.printers_mlt = printers.mlt WHERE rentals.id = '".$g_id."'";
	$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
	$sel_rentals_prepared->execute();
	$sel_rentals_data = $sel_rentals_prepared->fetch();

	if($sel_rentals_data['status']!=1) {
		$title = "Erro";
		$message = "Este não é um aluguel válido para ser finalizado.";
	}else{
		// arrumando o status das impressoras
		$sel_printers = "SELECT * FROM printers INNER JOIN rentals_has_printers ON rentals_has_printers.printers_mlt=printers.mlt WHERE rentals_has_printers.rentals_id=" . $g_id;
		$sel_printers_prepared = $db_connection->prepare($sel_printers);
		$sel_printers_prepared->execute();
		
		while ($sel_printers_data = $sel_printers_prepared->fetch()) {
			$table = "printers";
			$data = array(
				'status' => '0'
			);
			$condition = "mlt=" . $sel_printers_data['mlt'];
			db_update($table, $data, $condition);
		}
		// finalizando o aluguel
		$table = "rentals";
		$data = array(
			'status' => 2
		);
		$condition = "id=" . $g_id;
		$upd_rentals = db_update($table, $data, $condition);

		if($upd_rentals){
			$title = "Sucesso";
			$message = "Aluguel finalizado com sucesso.";
		}else{
			$title = "Erro";
			$message = "Erro na finalização de aluguel.";
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php
			$back = "?folder=rentals/&file=admin_view_rentals&ext=php";
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>

