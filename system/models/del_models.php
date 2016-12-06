<?php validatePermission(array(0, 1));
	$p_id = $_POST['id'];
	
	if($p_id==""){
		$message = "Modelo inexistente";
	}else{
		$sel_printers = "SELECT * FROM printers WHERE MD5(models_id)='".$p_id."' ";
		$sel_printers_prepared = $db_connection->prepare($sel_printers);
		$sel_printers_prepared->execute();
		if($sel_printers_prepared->rowCount()>0){
			$title = "Erro";
			$message = "Existem registros de impressora associados com esse registro; exclua-os e tente novamente.";
		}else{
			$table = "models";
			$condition = "MD5(id)='".$p_id."'";
			$del_models = db_delete($table, $condition);
			if($del_models){
				$title = "Sucesso";
				$message = "Modelo removido com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na exclusão de modelo.";
			}
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=models/&file=fmins_models&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>