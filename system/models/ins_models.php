<?php
	validatePermission(array(0, 1));
	$p_brand = trim($_POST['brand']);
	$p_name = trim($_POST['name']);

	if(!validateNumbers(1,2,$p_brand)){
		$title = "Erro";
		$message = "O campo \"Marca\" foi preenchido incorretamente.";
	}else if(!validateText(1,60,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else{
		$sel_models = "SELECT * FROM models WHERE name='".$p_name."' and brands_id='".$p_brand."'";
		$sel_models_prepared = $db_connection->prepare($sel_models);
		$sel_models_prepared->execute();
		if($sel_models_prepared->rowCount()==0){
			$table = "models";
			$data = array(
				'brands_id' => $p_brand,
				'name' => $p_name
			);
			$ins_models = db_add($table, $data);
			if($ins_models){
				$title = "Sucesso";
				$message = "Modelo inserido com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na inserção de modelo.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de modelo já existe.";
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=models/&file=fmins_models&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
