<?php validatePermission(array(0));
	$p_id = $_POST['id'];

	$sel_admin = "SELECT id from users WHERE permission=0";
	$sel_admin_prepared = $db_connection->prepare($sel_admin);
	$sel_admin_prepared->execute();

	if($p_id==""){
		$title = "Erro";
		$message = "Esse usuário não existe.";
	}else if($sel_admin_prepared->rowCount()==1){
		$title = "Erro";
		$message = "Você não pode excluir o último administrador.";
	}else{
			$table = "users";
			$condition = "MD5(id)='".$p_id."'";
			$del_users = db_delete($table, $condition);

		if(!$del_users) {
			$title = "Erro";
			$message = "Erro na exclusão de usuário.";
		}else{
			if($p_id==md5($_SESSION['user_id'])){
				header("location: ../security/authentication/logout_authentication.php");
			}else {
				$title = "Sucesso";
				$message = "Usuário removido com sucesso.";
			}
		}
	}
	?>
		<div class="center_box">
			<h1><?php echo $title; ?></h1>
			<?php echo $message; ?>
			<br/><a href="?folder=users/admin/&file=fmins_admin&ext=php"><img height="15" src="../layout/images/back.png"> Voltar</a>
		</div>

