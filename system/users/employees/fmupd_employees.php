<?php
	validatePermission(array(0));

	$g_employees_id = $_GET['id'];

	$sel_users = "SELECT users.id, users.username, employees.name, employees.phone, users.password, employees.users_id FROM employees INNER JOIN users ON employees.users_id=users.id WHERE employees.id='".$g_employees_id."'";
	$sel_users_prepared = $db_connection->prepare($sel_users);
	$sel_users_prepared->execute();
	$sel_users_data = $sel_users_prepared->fetch();
?>

<h4>Registro de Funcionário</h4>
<div class="center_box">
	<h2>Editar funcionário</h2>
	<form name="employees" method="post" action="?folder=users/employees/&file=upd_employees&ext=php" onsubmit="return validateEmployees()">
		<input type="hidden" name="hidid" value="<?php echo $g_employees_id;?>">
		<input type="hidden" name="hiduserid" value="<?php echo $sel_users_data['users_id'];?>">
		<table>
			<tr>
				<td>Usuário</td>
				<td><input type="text" maxlength="16" name="username" value="<?php echo htmlspecialchars($sel_users_data['username']);?>"></td>
			</tr>
			<tr>
				<td>Senha</td>
				<td><input type="password" maxlength="16" name="password""></td>
			</tr>
			<tr>
				<td>Nome</td>
				<td><input type="text" maxlength="70" name="name" value="<?php echo htmlspecialchars($sel_users_data['name'])?>"></td>
			</tr>
			<tr>
				<td>Telefone</td>
				<td><input type="text" class="phone_mask" name="phone" value="<?php echo htmlspecialchars($sel_users_data['phone'])?>"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
