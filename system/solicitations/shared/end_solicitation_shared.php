<?php validatePermission(array(3));
	$p_id = $_POST['hidid'];
	$p_userid = $_POST['hiduser'];
	$p_password = trim($_POST['password']);
	$p_desc = trim($_POST['desc']);
if(!validateText(1, 30, $p_password)){
		$message = "O campo 'senha' foi preenchido incorretamente.";
	}else{
		$sel_users = "SELECT * FROM users WHERE id='".$p_userid."' AND permission<2";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();
		if($sel_users_prepared->rowCount()==1) {
			$sel_users_data = $sel_users_prepared->fetch();
			if (MD5($salt . $p_password) == $sel_users_data['password']) {
				$table = "solicitations";
				$data = array(
					'comment' => $p_desc,
					'status' => 2
				);
				$condition = "id=".$p_id;
				$upd_solicitations = db_update($table, $data, $condition);
				if ($upd_solicitations) {
					$title = "Sucesso";
					$message = "Solicitação finalizada com sucesso.";
				} else {
					$title = "Erro";
					$message = "Erro na finaização de solicitação.";
				}
			} else {
				$title = "Erro";
				$message = "Senha incorreta.";
			}
		}else{
			$title = "Erro";
			$message = "Usuário inexistente.";
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
			$back = "?folder=solicitations/shared/&file=fmend_solicitation_shared&ext=php&id=".$p_id;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>