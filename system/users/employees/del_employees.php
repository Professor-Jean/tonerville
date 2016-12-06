<?php
	validatePermission(array(0));

	$p_id = $_POST['id'];

	$sel_users = "SELECT users.id FROM employees INNER JOIN users ON employees.users_id=users.id WHERE md5(employees.id)='".$p_id."'";
	$sel_users_prepared = $db_connection->prepare($sel_users);
	$sel_users_prepared->execute();
	$sel_users_data = $sel_users_prepared->fetch();

	if($p_id==""){
		$title = "Erro";
		$message = "Esse funcionário não existe.";
	}else{
		$sel_solicitations = "SELECT * FROM solicitations WHERE users_id=".$sel_users_data['id'];
		$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
		$sel_solicitations_prepared->execute();
		
		if($sel_solicitations_prepared->rowCount()==0) {
			
			$table = "employees";
			$condition = "MD5(id)='" . $p_id . "'";
			$del_employees = db_delete($table, $condition);
			
			if ($del_employees) {
				$table = "users";
				$condition = "id='" . $sel_users_data['id'] . "'";
				$del_users = db_delete($table, $condition);
				
				if ($del_users) {
					$title = "Sucesso";
					$message = "Usuário removido com sucesso.";
				} else {
					$title = "Erro";
					$message = "Erro na remoção de usuário.";
				}
			} else {
				$title = "Erro";
				$message = "Erro na remoção de funcionário.";
			}
			
		} else {
			$title = "Erro";
			$message = "Existem solicitações vinculadas a esse funcionário.";
		}
	}
	?>
	<div class="center_box">
		<h1><?php echo $title; ?></h1>
		<?php echo $message; ?>
		<br/><a href="?folder=users/employees/&file=fmins_employees&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
	</div>
