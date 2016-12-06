<?php
	validatePermission(array(0, 1));
	$p_mlt = trim($_POST['mlt']);
	$p_model = trim($_POST['model']);

	if(!validateNumbers(3,3,$p_model)){
		$title = "Erro";
		$message = "O campo \"Modelo\" foi preenchido incorretamente.";
	}else{
		
		$table = "printers";
		$data = array(
			'models_id' => $p_model
		);
		$condition = "mlt=".$p_mlt;
		$upd_printers = db_update($table, $data, $condition);
		if($upd_printers){
			$title = "Sucesso";
			$message = "Impressora alterada com sucesso.";
		}else{
			$title = "Erro";
			$message = "Erro na alteração de impressora.";
		}
		
	}
	?>
	<div class="center_box">
		<h1><?php echo $title; ?></h1>
		<?php echo $message; ?>
		<?php
			if($title=='Sucesso'){
				$back = "?folder=printers/&file=fmins_printers&ext=php";
			}else{
				$back = "?folder=printers/&file=fmupd_printers&ext=php&mlt=".$p_hidmlt;
			}
		?>
		<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
	</div>
