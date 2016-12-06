<?php validatePermission(array(0, 1));
	$g_id = $_GET['id'];
	$table = "solicitations";
	$data = array(
		"users_id" => $_SESSION['user_id'],
		"status" => "1"
	);
	$condition = "id='".$g_id."'";
	$upd_solicitations = db_update($table, $data, $condition);
	if($upd_solicitations){
		$title = "Sucesso";
		$message = "Usuário vinculado com sucesso.";
	}else{
		$title = "Erro";
		$message = "Erro no Vínculo de usuário.";
	}
	?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br/><a href="?folder=solicitations/&file=view_solicitations&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>