<?php
	validatePermission(array(0, 1));
	$p_id = $_POST['hidid'];
	$p_mlt = $_POST['hidmlt'];
	$p_total_meter = $_POST['total_meter'];
	$p_color_meter = $_POST['color_meter'];

	
	$n_details = count($p_mlt);
	for ($c = 0; $c < $n_details; $c++){
		$sel_rentals_has_printers = "SELECT rentals_has_printers.* FROM rentals_has_printers INNER JOIN rentals ON rentals_has_printers.rentals_id=rentals.id WHERE rentals.id='".$p_id."' AND rentals_has_printers.printers_mlt='".$p_mlt[$c]."'";
		$sel_rentals_has_printers_prepared =  $db_connection->prepare($sel_rentals_has_printers);
		$sel_rentals_has_printers_prepared->execute();
		$sel_rentals_has_printers_data = $sel_rentals_has_printers_prepared->fetch();
		if (!validateNumbers(1, 6, $p_total_meter[$c])){
			$title = "Erro";
			$message = "O campo \"Medidor Total\" foi preenchido incorretamente.";
			break;
		}else if(!validateNumbers(0, 6, $p_color_meter[$c])){
			$title = "Erro";
			$message = "O campo \"Medidor Colorido\" foi preenchido incorretamente.";
			break;
		}else if ($p_color_meter[$c] > $p_total_meter[$c]){
			$title = "Erro";
			$message = "O medidor colorido não pode ser maior do que o medidor total.";
			break;
		}else if($p_color_meter[$c]<$sel_rentals_has_printers_data['initial_color_meter']){
		$title = "Erro";
		$message = "O campo \"Medidor Colorido\" deve ser maior que o medidor colorido do início do aluguel.";
		break;
		}else if($p_total_meter[$c]<$sel_rentals_has_printers_data['initial_total_meter']){
		$title = "Erro";
		$message = "O campo \"Medidor Total\" deve ser maior que o medidor total do início do aluguel.";
		break;
		}else{
					$table = "rentals_has_printers";
					$data = array(
						'final_total_meter' => $p_total_meter[$c],
						'final_color_meter' => $p_color_meter[$c]
					);
					$condition = "printers_mlt='".$p_mlt[$c]."' and rentals_id='".$p_id."'";
					$upd_rentals_has_printers = db_update($table, $data, $condition);
					if($upd_rentals_has_printers){
						$title = "Sucesso";
						$message = "Dados do relatório inserido com sucesso.";
					}else{
						$title = "Erro";
						$message = "Erro na inserção de dados do relatório.";
					}
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php
		if($title=='Sucesso'){
			$back = "?folder=rentals/&file=finalreport_rentals&ext=php&id=".$p_id;
		}else{
			$back = "?folder=rentals/&file=insertdata_rentals&ext=php&id=".$p_id;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>