<?php
	validatePermission(array(0, 1));
	$g_id = $_GET['id'];

	$sel_solicitations = "SELECT users_id FROM solicitations WHERE id = '".$g_id."'";
	$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
	$sel_solicitations_prepared->execute();
	$sel_solicitations_data = $sel_solicitations_prepared->fetch();
	if($sel_solicitations_data['users_id']==$_SESSION['user_id']){
		$table = "solicitations";
		$data = array(
			"users_id" => NULL,
			"status" => "0"
		);
		$condition = "id='" . $g_id . "'";
		$upd_solicitations = db_update($table, $data, $condition);
		if ($upd_solicitations) {
			$title = "Sucesso";
			$message = "Usuário desvinculado com sucesso.";
		} else {
			$title = "Erro";
			$message = "Erro ao desvincular o usuário.";
		}
	}else{
		$title = "Erro";
		$message = "Você não pode descinvular os outros.";
	}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
<?php echo $message; ?>
<br/><a href="?folder=solicitations/&file=view_solicitations&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
