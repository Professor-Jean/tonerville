<?php
	validatePermission(array(0, 1));
	$p_name = trim($_POST['category']);
	$p_priority = trim($_POST['priority']);
	if(!validateText(1,45,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else if(!validateNumbers(1,1,$p_priority)){
		$title = "Erro";
		$message = "O campo \"Prioridade\" foi preenchido incorretamente.";
	}else if(($p_priority <> 1) AND ($p_priority <> 0) AND ($p_priority <> 2)) {
		$title = "Erro";
		$message = "A prioridade deve estar entre 0 e 2";
	}else{
		$sel_categories = "SELECT * from categories WHERE name='".$p_name."'";
		$sel_categories_prepared = $db_connection->prepare($sel_categories);
		$sel_categories_prepared->execute();

		if($sel_categories_prepared->rowCount()==0){
			$table = "categories";
			$data = array(
				'name' => $p_name,
				'priority' => $p_priority,
			);
			$ins_categories = db_add($table, $data);
			if($ins_categories){
				$title = "Sucesso";
				$message = "Categoria inserida com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na inserção de categoria.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de categoria já existe.";
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br><a href="?folder=categories/&file=fmins_categories&ext=php"><img height="15" src="../layout/images/back.png"/>Voltar</a>
</div>