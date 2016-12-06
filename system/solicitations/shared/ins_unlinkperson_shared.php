<?php
	validatePermission(array(3));
	$p_user_id = $_POST['user_id'];
	$p_sol_id = $_POST['sol_id'];
	$p_password = $_POST['password'];

	if(!validateText(1, 30, $p_password)){
		$message = "O campo 'Senha' foi preenchido incorretamente.";
	}else{

		$sel_users = "SELECT password FROM users WHERE id=".$p_user_id;
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();
		$sel_users_data = $sel_users_prepared->fetch();

		if(md5($salt.$p_password)==$sel_users_data['password']){

			$table = "solicitations";
			$data = array(
				"users_id" => NULL,
				"status" => "0"
			);
			$condition = "id='" . $p_sol_id . "'";
			$upd_solicitations = db_update($table, $data, $condition);

			if ($upd_solicitations) {
				$title = "Sucesso";
				$message = "Usuário desvinculado com sucesso.";
			} else {
				$title = "Erro";
				$message = "Erro ao desvincular o usuário.";
			}

		} else {
			$title = "Erro";
			$message = "Senha incorreta.";
		}

	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php
		if($title=='Sucesso'){
			$back = "?folder=solicitations/shared/&file=shared_solicitations&ext=php";
		}else{
			$back = "?folder=solicitations/shared/&file=unlinkperson_shared&ext=php&user_id=".$p_user_id."&sol_id=".$p_sol_id;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>