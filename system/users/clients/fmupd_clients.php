<?php validatePermission(array(0));
	$g_id = $_GET['id'];
	$sel_clients = "SELECT clients.id, clients.users_id, clients.trade_name, clients.rep_name, clients.phone, clients.email, clients.city, clients.neighborhood, clients.street, clients.street_num, clients.street_comp, clients.cep, clients.cnpj, clients.ie, users.username FROM clients INNER JOIN users ON clients.users_id=users.id WHERE clients.id='".$g_id."'";
	$sel_clients_prepared = $db_connection->prepare($sel_clients);
	$sel_clients_prepared->execute();
	$sel_clients_data = $sel_clients_prepared->fetch();
?>
<h4>Registro de Cliente</h4>
<div class="center_box">
	<h2>Registrar cliente</h2>
	<form name="client" method="post" action="?folder=users/clients/&file=upd_clients&ext=php" onsubmit="return validateClients();">
		<input type="hidden" name="hidid" value="<?php echo $sel_clients_data['id'];?>" />
		<input type="hidden" name="hidusersid" value="<?php echo $sel_clients_data['users_id'];?>" />
		<table>
			<tr>
				<td>Nome fantasia</td>
				<td><input type="text" maxlength="90" name="trade_name" value="<?php echo $sel_clients_data['trade_name'];?>"></td>
			</tr>
			<tr>
				<td>Nome representante</td>
				<td><input type="text" maxlength="70" name="rep_name" value="<?php echo $sel_clients_data['rep_name'];?>"></td>
			</tr>
			<tr>
				<td>Telefone</td>
				<td><input type="text" class="phone_mask" name="phone" value="<?php echo $sel_clients_data['phone'];?>"></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="text" maxlength="255" name="email" value="<?php echo $sel_clients_data['email'];?>"></td>
			</tr>
			<tr>
				<td>Cidade</td>
				<td><input type="text" maxlength="40" name="city" value="<?php echo $sel_clients_data['city'];?>"></td>
			</tr>
			<tr>
				<td>Bairro</td>
				<td><input type="text" maxlength="40" name="neighborhood" value="<?php echo $sel_clients_data['neighborhood'];?>"></td>
			</tr>
			<tr>
				<td>Logradouro</td>
				<td><input type="text" maxlength="100" name="street" value="<?php echo $sel_clients_data['street'];?>"></td>
			</tr>
			<tr>
				<td>Número</td>
				<td><input type="text" maxlength="5" name="street_num" value="<?php echo $sel_clients_data['street_num'];?>"></td>
			</tr>
			<tr>
				<td>Complemento</td>
				<td><input type="text" maxlength="30" name="street_comp" value="<?php echo $sel_clients_data['street_comp'];?>"></td>
			</tr>
			<tr>
				<td>CEP</td>
				<td><input type="text" class="cep_mask" name="cep" value="<?php echo $sel_clients_data['cep'];?>"></td>
			</tr>
			<tr>
				<td>CNPJ</td>
				<td><input type="text" class="cnpj_mask" name="cnpj" value="<?php echo $sel_clients_data['cnpj'];?>"></td>
			</tr>
			<tr>
				<td>Inscrição estadual</td>
				<td><input type="text" maxlength="14" name="ie" value="<?php echo $sel_clients_data['ie'];?>"></td>
			</tr>
			<tr>
				<td>Usuário</td>
				<td><input type="text" maxlength="16" name="username" value="<?php echo $sel_clients_data['username'];?>"></td>
			</tr>
			<tr>
				<td>Senha</td>
				<td><input type="password" maxlength="32" name="password"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>