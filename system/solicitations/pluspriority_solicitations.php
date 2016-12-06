<?php

	$id = $_GET['id'];

	$sel_priority = "SELECT priority FROM solicitations WHERE id ='".$id."'";
	$sel_priority_prepared = $db_connection->prepare($sel_priority);
	$sel_priority_prepared->execute();
	$sel_priority_data = $sel_priority_prepared->fetch();

	if($sel_priority_data['priority'] <= 1){
		$priority = $sel_priority_data['priority'] + 1;
		$table = "solicitations";
		$data = array(
			'priority' => $priority,
		);
		$condition = "id='" . $id . "'";
		$upd_priority = db_update($table, $data, $condition);

		if($upd_priority){
			$title = "Sucesso";
			$message = "Prioridade atualizada com sucesso";
		}else{
			$title = "Erro";
			$message = "Erro na atualização de prioridade";
		}
	}else{
		$title = "Erro";
		$message = "A prioridade não pode passar de 2";
	}
	?>

<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php
		if($_SESSION['permission']<3){
			echo $message;
			$back = "?folder=solicitations/&file=view_solicitations&ext=php";
		}else{
			echo $message;
			$back = "?folder=solicitations/shared/&file=shared_solicitations&ext=php";
		}
	?>
	<br/><a href="<?php echo $back?>"><img height="15" src="../layout/images/back.png"> Voltar</a>
</div>
