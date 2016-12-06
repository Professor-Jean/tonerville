<?php
	validatePermission(array(0));
	$p_user = trim($_POST['username']);
	$p_password = trim($_POST['password']);
	$p_name = trim($_POST['name']);
	$p_id = trim($_POST['id']);
	$p_phone = trim($_POST['phone']);

	if(!validateText(1,16,$p_user)){
		$title = "Erro";
		$message = "O campo \"Usuário\" foi preenchido incorretamente.";
	}else if(!validateText(1,32,$p_password)){
		$title = "Erro";
		$message = "O campo \"Senha\" foi preenchido incorretamente.";
	}else if(!validateText(1,70,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
	}else {

		$sel_users = "SELECT * FROM users WHERE username='" . $p_user . "' AND id<>'".$p_id."'";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();

		if ($sel_users_prepared->rowCount() == 0){
			$table = "users";
			$data = array(
				'username' => $p_user,
				'password' => md5($salt.$p_password),
				'permission' => '1'
			);
			$ins_users = db_add($table, $data);
			$users_id = $db_connection->lastInsertId();

			if($ins_users){

				$table = "employees";
				$data = array(
					'users_id' => $users_id,
					'name' => $p_name,
					'phone' => $p_phone
				);
				$ins_employees = db_add($table, $data);

				if($ins_employees){
					$title = "Sucesso";
					$message = "Funcionário inserido com sucesso.";
				}else{
					$title = "Erro";
					$message = "Erro na inserção de funcionário.";

					$table = "users";
					$condition = "id='".$users_id."'";
					$del_users = db_delete($table, $condition);
				}
			}else{
				$title = "Erro";
				$message = "Erro na inserção de usuário.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de usuário já existe.";
		}
	}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br><a href="?folder=users/employees/&file=fmins_employees&ext=php"><img height="15" src="../layout/images/back.png"/>Voltar</a>
</div>
