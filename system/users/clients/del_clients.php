<?php validatePermission(array(0));
	$p_id = $_POST['id'];
	if($p_id==""){
		$title = "Erro";
		$message = "Cliente inexistente.";
	}else{
		$sel_rentals = "SELECT * FROM rentals WHERE MD5(clients_id)='".$p_id."' ";
		$sel_rentals_prepared = $db_connection->prepare($sel_rentals);
		$sel_rentals_prepared->execute();
		if($sel_rentals_prepared->rowCount()>0) {
			$title = "Erro";
			$message = "Existem registros de aluguel associados com esse registro; Finalize-os e tente novamente.";
		}else{
			$sel_clients = "SELECT users_id FROM clients WHERE MD5(id)='".$p_id."'";
			$sel_clients_prepared = $db_connection->prepare($sel_clients);
			$sel_clients_prepared->execute();
			$sel_clients_data = $sel_clients_prepared->fetch();
			$table = "clients";
			$condition = "MD5(id)='".$p_id."'";
			$del_clients = db_delete($table, $condition);
			if($del_clients) {
				$table = "users";
				$condition = "id='".$sel_clients_data['users_id']."'";
				$del_users = db_delete($table, $condition);
				if($del_users) {
					$title = "Sucesso";
					$message = "Cliente removido com sucesso.";
				}else{
					$title = "Erro";
					$message = "Erro na exclusão de usuário.";
				}
			}else{
				$title = "Erro";
				$message = "Erro na exclusão de cliente.";
			}
		}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=users/clients/&file=fmins_clients&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>