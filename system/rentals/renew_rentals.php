<?php
	validatePermission(array(0, 1));
	$p_rental           = $_POST['rental_id'];
	$p_client           = $_POST['client'];
	$p_start_date       = $_POST['start_date'];
	$p_end_date         = $_POST['end_date'];
	$p_page_cap         = trim($_POST['page_cap']);
	$p_page_cap_price   = trim($_POST['page_cap_price']);
	$p_page_distinction = $_POST['page_distinction'];
	$p_bw_price         = trim($_POST['bw_price']);
	$p_color_price      = trim($_POST['color_price']);
	$p_mlt              = $_POST['mlt'];
	$p_total_meter      = $_POST['total_meter'];
	$p_color_meter      = $_POST['color_meter'];

	// arrumando os preços
	$p_bw_price = str_replace('.', '', $p_bw_price);
	$p_color_price = str_replace('.', '', $p_color_price);
	$p_page_cap_price = str_replace('.', '', $p_page_cap_price);
	
	$p_bw_price = str_replace(',', '.', $p_bw_price);
	$p_color_price = str_replace(',', '.', $p_color_price);
	$p_page_cap_price = str_replace(',', '.', $p_page_cap_price);
	
	if (!validateText(4,4,$p_client)){
		$title = "Erro";
		$message = "O campo \"Cliente\" foi preenchido incorretamente.";
	} else if (!validateDate($p_start_date)){
		$title = "Erro";
		$message = "O campo \"Data de início\" foi preenchido incorretamente.";
	} else if (!validateDate($p_end_date)){
		$title = "Erro";
		$message = "O campo \"Data de fim\" foi preenchido incorretamente.";
	} else if (strtotime(str_replace('/', '-', $p_start_date)) > strtotime(str_replace('/', '-', $p_end_date))){
		$title = "Erro";
		$message = "A data de início deve ser antes da data de fim.";
	} else if (!validateNumbers(1, 5, $p_page_cap)) {
		$title = "Erro";
		$message = "O campo \"Franquia\" foi preenchido incorretamente.";
	} else if ($p_page_distinction && $p_page_cap){
		$title = "Erro";
		$message = "Não pode haver franquia com distinção de tipo de página.";
	} else if (!validatePrice(1, 7, $p_page_cap_price)){
		$title = "Erro";
		$message = "O campo \"Preço da franquia\" foi preenchido incorretamente.";
	} else if (!validatePrice(1, 4, $p_bw_price)){
		$title = "Erro";
		$message = "O campo \"Preço da página monocromática excedida\" foi preenchido incorretamente.";
	} else if (!validatePrice(1, 4, $p_color_price) && $p_page_distinction==1){
		$title = "Erro";
		$message = "O campo \"Preço da página colorida excedida\" foi preenchido incorretamente.";
	} else {
		// verificando impressoras duplas
		$duplicate_mlts = false;
		foreach (array_count_values($p_mlt) as $mlt){
			if ($mlt != 1){
				$duplicate_mlts = true;
			}
		}
		
		if (!$duplicate_mlts) {
			
			// finalizando o aluguel
			$table = "rentals";
			$data = array(
				'status' => '2'
			);
			$condition = "id=" . $p_rental;
			$upd_rentals = db_update($table, $data, $condition);
			
			if ($upd_rentals) {
				// arrumando o status das impressoras
				$sel_printers = "SELECT * FROM printers INNER JOIN rentals_has_printers ON rentals_has_printers.printers_mlt=printers.mlt WHERE rentals_has_printers.rentals_id=" . $p_rental;
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
				
				// arrumando os valores de data
				$date_array = explode('/', $p_start_date);
				$p_start_date = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
				$date_array = explode('/', $p_end_date);
				$p_end_date = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
				// inserindo o aluguel no banco
				$table = 'rentals';
				$data = array(
					'clients_id' => $p_client,
					'page_distinction' => $p_page_distinction ?: '0', // seta como 0 se for nulo
					'bw_price' => $p_bw_price,
					'start_date' => $p_start_date,
					'end_date' => $p_end_date,
					'status' => '0',
					'color_price' => $p_page_distinction ? $p_color_price : '0',
					'page_cap' => $p_page_cap,
					'page_cap_price' => $p_page_cap_price
				);
				$ins_rentals = db_add($table, $data);
				if ($ins_rentals) {
					// recebendo o id do aluguel
					$rental_id = $db_connection->lastInsertId();
					// recebendo o número de detalhes
					$n_details = count($p_mlt);
					for ($c = 0; $c < $n_details; $c++) {
						if (!validateNumbers(1, 4, $p_mlt[$c]) || !validateNumbers(1, 6, $p_total_meter[$c]) || (!validateNumbers(1, 6, $p_total_meter[$c]) && $p_page_distinction)) {
							$title = "Erro";
							$message = "Linha " . ($c + 1) . " preenchida incorretamente.";
							break;
						} else if ($p_color_meter[$c] > $p_total_meter[$c]) {
							$title = "Erro";
							$message = "O medidor colorido não pode ser maior do que o medidor total.";
							break;
						} else {
							
							$table = "rentals_has_printers";
							$data = array(
								'rentals_id' => $rental_id,
								'printers_mlt' => $p_mlt[$c],
								'initial_total_meter' => $p_total_meter[$c],
								'initial_color_meter' => $p_color_meter[$c]
							);
							$ins_printers = db_add($table, $data);
							if ($ins_printers) {
								
								$table = 'printers';
								$data = array(
									'status' => 1
								);
								$condition = 'mlt=' . $p_mlt[$c];
								
								$upd_printers = db_update($table, $data, $condition);
								if ($upd_printers) {
									$title = "Sucesso";
									$message = "Aluguel renovado com sucesso.";
								} else {
									$title = "Erro";
									$message = "Erro ao mudar o status da impressora.";
									break;
								}
								
							} else {
								$title = "Erro";
								$message = "Erro na inserção de impressora.";
								break;
							}
							
						}
					}
					
				} else {
					$title = "Erro";
					$message = "Erro na inserção do novo aluguel.";
				}
			} else {
				$title = "Erro";
				$message = "Erro na finalizaçao do aluguel antigo.";
			}
		} else {
			$title = "Erro";
			$message = "Não se pode cadastrar a mesma impressora mais de uma vez.";
		}
	}

	?>
	<div class="center_box">
		<h1><?php echo $title; ?></h1>
		<?php echo $message; ?>
		<br/><a href="?folder=rentals/&file=admin_view_rentals&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
	</div>
