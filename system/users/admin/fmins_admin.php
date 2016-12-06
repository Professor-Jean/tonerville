	<?php validatePermission(array(0));?>
	<h4>Registro de administrador</h4>
	<div class="center_box">
		<h2>Registrar administrador</h2>
		<form name="admin" method="post" action="?folder=users/admin/&file=ins_admin&ext=php" onsubmit="return validateAdmin()">
			<table>
				<tr>
					<td>*Nome de usuário</td>
					<td><input type="text" maxlength="16" name="name"></td>
				</tr>
				<tr>
					<td>*Senha</td>
					<td><input type="password" maxlength="30" name="password"></td>
				</tr>
				<tr>
					<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
				</tr>
			</table>
		</form>
	</div>
<table class="entries">
	<tr>
		<th width="10%">ID</th>
		<th width="60%">Nome</th>
		<th width="15%">Editar</th>
		<th width="15%">Excluir</th>
	</tr>
	<?php
		$sel_users = "SELECT id, username FROM users WHERE permission='0'";
		$sel_users_prepared = $db_connection->prepare($sel_users);
		$sel_users_prepared->execute();
		while($sel_users_data = $sel_users_prepared->fetch()){
	?>
	<tr>
		<td><?php echo $sel_users_data['id']?></td>
		<td><?php echo $sel_users_data['username']?></td>
		<td><a href="?folder=users/admin/&file=fmupd_admin&ext=php&id=<?php echo $sel_users_data['id'];?>"><img src="../layout/images/edit.png" height="20px"></a></td>
		<td><?php echo safeDelete($sel_users_data['id'], '?folder=users/admin/&file=del_admin&ext=php', 'usuário', $sel_users_data['username'])?></td>
	</tr>
	<?php }?>
</table>