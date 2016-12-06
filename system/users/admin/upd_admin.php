<?php
	validatePermission(array(0));

	$p_id = $_POST['hidid'];
	$p_name = trim($_POST['name']);
	$p_password = trim($_POST['password']);

	if(!validateText(1,16,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome de usuário\" foi preenchido incorretamente.";
		$back = "?folder=users/admin/&file=fmupd_admin&php";
	}else if(!validateText(1,32,$p_password)){
		$title = "Erro";
		$message = "O campo \"Senha\" foi preenchido incorretamente.";
		$back = "?folder=users/admin/&file=fmupd_admin&php";
	}else{
		$sel_users = "SELECT * FROM users WHERE username='".$p_name."' AND id<>'".$p_id."'";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();
		if($sel_users_prepared->rowCount()==0){
			$table = "users";
			$data = array(
					'username' => $p_name,
					'password' => md5($salt.$p_password)
			);
			$condition = "id='".$p_id."'";
			$upd_users = db_update($table, $data, $condition);
			if($upd_users){
				$title = "Sucesso";
				$message = "Usuário alterado com sucesso.";
			}else{
				$title = "Erro";
				$message = $condition;
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de administrador já existe.";
		}
	}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php if($title=='Sucesso'){
		$back = "?folder=users/admin/&file=fmins_admin&ext=php";
	}else{
		$back = "?folder=users/admin/&file=fmupd_admin&ext=php&id=".$p_id;
	}?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
