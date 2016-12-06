<?php
	validatePermission(array(2));
	$p_printers = $_POST['printers']; //mlt da impressora
	$p_category = $_POST['category'];
	$p_description = trim($_POST['description']);

	if(!validateText(1,4,$p_printers)){
		$title = "Erro";
		$message = "O campo \"impressora\" foi preenchido incorretamente.";
	}else if(!validateText(1,45,$p_category)) {
		$title = "Erro";
		$message = "O campo \"categoria\" foi preenchido incorretamente.";
	}else {

		$sel_category = "SELECT * from categories WHERE id='" .$p_category . "'";
		$sel_category_prepared = $db_connection->prepare($sel_category);
		$sel_category_prepared->execute();
		$sel_category_data = $sel_category_prepared->fetch();

		$sel_client = "SELECT clients.id FROM clients INNER JOIN users ON clients.users_id = users.id WHERE users.id = '".$_SESSION['user_id']."'";
		$sel_client_prepared = $db_connection->prepare($sel_client);
		$sel_client_prepared->execute();
		$sel_client_data = $sel_client_prepared->fetch();

		$ex_data = date('d/m/Y');
		$arraydata = explode("/", $ex_data);
		@$p_data = $arraydata[2] . "-" . $arraydata[1] . "-" . $arraydata[0];

			$table = "solicitations";
			$data = array(
				'categories_id' => $p_category,
				'printers_mlt' => $p_printers,
				'clients_id' => $sel_client_data['id'],
				'date' => $p_data,
				'priority' => $sel_category_data['priority'],
				'status' => '0',
				'description' => $p_description
			);
			$ins_admin = db_add($table, $data);
			if($ins_admin){
				$title = "Sucesso";
				$message = "Solicitação enviada com sucesso.";
			}else{
				$title = "Erro";
				$message = "Erro no envio de Solicitação.";
			}
	}
?>
<div class="center_box">
	<h1><?php echo $title; ?></h1>
	<?php echo $message; ?>
	<br><a href="?folder=solicitations/&file=fmins_solicitations&ext=php"><img height="15" src="../layout/images/back.png"/>Voltar</a>
</div>