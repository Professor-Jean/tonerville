<?php
	validatePermission(array(0, 1));
	$p_name = trim($_POST['name']);

	if(!validateText(1,20,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else{
		$sel_brands = "SELECT * FROM brands WHERE name='".$p_name."'";
		$sel_brands_prepared = $db_connection->prepare($sel_brands);
		$sel_brands_prepared->execute();
		if($sel_brands_prepared->rowCount()==0){
			$table = "brands";
			$data = array(
					'name' => $p_name,
			);
			$ins_brands = db_add($table, $data);
			if($ins_brands){
				$title = "Sucesso";
				$message = "Marca inserida com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na inserção de marca.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de marca já existe.";
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=brands/&file=fmins_brands&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
