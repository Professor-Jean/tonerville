<?php validatePermission(array(0, 1));
	$p_id = $_POST['id'];

	if($p_id==""){
		$message = "Marca inexistente";
	}else{
		$sel_models = "SELECT * FROM models WHERE MD5(brands_id)='".$p_id."' ";
		$sel_models_prepared = $db_connection->prepare($sel_models);
		$sel_models_prepared->execute();
		if($sel_models_prepared->rowCount()>0){
			$title = "Erro";
			$message = "Existem registros de modelo associados com esse registro; exclua-os e tente novamente.";
		}else{
			$table = "brands";
			$condition = "MD5(id)='".$p_id."'";
			$del_brands = db_delete($table, $condition);
			if($del_brands){
				$title = "Sucesso";
				$message = "Marca removida com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na exclusão de marca.";
			}
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=brands/&file=fmins_brands&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>