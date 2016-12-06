<?php validatePermission(array(0, 1));
	$p_id = $_POST['id'];

	if($p_id==""){
		$title = "Erro";
		$message = "Essa categoria não existe.";
	}else{
		$sel_solicitations = "SELECT * FROM solicitations WHERE MD5(categories_id)='".$p_id."' ";
		$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
		$sel_solicitations_prepared->execute();
	if($sel_solicitations_prepared->rowCount()>0){
		$title = "Erro";
		$message = "Existem registros de solicitação associados com esse registro; finalize-os e tente novamente.";
	}else{
		$table = "categories";
		$condition = "MD5(id)='".$p_id."'";
		$del_categories = db_delete($table, $condition);
		if(!$del_categories) {
			$title = "Erro";
			$message = "Erro na exclusão de categoria.";
		}else{
			$title = "Sucesso";
			$message = "Categoria removida com sucesso.";
		}
	}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=categories/&file=fmins_categories&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>

