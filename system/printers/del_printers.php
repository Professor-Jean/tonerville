<?php validatePermission(array(0, 1));
	$p_id = $_POST['id'];
	if($p_id==""){
		$message = "Impressora inexistente.";
	}else{
		// verificando integridade referencial
		$sel_rentals = "SELECT * FROM rentals_has_printers WHERE MD5(printers_mlt)='".$p_id."'";
		$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
		$sel_rentals_prepared->execute();

		if ($sel_rentals_prepared->rowCount()==0){
			$table = "printers";
			$condition = "MD5(mlt)='".$p_id."'";
			$del_videos = db_delete($table, $condition);

			if($del_videos){
				$title = "Sucesso";
				$message = "Impressora removida com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na exclusão de impressora.";
			}
		} else {
			$title = "Erro";
			$message = "Não é possível excluir uma impressora usada em um aluguel.";
		}

	}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br><a href="?folder=printers/&file=fmins_printers&ext=php"><img src="../layout/images/back.png" height="20"> Voltar</a>
</div>
