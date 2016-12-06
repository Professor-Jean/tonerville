<?php
	validatePermission(array(0, 1));

	$p_id = $_POST['hidid'];
	$p_desc = trim($_POST['description']);

	$sel_solicitations = "SELECT status, users_id FROM solicitations WHERE id = '".$p_id."'";
	$sel_solicitations_prepared = $db_connection->prepare($sel_solicitations);
	$sel_solicitations_prepared->execute();
	$sel_solicitations_data = $sel_solicitations_prepared->fetch();
if($sel_solicitations_data['users_id']==$_SESSION['user_id']){
	if ($sel_solicitations_data['status'] != 1) {
		$title = "Erro";
		$message = "Esta não é uma solicitação válida para ser finalizada.";
	} else {
		$table = "solicitations";
		$data = array(
			'comment' => $p_desc,
			'status' => 2
		);
		$condition = "id=" . $p_id;
		$upd_solicitations = db_update($table, $data, $condition);
		if ($upd_solicitations) {
			$title = "Sucesso";
			$message = "Solicitação finalizada com sucesso.";
		} else {
			$title = "Erro";
			$message = "Erro na finalização de solicitação.";
		}
	}
}else{
	$title = "Erro";
	$message = "Você não pode finalizar a solicitação alheia.";
}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<?php
		if($title=='Sucesso'){
			$back = "?folder=solicitations/&file=view_solicitations&ext=php";
		}else{
			$back = "?folder=solicitations/&file=view_solicitations&ext=php&mlt=".$p_hidmlt;
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
