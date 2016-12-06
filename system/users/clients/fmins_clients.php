<?php validatePermission(array(0));?>
<h4>Registro de Cliente</h4>
<div class="center_box">
	<h2>Registrar cliente</h2>
	<form name="client" method="post" action="?folder=users/clients/&file=ins_clients&ext=php" onsubmit="return validateClients();">
		<table>
			<tr>
				<td>Nome fantasia</td>
				<td><input type="text" maxlength="90" name="trade_name"></td>
			</tr>
			<tr>
				<td>*Nome representante</td>
				<td><input type="text" maxlength="70" name="rep_name"></td>
			</tr>
			<tr>
				<td>Telefone</td>
				<td><input type="text" class="phone_mask" name="phone" placeholder="(47) 99999-9999"></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="text" maxlength="255" name="email"></td>
			</tr>
			<tr>
				<td>*Cidade</td>
				<td><input type="text" maxlength="40" name="city"></td>
			</tr>
			<tr>
				<td>*Bairro</td>
				<td><input type="text" maxlength="40" name="neighborhood"></td>
			</tr>
			<tr>
				<td>*Logradouro</td>
				<td><input type="text" maxlength="100" name="street"></td>
			</tr>
			<tr>
				<td>*Número</td>
				<td><input type="text" maxlength="5" name="street_num" placeholder="999"></td>
			</tr>
			<tr>
				<td>Complemento</td>
				<td><input type="text" maxlength="30" name="street_comp"></td>
			</tr>
			<tr>
				<td>*CEP</td>
				<td><input type="text" class="cep_mask" name="cep" placeholder="99999-999"></td>
			</tr>
			<tr>
				<td>CNPJ</td>
				<td><input type="text" class="cnpj_mask" maxlength="18" name="cnpj"  placeholder="99.999.999/9999-99"></td>
			</tr>
			<tr>
				<td>Inscrição estadual</td>
				<td><input type="text" maxlength="14" name="ie"></td>
			</tr>
			<tr>
				<td>*Usuário</td>
				<td><input type="text" maxlength="16" name="username"></td>
			</tr>
			<tr>
				<td>*Senha</td>
				<td><input type="password" maxlength="32" name="password" placeholder="*********"></td>
			</tr>
			<tr>
				<td colspan="2"><button type="reset" class="reset_btn">Reiniciar</button><button type="submit" class="submit_btn">Enviar</button></td>
			</tr>
		</table>
	</form>
</div>
<?php
	$sel_clients = "SELECT clients.id, clients.trade_name, clients.rep_name, users.username FROM clients INNER JOIN users ON clients.users_id=users.id";
	$sel_clients_prepared = $db_connection->prepare($sel_clients);
	$sel_clients_prepared->execute();
?>
<table class="entries">
	<tr>
		<th width="10%">ID</th>
		<th width="20%">Nome fantasia</th>
		<th width="15%">Nome representante</th>
		<th width="25%">Usuário</th>
		<th width="10%">Editar</th>
		<th width="10%">Excluir</th>
		<th width="10%">Detalhes</th>
	</tr>
	<?php
		if($sel_clients_prepared->rowCount()>0){
			
			while($sel_clients_data = $sel_clients_prepared->fetch()){
				?>
				<tr>
					<td><?php echo $sel_clients_data['id']; ?></td>
					<td><?php echo $sel_clients_data['trade_name'] ?: 'Pessoa física'; ?></td>
					<td><?php echo $sel_clients_data['rep_name']; ?></td>
					<td><?php echo $sel_clients_data['username']; ?></td>
					<td><a href="?folder=users/clients/&file=fmupd_clients&ext=php&id=<?php echo $sel_clients_data['id']?>" title="Editar Registro"><img src="../layout/images/edit.png" height="20px"></a></td>
					<td><?php echo safeDelete($sel_clients_data['id'], '?folder=users/clients/&file=del_clients&ext=php', 'cliente', $sel_clients_data['rep_name'])?></td>
					<td><a href="?folder=users/clients/&file=view_clients&ext=php&id=<?php echo $sel_clients_data['id']?>" title="Consulta Detalhada"><img src="../layout/images/external.png" height="20px"></a></td>
				</tr>
				<?php
			}
		}else {
			?>
			<tr>
				<td colspan="7">Não há registros.</td>
			</tr>
			<?php
		}
	?>
</table>