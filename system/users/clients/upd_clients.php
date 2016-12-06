<?php
	validatePermission(array(0));
	$p_id = $_POST['hidid'];
	$p_usersid = trim($_POST['hidusersid']);
	$p_fname = trim($_POST['trade_name']);
	$p_rname = trim($_POST['rep_name']);
	$p_phone = trim($_POST['phone']);
	$p_email = trim($_POST['email']);
	$p_city = trim($_POST['city']);
	$p_neighborhood = trim($_POST['neighborhood']);
	$p_street = trim($_POST['street']);
	$p_number = trim($_POST['street_num']);
	$p_complement = trim($_POST['street_comp']);
	$p_cep = trim($_POST['cep']);
	$p_cnpj = trim($_POST['cnpj']);
	$p_ie = trim($_POST['ie']);
	$p_username = trim($_POST['username']);
	$p_password = trim($_POST['password']);
	if(!validateText(0,90,$p_fname)){
		$title = "Erro";
		$message = "O campo \"Nome fantasia\" foi preenchido incorretamente.";
	}else if(!validateText(1,70,$p_rname)){
		$title = "Erro";
		$message = "O campo \"Nome representante\" foi preenchido incorretamente.";
	}else if ($p_phone!="" && !validatePhone($p_phone)){
		$title = "Erro";
		$message = "O campo \"Telefone\" foi preenchido incorretamente.";
	}else if ($p_email!="" && !validateEmail($p_email)){
		$title = "Erro";
		$message = "O campo \"E-mail\" foi preenchido incorretamente.";
	}else if($p_email=="" && $p_phone==""){
		$title = "Erro";
		$message = "Não se pode deixar ambos o e-mail e o telefone vazios.";
	}else if(!validateText(1,40,$p_city)){
		$title = "Erro";
		$message = "O campo \"Cidade\" foi preenchido incorretamente.";
	}else if(!validateText(1,40,$p_neighborhood)){
		$title = "Erro";
		$message = "O campo \"Bairro\" foi preenchido incorretamente.";
	}else if(!validateText(1,100,$p_street)){
		$title = "Erro";
		$message = "O campo \"Logradouro\" foi preenchido incorretamente.";
	}else if(!validateNumbers(1,5,$p_number)){
		$title = "Erro";
		$message = "O campo \"Número\" foi preenchido incorretamente.";
	}else if(!validateText(0,30,$p_complement)){
		$title = "Erro";
		$message = "O campo \"Complemento\" foi preenchido incorretamente.";
	}else if(!validateNumbers(1,8,$p_cep)){
		$title = "Erro";
		$message = "O campo \"CEP\" foi preenchido incorretamente.";
	}else if(!validateNumbers(0,14,$p_cnpj)){
		$title = "Erro";
		$message = "O campo \"CNPJ\" foi preenchido incorretamente.";
	}else if(!validateNumbers(0,14,$p_ie)){
		$title = "Erro";
		$message = "O campo \"Inscrição estadual\" foi preenchido incorretamente.";
	}else if(!validateText(1,16,$p_username)){
		$title = "Erro";
		$message = "O campo \"Usuário\" foi preenchido incorretamente.";
	}else if(!validateText(1,32,$p_password)){
		$title = "Erro";
		$message = "O campo \"Senha\" foi preenchido incorretamente.";
	}else{
		$sel_users = "SELECT * FROM users WHERE username='".$p_username."' and id<>'".$p_usersid."'";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();
		$sel_clients = "SELECT * FROM clients WHERE rep_name='".$p_rname."' and id<>'".$p_id."'";
		$sel_clients_prepared = $db_connection->prepare($sel_clients);
		$sel_clients_prepared->execute();
		if(($sel_users_prepared->rowCount()==0)&($sel_clients_prepared->rowCount()==0)){
			$table = "users";
			$data = array(
				'username' => $p_username,
				'password' => MD5($salt.$p_password)
			);
			$condition = "id='".$p_usersid."'";
			$upd_users = db_update($table, $data, $condition);
			if($upd_users) {
				$table = "clients";
				$data = array(
					'trade_name' => $p_fname,
					'rep_name' => $p_rname,
					'phone' => $p_phone,
					'email' => $p_email,
					'city' => $p_city,
					'neighborhood' => $p_neighborhood,
					'street' => $p_street,
					'street_num' => $p_number,
					'street_comp' => $p_complement,
					'cep' => $p_cep,
					'cnpj' => $p_cnpj,
					'ie' => $p_ie
				);
				$condition = "id='" . $p_id . "'";
				$upd_clients = db_update($table, $data, $condition);
				if ($upd_clients) {
					$title = "Sucesso";
					$message = "Cliente alterado com sucesso.";
				} else {
					$title = "Erro";
					$message = "Erro na alteração de cliente.";
				}
			}else{
				$title = "Erro";
				$message = "Erro na alteração de usuário.";
			}
		}else{
			$title = "Erro";
			$message = "Esse registro de cliente já cliente.";
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php
		if($title=='Sucesso'){
			$back = "?folder=users/clients/&file=fmins_clients&ext=php";
		}else{
			$back = "?folder=users/clients/&file=fmupd_clients&ext=php&id=".$p_id;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>