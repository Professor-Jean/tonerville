<?php
	validatePermission(array(0));
	$p_name = trim($_POST['name']);
	$p_password = trim($_POST['password']);
	$salt = "vU782bUv034n1vU0qjGF";
	if(!validateText(1,16,$p_name)){
		$title = "Erro";
		$message = "O campo \"Nome de usuário\" foi preenchido incorretamente.";
	}else if(!validateText(1,32,$p_password)) {
		$title = "Erro";
		$message = "O campo \"Senha\" foi preenchido incorretamente.";
	}else {

		$sel_admin = "SELECT * from users WHERE username='" .$p_name . "'";
		$sel_admin_prepared = $db_connection->prepare($sel_admin);
		$sel_admin_prepared->execute();

		if($sel_admin_prepared->rowCount()==0){
			$table = "users";
			$data = array(
					'username' => $p_name,
					'password' => md5($salt.$p_password),
					'permission' => '0'
			);
			$ins_admin = db_add($table, $data);
			if($ins_admin){
				$title = "Sucesso";
				$message = "Administrador inserido com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro na inserção de Administrador.";
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
				<br><a href="?folder=users/admin/&file=fmins_admin&ext=php"><img height="15" src="../layout/images/back.png"/>Voltar</a>
</div>