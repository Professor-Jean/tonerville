<?php

	$p_user = $_POST['username'];
	$p_password = $_POST['password'];

	if(!validateText(1, 16, $p_user)){
		$message = "O campo 'usuário' foi preenchido incorretamente.";
	} else if(!validateText(1, 30, $p_password)) {
		$message = "O campo 'senha' foi preenchido incorretamente.";
	} else {
			
		// verificando se os dados estão corretos
		$sel_users = "SELECT * FROM users WHERE username=:username AND password=:password";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->bindParam(':username', $p_user);
		$sel_users_prepared->bindParam(':password', md5($salt.$p_password));
		$sel_users_prepared->execute();
		
		if($sel_users_prepared->rowCount() == 1){
			
			$sel_users_data = $sel_users_prepared->fetch();
			session_start();
			$_SESSION['user_id'] = $sel_users_data['id'];
			$_SESSION['username'] = $sel_users_data['username'];
			$_SESSION['permission'] = $sel_users_data['permission'];
			$_SESSION['session_id'] = session_id();
		
			header("Location: system/main_system.php");
		
		} else {
			$message = "O campo 'usuário/senha' foi preenchido incorretamente.";
		}
	
	}
	
?>

<div class="auth_message">
	<h1>Erro de autenticação</h1>
	<h2><?php echo $message;?></h2>
</div>