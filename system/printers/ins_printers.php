<?php
	validatePermission(array(0, 1));
	$p_mlt = trim($_POST['mlt']);
	$p_model = trim($_POST['model']);

	if(!validateNumbers(1,4,$p_mlt)){
		$title = "Erro";
		$message = "O campo \"MLT\" foi preenchido incorretamente.";
	}else if(!validateNumbers(3,3,$p_model)){
		$title = "Erro";
		$message = "O campo \"Modelo\" foi preenchido incorretamente.";
	}else{
		$sel_printers = "SELECT * FROM printers WHERE mlt='".$p_mlt."' ";
		$sel_printers_prepared = $db_connection->prepare($sel_printers);
		$sel_printers_prepared->execute();

		if($sel_printers_prepared->rowCount()==0){
			$table = "printers";
			$data = array(
				'mlt' => $p_mlt,
				'models_id' => $p_model,
				'status' => "0"
			);
			$ins_printers = db_add($table, $data);
			if($ins_printers){
				$title = "Sucesso";
				$message = "Impressora inserida com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na inserção de impressora.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de impressora já existe.";
		}
	}
	?>
	<div class="center_box">
		<h1><?php echo $title; ?></h1>
		<?php echo $message; ?>
		<br><a href="?folder=printers/&file=fmins_printers&ext=php"><img src="../layout/images/back.png" height="20"> Voltar</a>
	</div>
