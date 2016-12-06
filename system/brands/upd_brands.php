<?php	validatePermission(array(0, 1));

	$p_id = $_POST['hidid'];
	$p_name = trim($_POST['name']);

	if(!validateText(1,20,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else{
		$sel_brands = "SELECT * FROM brands WHERE name='".$p_name."' and id<>'".$p_id."'";
		$sel_brands_prepared = $db_connection->prepare($sel_brands);
		$sel_brands_prepared->execute();
		if($sel_brands_prepared->rowCount()==0){
			$table = "brands";
			$data = array(
					'name' => $p_name,
			);
			$condition = "id='".$p_id."'";
			$upd_brands = db_update($table, $data, $condition);
			if($upd_brands){
				$title = "Sucesso";
				$message = "Marca alterada com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na alteração de marca.";
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
	<?php if($title=='Sucesso'){
		$back = "?folder=brands/&file=fmins_brands&ext=php";
	}else{
		$back = "?folder=brands/&file=fmupd_brands&ext=php&id=".$p_id;
	}?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>