<?php
	validatePermission(array(0, 1));
	$g_mlt = $_GET['mlt'];
	$g_rental_id = $_GET['id'];
	$table = "printers";
	$data = array(
		'status' => '1'
	);
	$condition = "mlt=".$g_mlt;

	$upd_printers = db_update($table, $data, $condition);

	$table = "rentals_has_printers";
	$data = array(
		'final_total_meter' => NULL,
		'final_color_meter' => NULL
	);
	$condition = "rentals_id=".$g_rental_id." AND printers_mlt=".$g_mlt;

	$upd_rentals_has_printers = db_update($table, $data, $condition);

	if($upd_printers && $upd_rentals_has_printers){
		$title = "Sucesso";
		$message = "Impressora retornada com sucesso.";
	} else {
		$title = "Erro";
		$message = "Erro no retorno da impressora.";
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=rentals/&file=admin_view_rentals&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
