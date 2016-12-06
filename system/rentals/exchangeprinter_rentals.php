<?php
	validatePermission(array(0, 1));
	$p_old_mlt             = $_POST['old_mlt'];
	$p_page_distinction    = trim($_POST['page_distinction']);
	$p_rental_id           = $_POST['rental_id'];
	$p_final_total_meter   = trim($_POST['final_total_meter']);
	$p_final_color_meter   = trim(@$_POST['final_color_meter']);
	$p_mlt                 = $_POST['mlt'];
	$p_initial_total_meter = trim($_POST['initial_total_meter']);
	$p_initial_color_meter = trim(@$_POST['initial_color_meter']);
	
	if (!validateNumbers(1,6,$p_final_total_meter)){
		$title = "Erro";
		$message = "O campo \"Medidor total final\" foi preenchido incorretamente.";
	} else if (!validateNumbers(1,6,$p_final_color_meter) && $p_page_distinction==1){
		$title = "Erro";
		$message = "O campo \"Medidor colorido final\" foi preenchido incorretamente.";
	} else if (!validateNumbers(1,4,$p_mlt)){
		$title = "Erro";
		$message = "O campo \"MLT\" foi preenchido incorretamente.";
	} else if (!validateNumbers(1,6,$p_initial_total_meter)){
		$title = "Erro";
		$message = "O campo \"Medidor total inicial\" foi preenchido incorretamente.";
	} else if (!validateNumbers(1,6,$p_initial_color_meter) && $p_page_distinction==1){
		$title = "Erro";
		$message = "O campo \"Medidor colorido inicial\" foi preenchido incorretamente.";
	} else {
		
		$sel_printers = "SELECT * FROM rentals INNER JOIN rentals_has_printers ON rentals.id=rentals_has_printers.rentals_id WHERE rentals_has_printers.printers_mlt=".$p_old_mlt." AND rentals.id=".$p_rental_id;
		$sel_printers_prepared = $db_connection->prepare($sel_printers);
		$sel_printers_prepared->execute();
		$sel_printers_data = $sel_printers_prepared->fetch();
		if($p_final_total_meter < $sel_printers_data['initial_total_meter']){
			$title = "Erro";
			$message = "O campo \"Medidor total final\" deve ser maior que o medidor total inicial.";
		} else if (($p_final_color_meter < $sel_printers_data['initial_color_meter']) && $p_page_distinction){
			$title = "Erro";
			$message = "O campo \"Medidor colorido final\" deve ser maior que o medidor colorido inicial.";
		} else {
			
			if ($p_page_distinction == 1) {
				
				$table = "printers";
				$data = array(
					'status' => '2'
				);
				$condition = "mlt=" . $p_old_mlt;
				
				$upd_printers = db_update($table, $data, $condition);
				
				$table = "rentals_has_printers";
				$data = array(
					'final_total_meter' => $p_final_total_meter,
					'final_color_meter' => $p_final_color_meter
				);
				$condition = "rentals_id=" . $p_rental_id . " AND printers_mlt=" . $p_old_mlt;
				
				$upd_rentals_has_printers = db_update($table, $data, $condition);
				
				if ($upd_printers && $upd_rentals_has_printers) {
					
					$table = "rentals_has_printers";
					$data = array(
						'rentals_id' => $p_rental_id,
						'printers_mlt' => $p_mlt,
						'initial_total_meter' => $p_initial_total_meter,
						'initial_color_meter' => $p_initial_color_meter
					);
					
					$ins_rentals_has_printers = db_add($table, $data);
					
					$table = "printers";
					$data = array(
						'status' => '1'
					);
					$condition = "mlt=" . $p_mlt;
					
					$upd_printers = db_update($table, $data, $condition);
					
					if ($ins_rentals_has_printers && $upd_printers) {
						$title = "Sucesso";
						$message = "Impressora trocada com sucesso.";
					} else {
						$title = "Erro";
						$message = "Erro na inserção da nova impressora.";
					}
					
				} else {
					$title = "Erro";
					$message = "Erro na atualização da impressora antiga.";
				}
				
			} else {
				
				$table = "printers";
				$data = array(
					'status' => '2'
				);
				$condition = "mlt=" . $p_old_mlt;
				
				$upd_printers = db_update($table, $data, $condition);
				
				$table = "rentals_has_printers";
				$data = array(
					'final_total_meter' => $p_final_total_meter
				);
				$condition = "rentals_id=" . $p_rental_id . " AND printers_mlt=" . $p_old_mlt;
				
				$upd_rentals_has_printers = db_update($table, $data, $condition);
				
				if ($upd_printers && $upd_rentals_has_printers) {
					
					$table = "rentals_has_printers";
					$data = array(
						'rentals_id' => $p_rental_id,
						'printers_mlt' => $p_mlt,
						'initial_total_meter' => $p_initial_total_meter
					);
					
					$ins_rentals_has_printers = db_add($table, $data);
					
					$table = "printers";
					$data = array(
						'status' => '1'
					);
					$condition = "mlt=" . $p_mlt;
					
					$upd_printers = db_update($table, $data, $condition);
					
					if ($ins_rentals_has_printers && $upd_printers) {
						$title = "Sucesso";
						$message = "Impressora trocada com sucesso.";
					} else {
						$title = "Erro";
						$message = "Erro na inserção da nova impressora.";
					}
					
				} else {
					$title = "Erro";
					$message = "Erro na atualização da impressora antiga.";
				}
				
			}
		}
	}

	?>
	<div class="center_box">
		<h1><?php echo $title; ?></h1>
		<?php echo $message; ?>
		<br/><a href="?folder=rentals/&file=admin_view_rentals&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
	</div>
