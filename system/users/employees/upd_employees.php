<?php
	validatePermission(array(0));

	$g_employees_id = $_POST['hidid'];
	$p_users_id = $_POST['hiduserid'];
	$p_username = trim($_POST['username']);
	$p_password = trim($_POST['password']);
	$p_name = trim($_POST['name']);
	$p_phone = trim($_POST['phone']);

	if(!validateText(1,16,$p_username)){
		$title = "Erro";
		$message = "O campo \"Usuário\" foi preenchido incorretamente.";
		$back = "?folder=users/employees/&file=fmupd_employees&php";
	}else if(!validateText(1,32,$p_password)) {
		$title = "Erro";
		$message = "O campo \"Senha\" foi preenchido incorretamente.";
		$back = "?folder=users/employees/&file=fmupd_employees&php";
	}else if(!validateText(1,70,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome\" foi preenchido incorretamente.";
		$back = "?folder=users/employees/&file=fmupd_employees&php";
	}else{

		$sel_employees = "SELECT users.id, users.username, employees.name, employees.phone, users.password FROM employees INNER JOIN users ON employees.users_id=users.id WHERE users.id<>'".$p_users_id."' AND users.username='".$p_username."'";
		$sel_employees_prepared = $db_connection->prepare($sel_employees);
		$sel_employees_prepared->execute();
		$sel_employees_data = $sel_employees_prepared->fetch();

		$sel_users = "SELECT * FROM users WHERE username='" . $p_username . "' AND id<>'".$p_users_id."'";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();


		if($sel_users_prepared->rowCount()==0){
			$table = "users";
			$data = array(
				'username' => $p_username,
				'password' => md5($salt.$p_password)
			);
			$condition = "id='".$p_users_id."'";
			$upd_users = db_update($table, $data, $condition);
			if($upd_users){
				$table = "employees";
				$data = array(
					'name' => $p_name,
					'phone' => $p_phone
				);
				$condition = "id='".$g_employees_id."'";
				$upd_users = db_update($table, $data, $condition);
				if($upd_users){
					$title = "Sucesso";
					$message = "Funcionário alterado com sucesso.";
				}else {
					$title = "Erro";
					$message = "Erro na atualização de funcionário.";
				}
			}else{
				$title = "Erro";
				$message = "Erro na atualização de usuário.";
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
	<?php if($title=='Sucesso'){
		$back = "?folder=users/employees/&file=fmins_employees&ext=php";
	}else{
		$back = "?folder=users/employees/&file=fmupd_employees&ext=php&id=".$g_employees_id;
	}?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
