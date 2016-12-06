<?php
	validatePermission(array(0, 1));
	$p_id = $_POST['hidid'];
	$p_brand = trim($_POST['brand']);
	$p_name = trim($_POST['name']);
	
	if(!validateNumbers(1,2,$p_brand)){
		$title = "Erro";
		$message = "O campo \"Marca\" foi preenchido incorretamente.";
	}else if(!validateText(1,60,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else{
		$sel_models = "SELECT * FROM models WHERE name='".$p_name."' AND brands_id='".$p_brand."' AND id<>'".$p_id."'";
		$sel_models_prepared = $db_connection->prepare($sel_models);
		$sel_models_prepared->execute();
		if($sel_models_prepared->rowCount()==0){
			$table = "models";
			$data = array(
				'brands_id' => $p_brand,
				'name' => $p_name
			);
			$condition = "id='".$p_id."'";
			$upd_models = db_update($table, $data, $condition);
			if($upd_models){
				$title = "Sucesso";
				$message = "Modelo alterado com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na alteração de modelo.";
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
	<?php
		if($title=='Sucesso'){
			$back = "?folder=models/&file=fmins_models&ext=php";
		}else{
			$back = "?folder=models/&file=fmupd_models&ext=php&id=".$p_id;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>

