<?php validatePermission(array(0));
	$g_id = $_GET['id'];

	$sel_users = "SELECT * FROM users WHERE id='".$g_id."'";
	$sel_users_prepared = $db_connection->prepare($sel_users);
	$sel_users_prepared->execute();
	$sel_users_data = $sel_users_prepared->fetch();
?>
<h4>Registro de administrador</h4>
<div class="center_box">
	<h2>Editar administrador</h2>
	<form name="admin" method="post" action="?folder=users/admin/&file=upd_admin&ext=php" onsubmit="return validateAdmin()">
		<input type="hidden" name="hidid" value="<?php echo $sel_users_data['id'];?>">
		<table>
			<tr>
				<td>Nome de usuário</td>
				<td><input type="text" maxlength="16" name="name" value="<?php echo htmlspecialchars($sel_users_data['username']);?>"></td>
			</tr>
			<tr>
				<td>Senha</td>
				<td><input type="password" maxlength="30" name="password"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>