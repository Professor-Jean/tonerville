	<?php validatePermission(array(0));?>
	<h4>Registro de Funcionário</h4>
	<div class="center_box">
		<h2>Registrar funcionário</h2>
		<form name="employees" method="post" action="?folder=users/employees/&file=ins_employees&ext=php" onsubmit="return validateEmployees()">
			<table>
				<tr>
					<td>*Usuário</td>
					<td><input type="text" maxlength="16" name="username"></td>
				</tr>
				<tr>
					<td>*Senha</td>
					<td><input type="password" maxlength="32" name="password"></td>
				</tr>
				<tr>
					<td>*Nome</td>
					<td><input type="text" maxlength="70" name="name"></td>
				</tr>
				<tr>
					<td>Telefone</td>
					<td><input type="text" name="phone" class="phone_mask"></td>
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
			<th width="25%">Usuário</th>
			<th width="25%">Nome</th>
			<th width="20%">Telefone</th>
			<th width="10%">Editar</th>
			<th width="10%">Excluir</th>
		</tr>
		<?php
			$sel_users = "SELECT employees.id, users.username, employees.name, employees.phone FROM employees INNER JOIN users ON employees.users_id=users.id";
			$sel_users_prepared = $db_connection->prepare($sel_users);
			$sel_users_prepared->execute();
			while($sel_users_data = $sel_users_prepared->fetch()){
				?>
				<tr>
					<td><?php echo $sel_users_data['id']?></td>
					<td><?php echo $sel_users_data['username']?></td>
					<td><?php echo $sel_users_data['name']?></td>
					<td class="phone_mask optional_mask"><?php echo $sel_users_data['phone']?></td>
					<td><a href="?folder=users/employees/&file=fmupd_employees&ext=php&id=<?php echo $sel_users_data['id'];?>"><img src="../layout/images/edit.png" height="20px"></a></td>
					<td><?php echo safeDelete($sel_users_data['id'], '?folder=users/employees/&file=del_employees&ext=php', 'usuário', $sel_users_data['name'])?></td>
				</tr>
			<?php }
				if($sel_users_prepared->rowCount()==0){
			?>
				<tr>
					<td colspan="6">Não há registros</td>
				</tr>
			<?php
					}
			?>
	</table>